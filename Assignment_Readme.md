A secure web-based Movie Booking System developed for IE5042 Software Security assignment. 
This project demonstrates the identification and mitigation of OWASP Top 10 vulnerabilities, including SQL Injection and XSS, 
and features integrated OAuth 2.0 authentication.

IE5042 - Software Security Assignment (Movie Booking System)

1. Group Information
Member 1 Name: K.K Janith Pasindu

Member 1 Index: MS26917252

Member 2 Name: D.G.C.D Weerakoon

Member 2 Index: MS26902410

2. Project Links
Original Project Reference: https://github.com/gosaliajainam/online-movie-booking

Modified Project Repository: https://github.com/K2Pasindu/Secure-Movie-Booking-Assignment

Demo Video (YouTube): [Oyaage YouTube Video Link eka methana danna]

3. Executive Summary
This project focuses on auditing and securing a legacy Online Movie Booking System. The primary goal was to identify critical security flaws based on the OWASP Top 10 framework and implement robust defenses. Key improvements include securing the database layer against injection attacks, protecting user sessions, and implementing modern authentication via OAuth 2.0.

4. Vulnerabilities Identified & Fixed
SQL Injection (SQLi): Found in login and movie search modules. Fixed using MySQLi Prepared Statements.

Stored Cross-Site Scripting (XSS): Found in the user profile and booking comments section. Fixed using Output Encoding.

Broken Authentication: Passwords were stored in plain text. Fixed by implementing BCRYPT Password Hashing.

Sensitive Data Exposure: Database connection errors were visible to users. Fixed by disabling verbose error reporting.

Insecure Direct Object Reference (IDOR): Booking details were accessible by changing IDs in the URL. Fixed with session-level authorization.

Security Misconfiguration: Improper directory listing enabled. Fixed via .htaccess configuration.

5. Security Tools Used
OWASP ZAP: For automated vulnerability scanning.

sqlmap: For testing SQL injection points.

OWASP Dependency-Check: To scan for vulnerable PHP libraries.

6. Setup & Installation
Clone the repository.

Import database.sql (or the relevant .sql file) into your MySQL server via phpMyAdmin.

Configure config.php (or your db connection file) with your local database credentials.

Run via XAMPP/WAMP (localhost).
