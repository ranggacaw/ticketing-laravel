# Spec: User Profile

## Overview

Allow users to view and edit their profile information, including password management.

---

## ADDED Requirements

### Requirement: View Profile

Users SHALL be able to view their profile information.

#### Scenario: View profile page

- **WHEN** a logged-in user navigates to `/user/profile`
- **THEN** they see: name, email, phone, account created date

---

### Requirement: Edit Profile

Users SHALL be able to update their profile information.

#### Scenario: Update name

- **WHEN** user edits their name and saves
- **THEN** name is updated
- **AND** success notification shown: "Profile updated successfully"

#### Scenario: Upload Avatar

- **WHEN** user selects a valid image file (jpeg, png, max 2MB)
- **AND** saves the profile
- **THEN** the avatar is uploaded and displayed
- **AND** old avatar (if any) is replaced

#### Scenario: Update phone number

- **WHEN** user adds or updates phone number and saves
- **THEN** phone number is saved
- **AND** success notification shown

#### Scenario: Update email to existing email

- **WHEN** user changes email to one already registered
- **THEN** error shown: "This email is already in use"
- **AND** email is not changed

#### Scenario: Validation errors

- **WHEN** user enters invalid data (e.g., invalid email format, large image)
- **THEN** inline validation errors are displayed

---

### Requirement: Change Password

Users SHALL be able to change their password securely.

#### Scenario: Successful password change

- **WHEN** user enters correct current password
- **AND** enters new password (min 8 characters) with confirmation
- **THEN** password is updated
- **AND** success notification shown: "Password updated successfully"

#### Scenario: Incorrect current password

- **WHEN** user enters incorrect current password
- **THEN** error shown: "Current password is incorrect"
- **AND** password not changed

#### Scenario: Password confirmation mismatch

- **WHEN** new password and confirmation don't match
- **THEN** error shown: "New passwords do not match"

#### Scenario: Weak password rejected

- **WHEN** user enters password shorter than 8 characters
- **THEN** error shown: "Password must be at least 8 characters"

---

### Requirement: Profile Form Design

Profile page SHALL be responsive and user-friendly.

#### Scenario: Responsive layout

- **WHEN** viewed on mobile, tablet, or desktop
- **THEN** form is properly laid out with appropriate touch targets

#### Scenario: Separate password section

- **WHEN** user views profile page
- **THEN** password change fields are in a visually distinct section

---

## Technical Notes

- Routes: `GET /user/profile`, `PUT /user/profile`, `PUT /user/profile/password`
- Controller: `User\ProfileController`
- Password verification uses `Hash::check()`
