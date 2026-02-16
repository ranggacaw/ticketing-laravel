# Spec: User Authentication

## Overview

Provides registration, login, password reset, and session management for ticket holders (users with `role='user'`).

---

## ADDED Requirements

### Requirement: User Registration

Users SHALL be able to create an account to access their tickets and payment history.

#### Scenario: Successful registration

- **WHEN** a guest user enters valid name, email, password, password confirmation, and optional phone
- **AND** submits the registration form
- **THEN** a new user account is created with `role='user'`
- **AND** they are logged in automatically
- **AND** they are redirected to `/user/dashboard`

#### Scenario: Registration with existing email

- **WHEN** a guest user enters an email that already exists
- **AND** submits the form
- **THEN** inline validation error is shown: "This email is already registered"
- **AND** no duplicate account is created

#### Scenario: Registration password mismatch

- **WHEN** a guest user enters mismatched password and confirmation
- **THEN** inline validation error is shown: "Passwords do not match"

#### Scenario: Registration rate limiting

- **WHEN** more than 3 registration attempts are made within 1 minute
- **THEN** error is shown: "Too many attempts. Please try again later."

---

### Requirement: User Login with Role-based Redirect

The system SHALL authenticate users and redirect them based on their role.

#### Scenario: User role redirects to user dashboard

- **WHEN** a user with `role='user'` logs in successfully
- **THEN** they are redirected to `/user/dashboard`

#### Scenario: Admin role redirects to admin dashboard

- **WHEN** a user with `role='admin'` logs in successfully
- **THEN** they are redirected to `/admin/dashboard`

#### Scenario: Volunteer role redirects to scan page

- **WHEN** a user with `role='volunteer'` logs in successfully
- **THEN** they are redirected to `/scan`

#### Scenario: Invalid credentials rejected

- **WHEN** a user enters incorrect email or password
- **THEN** error is shown: "Invalid email or password"
- **AND** no session is created

#### Scenario: Login rate limiting

- **WHEN** more than 5 incorrect login attempts occur within 1 minute
- **THEN** error is shown: "Too many login attempts. Please try again."
- **AND** further attempts blocked temporarily

#### Scenario: Remember me extends session

- **WHEN** a user checks "Remember Me" and logs in
- **THEN** session persists for 30 days

---

### Requirement: Password Reset

Users SHALL be able to reset their password via email link.

#### Scenario: Request password reset

- **WHEN** a user enters their registered email on forgot password page
- **THEN** a password reset email is sent
- **AND** success message shown: "Check your email for reset instructions"

#### Scenario: Reset with valid token

- **WHEN** a user clicks a valid password reset link (within 1 hour)
- **AND** enters new password with confirmation
- **THEN** password is updated
- **AND** redirected to login with success message

#### Scenario: Reset with expired token

- **WHEN** a user clicks an expired reset link (older than 1 hour)
- **THEN** error shown: "This reset link has expired"

#### Scenario: Password reset rate limiting

- **WHEN** more than 3 reset requests made within 1 hour
- **THEN** error shown: "Too many reset requests. Please try again later."

---

### Requirement: Login Page Registration Link

The login page SHALL link to the registration page.

#### Scenario: Link to registration displayed

- **WHEN** a guest views the login page
- **THEN** they see link: "Don't have an account? Register"
- **AND** clicking navigates to `/register`

---

## Technical Notes

- Uses Laravel's built-in authentication features
- Password hashing via Bcrypt
- CSRF protection on all forms
- Rate limiting via Laravel's throttle middleware
