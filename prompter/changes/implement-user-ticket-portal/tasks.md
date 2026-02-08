# Tasks: Implement User Ticket Portal (MVP 1)

## Overview

Ordered list of work items to implement the User Ticket Portal MVP 1. Tasks are grouped into phases with clear dependencies and validation criteria.

---

## Phase 1: Database Foundation

### Task 1.1: Create `payments` Table Migration

**Description**: Create migration for the payments table to store user payment records.
**Dependencies**: None
**Validation**:

- Migration runs without errors
- Table created with correct columns and indexes
- Foreign keys properly constrained

**Files**:

- `database/migrations/XXXX_XX_XX_create_payments_table.php` (new)

---

### Task 1.2: Create `payment_tickets` Pivot Table Migration

**Description**: Create migration for the many-to-many relationship between payments and tickets.
**Dependencies**: Task 1.1
**Validation**:

- Migration runs successfully
- Unique constraint on payment_id + ticket_id works

**Files**:

- `database/migrations/XXXX_XX_XX_create_payment_tickets_table.php` (new)

---

### Task 1.3: Add User Portal Columns to `users` Table

**Description**: Add `phone` and `notification_preferences` columns to users table.
**Dependencies**: None
**Validation**:

- Migration adds columns successfully
- Existing user data preserved
- Default values applied correctly

**Files**:

- `database/migrations/XXXX_XX_XX_add_portal_fields_to_users_table.php` (new)

---

### Task 1.4: Add User Relationship to `tickets` Table

**Description**: Add `user_id` foreign key and `payment_status` enum to tickets table.
**Dependencies**: None
**Validation**:

- Migration adds columns with nullable user_id
- Payment status defaults to 'confirmed' for existing tickets
- Index created on user_id

**Files**:

- `database/migrations/XXXX_XX_XX_add_user_id_to_tickets_table.php` (new)

---

### Task 1.5: Create Data Migration Script

**Description**: Script to link existing tickets to user accounts via email matching.
**Dependencies**: Tasks 1.3, 1.4
**Validation**:

- Tickets matched to users by email
- No data loss for orphan tickets
- Script is idempotent (safe to run multiple times)

**Files**:

- `database/migrations/XXXX_XX_XX_link_tickets_to_users.php` (new)

---

## Phase 2: Models & Relationships

### Task 2.1: Create Payment Model

**Description**: Create Payment model with relationships to User and Ticket.
**Dependencies**: Tasks 1.1, 1.2
**Validation**:

- `belongsTo` User relationship works
- `belongsToMany` Ticket relationship works
- Invoice number generation works
- Status accessors/mutators work

**Files**:

- `app/Models/Payment.php` (new)

---

### Task 2.2: Update User Model

**Description**: Add relationships and fillable fields for user portal.
**Dependencies**: Task 1.3
**Validation**:

- `hasMany` tickets relationship works
- `hasMany` payments relationship works
- Phone field is fillable
- ROLE_USER constant added

**Files**:

- `app/Models/User.php` (modify)

---

### Task 2.3: Update Ticket Model

**Description**: Add user relationship and payment status to Ticket model.
**Dependencies**: Tasks 1.4, 2.1
**Validation**:

- `belongsTo` User relationship works
- `belongsToMany` Payment relationship works
- Payment status casting works

**Files**:

- `app/Models/Ticket.php` (modify)

---

## Phase 3: Authentication Extension

### Task 3.1: Add Registration to AuthController

**Description**: Extend AuthController to handle user registration with 'user' role.
**Dependencies**: Task 2.2
**Validation**:

- Registration creates user with role='user'
- Email validation (unique)
- Password confirmation works
- Redirect to user dashboard after registration

**Files**:

- `app/Http/Controllers/AuthController.php` (modify)

---

### Task 3.2: Create Registration View

**Description**: Create registration form view with responsive design.
**Dependencies**: None (parallel with 3.1)
**Validation**:

- Form displays correctly on mobile/tablet/desktop
- Inline validation errors shown
- Link to login page works
- Glass card aesthetic applied

**Files**:

- `resources/views/auth/register.blade.php` (new)

---

### Task 3.3: Add Password Reset Functionality

**Description**: Implement forgot password and reset password flows.
**Dependencies**: Task 3.1
**Validation**:

- Forgot password sends email (if mail configured)
- Reset token expires in 1 hour
- Password successfully updated
- Rate limiting applied (3 requests/hour)

**Files**:

- `resources/views/auth/forgot-password.blade.php` (new)
- `resources/views/auth/reset-password.blade.php` (new)
- `app/Http/Controllers/AuthController.php` (modify)

---

### Task 3.4: Update Login Flow for User Role

**Description**: Modify login to redirect users to user dashboard vs admin dashboard.
**Dependencies**: Task 3.1
**Validation**:

- Users with role='user' redirect to `/user/dashboard`
- Users with role='admin/staff' redirect to `/admin/dashboard`
- Users with role='volunteer' redirect to `/scan`
- Login view has link to register page

**Files**:

- `app/Http/Controllers/AuthController.php` (modify)
- `resources/views/auth/login.blade.php` (modify)

---

## Phase 4: User Portal Core

### Task 4.1: Create User Portal Layout

**Description**: Create the base layout for user portal with navigation and responsive sidebar.
**Dependencies**: Phase 3 complete
**Validation**:

- Layout works on mobile (bottom nav)
- Layout works on tablet/desktop (sidebar)
- Dark mode toggle works (if existing)
- Profile dropdown menu works

**Files**:

- `resources/views/user/layouts/app.blade.php` (new)
- `resources/css/user.css` (new or extend existing)

---

### Task 4.2: Create User Dashboard Controller & View

**Description**: Implement user dashboard with summary widgets and recent activity.
**Dependencies**: Task 4.1, Phase 2 complete
**Validation**:

- Shows active ticket count
- Shows pending payment count
- Shows past events count
- Displays recent tickets list
- Displays recent payments list
- Data cached for 5 minutes

**Files**:

- `app/Http/Controllers/User/DashboardController.php` (new)
- `resources/views/user/dashboard.blade.php` (new)

---

### Task 4.3: Create User Ticket Controller & List View

**Description**: Implement My Tickets page with filtering and pagination.
**Dependencies**: Task 4.1, Task 2.3
**Validation**:

- Lists only current user's tickets
- Tabs: Upcoming, Past, Pending
- Pagination: 12 per page
- Each card shows: event, date, seat, status, type
- Click navigates to detail

**Files**:

- `app/Http/Controllers/User/TicketController.php` (new)
- `resources/views/user/tickets/index.blade.php` (new)

---

### Task 4.4: Create Ticket Detail View

**Description**: Implement ticket detail page with barcode display.
**Dependencies**: Task 4.3
**Validation**:

- Shows all ticket information
- Barcode/QR displays and is scannable
- Status clearly indicated
- Download button works (PDF or image)
- Share functionality works
- Policy prevents access to other users' tickets

**Files**:

- `resources/views/user/tickets/show.blade.php` (new)
- `app/Policies/TicketPolicy.php` (new)
- `app/Http/Controllers/User/TicketController.php` (modify)

---

### Task 4.5: Create Payment Controller & List View

**Description**: Implement Payment History page with filtering.
**Dependencies**: Task 4.1, Task 2.1
**Validation**:

- Lists only current user's payments
- Filter by status (All, Confirmed, Pending)
- Date range filter
- Sorted by date (newest first)
- Each row shows: invoice, date, amount, status

**Files**:

- `app/Http/Controllers/User/PaymentController.php` (new)
- `resources/views/user/payments/index.blade.php` (new)

---

### Task 4.6: Create Payment Detail View

**Description**: Implement payment detail modal/page with breakdown.
**Dependencies**: Task 4.5
**Validation**:

- Shows invoice number, date, amount
- Shows list of associated tickets
- Shows payment status and history
- Link to download receipt (stretch)
- Policy prevents access to other users' payments

**Files**:

- `resources/views/user/payments/show.blade.php` (new)
- `app/Policies/PaymentPolicy.php` (new)

---

### Task 4.7: Create Profile Controller & View

**Description**: Implement profile view and edit functionality.
**Dependencies**: Task 4.1
**Validation**:

- Shows current profile information
- Allows editing: name, email, phone
- Email change requires password confirmation
- Separate password change section
- Current password required to change password

**Files**:

- `app/Http/Controllers/User/ProfileController.php` (new)
- `resources/views/user/profile/edit.blade.php` (new)

---

## Phase 5: Routing & Security

### Task 5.1: Configure User Portal Routes

**Description**: Add all user portal routes with proper middleware.
**Dependencies**: Phase 4 controllers created
**Validation**:

- All routes accessible to role='user'
- All routes blocked for other roles
- Routes use proper names (user.\*)
- 404 for non-existent resources
- 403 for unauthorized access

**Files**:

- `routes/web.php` (modify)

---

### Task 5.2: Create Authorization Policies

**Description**: Implement policies for Ticket and Payment access control.
**Dependencies**: Tasks 4.4, 4.6
**Validation**:

- Users can only view their own tickets
- Users can only view their own payments
- Admin can view all (for debugging)
- Policies registered in AuthServiceProvider

**Files**:

- `app/Providers/AuthServiceProvider.php` (modify)
- `app/Policies/TicketPolicy.php` (verify)
- `app/Policies/PaymentPolicy.php` (verify)

---

### Task 5.3: Implement Rate Limiting

**Description**: Add rate limiting to auth endpoints.
**Dependencies**: Task 3.3
**Validation**:

- Login: 5 attempts per minute
- Password reset: 3 requests per hour
- Registration: 3 per minute
- Appropriate error messages shown

**Files**:

- `app/Http/Kernel.php` or `routes/web.php` (modify)

---

## Phase 6: Polish & Testing

### Task 6.1: Add Skeleton Loading States

**Description**: Implement skeleton loaders for dashboard and list pages.
**Dependencies**: Phase 4 complete
**Validation**:

- Skeleton shown while data loads
- Smooth transition to actual content
- Works on all relevant pages

**Files**:

- `resources/views/user/components/skeleton-*.blade.php` (new)
- Various view files (modify)

---

### Task 6.2: Add Toast Notifications

**Description**: Implement toast notification system for user feedback.
**Dependencies**: Task 4.1
**Validation**:

- Toasts appear for: save, error, success actions
- Auto-dismiss after 3-5 seconds
- Dismissible by click
- Positioned bottom-right on desktop, top on mobile

**Files**:

- `resources/views/user/components/toast.blade.php` (new)
- `resources/js/user.js` or inline (new/modify)

---

### Task 6.3: Write Feature Tests

**Description**: Create feature tests for all user portal functionality.
**Dependencies**: All phases complete
**Validation**:

- Tests pass for: registration, login, view tickets, view payments, profile update
- Tests verify authorization (can't access others' data)
- Tests verify redirect logic

**Files**:

- `tests/Feature/UserPortal/RegistrationTest.php` (new)
- `tests/Feature/UserPortal/LoginTest.php` (new)
- `tests/Feature/UserPortal/TicketTest.php` (new)
- `tests/Feature/UserPortal/PaymentTest.php` (new)
- `tests/Feature/UserPortal/ProfileTest.php` (new)

---

### Task 6.4: Final Responsive Testing & Fixes

**Description**: Test all pages on various devices and fix any responsive issues.
**Dependencies**: All phases complete
**Validation**:

- Works on iPhone 12+ sizes
- Works on iPad sizes
- Works on desktop
- No horizontal scroll
- Touch targets appropriately sized (44x44px min)

**Files**:

- Various CSS/view files (modify as needed)

---

## Summary

| Phase          | Tasks   | Estimated Time | Dependencies |
| -------------- | ------- | -------------- | ------------ |
| 1. Database    | 1.1-1.5 | 1 day          | None         |
| 2. Models      | 2.1-2.3 | 0.5 day        | Phase 1      |
| 3. Auth        | 3.1-3.4 | 1.5 days       | Phase 2      |
| 4. Portal Core | 4.1-4.7 | 3-4 days       | Phase 3      |
| 5. Security    | 5.1-5.3 | 1 day          | Phase 4      |
| 6. Polish      | 6.1-6.4 | 2 days         | Phase 5      |

**Total Estimated Time**: ~9-10 days of development work

---

## Parallelization Opportunities

The following tasks can be worked on in parallel:

- **Task 1.3** (users table) and **Task 1.4** (tickets table) - independent migrations
- **Task 3.2** (registration view) and **Task 3.1** (auth controller) - view and logic
- **Task 4.3** and **Task 4.5** - ticket and payment controllers (once layout done)
- **Task 6.1-6.3** - all polish tasks are independent
