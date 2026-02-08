# Proposal: Implement User Ticket Portal (MVP 1)

## Summary

Implement the core User Ticket Portal (MVP 1) as defined in the PRD, enabling ticket holders to register, login, view their tickets, access payment history, and manage their profile through a modern, responsive UI.

## Status

| Attribute            | Value                                    |
| -------------------- | ---------------------------------------- |
| **Proposal ID**      | implement-user-ticket-portal             |
| **Status**           | Draft                                    |
| **PRD Reference**    | `prompter/user-ticket-experience/prd.md` |
| **Target MVP**       | MVP 1 - Core User Portal                 |
| **Estimated Effort** | 4-6 weeks                                |
| **Priority**         | P0 - Critical                            |

## Background & Context

### Current State

- **User Roles**: Only `admin`, `staff`, `volunteer` exist - no `user` (ticket holder) role
- **Ticket-User Relationship**: Tickets have `user_email` but no `user_id` foreign key
- **User Portal**: Does not exist - ticket holders have no online access
- **Authentication**: Only internal staff/admin login exists

### Problem

Ticket holders have no visibility into their ticket status, payment history, or a way to engage with the platform post-purchase. This leads to:

- Increased support requests for ticket information
- No mechanism for collecting customer feedback
- Manual payment confirmation processes
- Reduced customer engagement and satisfaction

## Proposed Solution

### New Capabilities

| Capability                 | Description                                            |
| -------------------------- | ------------------------------------------------------ |
| **user-authentication**    | Registration, login, password reset for ticket holders |
| **user-dashboard**         | Central hub showing tickets, payments, and activities  |
| **ticket-details-view**    | Comprehensive ticket information with barcode display  |
| **payment-history**        | List and detail views of user payment transactions     |
| **user-profile**           | Profile viewing and editing functionality              |
| **responsive-user-portal** | Modern, mobile-first UI for all user-facing pages      |

### Database Changes

#### New Tables

- `payments` - Store payment records with status tracking
- `payment_tickets` - Many-to-many relationship between payments and tickets

#### Schema Modifications

- `users` table: Add `phone` column, `notification_preferences` JSON column
- `tickets` table: Add `user_id` foreign key, `payment_status` enum column

### Route Structure

All user portal routes under `/user` prefix with `user` role middleware:

- `GET /user/dashboard` - User dashboard
- `GET /user/tickets` - My tickets list
- `GET /user/tickets/{id}` - Ticket details
- `GET /user/payments` - Payment history
- `GET /user/payments/{id}` - Payment details
- `GET /user/profile` - View/edit profile

### UI/UX Approach

- Mobile-first responsive design
- Glass card aesthetic (matching existing admin UI patterns)
- Modern color palette from PRD (Indigo/Emerald/Amber)
- Inter font family
- Skeleton loading states
- Toast notifications for feedback

## Scope

### In Scope (MVP 1)

- ✅ User registration with email verification
- ✅ User login with "Remember Me" functionality
- ✅ Password reset flow
- ✅ User dashboard with ticket/payment overview
- ✅ My Tickets list with filtering (Upcoming, Past, Pending)
- ✅ Ticket details page with barcode display
- ✅ Payment history list with status filters
- ✅ Payment details modal/page
- ✅ Profile viewing and editing
- ✅ Responsive design for mobile/tablet/desktop
- ✅ Data migration script to link existing tickets to users

### Out of Scope (Deferred to MVP 2+)

- ❌ WhatsApp payment confirmation
- ❌ Notification system (in-app, email)
- ❌ Review/testimonial system
- ❌ Social login (Google/Facebook)
- ❌ In-app ticket purchase
- ❌ Multi-language support

## Dependencies

| Dependency             | Type    | Status        | Notes                     |
| ---------------------- | ------- | ------------- | ------------------------- |
| Laravel Breeze/Fortify | Package | To evaluate   | For auth scaffolding      |
| Email verification     | Feature | Open question | OQ-01 pending decision    |
| Existing ticket data   | Data    | Available     | Has `user_email` to match |

## Open Questions

Inherited from PRD that affect this proposal:

- **OQ-01**: Should email verification be required for registration?
- **OQ-04**: What is the maximum number of tickets per user?

## Risks & Mitigations

| Risk                                      | Impact | Mitigation                                   |
| ----------------------------------------- | ------ | -------------------------------------------- |
| Existing tickets not matching user emails | Medium | Create fallback for orphan tickets           |
| Performance with many tickets per user    | Low    | Pagination, caching, lazy loading            |
| Mobile UX complexity                      | Medium | Mobile-first design, progressive enhancement |

## Related Changes

- Builds upon: `add-user-history-tracking` (activity logging infrastructure)
- Future: `implement-user-notifications` (MVP 2)
- Future: `implement-user-reviews` (MVP 2)
- Future: `implement-whatsapp-payment` (MVP 2)
