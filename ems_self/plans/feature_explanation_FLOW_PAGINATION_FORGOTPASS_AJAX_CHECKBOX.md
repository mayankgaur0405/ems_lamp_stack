# Complete Feature Implementation Guide

This guide explains the exact workflows, file changes, and code used to implement the new features in your EMS project. You can use this to understand the logic, replicate it in future projects, or explain it to your trainer.

---

## 1. Global UI & Aesthetics
**The Goal:** Make the app look modern without changing the core PHP logic.
**The Flow:** We created a single custom CSS file (`style.css`) containing modern design classes (like `glass-panel` for blurred backgrounds and hover animations). We then linked this CSS file in the global header so every page automatically gets the new styling.

**Files Modified:**
- **[NEW]** `assets/css/style.css`: Contains the new design rules.
- **[MODIFIED]** `includes/header.php`: Linked the new CSS file.

**Key Code Snippet:**
```html
<!-- In includes/header.php -->
<link href="/php-training-pe-front/study/ems_self/assets/css/style.css" rel="stylesheet">
```

---

## 2. Database Preparation
**The Goal:** Support email verification, password resets, and multiple skills.
**The Flow:** We ran SQL commands to add new columns to the `employees` table.

**Key Code Snippet (SQL):**
```sql
ALTER TABLE employees ADD COLUMN verification_token VARCHAR(255) NULL;
ALTER TABLE employees ADD COLUMN reset_token VARCHAR(255) NULL;
ALTER TABLE employees ADD COLUMN reset_token_expiry DATETIME NULL;
ALTER TABLE employees ADD COLUMN skills VARCHAR(255) NULL;
```

---

## 3. PHPMailer Central Configuration
**The Goal:** Send emails (like Verification, Reset Password, Contact) easily from any file without repeating the SMTP credentials.
**The Flow:** We created a wrapper function called `send_mail()`. Whenever a page needs to send an email, it just requires this file and calls the function.

**Files Modified:**
- **[NEW]** `includes/mail_config.php`

**Key Code Snippet:**
```php
require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/php mailer/PHPMailer/src/SMTP.php';

function send_mail($to, $to_name, $subject, $body) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    // ... SMTP config goes here (Host, Port, Username, Password) ...
    $mail->send();
    return true;
}
```

---

## 4. Email Verification Flow (Registration)
**The Flow:** 
1. The Admin adds an employee. 
2. We generate a random secure string (`$token`).
3. The employee is saved to the database with `status = 0` (inactive) and the token is saved in the `verification_token` column.
4. An email is sent to the employee with a link to `verify.php?token=XYZ`.
5. When the employee clicks the link, `verify.php` checks if the token exists. If it does, it updates the database to `status = 1` and deletes the token.

**Files Modified:**
- **[MODIFIED]** `admin/employee/add_employee.php`
- **[NEW]** `verify.php`

**Key Code Snippets:**
*Generating the token and sending the email (add_employee.php)*
```php
require "../../includes/mail_config.php"; // Include our mailer setup

$token = bin2hex(random_bytes(32)); // Generate a random 64-character string

// In the INSERT query, we hardcode status to 0 and insert the token
$insert_query = "INSERT INTO employees (name, email, ..., status, verification_token) 
                 VALUES ('$name', '$email', ..., 0, '$token')";

// Send the email
$verify_link = "http://localhost/php-training-pe-front/study/ems_self/verify.php?token=" . $token;
send_mail($email, $name, 'Verify Your Account', "Click here to verify: <a href='$verify_link'>Link</a>");
```

*Verifying the token (verify.php)*
```php
$token = mysqli_real_escape_string($conn, $_GET['token']);
// Update status to 1 if token matches
$update_query = "UPDATE employees SET status=1, verification_token=NULL WHERE verification_token='$token'";
mysqli_query($conn, $update_query);
```

---

## 5. Forgot Password Flow
**The Flow:** 
1. The user enters their email on `forgot_password.php`.
2. We check if the email exists. If yes, we generate a `$token` and an `$expiry` time (current time + 1 hour).
3. We save these to `reset_token` and `reset_token_expiry` in the DB.
4. We send an email with the link `reset_password.php?token=XYZ`.
5. On `reset_password.php`, we check if the token exists AND if the current time is less than the expiry time.
6. If valid, we show a form to enter a new password. We hash the new password, update it in the DB, and delete the token.

**Files Modified:**
- **[NEW]** `forgot_password.php`
- **[NEW]** `reset_password.php`

**Key Code Snippet (Setting Expiry in forgot_password.php):**
```php
$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1 hour from now

$update_query = "UPDATE employees SET reset_token='$token', reset_token_expiry='$expiry' WHERE id=" . $employee['id'];
```

---

## 6. Contact Admin Form
**The Flow:** 
1. A logged-in employee fills out the form on `contact.php`.
2. We capture the `subject` and `message`.
3. We fetch the employee's name and email from the session ID.
4. We call the `send_mail()` function, passing the Admin's email address as the destination.

**Files Modified:**
- **[MODIFIED]** `includes/employee_sidebar.php`: Added the sidebar link.
- **[NEW]** `employee/contact.php`: The form logic.

**Key Code Snippet (contact.php):**
```php
$admin_email = 'mayankgaur1504@gmail.com'; 
$email_body = "<p>Message from: " . $employee['name'] . "</p><p>" . $_POST['message'] . "</p>";

send_mail($admin_email, 'Admin', "Contact Form", $email_body);
```

---

## 7. Employee Profile Checkbox (Skills)
**The Flow:** 
1. HTML checkboxes must use an array name like `name="skills[]"`. 
2. When the form is submitted, PHP receives an array of selected skills (e.g., `['PHP', 'HTML']`).
3. We use PHP's `implode(',', $array)` to turn the array into a comma-separated string (`"PHP,HTML"`) to save it in the database.
4. When viewing the profile, we fetch the string from the database and use `explode(',', $string)` to turn it back into an array.
5. We use `in_array()` inside the HTML to check the boxes the user previously selected.

**Files Modified:**
- **[MODIFIED]** `admin/employee/add_employee.php`
- **[MODIFIED]** `employee/profile.php`

**Key Code Snippet (profile.php):**
*Processing the submission:*
```php
// Turns ['PHP', 'MySQL'] into "PHP,MySQL"
$skills = isset($_POST['skills']) ? implode(',', $_POST['skills']) : ''; 
```
*Displaying the checked boxes:*
```php
// Turns "PHP,MySQL" back into an array
<?php $emp_skills = explode(',', $employee['skills']); ?>

<!-- Check if 'PHP' is in the array, if yes, print 'checked' -->
<input type="checkbox" name="skills[]" value="PHP" <?php if(in_array('PHP', $emp_skills)) echo 'checked'; ?>> PHP
```

---

## 8. Pagination & Search
**The Flow (Pagination):** 
1. We count total rows in the database.
2. We divide by `rows_per_page` to get total pages.
3. We calculate the `OFFSET` based on the current page (e.g., Page 2 skips the first 2 rows).
4. We use the SQL `LIMIT X, Y` clause to fetch only that chunk of data.
5. We render Bootstrap HTML to draw the `1, 2, 3, Next` buttons.

**The Flow (Client-Side Search - Department View):**
1. An input box calls a JavaScript function `onkeyup`.
2. The JS function grabs the text, loops through every table row (`<tr>`), checks the text inside the specific column (`<td>`), and hides the row if it doesn't match the search text.

**Files Modified:**
- **[MODIFIED]** `admin/employee/view_employee.php`
- **[MODIFIED]** `admin/department/view_department.php`

**Key Code Snippet (JS Search in view_department.php):**
```javascript
function filterTable() {
    let input = document.getElementById("deptSearch").value.toUpperCase();
    let tr = document.getElementById("deptTable").getElementsByTagName("tr");
    
    // Loop through all rows
    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[1]; // Target column 2 (Name)
        if (td) {
            let txtValue = td.textContent || td.innerText;
            // Hide the row if text doesn't match
            tr[i].style.display = txtValue.toUpperCase().indexOf(input) > -1 ? "" : "none";
        }       
    }
}
```
