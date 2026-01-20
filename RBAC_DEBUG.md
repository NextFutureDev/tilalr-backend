RBAC Debugging Helpers

This file documents helpful scripts to inspect and manage roles & permissions.

Scripts:

- `php scripts/list_permissions.php` — lists all permission names in the DB.
- `php verify_rbac.php` — prints roles and a short summary of assigned permissions.
- `php scripts/show_rbac.php` — prints detailed mapping:
  - Role -> permissions (each permission name on its own line)
  - User -> roles -> effective permissions
- `php scripts/create_customer_role.php` — ensures the `customer` role exists, ensures common booking/contact/reservation/user permissions, and creates `customer@tilalr.com` test user (password `password123`).

Usage notes:
- After creating/updating roles or permissions, re-login in the frontend (or call `GET /api/user`) so the UI fetches the new permissions.
- If a page still doesn't show, verify the exact permission name the frontend checks (compare against the output of `scripts/show_rbac.php`).
