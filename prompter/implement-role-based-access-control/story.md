## 🧾 Story: Implement Role-Based Access Control

### 🧑 As a System Administrator,
I want to assign specific roles (e.g., admin, user) to accounts and enforce access restrictions
so that I can protect sensitive administrative data and functionality from unauthorized users.

### 🔨 Acceptance Criteria (BDD Format)
- **Given** a new user registers or is created
- **When** the account is finalized
- **Then** the user is assigned a default "user" role automatically

- **Given** a user with the "admin" role
- **When** they attempt to access restricted routes (e.g., /admin/dashboard, /admin/tickets)
- **Then** they are granted access to the page

- **Given** a user with the "standard user" role
- **When** they attempt to access restricted administrative routes
- **Then** they are denied access and redirected to the home page or shown a 403 Forbidden error

- **Given** the application code
- **When** a route requires specific privileges
- **Then** a custom Middleware checks the user's role before processing the request

### 📌 Expected Result
- Database migration to add a `role` column (or roles table) to the existing `users` table.
- A custom Middleware (e.g., `EnsureUserHasRole`) implemented to verify user privileges.
- Routes for the Admin Dashboard and Ticket Management protected by the new middleware.
- A database seeder or command to create an initial Admin user.
- Updated User model to handle role checking (e.g., `hasRole()` method).

### 🚫 Non-Goals (if applicable)
- Building a complex UI for managing roles and permissions dynamically (roles will be predefined effectively in code/database for now).
- Implementing granular permission-based access control (e.g., "can_edit_ticket" vs "can_delete_ticket") - strictly role-based (Admin vs User) for this story.

### 🗒️ Notes
- Use Laravel Breeze's existing authentication infrastructure.
- Ideally, add a helper method on the User model like `isAdmin()`.
- Ensure the navigation menu conditionally shows links based on the user's role (e.g., hidden Dashboard link for non-admins).
