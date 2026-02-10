# Tasks: Implement User Ticket Portal (MVP 1)

## Overview

Ordered list of work items to implement the User Ticket Portal MVP 1.

## Phase 1: Database & Models

### Task 1.1: Database Schema Updates **[DONE]**

**Description**: Create migrations for `testimonials`, `loyalty_points`, and updates to `users`/`tickets`.
**Validation**:

- `users`: Added `avatar`, `role` (or equivalent).
- `tickets`: Added `user_id`.
- `testimonials`: Created with `user_id`, `ticket_id`, `event_id`, `rating`, `comment`.
- `loyalty_points`: Created with `user_id`, `points`, `reason`.

### Task 1.2: Model Updates **[DONE]**

**Description**: Update Eloquent models with new relationships and fillable fields.
**Validation**:

- `User` hasMany `Ticket`, `Testimonial`.
- `Ticket` belongsTo `User`.
- `Testimonial` belongsTo `User`, `Ticket`.

### Task 1.3: Data Migration Script **[DONE]**

**Description**: Link existing tickets to users based on email.
**Validation**:

- Existing tickets with valid emails are linked to new/existing user accounts.

## Phase 2: Authentication

### Task 2.1: User Registration **[DONE]**

**Description**: Implement public-facing registration form and controller logic.
**Validation**:

- User can register.
- Account is created with `attendee` role.
- Auto-login after registration.

### Task 2.2: User Login & Logout **[DONE]**

**Description**: Implement login flow distinct from Admin (or shared with role check).
**Validation**:

- User can login.
- Redirects to `/user/dashboard`.
- Logout works.

### Task 2.3: Profile Management **[DONE]**

**Description**: View and Edit profile (Name, Email, Password, Avatar).
**Validation**:

- Can update name/email.
- Can upload/change avatar.
- Can change password.

## Phase 3: Core Portal Features

### Task 3.1: User Layout & Dashboard **[DONE]**

**Description**: Create the main layout (sidebar/nav) and Dashboard index.
**Validation**:

- Responsive layout.
- Dashboard shows "Upcoming Tickets" count, "Loyalty Points".
- Navigation links work.

### Task 3.2: My Tickets List **[DONE]**

**Description**: List tickets with tabs for "Upcoming" and "Past".
**Validation**:

- Upcoming tab shows future events.
- Past tab shows past events.
- Cards show event details.

### Task 3.3: Ticket Details **[DONE]**

**Description**: Detailed view of a single ticket.
**Validation**:

- Shows QR/Barcode.
- Shows Event details (map, time).
- Download PDF button (stub or actual).

## Phase 4: Engagement Features

### Task 4.1: Testimonial System **[DONE]**

**Description**: Form to submit testimonials for PAST tickets.
**Validation**:

- "Write Review" button appears ONLY on past tickets.
- Form submits rating and text.
- Saved to database.
- Prevents duplicate reviews for same ticket.

### Task 4.2: Loyalty Points Display **[DONE]**

**Description**: specific section or widget to show loyalty points.
**Validation**:

- User sees current point balance.
- (Optional) History of points earned.

## Phase 5: Polish & Verification

### Task 5.1: Authorization Policies **[DONE]**

**Description**: Ensure users cannot access others' tickets or data.
**Validation**:

- `TicketPolicy` prevents view ID 1 if owned by User 2.
- `TestimonialPolicy`.

### Task 5.2: UI Polish **[DONE]**

**Description**: Apply glassmorphism and animations.
**Validation**:

- Hover effects.
- Transitions.
- Mobile responsiveness check.
