# CampXchange

**Published and maintained by Pushkar Bagade (@Pushkar726).**

The included presentation retains its original team attribution; this repository publishes the XAMPP-based PHP/MySQL project files.

CampXchange is a student-to-student marketplace for campus essentials. Students can browse listings, post items for sale, and contact sellers. The project is built with PHP and MySQL and can be run locally with XAMPP.

## Features

- Student registration and login with password hashing
- Marketplace home page and listing browser with search and category filters
- Item detail pages
- Create, edit, and delete your own listings
- Upload listing photos
- Send a message to a seller
- Student dashboard with listings and received-message counts
- Admin login and dashboards for users and marketplace items

## Project structure

- `index.php` — marketplace home page and latest listings
- `browse.php`, `item.php` — search and view marketplace listings
- `register.php`, `login.php`, `logout.php` — student account flow
- `add_item.php`, `edit_item.php`, `delete_item.php`, `my_items.php` — listing management
- `contact_seller.php` — buyer-to-seller messages
- `dashboard.php` — student dashboard
- `admin/` — admin login, overview, user list, and item management
- `includes/` — shared database, authentication, navigation, header, and footer code
- `css/`, `js/` — styles and scripts
- `database.sql` — MySQL database and table definitions
- `presentation/CampXchange-Presentation.pptx` — project presentation

## Run it with XAMPP

### Requirements

- Windows with XAMPP
- Apache and MySQL services from the XAMPP Control Panel
- PHP's `mysqli` extension (included with standard XAMPP installations)

### Setup

1. Copy or extract this project into XAMPP's web root as `C:\xampp\htdocs\campxchange`.
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. In a browser, open `http://localhost/phpmyadmin/`.
4. Import `database.sql`. It creates and selects the `campxchange` database and its tables.
5. Copy `config.example.php` to `config.php`. For a default local XAMPP setup, the example uses `127.0.0.1`, MySQL user `root`, an empty password, and database `campxchange`. If your MySQL settings differ, edit `config.php` to match them.
6. Open `http://localhost/campxchange/`.

The `uploads/` folder is where new listing photos are stored. It is included as an empty folder in the repository; the app needs permission to write there.

### Create an admin account

The public database script intentionally does not create an admin with a shared default password. To add an admin:

1. Open **Shell** from the XAMPP Control Panel and generate a password hash:

   ```sh
   php -r "echo password_hash('ReplaceThisWithYourOwnPassword', PASSWORD_DEFAULT), PHP_EOL;"
   ```

2. In phpMyAdmin, select the `campxchange` database and run this query, replacing the username and hash:

   ```sql
   INSERT INTO admins (username, password)
   VALUES ('your-admin-name', 'paste-the-generated-hash-here');
   ```

3. Sign in at `http://localhost/campxchange/admin/admin_login.php`.

## Configuration and data

- `config.php` is ignored by Git. Keep real database credentials in that local file; do not commit credentials.
- Uploaded listing photos are ignored by Git because they may contain user data. Add only assets you have permission to publish.
- The repository contains the schema, not a dump of live users, listings, or messages.

## Current scope

The presentation describes verified student accounts and broader transaction features. The current database schema includes users, items, messages, and admins, but does not implement student verification or payment processing. GitHub hosts this source code; it does not by itself deploy the app as a live website.

## License

No license has been selected yet. Add a license before allowing others to reuse or redistribute the project.

