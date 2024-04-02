show databases;

show tables;

use insurance;

create table seller_register (id int auto_increment, username varchar(30), password varchar(30), primary key (id));

desc seller_register;

select * from seller_register;


create table buyer_register (id int auto_increment, username varchar(30), password varchar(30), primary key (id));

desc buyer_register;

select * from buyer_register;

create table insurance_info (id int auto_increment, username varchar(30), risk_score varchar(30), premium_amount varchar(30), status varchar (10), primary key (id));

desc insurance_info;

select * from insurance_info;

truncate table insurance_info;














CREATE TABLE cyber_insurance_application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sum_insured DECIMAL(10, 2) NOT NULL,
    data_protection_policy ENUM('yes', 'no') NOT NULL,
    employee_compliance ENUM('yes', 'no') NOT NULL,
    compliance_check ENUM('yes', 'no') NOT NULL,
    safe_harbor ENUM('yes', 'no') NOT NULL,
    data_protection_officer ENUM('yes', 'no') NOT NULL,
    firewall ENUM('yes', 'no') NOT NULL,
    anti_virus ENUM('yes', 'no') NOT NULL,
    network_weakness ENUM('yes', 'no') NOT NULL,
    monitor_breaches ENUM('yes', 'no') NOT NULL,
    physical_security ENUM('yes', 'no') NOT NULL,
    payment_processing ENUM('yes', 'no') NOT NULL,
    encryption_requirements ENUM('yes', 'no') NOT NULL,
    backup_mission_critical ENUM('yes', 'no') NOT NULL,
    backup_data_assets ENUM('yes', 'no') NOT NULL,
    background_checks ENUM('yes', 'no') NOT NULL,
    remote_authentication ENUM('yes', 'no') NOT NULL,
    outsourcing ENUM('yes', 'no') NOT NULL,
    data_outsourcing ENUM('yes', 'no') NOT NULL,
    data_protection_insurance ENUM('yes', 'no') NOT NULL,
    indemnification ENUM('yes', 'no') NOT NULL,
    outsourcers_compliance ENUM('yes', 'no') NOT NULL,
    investigation_audit ENUM('yes', 'no') NOT NULL,
    subject_access_request ENUM('yes', 'no') NOT NULL,
    enforcement_notice ENUM('yes', 'no') NOT NULL,
    potential_claim ENUM('yes', 'no') NOT NULL
   
);


desc cyber_insurance_application;

select * from cyber_insurance_application;

truncate table cyber_insurance_application;






