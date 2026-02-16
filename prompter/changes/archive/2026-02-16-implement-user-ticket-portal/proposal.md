# Proposal: User Ticket Portal

## Summary

Implement the **User Ticket Portal** (MVP 1) as defined in the PRD. This is a dedicated, self-service interface for event attendees to manage their accounts, view ticket history, and provide testimonials for past events.

## Status

| Attribute            | Value                                |
| -------------------- | ------------------------------------ |
| **Proposal ID**      | implement-user-ticket-portal         |
| **Status**           | Draft                                |
| **PRD Reference**    | `prompter/user-ticket-portal/prd.md` |
| **Target MVP**       | MVP 1                                |
| **Estimated Effort** | 4-6 weeks                            |
| **Priority**         | High                                 |

## Background & Context

### Current State

- **User Management**: Heavily reliant on `admin.users.index`.
- **User Role**: Only admin/staff roles are well-defined; attendees lack a dedicated portal.
- **Engagement**: No mechanism for users to provide feedback/testimonials.
- **Visibility**: Users cannot easily view their ticket history or manage profile details.

### Problem

- **Friction**: Users cannot self-register easily.
- **Low Engagement**: Testimonials are not collected systematically.
- **Admin Burden**: Staff manually handle user data updates.

## Proposed Solution

### Capabilities

| Capability              | Description                                       |
| ----------------------- | ------------------------------------------------- |
| **user-authentication** | Self-service registration, login, password reset  |
| **user-profile**        | View and edit profile (Name, Email, Avatar)       |
| **ticket-management**   | List "Upcoming" and "Past" tickets; detailed view |
| **testimonial-system**  | Submit reviews/ratings for past events            |
| **user-dashboard**      | Central hub for stats and quick actions           |

### Database Changes

#### New Tables

- `testimonials`: Store user reviews (linked to `user_id`, `event_id`, `ticket_id`).
- `loyalty_points`: (If implementing full loyalty system now, otherwise prep schema).

#### Schema Modifications

- `users`: Ensure distinction between `admin` and `attendee` (role column or separate table approach TBD).
- `tickets`: Ensure linkage to `users` is robust.

### UI/UX Approach

- **Aesthetic**: Glassmorphism, premium feel, vibrant colors (consistent with `user.tickets.index`).
- **Responsive**: Mobile-first design.
- **Framework**: Laravel Blade + Tailwind CSS (DaisyUI).

## Scope

### MVP 1 (In Scope) ✅

- [x] **User Registration**: Public-facing sign-up.
- [x] **User Login**: Secure authentication for attendees.
- [x] **User Profile**: Edit Name, Email, Password, Avatar.
- [x] **My Tickets**: List with "Upcoming" vs "Past" tabs.
- [x] **Ticket Details**: Detailed view of a specific ticket.
- [x] **Testimonials**: Write review for past tickets.
- [x] **Dashboard**: specialized landing page for logged-in users.
- [x] **Social Sharing**: Share functionality for testimonials.
- [x] **Loyalty Program**: Basic points/rewards system.

### Out of Scope ❌

- Social Features (Friend requests).
- Complex Gamification.
- Ticket Resale Platform.

## Dependencies

- Existing `tickets` table structure.
- `User` model refactoring (handling roles).

## Open Questions

- Should user accounts be separate from admin accounts?
- Email verification requirement?
- Testimonial moderation workflow?

## Risks

- **Data Migration**: Linking existing tickets to new user accounts if email matches.
- **Security**: Ensuring users can ONLY see their own data.
