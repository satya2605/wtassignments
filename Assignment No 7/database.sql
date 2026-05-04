CREATE DATABASE IF NOT EXISTS vit_results_db;
USE vit_results_db;

CREATE TABLE IF NOT EXISTS student_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    -- Web Technology (WT)
    wt_mse INT DEFAULT 0,
    wt_ese INT DEFAULT 0,
    -- Operating Systems (OS)
    os_mse INT DEFAULT 0,
    os_ese INT DEFAULT 0,
    -- Artificial Intelligence (AI)
    ai_mse INT DEFAULT 0,
    ai_ese INT DEFAULT 0,
    -- Database Management Systems (DBMS)
    dbms_mse INT DEFAULT 0,
    dbms_ese INT DEFAULT 0
);

-- Seed some initial data
INSERT INTO student_results (student_name, course, wt_mse, wt_ese, os_mse, os_ese, ai_mse, ai_ese, dbms_mse, dbms_ese)
VALUES 
('Satya Nadella', 'B.Tech IT', 25, 65, 28, 60, 22, 55, 26, 68),
('Sundar Pichai', 'B.Tech CSE', 29, 68, 27, 62, 24, 58, 28, 64),
('Sam Altman', 'B.Tech AI-DS', 15, 30, 18, 35, 12, 25, 20, 28);
