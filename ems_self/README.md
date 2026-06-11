# 🏢 EmpManager — Employee Management System (LAMP Stack)

> A full-featured Employee Management System built with **PHP**, **MySQL**, **Bootstrap 5**, **jQuery**, and **JavaScript**. This project demonstrates real-world web development concepts including authentication, CAPTCHA, AJAX, file uploads, email verification, password hashing, role-based access, and more.

---

## 🌐 Live Demo

🔗 **[https://empmanager.infinityfreeapp.com](https://empmanager.infinityfreeapp.com)**

---

## 🔑 Demo Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `admin123` |
| **Employee** | `mayankgaur0307@gmail.com` | `admin123` |

---

## 📸 Screenshots

### Home Page — Portal Selection
- Modern dual-portal landing page with Admin and Employee login options.

### Admin Dashboard
- Overview cards showing Total Employees, Departments, Active Employees, and Total Ratings.
- Quick action buttons and recent registrations table.

### Employee Dashboard
- Personal info cards (Email, Phone, Designation, Department).
- Quick links to Profile, Leaderboard, and Change Password.

---

## ✅ Features & PHP/Web Topics Covered

### 🔐 Authentication & Security
| Feature | Description |
|---------|-------------|
| **CAPTCHA Verification** | Custom PHP-generated CAPTCHA image using `imagecreate()`, `imagestring()`, and random noise lines. Validated on both Admin & Employee login. |
| **Password Hashing** | Passwords stored securely using `password_hash()` with `PASSWORD_DEFAULT` (bcrypt). Verified with `password_verify()`. |
| **Session Management** | PHP `$_SESSION` used for login state, role-based access control (`admin` / `employee`). |
| **Role-Based Access Control** | Admin and Employee portals separated with session checks. Unauthorized users are redirected. |
| **Email Verification** | On signup/employee creation, a unique token (`bin2hex(random_bytes(32))`) is generated and sent via email. Account stays inactive until verified. |
| **Forgot Password** | Token-based password reset with 1-hour expiry. Reset link sent via PHPMailer. |
| **Account Enable/Disable** | Admin can enable or disable employee accounts (status toggle). |

---

### 📧 PHPMailer Integration
| Feature | Description |
|---------|-------------|
| **SMTP Email (Gmail)** | PHPMailer configured with Gmail SMTP (`smtp.gmail.com`, port `587`, STARTTLS). |
| **Email Verification Mail** | Sent on employee registration/signup with a verification link. |
| **Password Reset Email** | Sends a secure reset link with expiring token. |
| **Contact Admin (Employee→Admin)** | Employees can send messages to all admins via email from the Contact page. |

---

### 👨‍💼 Employee Management (Admin Panel)
| Feature | Description |
|---------|-------------|
| **Add Employee** | Multi-field form with name, email, phone, password, department, designation, job role, country/state/city, skills (checkboxes), profile picture, and resume upload. |
| **Edit Employee** | Pre-populated edit form with all employee details. |
| **View Employee List** | Paginated employee table with profile pictures, search bar, and action buttons. |
| **View Single Employee** | Detailed single-employee profile view card. |
| **Delete Employee** | Delete with JavaScript `confirm()` dialog. |
| **Enable/Disable Employee** | Toggle employee account status (active/inactive). |

---

### 🏗️ Department Management
| Feature | Description |
|---------|-------------|
| **Add Department** | Create new departments. |
| **View Departments** | List all departments. |
| **Delete Department** | Remove departments with cascading cleanup. |

---

### 👥 Team Management
| Feature | Description |
|---------|-------------|
| **View Teams** | View teams grouped by department. |
| **Team Members** | Many-to-many relationship between teams and employees (`team_members` join table with `UNIQUE` constraint). |

---

### ⭐ Performance Ratings & Leaderboard
| Feature | Description |
|---------|-------------|
| **Rate Employee** | Admin can rate employees (1–5 stars) with written review/feedback. |
| **View Ratings** | View all submitted ratings and evaluations. |
| **Top Employees / Leaderboard** | Employees ranked by average rating — visible to both Admin and Employee portals. |

---

### 📝 Form Handling & Validation
| Feature | Description |
|---------|-------------|
| **`$_POST` Handling** | All forms processed with PHP `$_POST` superglobal. |
| **`$_GET` Handling** | Used for pagination (`page_no`), employee selection (`emp_id`), token verification, and status updates. |
| **`$_FILES` Handling** | Profile picture and resume uploaded via `$_FILES` with `move_uploaded_file()`. |
| **`$_SESSION` Handling** | Login state, user ID, name, and role stored in sessions. |
| **`enctype="multipart/form-data"`** | Used in forms that handle file uploads. |

---

### ☑️ Checkboxes, Implode & Explode
| Feature | Description |
|---------|-------------|
| **Skills Checkboxes** | Multi-select checkboxes for skills (PHP, MySQL, HTML, CSS, JavaScript) using `name="skills[]"`. |
| **`implode()`** | Selected checkbox values joined into a comma-separated string for database storage: `implode(',', $_POST['skills'])`. |
| **`explode()`** | Stored skills string split back into array for pre-checking checkboxes on edit: `explode(',', $employee['skills'])`. |
| **`in_array()`** | Used to check if a skill exists in the employee's skills array for setting `checked` attribute. |

---

### 📁 File Upload
| Feature | Description |
|---------|-------------|
| **Profile Picture Upload** | Image files uploaded to `/uploads/profiles/` with timestamp prefix to prevent name collisions. |
| **Resume Upload** | Document files (`.pdf`, `.doc`, `.docx`) uploaded to `/uploads/resumes/`. |
| **`move_uploaded_file()`** | PHP function used to move uploaded files from temp directory to target folder. |
| **File Type Filtering** | HTML `accept` attribute used to restrict file types on the frontend (`accept="image/*"`, `accept=".pdf,.doc,.docx"`). |

---

### 🔍 AJAX & jQuery
| Feature | Description |
|---------|-------------|
| **Live Search** | Real-time employee search using `jQuery.ajax()` — sends keystrokes to `ajaxsearch.php` and dynamically updates the table without page reload. |
| **Dynamic Dropdowns** | Country → State → City and Department → Job Role cascading dropdowns using `fetch()` API and dedicated API endpoints (`/api/get_states.php`, `/api/get_cities.php`, `/api/get_job_roles.php`). |

---

### 📊 Database Design (MySQL)
| Feature | Description |
|---------|-------------|
| **Relational Schema** | Normalized database with tables: `employees`, `departments`, `countries`, `states`, `cities`, `job_roles`, `teams`, `team_members`, `employee_ratings`. |
| **Foreign Keys** | Proper FK constraints with `ON DELETE CASCADE` and `ON DELETE SET NULL`. |
| **JOIN Queries** | `LEFT JOIN` used extensively to fetch related data (department names, job role titles, etc.). |
| **Aggregate Queries** | `COUNT(*)` for dashboard statistics; `AVG()` for leaderboard rankings. |
| **LIKE Operator** | Used in AJAX search: `WHERE name LIKE '%search%' OR email LIKE '%search%'`. |
| **LIMIT & OFFSET** | Used for server-side pagination. |
| **Seed Data** | SQL seed files provided for quick setup (`ems.sql`, `seed_all_data.sql`, `seed_employees.sql`). |

---

### 🎨 Frontend & UI
| Feature | Description |
|---------|-------------|
| **Bootstrap 5** | Responsive grid, cards, tables, forms, modals, nav-pills, badges, and utility classes. |
| **Bootstrap Icons** | Icon library used throughout the UI. |
| **Custom CSS** | Glassmorphism panels, gradient backgrounds, hover effects, and custom card styles. |
| **Responsive Design** | Mobile-friendly layouts with Bootstrap breakpoints and media queries. |
| **Dark-Themed Login Panels** | Split-screen login pages with dark decorative panel + light form panel. |
| **Sidebar Navigation** | Separate admin sidebar and employee sidebar with active state highlighting. |

---

### 🔄 Miscellaneous PHP Concepts
| Feature | Description |
|---------|-------------|
| **`password_hash()` / `password_verify()`** | Secure password storage & verification. |
| **`mysqli_real_escape_string()`** | Basic SQL injection prevention. |
| **`htmlspecialchars()`** | XSS prevention on output. |
| **`date()` / `strtotime()`** | Date formatting and manipulation. |
| **`bin2hex(random_bytes())`** | Cryptographic token generation. |
| **`include` / `require`** | Modular code with reusable header, footer, sidebar, and config files. |
| **`header("Location: ...")`** | PHP redirects for navigation and access control. |
| **`nl2br()`** | Converting newlines to `<br>` for HTML display (in contact messages). |
| **`ceil()`** | Used for calculating total pages in pagination. |
| **`time()` prefix** | Timestamp-based unique filenames for uploads. |

---

## 🗂️ Project Structure

```
ems_self/
├── index.php                    # Home page (portal selector)
├── forgot_password.php          # Forgot password form
├── reset_password.php           # Reset password with token
├── verify.php                   # Email verification handler
├── logout.php                   # Session destroy & logout
│
├── admin/
│   ├── index.php                # Admin login (with CAPTCHA)
│   ├── dashboard.php            # Admin dashboard with stats
│   ├── profile.php              # Admin profile
│   ├── change_password.php      # Admin change password
│   ├── employee/
│   │   ├── add_employee.php     # Add employee form
│   │   ├── edit_employee.php    # Edit employee form
│   │   ├── view_employee.php    # Employee list with pagination
│   │   ├── view_single.php      # Single employee profile
│   │   ├── ajaxsearch.php       # AJAX search endpoint
│   │   └── action.php           # Delete/enable/disable actions
│   ├── department/
│   │   ├── add_department.php   # Add department
│   │   ├── view_department.php  # View departments
│   │   └── delete_department.php
│   ├── teams/
│   │   └── view_teams.php       # View teams
│   └── ratings/
│       ├── rate_employee.php    # Rate an employee (1-5 stars)
│       ├── view_ratings.php     # All ratings list
│       └── top_employees.php    # Leaderboard
│
├── employee/
│   ├── index.php                # Employee login & signup (with CAPTCHA)
│   ├── dashboard.php            # Employee dashboard
│   ├── profile.php              # View & edit own profile
│   ├── change_password.php      # Change password
│   ├── contact.php              # Contact admin (email form)
│   └── top_employees.php        # Leaderboard view
│
├── api/
│   ├── get_states.php           # AJAX: Get states by country
│   ├── get_cities.php           # AJAX: Get cities by state
│   └── get_job_roles.php        # AJAX: Get job roles by department
│
├── assets/
│   ├── css/style.css            # Custom stylesheet
│   └── js/
│       ├── location.js          # Cascading location dropdowns
│       └── job_roles.js         # Dynamic job role dropdown
│
├── includes/
│   ├── db.php                   # Database connection (mysqli)
│   ├── header.php               # Common HTML head
│   ├── footer.php               # Common footer with Bootstrap JS
│   ├── sidebar.php              # Admin sidebar navigation
│   ├── employee_sidebar.php     # Employee sidebar navigation
│   ├── captcha.php              # CAPTCHA image generator
│   ├── mail_config.php          # PHPMailer SMTP configuration
│   └── PHPMailer/               # PHPMailer library files
│
├── database/
│   ├── ems.sql                  # Database schema (CREATE TABLE)
│   ├── seed_all_data.sql        # Full seed data
│   └── seed_employees.sql       # Employee seed data
│
└── uploads/
    ├── profiles/                # Uploaded profile pictures
    └── resumes/                 # Uploaded resume documents
```

---

## 🛠️ Tech Stack

| Technology | Usage |
|------------|-------|
| **PHP 8.x** | Backend logic, form handling, sessions, file uploads |
| **MySQL** | Relational database with foreign keys |
| **Bootstrap 5.3** | Responsive UI framework |
| **Bootstrap Icons** | Icon set |
| **jQuery 3.7** | AJAX live search |
| **JavaScript (Vanilla)** | Fetch API for cascading dropdowns |
| **PHPMailer** | SMTP email (Gmail) |
| **GD Library** | CAPTCHA image generation |
| **Apache (XAMPP)** | Local development server |

---

## 🚀 Local Setup

1. **Clone or download** the project into your XAMPP `htdocs` directory.
2. **Import database**: Run `database/ems.sql` in phpMyAdmin to create the schema. Then run `database/seed_all_data.sql` to populate sample data.
3. **Configure database**: Edit `includes/db.php` with your MySQL credentials.
4. **Configure email**: Edit `includes/mail_config.php` with your Gmail SMTP credentials (app password required).
5. **Start XAMPP**: Ensure Apache and MySQL are running.
6. **Access**: Open `http://localhost/your-path/ems_self/` in your browser.

---

## 📋 Summary of All PHP/Web Topics Demonstrated

| # | Topic |
|---|-------|
| 1 | PHP Sessions (`$_SESSION`) |
| 2 | PHP Forms (`$_POST`, `$_GET`) |
| 3 | File Uploads (`$_FILES`, `move_uploaded_file()`) |
| 4 | Password Hashing (`password_hash()`, `password_verify()`) |
| 5 | CAPTCHA Generation (GD Library — `imagecreate()`, `imagestring()`) |
| 6 | PHPMailer (SMTP Email via Gmail) |
| 7 | Email Verification (Token-based) |
| 8 | Forgot/Reset Password (Token with expiry) |
| 9 | AJAX Live Search (jQuery `$.ajax()`) |
| 10 | Dynamic Cascading Dropdowns (Fetch API) |
| 11 | Checkboxes with `implode()` / `explode()` |
| 12 | File Upload (Profile Picture & Resume) |
| 13 | MySQL CRUD Operations |
| 14 | JOIN Queries (LEFT JOIN) |
| 15 | Pagination (LIMIT & OFFSET) |
| 16 | Role-Based Access Control |
| 17 | `include` / `require` (Modular architecture) |
| 18 | `htmlspecialchars()` (XSS prevention) |
| 19 | `mysqli_real_escape_string()` (SQL injection prevention) |
| 20 | Foreign Keys & Relational Database Design |
| 21 | Bootstrap 5 Responsive UI |
| 22 | Account Enable/Disable (Status Toggle) |
| 23 | Contact Admin via Email |
| 24 | Employee Ratings & Leaderboard |
| 25 | Seed Data (SQL files) |

---

## 👨‍💻 Author

**Mayank Gaur**

---

## 📄 License

This project is built for learning and training purposes.
