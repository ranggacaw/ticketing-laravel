## 🧠 Epic: Admin User Management

### 🎯 Epic Goal
We need to implement a comprehensive user management interface in order for the **Admin** to view, list, and manage system users (Staff and Volunteers) while ensuring that sensitive user data is restricted from lower-privileged roles.

### 🚀 Definition of Done
- [x] Registered users are displayed in a responsive and premium table layout.
- [x] User list is strictly restricted to the `admin` role via middleware.
- [x] Admin can navigate between the user list and the registration form seamlessly.
- [x] The user list displays key information: Name, Email, Role, and Join Date.
- [x] Empty state is handled gracefully for the user list.

### 📌 High-Level Scope (Included)
- `GET /admin/users` route implementation with `auth` and `role:admin` middleware.
- `UserController@index` method to fetch and display users.
- `index.blade.php` with a sleek, modern UI consistent with the existing theme.
- Navigation links updated to include "User Management".

### ❌ Out of Scope
- User editing/deletion (to be handled in a separate Epic/Task).
- Password reset functionality from the admin panel.
- Advanced filtering and searching (basic listing first).

### 📁 Deliverables
- User List View (`resources/views/admin/users/index.blade.php`)
- Route definition in `routes/web.php`
- Controller logic in `UserController.php`

### 🧩 Dependencies
- Existing `RoleMiddleware` for access control.
- `User` model with `role` attribute.

### ⚠️ Risks / Assumptions
- **Risk**: Unauthorized access if middleware is misconfigured. Ensure `role:admin` is correctly applied.
- **Assumption**: There are enough users to justify a list (or the system is scaling).

### 🎯 Success Metrics
- 100% of admin users can access the user list.
- 0% of non-admin users (staff/volunteers) can access the user list (403 Forbidden).
