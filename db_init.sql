-- Use variables
-- SET hospital = 'hospital';
-- SET root = 'root';
-- SET patient = 'patient';
-- SET patient2 = 'insurance';


-- Connect to MySQL server on localhost
-- mysql -u root -p;

-- Create a new database (if it doesn't exist)
CREATE DATABASE IF NOT EXISTS hospital;

-- Switch to the newly created database
USE hospital;

-- Create a table named 'your_table_name'
CREATE TABLE IF NOT EXISTS patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    PRIMARY KEY (_id));


CREATE TABLE IF NOT EXISTS insurance(
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT(10) UNSIGNED NOT NULL,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (patient_id) REFERENCES patient(_id));


-- create patient table sample data
insert into hospital.patient (pn, first, last, dob) VALUES 
('3456789012', 'Mart', 'Tamm', '1987-10-15'),
('6012345673', 'Liisa', 'Mägi', '1995-05-20'),
('5678901234', 'Andres', 'Sepp', '1980-03-10'),
('4734567890', 'Kati', 'Kask', '1976-12-25'),
('4987654321', 'Eva', 'Pärn', '1992-08-05');


-- create insurance table sample data
insert into hospital.insurance (patient_id, iname, from_date, to_date) VALUES
(1, 'Haigekassa', '2020-01-01', '2021-12-31'),
(1, 'Elukindlustus', '2018-05-01', '2023-04-30'),
(2, 'Ergo Kindlustus', '2019-03-15', '2022-02-28'),
(2, 'Omniva Kindlustus', '2021-07-01', '2024-06-30'),
(3, 'IF Kindlustus', '2017-09-10', '2022-08-31'),
(3, 'Salva Kindlustus', '2020-11-15', '2025-10-31'),
(4, 'PZU Kindlustus', '2018-12-20', '2023-11-30'),
(4, 'Compensa Kindlustus', '2019-08-15', '2022-07-31'),
(5, 'Swedbank Kindlustus', '2020-06-01', '2023-05-31'),
(5, 'Eesti Kindlustus', '2021-03-01', '2024-02-28');


-- Exit MySQL prompt
exit

