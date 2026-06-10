-- ============================================================
-- Seed 20 employees for testing pagination & search filters
-- Database: ems2
-- Run: mysql -u root ems2 < seed_employees.sql
-- ============================================================
-- All passwords are hashed from "password123"

SET @pwd = '$2y$10$JNTwO97xNMHsTB226c9e9O2oHST9lfSUknc5QGHvemd5AokJn0YFy';

INSERT INTO employees
  (name, email, phone, password, department_id, role, joining_date, designation, country_id, state_id, city_id, job_role_id, status)
VALUES
  -- Engineering department employees
  ('Aarav Sharma',       'aarav.sharma@company.com',       '9876543210', @pwd, 1, 'employee', '2024-01-15', 'Junior Developer',    3, 5, 5, 1, 1),
  ('Priya Patel',        'priya.patel@company.com',        '9876543211', @pwd, 1, 'employee', '2023-06-20', 'Senior Developer',    3, 6, 7, 1, 1),
  ('James Anderson',     'james.anderson@company.com',     '1234567890', @pwd, 1, 'employee', '2024-03-10', 'DevOps Specialist',   1, 1, 1, 2, 1),
  ('Emily Chen',         'emily.chen@company.com',         '1234567891', @pwd, 1, 'employee', '2023-11-05', 'Full Stack Developer',1, 2, 3, 1, 0),
  ('Rahul Verma',        'rahul.verma@company.com',        '9876543212', @pwd, 1, 'employee', '2024-05-01', 'Backend Engineer',    3, 7, 8, 1, 1),

  -- HR department employees
  ('Sneha Gupta',        'sneha.gupta@company.com',        '9876543213', @pwd, 2, 'employee', '2023-02-14', 'HR Coordinator',      3, 5, 6, 3, 1),
  ('Michael Brown',      'michael.brown@company.com',      '1234567892', @pwd, 2, 'employee', '2024-07-22', 'Recruiter',           1, 1, 2, 3, 1),
  ('Sophie Williams',    'sophie.williams@company.com',    '4412345678', @pwd, 2, 'employee', '2023-09-30', 'HR Analyst',          2, 3, 4, 3, 0),
  ('Ananya Reddy',       'ananya.reddy@company.com',       '9876543214', @pwd, 2, 'employee', '2024-01-08', 'Training Manager',    3, 6, 7, 3, 1),

  -- Marketing department employees
  ('David Miller',       'david.miller@company.com',       '1234567893', @pwd, 3, 'employee', '2023-04-18', 'Content Strategist',  1, 2, 3, 4, 1),
  ('Kavya Nair',         'kavya.nair@company.com',         '9876543215', @pwd, 3, 'employee', '2024-02-25', 'Social Media Manager',3, 5, 5, 4, 1),
  ('Oliver Taylor',      'oliver.taylor@company.com',      '4412345679', @pwd, 3, 'employee', '2023-08-12', 'Brand Manager',       2, 3, 4, 4, 0),
  ('Meera Iyer',         'meera.iyer@company.com',         '9876543216', @pwd, 3, 'employee', '2024-06-01', 'Digital Marketing Lead',3, 6, 7, 4, 1),
  ('Sarah Johnson',      'sarah.johnson@company.com',      '1234567894', @pwd, 3, 'employee', '2023-12-15', 'SEO Specialist',      1, 1, 1, 4, 1),

  -- Sales department employees
  ('Vikram Singh',       'vikram.singh@company.com',       '9876543217', @pwd, 4, 'employee', '2024-04-05', 'Sales Manager',       3, 7, 8, 5, 1),
  ('Jessica Davis',      'jessica.davis@company.com',      '1234567895', @pwd, 4, 'employee', '2023-07-28', 'Account Executive',   1, 2, 3, 5, 1),
  ('Arjun Mehta',        'arjun.mehta@company.com',        '9876543218', @pwd, 4, 'employee', '2024-08-10', 'Business Development', 3, 5, 6, 5, 0),
  ('Charlotte Wilson',   'charlotte.wilson@company.com',   '4412345680', @pwd, 4, 'employee', '2023-10-22', 'Regional Sales Head', 2, 3, 4, 5, 1),
  ('Rohan Desai',        'rohan.desai@company.com',        '9876543219', @pwd, 4, 'employee', '2024-03-17', 'Inside Sales Rep',    3, 5, 5, 5, 1),
  ('Daniel Thompson',    'daniel.thompson@company.com',    '1234567896', @pwd, 4, 'employee', '2023-05-09', 'Sales Analyst',       1, 1, 2, 5, 1);
