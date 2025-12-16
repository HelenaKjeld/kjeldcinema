# RowanCinema

RowanCinema is a cinema booking website built as a 1st semester exam project for **Databases** and **Web Programming – Backend PHP** at **Erhvervsakademi SydVest**.  
The site is a Dynamic Web Page (DWP) with a simple CMS-style **Admin Panel** for managing content and cinema data.

- **Repository:** https://github.com/HelenaKjeld/kjeldcinema
- **Deployed:** https://kanid.dk/

---

## Project overview

RowanCinema allows guests and registered users to:

- Browse movies and showtimes (filtered by date via a weekly calendar)
- Select seats with a visual seat map
- Complete a booking and view/download tickets and invoices
- View purchased tickets on a profile page (logged-in users)

Admins can:

- Manage movies, news, “coming soon”, about content, company info
- Create/manage showings (schedules) with venue + time + price
- Manage venues (generate seating layouts)
- Manage users (edit/delete, with restrictions)
- View bookings and ticket details

---

## Tech stack

- **Backend:** PHP (OOP structure)
- **Database:** MySQL (InnoDB), Views, Triggers
- **DB access:** PDO (prepared statements)
- **Frontend:** HTML + Tailwind CSS
- **Client-side:** JavaScript (seat selection)
- **Other:** PDF generation (tickets/invoices), optional payment integration (Stripe-related files)

---

## Folder structure (high level)

- `OOP/classes/` – Models (BaseModel + table classes like Movie, Showing, Ticket, Invoice, User)
- `includes/` – helpers (sessions, sanitization, constants)
- `components/` – reusable UI parts (header, footer, movie cards, calendar, etc.)
- `admin/` – Admin Panel pages
- `booking/` – Booking flow pages (confirm, create ticket, invoice page, PDF ticket)
- `sql/` – Database creation scripts

---

## Database

The database contains the entities needed for a cinema booking system:

- Movies, showings, venues/showrooms, seating
- Tickets and invoices
- Users + roles (admin/user)
- News, coming soon, company info, about content

### Views (why they matter)

- `v_booking_overview`: consolidates booking/showing overview for the admin booking pages, so PHP can query it with a simple `SELECT` instead of complex joins/counts.
- `seat_status` (if present): provides seat availability per showing for the seat map.

### Triggers (why they matter)

Triggers enforce business rules at database level, e.g. preventing destructive actions (like deleting paid invoices or admin accounts).

---

## Local setup (Windows + WAMP)

1. **Clone repo**
   ```bash
   git clone https://github.com/HelenaKjeld/kjeldcinema.git
   ```
2. **Place project in WAMP web root**
   Example:
   ```
   C:\wamp64\www\kjeldcinema
   ```
3. **Create/import database**

   - Open phpMyAdmin (WAMP)
   - Import one of:
     - `sql/rowancinema.sql` (if it contains schema + data)
     - or `sql/CreateCinemaDB.sql` (schema builder)

4. **Configure DB connection**
   Update your DB credentials in:
   - `includes/constants.php`

        The database connection settings are git ignored. As such, please create your own file at /include/constants.php with the following content with your own settings:

    ```
    <?php
    if (!defined('DB_SERVER')) define('DB_SERVER', 'X');
    if (!defined('DB_USER')) define('DB_USER', 'X');
    if (!defined('DB_PASS')) define('DB_PASS', 'X');
    if (!defined('DB_NAME')) define('DB_NAME', 'X');
    ?>
    ```

5. **Run**
   Open:
   ```
   http://localhost/kjeldcinema/
   ```

---

## Admin access

Admin pages live under:

- `/admin/admin_page.php`

Admins are identified via a role field (e.g. `Role = 'admin'`).  
To make a user admin, update the user role in the database (example):

```sql
UPDATE user
SET Role = 'admin'
WHERE Email = 'your-admin-email@example.com';
```

---

## Security notes (important)

- Passwords are hashed during signup using `password_hash()` and verified on login.
- Input/output sanitization is handled via helper functions (e.g. `politi()`).
- Prepared statements are used (PDO) to reduce SQL injection risk.

**Do not commit real secrets** (DB passwords, email passwords, API keys) to GitHub.  
For a production-ready setup, use environment variables or a separate config file outside the repository.

---

## Key features to demonstrate (for teachers)

- **OOP CRUD structure:** `BaseModel.php` + specific models per table
- **Session handling:** login state + role-based access control
- **Seat selection:** live UI with booked/available states
- **Advanced SQL:** views for admin overview + triggers for integrity rules
- **Admin CMS functions:** update content without editing code

---

## Author

Developed by **Helena Kjeld**  
Supervisors: **Søren Spangsberg Jørgensen** and **Kim Thøisen**  
Hand-in date: **17-12-2025**
