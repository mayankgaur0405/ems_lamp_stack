-- ============================================================
-- Seed additional data across ALL tables for testing
-- Database: ems2
-- ============================================================

-- ========================
-- DEPARTMENTS (adding 6 more → total 10)
-- ========================
INSERT INTO departments (name) VALUES
  ('Finance'),
  ('Operations'),
  ('Design'),
  ('Legal'),
  ('Customer Support'),
  ('Research & Development');

-- ========================
-- COUNTRIES (adding 5 more → total 8)
-- ========================
INSERT INTO countries (name) VALUES
  ('Canada'),
  ('Australia'),
  ('Germany'),
  ('Japan'),
  ('Singapore');

-- Get newly inserted country IDs (they'll be 4,5,6,7,8)
-- Canada=4, Australia=5, Germany=6, Japan=7, Singapore=8

-- ========================
-- STATES (adding 10 more → total 17)
-- ========================
INSERT INTO states (name, country_id) VALUES
  ('Ontario', 4),
  ('British Columbia', 4),
  ('New South Wales', 5),
  ('Victoria', 5),
  ('Bavaria', 6),
  ('Berlin', 6),
  ('Tokyo', 7),
  ('Osaka', 7),
  ('Central Region', 8),
  ('Delhi', 3);

-- New state IDs: Ontario=8, BC=9, NSW=10, Victoria=11, Bavaria=12, Berlin=13, Tokyo=14, Osaka=15, Central=16, Delhi=17

-- ========================
-- CITIES (adding 12 more → total 20)
-- ========================
INSERT INTO cities (name, state_id) VALUES
  ('Toronto', 8),
  ('Ottawa', 8),
  ('Vancouver', 9),
  ('Sydney', 10),
  ('Melbourne', 11),
  ('Munich', 12),
  ('Berlin', 13),
  ('Tokyo', 14),
  ('Kyoto', 15),
  ('Singapore City', 16),
  ('New Delhi', 17),
  ('Noida', 17);

-- New city IDs: Toronto=9, Ottawa=10, Vancouver=11, Sydney=12, Melbourne=13, Munich=14, Berlin=15, Tokyo=16, Kyoto=17, Singapore City=18, New Delhi=19, Noida=20

-- ========================
-- JOB ROLES (adding 13 more → total 18)
-- ========================
INSERT INTO job_roles (title, department_id) VALUES
  ('QA Engineer', 1),
  ('Tech Lead', 1),
  ('HR Executive', 2),
  ('Content Writer', 3),
  ('Digital Marketing Manager', 3),
  ('Sales Manager', 4),
  ('Financial Analyst', 5),
  ('Accountant', 5),
  ('Operations Manager', 6),
  ('Supply Chain Analyst', 6),
  ('UI/UX Designer', 7),
  ('Graphic Designer', 7),
  ('Legal Advisor', 8),
  ('Customer Support Lead', 9),
  ('Support Executive', 9),
  ('Research Scientist', 10),
  ('Data Analyst', 10);

-- ========================
-- TEAMS (adding 8 more → total 10)
-- ========================
INSERT INTO teams (name, department_id) VALUES
  ('Backend Team', 1),
  ('Frontend Team', 1),
  ('Talent Acquisition', 2),
  ('Growth Marketing', 3),
  ('Enterprise Sales', 4),
  ('Budget & Planning', 5),
  ('Creative Studio', 7),
  ('R&D Innovation Lab', 10);

-- New team IDs: Backend=3, Frontend=4, Talent=5, Growth=6, Enterprise=7, Budget=8, Creative=9, R&D=10

-- ========================
-- MORE EMPLOYEES (15 more across new departments → total ~40)
-- ========================
SET @pwd = '$2y$10$JNTwO97xNMHsTB226c9e9O2oHST9lfSUknc5QGHvemd5AokJn0YFy';

INSERT INTO employees
  (name, email, phone, password, department_id, role, joining_date, designation, country_id, state_id, city_id, job_role_id, status)
VALUES
  -- Finance
  ('Neha Kapoor',        'neha.kapoor@company.com',        '9876500001', @pwd, 5, 'employee', '2024-02-10', 'Senior Analyst',       3, 5, 5, 12, 1),
  ('Robert Clarke',      'robert.clarke@company.com',      '1234500001', @pwd, 5, 'employee', '2023-09-15', 'Accountant',           1, 1, 1, 13, 1),
  ('Yuki Tanaka',        'yuki.tanaka@company.com',        '8123400001', @pwd, 5, 'employee', '2024-05-20', 'Financial Controller', 7, 14, 16, 12, 0),

  -- Operations
  ('Amit Joshi',         'amit.joshi@company.com',         '9876500002', @pwd, 6, 'employee', '2023-11-01', 'Ops Manager',          3, 17, 19, 14, 1),
  ('Laura Martinez',     'laura.martinez@company.com',     '1234500002', @pwd, 6, 'employee', '2024-06-12', 'Logistics Coordinator',4, 8, 9, 15, 1),
  ('Chen Wei',           'chen.wei@company.com',           '8123400002', @pwd, 6, 'employee', '2023-07-08', 'Supply Chain Lead',    8, 16, 18, 15, 1),

  -- Design
  ('Sakshi Rathore',     'sakshi.rathore@company.com',     '9876500003', @pwd, 7, 'employee', '2024-01-25', 'UI/UX Lead',           3, 6, 7, 16, 1),
  ('Marcus Lee',         'marcus.lee@company.com',         '1234500003', @pwd, 7, 'employee', '2023-08-30', 'Visual Designer',      5, 10, 12, 17, 1),
  ('Emma Schneider',     'emma.schneider@company.com',     '4912345001', @pwd, 7, 'employee', '2024-04-18', 'Motion Designer',      6, 12, 14, 17, 0),

  -- Legal
  ('Aditi Saxena',       'aditi.saxena@company.com',       '9876500004', @pwd, 8, 'employee', '2023-03-22', 'Senior Legal Counsel', 3, 17, 19, 18, 1),
  ('Thomas Wright',      'thomas.wright@company.com',      '4412340001', @pwd, 8, 'employee', '2024-07-05', 'Contract Specialist',  2, 4, 4, 18, 1),

  -- Customer Support
  ('Pooja Malhotra',     'pooja.malhotra@company.com',     '9876500005', @pwd, 9, 'employee', '2024-03-14', 'Support Team Lead',    3, 7, 8, 19, 1),
  ('Kevin Park',         'kevin.park@company.com',         '1234500004', @pwd, 9, 'employee', '2023-12-01', 'Support Specialist',   4, 9, 11, 20, 0),

  -- R&D
  ('Dr. Ramesh Iyer',    'ramesh.iyer@company.com',        '9876500006', @pwd, 10, 'employee', '2023-01-10', 'Lead Researcher',     3, 6, 7, 21, 1),
  ('Hannah Fischer',     'hannah.fischer@company.com',     '4912345002', @pwd, 10, 'employee', '2024-08-20', 'Data Scientist',      6, 13, 15, 22, 1);

-- ========================
-- TEAM MEMBERS (assign employees to teams)
-- ========================
INSERT INTO team_members (team_id, employee_id) VALUES
  -- Backend Team (team 3) - Engineering employees
  (3, 10),   -- Aarav Sharma
  (3, 14),   -- Rahul Verma
  -- Frontend Team (team 4) - Engineering employees
  (4, 11),   -- Priya Patel
  (4, 13),   -- Emily Chen
  -- Talent Acquisition (team 5) - HR employees
  (5, 15),   -- Sneha Gupta
  (5, 16),   -- Michael Brown
  -- Growth Marketing (team 6)
  (6, 19),   -- David Miller
  (6, 20),   -- Kavya Nair
  -- Enterprise Sales (team 7)
  (7, 24),   -- Vikram Singh
  (7, 25),   -- Jessica Davis
  -- Core Development (team 1) - add more members
  (1, 12),   -- James Anderson
  -- Recruitment Squad (team 2) - add more
  (2, 18);   -- Ananya Reddy

-- ========================
-- EMPLOYEE RATINGS (add reviews for testing)
-- ========================
INSERT INTO employee_ratings (employee_id, rated_by, rating, review) VALUES
  (10, 1, 4, 'Aarav shows great initiative and consistently delivers quality code. Strong potential for growth.'),
  (11, 1, 5, 'Priya is an exceptional developer. Her code reviews are thorough and she mentors juniors effectively.'),
  (12, 1, 3, 'James is reliable with DevOps tasks but could improve communication with the team.'),
  (14, 1, 4, 'Rahul has strong backend skills and is quick to pick up new technologies.'),
  (15, 1, 5, 'Sneha is an outstanding HR coordinator. She handles recruitment drives flawlessly.'),
  (16, 1, 4, 'Michael brings great energy to the recruitment process. Good cultural fit assessments.'),
  (19, 1, 4, 'David creates compelling content strategies. His blog posts have increased engagement by 40%.'),
  (20, 1, 3, 'Kavya manages social media well but needs to explore newer platforms and trends.'),
  (24, 1, 5, 'Vikram consistently exceeds sales targets. A natural leader in the sales team.'),
  (25, 1, 4, 'Jessica builds excellent client relationships. Her retention rate is among the highest.'),
  (28, 1, 4, 'Rohan is a persistent closer. Great at follow-ups and maintaining pipeline discipline.'),
  (3, 1, 4, 'Jane manages HR processes efficiently and has great interpersonal skills.');
