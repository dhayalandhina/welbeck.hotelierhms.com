<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=2,8,14&height=180&section=header&text=Welbeck+HMS&fontSize=60&fontColor=fff&animation=twinkling&fontAlignY=35&desc=Hotel%20Management%20System%20—%20FrontOffice%20Module&descAlignY=58&descSize=16" width="100%"/>

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](https://codeigniter.com)
[![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)](https://apachefriends.org)

</div>

---

## 🏨 What is Welbeck HMS?

**Welbeck Hotel Management System** is a comprehensive hotel management platform focusing on the FrontOffice module. Built with PHP + CodeIgniter framework, it handles reservations, guest check-in/check-out, room management, billing, and guest proofing — everything a hotel front desk needs.

> Part of the **Microgenn HotelierHMS** suite — built by [Dhina](https://github.com/dhayalandhina)

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🛎️ **Reservations** | Room booking and availability management |
| 🔑 **Check-in / Check-out** | Guest arrival and departure workflows |
| 🏠 **Room Management** | Room types, rates, and status tracking |
| 💳 **Billing & Invoicing** | Automated invoice generation |
| 👤 **Guest Profiles** | Guest history and document management |
| 📄 **Guest Proof** | KYC document upload and verification |
| 📊 **Reports** | Daily, monthly operational reports |

---

## 🏗️ Architecture

```
Browser
   ↓
CodeIgniter MVC (PHP)
   ↓
├── Controllers (app/)     # Business logic
├── Views (skin/)          # UI templates
├── Models                 # Database layer
└── MySQL Database         # Hotel data storage
```

---

## 📁 Project Structure

```
welbeck.hotelierhms.com/
├── app/                   # CodeIgniter application
│   ├── Controllers/       # Route handlers & business logic
│   ├── Models/            # Database models
│   └── Views/             # HTML templates
├── GuestProof/            # Guest KYC document uploads
├── assets/                # CSS, JS, images
├── skin/                  # UI theme & templates
├── system/                # CodeIgniter core
├── upload/                # File uploads
├── SQLQuery1.sql          # Database schema
├── index.php              # Application entry point
└── web.config             # IIS configuration
```

---

## 🚀 Quick Start (XAMPP)

### 1. Setup Database
```sql
-- Import the schema
source SQLQuery1.sql;
```

### 2. Configure Database
```php
// app/Config/Database.php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'welbeck_hms',
```

### 3. Run
```bash
# Windows — double click
xamp_batch.txt

# Or start Apache + MySQL from XAMPP Control Panel
# Visit: http://localhost/welbeck.hotelierhms.com
```

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Language | PHP 7.4+ |
| Framework | CodeIgniter 3 |
| Database | MySQL |
| Frontend | HTML5, CSS3, Bootstrap, jQuery |
| Server | Apache (XAMPP) / IIS |

---

## 🗺️ Modules Roadmap

- [x] 🛎️ FrontOffice Module
- [ ] 🍽️ Restaurant POS Module
- [ ] 🧹 Housekeeping Module
- [ ] 💰 Accounts & Billing Module
- [ ] 📊 Management Reports Module
- [ ] 📱 Mobile App (Guest Self Check-in)

---

<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=2,8,14&height=80&section=footer" width="100%"/>

**Part of [Microgenn HotelierHMS](https://github.com/dhayalandhina) — Built by Dhina 🚀**

</div>
