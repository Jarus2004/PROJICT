# PROJECT

เว็บไซต์ขายKEYS GAMES พัฒนาโดยใช้ PHP และ MySQL  
มีระบบสมาชิก ตะกร้าสินค้า และระบบแอดมิน

## Contents
- [Features](#features)
- [Technologies](#technologies)
- [Project Structure](#project-structure)
- [Database Structure](#database-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Author](#author)

## Features
- สมัครสมาชิก / เข้าสู่ระบบ
- ระบบตะกร้าสินค้า
- ระบบแอดมิน
- CRUD ข้อมูล

## Technologies
- PHP
- MySQL
- HTML / CSS
- Bootstrap 5
- JavaScript

## Project Structure
```
PROJECT-PHP/
│
├── admin/                     # ส่วนผู้ดูแลระบบ
│   ├── admin_page.php         # หน้าแดชบอร์ดแอดมิน
│   ├── edit_game.php          # แก้ไขข้อมูลสินค้า/เกม
│   └── insert_product.php     # เพิ่มสินค้าใหม่
│
├── auth/                      # ระบบยืนยันตัวตน
│   ├── login.php              # หน้าเข้าสู่ระบบ
│   ├── logout.php             # ออกจากระบบ
│   ├── register.php           # สมัครสมาชิก
│   ├── roe.php                # ตรวจสอบสิทธิ์ (role)
│   └── signin.php             # ประมวลผลการเข้าสู่ระบบ
│
├── cart/                      # ระบบตะกร้าสินค้า
│   ├── add_to_cart.php        # เพิ่มสินค้าเข้าตะกร้า
│   └── cart_page.php          # แสดงรายการสินค้าในตะกร้า
│
├── config/                    # การตั้งค่าระบบ
│   └── data.php               # การเชื่อมต่อฐานข้อมูล
│
├── includes/                  # ไฟล์ที่เรียกใช้ซ้ำ
│   └── slide.php              # สไลด์ / ส่วนแสดงผลร่วม
│
├── pages/                     # หน้าทั่วไปของเว็บไซต์
│   └── page.php
│
├── PAGEBACKUP/                # สำรองไฟล์
├── test/                      # ใช้สำหรับทดสอบระบบ
├── upload/                    # เก็บไฟล์ที่อัปโหลด (รูปสินค้า ฯลฯ)
│
└── README.md                  # เอกสารอธิบายโปรเจกต์
```

## Database Structure

โปรเจกต์นี้ใช้ฐานข้อมูล MySQL โดยมีตารางหลักดังนี้

### users
- id
- username
- password
- email
- creattime
- role (admin / user)

ใช้สำหรับจัดการข้อมูลผู้ใช้งานและสิทธิ์การเข้าถึง

### products
- id
- name
- price
- image

ใช้สำหรับจัดการข้อมูลสินค้า

### cart
- cart_id
- user_id
- product_id

ใช้สำหรับจัดการตะกร้าสินค้า

### cart_items
- cart_item_id
- cart_id
- product_id
- price
- quantity

แสดงสินค้าของแจ่ละUSER

## Installation
1. Clone หรือ Download โปรเจกต์
2. วางในโฟลเดอร์ htdocs
3. สร้างฐานข้อมูล
4. ตั้งค่าไฟล์ config/db.php

## Usage
เข้าใช้งานผ่าน  
http://localhost/project-php/auth/login.php

## Author
Jarus (Bonus)
Junior Web Developer