# 🧠 Epic: Role-Based Authentication and Access Control

## 🎯 Epic Goal
We need to **implement a complete authentication system with role-based access control** in order for **event administrators, staff, and volunteers** to **securely access appropriate features based on their assigned roles**.

---

## 🚀 Definition of Done
- [ ] All pages require authentication (unauthenticated users are redirected to login)
- [ ] Login page is functional and accessible to all unauthenticated users
- [ ] Register page/modal is functional and **only accessible by admin role**
- [ ] Registration form captures: Name, Email, and Role (Admin, Staff, Volunteer)
- [ ] **Admin** role can access all pages without restriction, including register functionality
- [ ] **Staff** role can access all pages **except** the register page/modal
- [ ] **Volunteer** role can **only** access the Scan page and the validated ticket data list
- [ ] Validated tickets become **read-only** (no edit functionality, display only)
- [ ] Role-based navigation displays only accessible menu items per role
- [ ] Proper 403/unauthorized handling for role-restricted access attempts

---

## 📌 High-Level Scope (Included)
- **Authentication System**
  - Login page with email/password
  - Session management and logout functionality
  - "Remember me" functionality (optional)

- **User Registration (Admin-only)**
  - Register page or modal accessible only by admin
  - Form fields: Name, Email, Password, Role (dropdown: Admin, Staff, Volunteer)
  - User creation with role assignment

- **Role-Based Access Control (RBAC)**
  - Three distinct roles: Admin, Staff, Volunteer
  - Middleware for role-based route protection
  - Role-specific page access as defined below

- **Role Permissions Matrix**
  | Feature/Page | Admin | Staff | Volunteer |
  |--------------|-------|-------|-----------|
  | Dashboard | ✅ | ✅ | ❌ |
  | Ticket Management | ✅ | ✅ | ❌ |
  | Create/Edit Tickets | ✅ | ✅ | ❌ |
  | Scan Page | ✅ | ✅ | ✅ |
  | Validated Tickets List | ✅ | ✅ | ✅ |
  | Register User | ✅ | ❌ | ❌ |
  | User Management | ✅ | ❌ | ❌ |

- **Validated Ticket Behavior**
  - Once a ticket is validated, it becomes read-only
  - Edit button removed/disabled for validated tickets
  - Only view/display functionality available for validated tickets

- **UI/UX Adjustments**
  - Role-based navigation menu (hide inaccessible items)
  - Proper unauthorized access messages
  - Consistent styling with existing admin theme

---

## ❌ Out of Scope
- Password reset/forgot password functionality
- Email verification for new users
- OAuth/social login (Google, Facebook, etc.)
- Two-factor authentication (2FA)
- API token-based authentication
- Granular permission management beyond role-based
- User self-registration (public registration)
- Advanced audit logging of user actions

---

## 📁 Deliverables
- **Login Page** - Blade view with authentication form
- **Register Page/Modal** - Admin-only user creation interface
- **Role Middleware** - Laravel middleware for role-based access control
- **Updated User Model** - With role field and role-checking methods
- **Database Migration** - Add role column to users table (if not exists)
- **Route Protection** - Updated routes with role middleware
- **Updated Navigation** - Role-aware sidebar/menu component
- **Updated Ticket Views** - Read-only mode for validated tickets
- **User Seeder** - Default admin user for initial access

---

## 🧩 Dependencies
- Laravel Breeze or existing authentication scaffolding
- Existing User model and users table
- Existing ticket validation system (to determine validated status)
- Current admin layout and styling (for UI consistency)

---

## ⚠️ Risks / Assumptions
- **Assumption**: A 'role' column exists or can be added to the users table
- **Assumption**: Ticket validation status is already tracked in the database
- **Assumption**: Only one role per user (no multi-role support)
- **Risk**: Existing users may need role assignment during migration
- **Risk**: Route/controller changes may affect existing functionality
- **Assumption**: The scan page and ticket list pages already exist
- **Risk**: UI changes to navigation may impact mobile responsiveness

---

## 🎯 Success Metrics
- 100% of pages require authentication (no public access to admin features)
- Role-based access works correctly for all three roles
- Zero unauthorized access to role-restricted pages
- Volunteers cannot access ticket editing functionality
- Validated tickets cannot be modified by any role
- Admin can successfully create new users with any role
- No regression in existing ticket management functionality
