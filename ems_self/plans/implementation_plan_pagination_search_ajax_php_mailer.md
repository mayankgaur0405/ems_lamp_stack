# Goal Description

The objective is to introduce a cohesive set of feature enhancements and design upgrades across the EMS application. This includes standardizing pagination and search filters across all data tables, integrating PHPMailer to handle user verification and communication, adding new features to the employee profile, and overhauling the user interface to be highly professional and visually appealing while maximizing data density, all without altering the fundamental PHP logic.

## User Review Required

> [!WARNING]
> **PHPMailer Installation:** Since this project doesn't appear to be using Composer currently, we will need to either introduce Composer (which is the modern standard for PHP) or download the PHPMailer library manually into an `includes/PHPMailer` folder. We will plan to use the manual inclusion method to keep things simple unless you prefer Composer.

> [!IMPORTANT]
> **Database Changes Required:** 
> - Adding a `verification_token` column to the `employees` table to handle email verification and password resets.
> - Creating a new table (or using the tokens column) for tracking "Forgot Password" requests.

## Open Questions

> [!CAUTION]
> **To proceed with the execution after approval, please clarify the following:**

1. **Profile Checkbox Feature:** Could you clarify what exactly the checkbox feature in the employee profile should do? (e.g., is it for selecting multiple skills, agreeing to policies, subscribing to notifications, etc.?)
2. **SMTP Credentials:** Do you have an SMTP server (like Gmail App Passwords, Mailtrap, SendGrid, etc.) ready for sending emails? We'll need these credentials in a configuration file.
3. **PHPMailer setup:** Are you comfortable with downloading PHPMailer manually into an `includes/` directory, or would you prefer setting up Composer?
4. **Contact Form Location:** Should the new Contact Form be a separate page accessible from the employee dashboard, or integrated into an existing page?

## Proposed Changes

### 1. Global UI & Aesthetic Overhaul

Introduce a modern design system with vibrant, professional themes without writing complex advanced PHP logic.

#### [NEW] `assets/css/style.css`
- Add modern Google Fonts (e.g., Inter).
- Implement glassmorphism effects, soft shadows, and subtle micro-animations for buttons and table rows.
- Ensure all forms and inputs use rounded corners, floating labels, or modern Bootstrap 5 techniques.

#### [MODIFY] `includes/header.php` / `includes/to_include_header_footer_sidebar.php`
- Link the new custom CSS.
- Update global navigation components to match the premium feel.

---

### 2. Data Density Improvements in Tables

#### [MODIFY] `admin/employee/view_employee.php`
- **Compact Columns:** Combine `Name`, `Email`, and `Phone` into a single "Employee Details" column. The name will be bold and prominent, with the email and phone in smaller, subdued text below it.
- **Status & Role:** Combine Department and Role into an "Assignment" column.
- Update table styling with the new CSS to feel lighter and more spacious despite the increased data density.

---

### 3. Pagination and Search Implementation

#### [MODIFY] List Pages (`admin/employee/view_employee.php`, `admin/department/view_department.php`, `admin/teams/view_teams.php`)
- Standardize the pagination component using Bootstrap's official pagination styles.
- Add a unified search bar at the top of these tables that filters results dynamically (improving the existing AJAX implementation to be more robust and styled).

---

### 4. PHPMailer Integrations

#### [NEW] `includes/mail_config.php`
- Configuration file for SMTP host, port, username, and password.

#### [MODIFY] Registration Flow (`admin/employee/add_employee.php` / `employee/register.php`)
- When a new employee is created, default `status = 0`.
- Generate a unique secure token and store it.
- Send an email via PHPMailer containing an activation link (e.g., `verify.php?token=XYZ`).

#### [NEW] `verify.php`
- Verifies the token and updates the employee `status` to `1` (Active).

#### [NEW] Forgot Password Flow (`forgot_password.php`, `reset_password.php`)
- Form to accept an email address.
- Generates a time-sensitive reset token and emails a reset link.
- Form to securely set a new password.

#### [NEW] Contact Form (`employee/contact.php`)
- Simple form for employees to send a message.
- Submitting the form uses PHPMailer to send the contents directly to the designated company admin email.

---

### 5. Employee Profile Checkbox Feature

#### [MODIFY] `employee/profile.php`
- Add the required checkbox feature (pending clarification on its exact purpose).
- Update the database and backend logic to save the state of these checkboxes.

## Verification Plan

### Automated/Backend Tests
- Verify that SQL queries for the modified tables (with pagination and search) execute efficiently and return the correct subset of data.
- Ensure the `verification_token` logic generates unique hashes.

### Manual Verification
- **Email Sending:** Use Mailtrap or a real SMTP account to verify that Registration, Forgot Password, and Contact Form emails are successfully delivered with the correct formatting.
- **Authentication Flow:** Register a new user -> Verify they cannot log in initially -> Click email link -> Verify successful login.
- **UI Responsiveness:** Check the new condensed data tables on mobile and desktop views to ensure text doesn't overflow and the design remains premium.
