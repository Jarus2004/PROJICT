# PROJECT-PHP - VALIDATION REPORT 🔍

## Executive Summary
**Status:** ⚠️ **MULTIPLE CRITICAL ISSUES FOUND**
- **Critical Issues:** 5
- **High Priority Issues:** 4
- **Medium Priority Issues:** 3
- **Total Issues:** 12

---

## CRITICAL ISSUES 🔴

### 1. SQL Injection Vulnerabilities
**Severity:** CRITICAL | **Type:** Security

#### Files Affected:
- [test/index.php](test/index.php#L21)
- [pages/page.php](pages/page.php#L91)
- [test/test.php](test/test.php)

#### Problem:
```php
// VULNERABLE ❌
$stmt = $conn->prepare("SELECT * FROM bob WHERE id = $user_id");
$stmt->execute();
```

The variable `$user_id` is directly inserted into SQL query string instead of using prepared statement parameters.

#### Fix:
```php
// SECURE ✅
$stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
$stmt->execute([$user_id]);
```

**Impact:** An attacker could inject malicious SQL code and compromise the database.

---

### 2. Incorrect File Path - Wrong Require Statement
**Severity:** CRITICAL | **Type:** File System

#### File: [test/index.php](test/index.php#L1)

#### Problem:
```php
<?php  
    require_once 'data.php';  // ❌ WRONG PATH
```
The file `data.php` is located in `config/` directory, not in `test/` directory.

#### Current Structure:
```
test/
  ├── index.php (trying to require 'data.php')
  ├── header.php
  ├── test.php
  └─ styles.css

config/
  └── data.php ✅ (actual location)
```

#### Fix:
```php
<?php  
    require_once '../config/data.php';  // ✅ CORRECT
```

**Impact:** File will not be found, causing fatal error: "Failed opening required 'data.php'".

---

### 3. Null Pointer/Undefined Array Access
**Severity:** CRITICAL | **Type:** Logic Error

#### Files Affected:
- [test/index.php](test/index.php#L22-23)
- [pages/page.php](pages/page.php#L91-95)

#### Problem:
```php
<?php 
    if(isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->prepare("SELECT * FROM bob WHERE id = $user_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>
<!-- Now using $row without checking if it exists -->
<p>ปลอดภัย <?php echo $row['username']; ?></p>
```

#### Issues:
1. No null check before accessing `$row['username']`
2. If query returns no results, `$row` will be `false`
3. Causes "Trying to access array offset on false" error

#### Fix:
```php
<?php 
    if(isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->prepare("SELECT * FROM bob WHERE id = ?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            echo $row['username'];
        } else {
            echo "User not found";
        }
    }
?>
```

---

### 4. Email Registration - Null Pointer in Duplicate Check
**Severity:** CRITICAL | **Type:** Logic Error

#### File: [auth/roe.php](auth/roe.php#L24-29)

#### Problem:
```php
$checkE = $conn->prepare("SELECT * FROM bob WHERE email = :email");
$checkE->bindParam(':email', $email);
$checkE->execute();
$row = $checkE->fetch(PDO::FETCH_ASSOC);

if($row['email'] == $email) {  // ❌ If no results, $row is false!
    $_SESSION['error'] = "Email นี้ถูกใช้แล้ว";
}
```

If no user with that email exists, `$row` is `false`, and accessing `$row['email']` causes error.

#### Fix:
```php
$checkE = $conn->prepare("SELECT * FROM bob WHERE email = :email");
$checkE->bindParam(':email', $email);
$checkE->execute();
$row = $checkE->fetch(PDO::FETCH_ASSOC);

if($row && $row['email'] == $email) {  // ✅ Check if $row exists first
    $_SESSION['error'] = "Email นี้ถูกใช้แล้ว";
}
```

---

### 5. Weak File Upload Security
**Severity:** CRITICAL | **Type:** Security

#### Files Affected:
- [admin/insert_product.php](admin/insert_product.php#L8-19)
- [admin/edit_game.php](admin/edit_game.php#L14-29)

#### Problems:
1. **Predictable Filenames:** Uses `rand()` which can cause collision
   ```php
   $filenew = rand() . "." . $filesactext;  // Weak! Only checks extension
   ```
2. **Extension-Only Validation:** Easily bypassed by renaming malicious files
3. **No MIME Type Check:** Doesn't verify actual file type

#### Risks:
- Attackers can upload PHP/executable files by renaming them
- Path traversal attacks possible
- File collision overwrites

#### Fix:
```php
// Generate unique filename with hash
$filename = bin2hex(random_bytes(16)) . "." . $filesactext;

// Validate MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $image['tmp_name']);
$allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];

if (!in_array($mime, $allowed_mimes)) {
    $_SESSION['error'] = "File type not allowed";
    exit();
}

// Store in safe location outside web root
$filePath = dirname(__DIR__) . "/uploads/" . $filename;
```

---

## HIGH PRIORITY ISSUES 🟠

### 6. Database Connection Hardcoded Credentials
**Severity:** HIGH | **Type:** Security

#### File: [config/data.php](config/data.php#L1-8)

#### Problem:
```php
$servername = "localhost";
$username = "root";
$password = "";  // ❌ Credentials visible in code
```

Credentials are hardcoded and visible in version control.

#### Fix:
```php
// Use environment variables or .env file
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'register';
```

Or use a `.env` file (add to .gitignore):
```
DB_HOST=localhost
DB_USER=root
DB_PASS=your_secure_password
DB_NAME=register
```

---

### 7. No CSRF Token Protection
**Severity:** HIGH | **Type:** Security

#### Files Affected:
- [auth/login.php](auth/login.php)
- [auth/register.php](auth/register.php)
- [admin/product.php](admin/product.php)
- All forms

#### Problem:
Forms lack CSRF tokens. An attacker can forge requests on behalf of users.

#### Fix:
```php
// In forms, add token
<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <!-- form fields -->
</form>

// In processing script
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}
```

---

### 8. Missing Input Validation
**Severity:** HIGH | **Type:** Security

#### File: [admin/insert_product.php](admin/insert_product.php#L9-10)

#### Problem:
```php
$name = $_POST['name'];      // ❌ No validation
$price = $_POST['price'];    // ❌ No validation
```

#### Fix:
```php
$name = trim($_POST['name'] ?? '');
$price = floatval($_POST['price'] ?? 0);

if (empty($name) || $name > 100) {
    $_SESSION['error'] = "Invalid product name";
    exit();
}

if ($price <= 0) {
    $_SESSION['error'] = "Invalid price";
    exit();
}
```

---

### 9. Missing Admin Check in Admin Pages
**Severity:** HIGH | **Type:** Security

#### File: [admin/edit_game.php](admin/edit_game.php#L1-6)

#### Problem:
Admin check happens but missing `exit()` after redirect:
```php
if(!isset($_SESSION['admin_login'])){
    header("Location: ../auth/login.php");
    // ❌ Missing exit() - code continues executing!
}
```

#### Fix:
```php
if(!isset($_SESSION['admin_login'])){
    header("Location: ../auth/login.php");
    exit();  // ✅ Stop execution
}
```

---

## MEDIUM PRIORITY ISSUES 🟡

### 10. Inconsistent Directory Structure
**Severity:** MEDIUM | **Type:** Organization

#### Issue:
- Files reference both `test/` and `pages/` as homepage
- `test/index.php` appears to be duplicate of `pages/page.php`
- Unclear which is the actual entry point

#### Recommendation:
Remove duplicate files and maintain single entry point. Use [pages/page.php](pages/page.php) as main homepage.

---

### 11. Missing Database Schema Documentation
**Severity:** MEDIUM | **Type:** Documentation

#### Issue:
No SQL schema file provided. Table names are scattered through code:
- `bob` (users)
- `games_table` (products)
- `cart`, `cart_item` (shopping cart)
- `game_keys` (keys)

#### Recommendation:
Create `database.sql` with all schema definitions:
```sql
CREATE TABLE bob (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    user_role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Include other tables...
```

---

### 12. No Error Logging
**Severity:** MEDIUM | **Type:** Logging

#### Issue:
Errors displayed directly to users with `echo $e->getMessage()` - exposes system information.

#### Fix:
```php
try {
    // code
} catch(PDOException $e) {
    error_log($e->getMessage(), 0);  // Log to file
    $_SESSION['error'] = "Database error occurred";
    header("Location: error.php");
}
```

---

## SUMMARY TABLE

| Issue | Severity | File(s) | Status |
|-------|----------|---------|--------|
| SQL Injection | 🔴 CRITICAL | test/index.php, pages/page.php | NOT FIXED |
| Wrong Require Path | 🔴 CRITICAL | test/index.php | NOT FIXED |
| Null Pointer Errors | 🔴 CRITICAL | test/index.php, pages/page.php | NOT FIXED |
| Email Duplicate Check | 🔴 CRITICAL | auth/roe.php | NOT FIXED |
| Weak File Upload | 🔴 CRITICAL | admin/insert_product.php, edit_game.php | NOT FIXED |
| Hardcoded Credentials | 🟠 HIGH | config/data.php | NOT FIXED |
| No CSRF Protection | 🟠 HIGH | All forms | NOT FIXED |
| Missing Input Validation | 🟠 HIGH | admin/insert_product.php | NOT FIXED |
| Missing Admin exit() | 🟠 HIGH | admin/edit_game.php | NOT FIXED |
| Duplicate Files | 🟡 MEDIUM | test/index.php, pages/page.php | NOT FIXED |
| No DB Schema Doc | 🟡 MEDIUM | Project Root | NOT FIXED |
| No Error Logging | 🟡 MEDIUM | Multiple | NOT FIXED |

---

## Recommended Action Plan

1. **IMMEDIATE (Today):**
   - Fix SQL injection vulnerabilities
   - Fix null pointer errors
   - Fix require path in test/index.php
   - Add exit() after redirects

2. **THIS WEEK:**
   - Implement CSRF protection
   - Add input validation
   - Improve file upload security
   - Move credentials to env file

3. **THIS MONTH:**
   - Implement error logging
   - Add database schema documentation
   - Remove duplicate files
   - Add unit tests

---

Generated: 2026-02-08
