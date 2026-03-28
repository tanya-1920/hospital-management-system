<img width="1900" height="920" alt="image" src="https://github.com/user-attachments/assets/8beb402b-d581-4c9d-8dfa-faaab99264f3" />
# hospital-management-system

---

## 📌 Description

Hospital Management System (HDIMS) is a web-based Hospital Management System designed to streamline healthcare operations and to manage hospital activities efficiently through a centralized platform. It helps in handling patient records, doctor management, appointment scheduling, and administrative tasks. It includes modules for patient registration, doctor scheduling, appointment booking, and administrative control, built using PHP and MySQL.

---

## Features

*  Patient Registration & Login
*  Doctor Management
*  Appointment Booking System
*  Admin Dashboard
*  Patient Records Management
*  Role-Based Access (Admin / Doctor / Patient)

---

##  Tech Stack

* **Frontend:**: HTML, CSS, JavaScript
* **Backend:**: PHP
* **Database:**: MySQL
* **Server:**:XAMPP

---


##  Installation & Setup

Follow the steps below to run the project locally on your system:

---

###  Prerequisites

Make sure the following are installed on your system:

* XAMPP (Apache + MySQL)
   <br> source link(windows) : `https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe `
   <br> tutorial link : `https://youtu.be/UjAbsItMPRY?si=Vc9ITMEKEuIj08ll`
* Web browser (any)
* Git (for cloning)
   <br> source link : `https://github.com/`
   

---

### 🔹 Step 1: Clone the Repository

```bash
git clone https://github.com/tanya-1920/hospital-management-system.git
```

Or download the ZIP and extract it.

---

### 🔹 Step 2: Move Project to XAMPP Directory

* Navigate to your XAMPP installation folder
* Open `htdocs`
* Copy the project folder (`hms`) into:

```bash
C:\xampp\htdocs\
```

Final path should look like:
<img width="1259" height="275" alt="image" src="https://github.com/user-attachments/assets/e7ceaf65-6a2d-416e-bbf1-972bf3341a4c" />

```bash
C:\xampp\htdocs\hms
```

---

### 🔹 Step 3: Start XAMPP Server

* Open XAMPP Control Panel
* Start the following services:

  * Apache
  * MySQL

Make sure both are running (GREEN status)
<img width="836" height="563" alt="image" src="https://github.com/user-attachments/assets/485248f8-446f-4010-9be9-31ad4d8157dc" />

---

### 🔹 Step 4: Create Database

1. Open browser and go to:

```bash
http://localhost/phpmyadmin
```

2. Click on **New**  
3. Create a database named:

```bash
hms
```
<img width="1419" height="854" alt="image" src="https://github.com/user-attachments/assets/c17e24ea-d7d7-4317-8c40-744b30730544" />
(click on create)
---

### 🔹 Step 5: Import Database

1. Select the `hms` database
2. Click on **Import**
3. Click **Choose File**
4. Select the file:

```bash
hms.sql
```
<img width="1883" height="921" alt="image" src="https://github.com/user-attachments/assets/e837220e-ad6c-4a76-94ea-d063b298e531" />

(from your project folder)

5. Click **Go**

---

### 🔹 Step 6: Configure Database Connection

Open the file:

```bash
hms/include/config.php
```

---

### 🔹 Step 7: Run the Project

Open browser and go to:

```bash
http://localhost/hms
```

---

### 🔹 Step 8: Login credentials

* Admin Panel: `http://localhost/hdmis/hms/admin/`
      <br>  USERNAME:
      <br>  PASSWORD:
* Doctor Panel: `http://localhost/hdmis/hms/doctor/`
      <br>  USERNAME:
      <br>  PASSWORD:
* Patient Panel: `http://localhost/hdmis/hms/user-login.php`
      <br>  USERNAME:
     <br>   PASSWORD:
---

###  Troubleshooting

* If Apache/MySQL not starting → check port conflicts
* If database not connecting → verify config.php credentials
* If page not loading → ensure project is inside `htdocs`
* If CSS not loading → check file paths

---

###  Setup Complete

Your Hospital Management System should now be running locally.


##  Screenshots

**LANDING PAGE**
<br>Hero section
<img width="1900" height="920" alt="image" src="https://github.com/user-attachments/assets/8beb402b-d581-4c9d-8dfa-faaab99264f3" />
<br>Services
<img width="1887" height="912" alt="image" src="https://github.com/user-attachments/assets/d36a977c-1b20-49c7-8b3a-ed8a54ac28ff" />
<img width="1918" height="917" alt="image" src="https://github.com/user-attachments/assets/64f55640-a5a4-4771-9f0b-b313164908b7" />
<br>Reviews
<img width="1917" height="923" alt="image" src="https://github.com/user-attachments/assets/173fcf24-7868-41ec-8193-205e077d4177" />
<br>Portals
<img width="1899" height="923" alt="image" src="https://github.com/user-attachments/assets/8cc0a613-6fbe-407f-8bf7-07b663e39d1d" />
<br>Contact
<img width="1892" height="920" alt="image" src="https://github.com/user-attachments/assets/17de0d73-1845-45e2-ab1c-e7ed4453d1a9" />

<br>
<br>
##LOGINS & SIGNUP
<br>
#<br>Patient panel
<img width="1897" height="903" alt="image" src="https://github.com/user-attachments/assets/cd5d9755-1d4f-4df0-8de5-abc9970f57c6" />
<img width="1895" height="901" alt="image" src="https://github.com/user-attachments/assets/b1986113-f018-44fc-aa5a-63423e898553" />
<br>
#<br> Doctor Panel 
<img width="1895" height="903" alt="image" src="https://github.com/user-attachments/assets/00cc88ec-46b1-4024-a049-6349e79cd175" />
<br>
#<br> Admin Panel 
<img width="1898" height="900" alt="image" src="https://github.com/user-attachments/assets/ddfc7067-b66f-49ac-8bbd-e042bb5d3885" />
<br>
<br>

###  USER PANEL 
<br>
<br> user Dashoard
<img width="1893" height="913" alt="image" src="https://github.com/user-attachments/assets/b0af8585-94aa-42b6-a3a9-7cc75ccf0647" />
<img width="1900" height="395" alt="image" src="https://github.com/user-attachments/assets/6ce91495-3f0c-4dec-83fb-8c7c7fc61af0" />
<br>
<br> Appointment booking form
<img width="1899" height="920" alt="image" src="https://github.com/user-attachments/assets/aa3f036d-e35b-43ad-9fd0-8a0e017ed814" />
<br>
<br> Appointment history
<img width="1882" height="925" alt="image" src="https://github.com/user-attachments/assets/883a9b37-4a08-46b1-b86e-cdf248883656" />
<br>
<br>Appointment tracking 
<img width="1917" height="912" alt="image" src="https://github.com/user-attachments/assets/15f4d258-abfd-436b-a73f-a6bd230afb88" />
<br>
<br> Login section
<img width="720" height="285" alt="image" src="https://github.com/user-attachments/assets/7c64d07a-4b20-4cf5-aac6-c49c7c081dfe" />
<br>
<br> Edit profile
<img width="1916" height="916" alt="image" src="https://github.com/user-attachments/assets/c0aebd5b-810c-4c0a-a798-1741df51399a" />
<br>
<br> Password change 
<img width="1913" height="914" alt="image" src="https://github.com/user-attachments/assets/24b23dba-fa5c-4c48-ade0-e66b75c6913b" />
<br>
<br>Loader
<img width="1914" height="912" alt="image" src="https://github.com/user-attachments/assets/efbcbdc1-cad5-45e3-8953-f289578e3631" />


<br>
<br>
<br>
###  DOCTOR PANEL 
 <br>
<br> Dashoard
<img width="1891" height="918" alt="image" src="https://github.com/user-attachments/assets/a4986361-639f-477d-ab71-59e3e4389013" />
<img width="1885" height="919" alt="image" src="https://github.com/user-attachments/assets/a1b34e3d-1062-4e85-afef-226357cc6b39" />
 <br>
<br> Edit profile
<img width="1890" height="920" alt="image" src="https://github.com/user-attachments/assets/03095037-85a6-4b2a-8a57-e2ccc572302b" />
 <br>
<br> Appointment record
<img width="1915" height="915" alt="image" src="https://github.com/user-attachments/assets/83b01c88-784f-4c06-a17b-263e0635a889" />
 <br>
<br> Edit patient
<img width="1892" height="921" alt="image" src="https://github.com/user-attachments/assets/6ecbd8bb-ecb3-4a57-81f3-528ae84f2660" />
<img width="1908" height="920" alt="image" src="https://github.com/user-attachments/assets/3254cfcd-7fe1-4669-8c8f-69fe24bb8139" />
<img width="1912" height="920" alt="image" src="https://github.com/user-attachments/assets/7043b0b7-3b17-4678-a284-0e74dfa2590f" />
<img width="1873" height="920" alt="image" src="https://github.com/user-attachments/assets/a63865ad-df0d-4dd0-b081-3365d19ad701" />

 <br>
<br> Pending Appointments
<img width="1913" height="919" alt="image" src="https://github.com/user-attachments/assets/36b8cb46-0300-4da4-847d-4fd417602ee4" />
<br>
<br> Search patient
<img width="1916" height="919" alt="image" src="https://github.com/user-attachments/assets/b7034c51-a64f-4513-aad9-b78816281a8e" />

<br>
<br>Login 
<img width="475" height="254" alt="image" src="https://github.com/user-attachments/assets/6cc60b16-09f4-4297-a6b7-7552a56828a4" />
<br>
<br>Change pass
<img width="1913" height="913" alt="image" src="https://github.com/user-attachments/assets/b268a476-7017-4225-b0b7-6cb10d921953" />







---

## 🎯 Objective

The main objective of this project is to reduce manual work in hospitals and improve efficiency through a digital system.

---

