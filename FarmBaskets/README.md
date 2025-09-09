# FarmBaskets (PHP + MySQL + Tailwind)
A beginner-friendly e‑commerce project for **Seeds & Pesticides** with 3 roles: **Customer, Supplier, Admin**.

## Features
- Customer: browse products, add to cart (session), checkout, view orders
- Supplier: add/edit own products, see sales and simple reports
- Admin: dashboard, manage users & suppliers (approve), manage products, orders, and reports
- Tailwind via CDN for clean, modern UI

## Quick Start (XAMPP/LAMP)
1. Copy the `FarmBaskets` folder into your web root (e.g., `C:\xampp\htdocs\` on Windows).
2. Create DB:
   - Open **phpMyAdmin** → run the SQL in `db.sql` to create schema + sample data.
3. Update DB creds in `config.php` if needed.
4. Visit: `http://localhost/FarmBaskets/`

### Demo Accounts
- **Admin** — email: `admin@farmbaskets.local` — pass: `admin123`
- **Supplier** — email: `supplier@farmbaskets.local` — pass: `supplier123`
- **Customer** — email: `customer@farmbaskets.local` — pass: `customer123`

> You can also register new Customer/Supplier/Admin accounts from the UI. Suppliers require admin approval.

## File Structure
```
FarmBaskets/
  admin/        # admin dashboards + CRUD
  auth/         # login/register/logout
  customer/     # shop, cart, checkout, orders
  supplier/     # supplier dashboards + CRUD + reports
  partials/     # header/footer + Tailwind layout
  config.php    # DB connection + helpers
  db.sql        # schema + seed data
  index.php     # landing + featured products
```

## Notes for Viva / Presentation
- Keep it simple: session cart, basic transactions on checkout, minimal SQL.
- Explain roles clearly: who can do what.
- Mention security basics (password hashing, SQL escaping) implemented here.
- Suggested enhancements: search, pagination, image uploads, payment integration.
