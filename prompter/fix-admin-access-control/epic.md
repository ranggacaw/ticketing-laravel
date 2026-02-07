# 🧠 Epic: Fix Admin Access Control

### 🎯 Epic Goal
We need to **fix the current 403 Forbidden error and refine the Role-Based Access Control (RBAC)** in order for **administrators** to **successfully access the admin dashboard while strictly preventing standard users from entering**.

### 🚀 Definition of Done
- [x] Users with the role `user` are correctly blocked (403 or redirect) from accessing `/admin/*` routes.
- [x] Users with the role `admin` (or any role != `user`) can successfully access `/admin/tickets` without a 403 error.
- [x] The "Forbidden" error is resolved for legitimate admin users.
- [x] Middleware logic accurately implements the "!= user" check.
- [x] The application operates without crashing or unauthorized access issues.

### 📌 High-Level Scope (Included)
- Debugging the current `RoleMiddleware` (or equivalent) logic.
- Verifying and updating `User` model role checks.
- confirming route middleware assignments in `routes/web.php`.
- Testing login flows for both `user` and `admin` roles.

### ❌ Out of Scope
- Creating new complex roles system (only fixing the existing simple check).
- Redesigning the login page UI.

### 📁 Deliverables
- Updated `Middleware` file.
- Updated `web.php` routes.
- (Optional) Updated `User` model if helper methods are needed.

### 🧩 Dependencies
- Existing Authentication system (Laravel Breeze/Jetstream/Default).
- Database with `users` table containing a `role` column.

### ⚠️ Risks / Assumptions
- Assumption: The `users` table already has a `role` column.
- Risk: If the session handling is broken, fixing the middleware won't solve the login issue.

### 🎯 Success Metrics
- 100% success rate for Admins accessing the dashboard.
- 0% success rate for Users accessing the dashboard.
