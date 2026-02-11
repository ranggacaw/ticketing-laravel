# Product Requirements Document (PRD)

# Event Ticketing Platform — Full Application Flow

---

## Overview

| Field              | Detail                                                                   |
| ------------------ | ------------------------------------------------------------------------ |
| **Product Name**   | Event Ticketing Platform                                                 |
| **Version**        | 2.0 — Full Application Flow                                              |
| **Target Release** | Q1 2026                                                                  |
| **Product Owner**  | [PO Name]                                                                |
| **Designer**       | [Designer Name]                                                          |
| **Tech Lead**      | [Tech Lead Name]                                                         |
| **QA Lead**        | [QA Lead Name]                                                           |
| **Tech Stack**     | Laravel 11, Blade Templates, MySQL, Vanilla CSS (dark premium aesthetic) |

---

## Quick Links

| Resource           | Link                  |
| ------------------ | --------------------- |
| **Figma / Design** | [Figma link]          |
| **Technical Spec** | [Tech Spec link]      |
| **Project Board**  | [Jira / PM Tool link] |
| **Repository**     | [GitHub link]         |
| **Staging URL**    | [Staging URL]         |

---

## 1. Background

### 1.1 Context

The Event Ticketing Platform is a full-stack Laravel web application designed for event organisers (admin side) and attendees (user side). It enables organisers to create events with rich master data (venues, organisers, ticket types, seats), manage ticket inventory, validate tickets via barcode scanning, and view activity history. On the user side, attendees can discover events, purchase tickets, view their activity, present tickets for scanning, manage their profile, and leave testimonials.

### 1.2 Current State

The platform already has:

- ✅ **Authentication & Role-Based Access Control** — Roles: `admin`, `staff`, `volunteer`, `user`
- ✅ **Master Data Schema** — Models: `Event`, `TicketType`, `Venue`, `Organizer`, `Seat`
- ✅ **Ticket Model** — With UUID, barcode, secure token, status, seat/event linkage
- ✅ **Payment Model** — Invoice generation, many-to-many with tickets
- ✅ **Admin Dashboard** — Basic dashboard, ticket CRUD, user management, activity history
- ✅ **User Portal** — Dashboard, ticket list/detail, payment history, profile, testimonials
- ✅ **Event Discovery** — Public event catalog (`/events`), event detail (`/events/{slug}`)
- ✅ **Checkout Flow** — Authenticated ticket purchase with seat selection
- ✅ **Ticket Scanning** — Barcode scanning for admin/staff/volunteer roles
- ⚠️ **Gaps** — Some admin master-data CRUD pages missing, user activity page thin, ticket preview/QR presentation incomplete

### 1.3 Problem Statement

While the foundational schema and basic flows exist, the application lacks a **unified, complete flow** covering every screen from the admin's perspective (creating an event end-to-end) and the user's perspective (discovering → purchasing → attending → reviewing). This PRD defines the **complete application flow** to close remaining gaps and ensure a cohesive, production-ready experience.

### 1.4 Current Workarounds

- Admin creates events/venues/organisers manually in the database or via tinker
- Users cannot see a consolidated "My Activity" timeline
- Ticket preview (visual ticket card) and testimonial submission flow are incomplete

---

## 2. Objectives

### 2.1 Business Objectives

| #    | Objective                                                                           | Measurement                                                                                      |
| ---- | ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| B-01 | Enable full self-service event creation via Admin UI                                | Admin can create an event with venue, organiser, ticket types, and seats without database access |
| B-02 | Increase ticket sales by providing a seamless browse → checkout flow                | Conversion rate from event view to checkout ≥ 5%                                                 |
| B-03 | Reduce check-in time with efficient barcode scanning                                | Average scan-to-validation time < 3 seconds                                                      |
| B-04 | Improve user retention through engagement features (testimonials, activity history) | Returning user rate ≥ 30% within 90 days                                                         |
| B-05 | Provide admin visibility into all user activity and payments                        | 100% of ticket/payment actions logged and viewable                                               |

### 2.2 User Objectives

**Admin / Staff:**

- Create and manage events, venues, organisers, ticket types, and seats from a single dashboard
- View all tickets/events in a searchable, filterable list
- Manage registered users and view their purchase/scan history
- Scan and validate tickets at events quickly and reliably

**User / Attendee:**

- Discover upcoming events with rich details (description, venue, pricing)
- Purchase tickets with seat selection and receive instant confirmation
- View all activity (purchases, scans, testimonials) in one timeline
- Present a scannable ticket (QR / barcode) at the event entrance
- Leave reviews/testimonials for attended events
- View detailed ticket information and keep ticket history

---

## 3. Success Metrics

| Metric                             | Type      | Baseline   | Target                                | Measurement Method                        | Timeline         |
| ---------------------------------- | --------- | ---------- | ------------------------------------- | ----------------------------------------- | ---------------- |
| Admin event creation success rate  | Primary   | 0% (no UI) | 95%                                   | Admin creates event E2E without errors    | MVP launch + 30d |
| Browse-to-checkout conversion      | Primary   | [Baseline] | ≥ 5%                                  | `event.view` → `checkout.complete` funnel | MVP launch + 60d |
| Average scan-to-validation time    | Primary   | [Baseline] | < 3s                                  | Timer from scan initiation to result      | MVP launch + 30d |
| User testimonial submission rate   | Secondary | 0%         | ≥ 10% of past-event ticket holders    | Testimonials / eligible tickets           | MVP launch + 90d |
| My Activity page engagement        | Secondary | N/A        | ≥ 40% of logged-in users visit weekly | Page-view analytics                       | MVP launch + 60d |
| Admin user management actions/week | Secondary | [Baseline] | Track                                 | Admin action logs                         | Ongoing          |

---

## 4. Scope

### 4.1 MVP 1 Goals

Deliver the **complete application flow** for both Admin and User sides as described in the feature tables below.

### 4.2 In-Scope Features

#### Admin Side

| #       | Feature                            | Status     | Description                                                                                                          |
| ------- | ---------------------------------- | ---------- | -------------------------------------------------------------------------------------------------------------------- |
| ✅ A-01 | **Master Data — Event CRUD**       | 🔨 Build   | Create, read, update, delete events with name, slug, description, location, start/end time, venue, organiser, status |
| ✅ A-02 | **Master Data — Ticket Type CRUD** | 🔨 Build   | Manage ticket types per event: name, description, price, quantity, sale dates                                        |
| ✅ A-03 | **Master Data — Seat CRUD**        | 🔨 Build   | Manage seats per venue: section, row, number, status, type                                                           |
| ✅ A-04 | **Master Data — Venue CRUD**       | 🔨 Build   | Manage venues: name, description, address, city, state, country, postal code, capacity                               |
| ✅ A-05 | **Master Data — Organiser CRUD**   | 🔨 Build   | Manage organisers: name, description, website, email, phone                                                          |
| ✅ A-06 | **List Events / Tickets**          | ✅ Exists  | Searchable, filterable table of events and issued tickets (enhance existing)                                         |
| ✅ A-07 | **List Registered Users**          | ✅ Exists  | View all registered users with role, email, registration date                                                        |
| ✅ A-08 | **Browse Events (Admin View)**     | 🔨 Build   | Admin-specific event catalog with management actions (edit, publish, unpublish)                                      |
| ✅ A-09 | **Manage User & User History**     | 🔨 Enhance | View/edit individual user details, see their payment history, ticket history, scan history                           |
| ✅ A-10 | **My Activity (Admin)**            | 🔨 Enhance | Admin's own activity log: events created, tickets validated, users managed                                           |
| ✅ A-11 | **Scan Ticket**                    | ✅ Exists  | Barcode scan page for admin/staff/volunteer with validation result (enhance UX)                                      |

#### User Side

| #       | Feature                          | Status    | Description                                                                    |
| ------- | -------------------------------- | --------- | ------------------------------------------------------------------------------ |
| ✅ U-01 | **Browse Event**                 | ✅ Exists | Public event catalog with search, filters (date, location, price), event cards |
| ✅ U-02 | **Checkout**                     | ✅ Exists | Ticket type selection → seat selection → payment → confirmation (enhance UX)   |
| ✅ U-03 | **My Activity**                  | 🔨 Build  | Consolidated timeline: purchases, scans, testimonials, profile updates         |
| ✅ U-04 | **Show Ticket for Scanning**     | 🔨 Build  | Full-screen QR/barcode display optimised for scanner readability               |
| ✅ U-05 | **Profile**                      | ✅ Exists | View/edit name, email, phone, avatar, notification preferences, password       |
| ✅ U-06 | **Ticket History**               | ✅ Exists | List of all tickets (upcoming & past) with status badges (enhance)             |
| ✅ U-07 | **Ticket Detail**                | ✅ Exists | Full ticket info: event, seat, type, price, payment status, barcode (enhance)  |
| ✅ U-08 | **Preview Ticket / Testimonial** | 🔨 Build  | Visual ticket card preview + testimonial submission form for past events       |

### 4.3 Out-of-Scope (MVP 1)

| #        | Feature                                               | Reason                                                          |
| -------- | ----------------------------------------------------- | --------------------------------------------------------------- |
| ❌ OS-01 | Online payment gateway integration (Midtrans, Stripe) | MVP uses manual payment proof upload; gateway deferred to MVP 2 |
| ❌ OS-02 | Multi-language / i18n support                         | Single language (English/Indonesian) for MVP                    |
| ❌ OS-03 | Email notification system                             | Deferred to MVP 2; users check status in-app                    |
| ❌ OS-04 | Advanced reporting / analytics dashboard              | Basic metrics on admin dashboard; full BI deferred              |
| ❌ OS-05 | Mobile native app                                     | Web-responsive only for MVP                                     |
| ❌ OS-06 | Loyalty points redemption flow                        | Points tracking exists; redemption flow deferred                |
| ❌ OS-07 | Multi-event ticket bundles / promo codes              | Deferred to MVP 2                                               |
| ❌ OS-08 | Organiser self-registration portal                    | Organisers managed by admin for MVP                             |

### 4.4 Future Iterations

| Phase     | Features                                                                          |
| --------- | --------------------------------------------------------------------------------- |
| **MVP 2** | Payment gateway integration, email notifications, promo codes, loyalty redemption |
| **MVP 3** | Organiser self-service portal, advanced analytics, multi-language                 |
| **MVP 4** | Mobile native app, push notifications, real-time seat availability                |

---

## 5. User Flows

### 5.1 Admin — Event Creation Flow (End-to-End)

```
[Admin Login]
    │
    ▼
[Admin Dashboard]
    │
    ├──► [Master Data: Venues]
    │        ├── Create Venue (name, address, capacity)
    │        ├── Manage Seats for Venue (section, row, number, type)
    │        └── Edit / Delete Venue
    │
    ├──► [Master Data: Organisers]
    │        ├── Create Organiser (name, email, website)
    │        └── Edit / Delete Organiser
    │
    ├──► [Master Data: Events]
    │        ├── Create Event (name, slug, description, date, venue, organiser)
    │        ├── Add Ticket Types (name, price, quantity, sale dates)
    │        ├── Publish / Unpublish Event
    │        └── Edit / Delete Event
    │
    ├──► [List Events / Tickets]
    │        ├── View all events with ticket count, sales status
    │        ├── Filter by status (draft/published/completed)
    │        ├── Click event → Event Detail with issued tickets
    │        └── Export ticket list (PDF/CSV)
    │
    ├──► [List Users]
    │        ├── View all registered users
    │        ├── Filter by role
    │        ├── Click user → User Detail
    │        └── View user's payment & ticket history
    │
    ├──► [Manage User & History]
    │        ├── View user profile details
    │        ├── View user's ticket purchases
    │        ├── View user's payment records
    │        ├── View user's scan/check-in history
    │        └── Edit user role / Deactivate user
    │
    ├──► [My Activity]
    │        ├── Admin's own action log (events created, tickets validated)
    │        └── Filter by action type, date range
    │
    └──► [Scan Ticket]
             ├── Camera / barcode scanner input
             ├── Validate ticket (UUID lookup)
             ├── Show result: ✅ Valid / ❌ Invalid / ⚠️ Already Scanned
             └── View list of validated tickets for current session
```

### 5.2 User — Browse to Attend Flow (End-to-End)

```
[Landing / Browse Events]
    │
    ├── Search by keyword, filter by date/location/price
    ├── View event cards (image, name, date, venue, price range)
    │
    ▼
[Event Detail Page]
    │
    ├── View description, schedule, venue info, organiser
    ├── View available ticket types with prices & availability
    │
    ▼
[Login / Register] (if not authenticated)
    │
    ▼
[Checkout]
    │
    ├── Select ticket type
    ├── Select seat (interactive seat map or dropdown)
    ├── Upload payment proof (or free ticket)
    ├── Confirm order
    │
    ▼
[Checkout Success]
    │
    ├── Ticket UUID displayed
    ├── Link to "My Tickets"
    │
    ▼
[My Tickets — Ticket History]
    │
    ├── Upcoming tickets (with "Show Ticket" action)
    ├── Past tickets (with "Preview" & "Leave Testimonial" actions)
    │
    ▼
[Ticket Detail]
    │
    ├── Full ticket information (event, seat, type, status)
    ├── Barcode / QR code display
    ├── Payment status
    │
    ▼
[Show Ticket for Scanning]
    │
    ├── Full-screen barcode/QR display
    ├── Brightness boost
    ├── Ticket holder name
    │
    ▼
[Preview Ticket / Testimonial]
    │
    ├── Visual ticket card (event poster, details, barcode)
    ├── Testimonial form (rating, text, for past events only)
    │
    ▼
[My Activity]
    │
    ├── Timeline of all actions: purchases, check-ins, testimonials
    ├── Filter by activity type
    │
    ▼
[Profile]
    │
    ├── Edit name, email, phone, avatar
    ├── Change password
    └── Notification preferences
```

### 5.3 Alternative Flows

| Scenario                              | Flow                                                            |
| ------------------------------------- | --------------------------------------------------------------- |
| **Free event checkout**               | Checkout skips payment proof upload → ticket issued immediately |
| **Sold-out ticket type**              | "Sold Out" badge shown, checkout button disabled                |
| **Already-scanned ticket**            | Scanner shows ⚠️ "Already Checked In" with timestamp            |
| **Invalid barcode**                   | Scanner shows ❌ "Invalid Ticket" with retry option             |
| **User without tickets**              | My Tickets shows empty state with "Browse Events" CTA           |
| **Admin creates event without venue** | Prompted to create venue first (inline modal or redirect)       |

### 5.4 Edge Cases

| Edge Case                               | Handling                                                                                       |
| --------------------------------------- | ---------------------------------------------------------------------------------------------- |
| Concurrent seat selection               | Database-level unique constraint on `(event_id, seat_id)` in tickets table; optimistic locking |
| Duplicate barcode scan within 5 seconds | Debounce on scan input; show "Already Processed"                                               |
| Event with no ticket types              | Event detail shows "Tickets coming soon" message                                               |
| User tries to checkout past event       | Checkout button hidden; "Event has ended" message                                              |
| Payment proof upload fails              | Client-side retry with progress indicator; max file size 5MB                                   |
| Admin deletes event with issued tickets | Soft-delete only; warning modal with ticket count                                              |

---

## 6. User Stories

### 6.1 Admin Side

| ID    | User Story                                                                                           | Acceptance Criteria                                                                                                                                                                                                                                                                            | Design  | Notes                                        | Platform | JIRA |
| ----- | ---------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------- | -------------------------------------------- | -------- | ---- |
| US-01 | As an admin, I want to create a venue with address and capacity so that events can be assigned to it | **Given** I'm on the Master Data > Venues page<br>**When** I click "Create Venue" and fill in name, address, city, state, country, postal code, capacity<br>**Then** the venue is saved and appears in the venue list<br>**And** I can see a success notification                              | [Figma] | Validate capacity is a positive integer      | Web      | -    |
| US-02 | As an admin, I want to manage seats for a venue so that users can select specific seats              | **Given** I'm viewing a venue's detail page<br>**When** I click "Manage Seats" and add seats with section, row, number, type<br>**Then** the seats are saved and displayed in a visual grid or table<br>**And** I can bulk-import seats via CSV                                                | [Figma] | Support seat types: regular, VIP, accessible | Web      | -    |
| US-03 | As an admin, I want to create an organiser profile so that events are attributed                     | **Given** I'm on Master Data > Organisers<br>**When** I fill in name, description, website, email, phone and submit<br>**Then** the organiser is created and available in the event creation form dropdown                                                                                     | [Figma] | Email must be unique                         | Web      | -    |
| US-04 | As an admin, I want to create an event with venue and organiser so that users can discover it        | **Given** I'm on Master Data > Events<br>**When** I fill in event name, description, dates, select venue and organiser, and submit<br>**Then** the event is created in "draft" status<br>**And** a slug is auto-generated from the name<br>**And** I can add ticket types to the event         | [Figma] | Slug must be URL-safe and unique             | Web      | -    |
| US-05 | As an admin, I want to add ticket types to an event so that users can purchase them                  | **Given** I'm on the event edit page<br>**When** I add a ticket type with name, price, quantity, sale start/end dates<br>**Then** the ticket type is saved and visible on the public event page<br>**And** availability is calculated as `quantity - sold`                                     | [Figma] | Support 0-price for free tickets             | Web      | -    |
| US-06 | As an admin, I want to view a list of all events with ticket statistics so that I can monitor sales  | **Given** I'm on the admin Events list page<br>**When** the page loads<br>**Then** I see all events with: name, date, venue, status, total tickets, sold tickets, revenue<br>**And** I can filter by status and search by name                                                                 | [Figma] | Paginate at 25 per page                      | Web      | -    |
| US-07 | As an admin, I want to view all registered users so that I can manage accounts                       | **Given** I'm on the admin Users list page<br>**When** the page loads<br>**Then** I see all users with: name, email, role, registration date, ticket count<br>**And** I can filter by role and search by name/email                                                                            | [Figma] | Exclude password display                     | Web      | -    |
| US-08 | As an admin, I want to view a user's purchase and ticket history so that I can assist them           | **Given** I'm viewing a user's detail page<br>**When** I click "History" tab<br>**Then** I see their payment records (invoice, amount, status, date) and ticket records (event, type, seat, status)                                                                                            | [Figma] | Show both confirmed and pending payments     | Web      | -    |
| US-09 | As an admin, I want to view my own activity log so that I can track my actions                       | **Given** I'm on the My Activity page<br>**When** the page loads<br>**Then** I see a chronological list of my actions: events created, tickets validated, users edited<br>**And** I can filter by action type and date range                                                                   | [Figma] | Uses existing ActivityLog model              | Web      | -    |
| US-10 | As an admin/staff/volunteer, I want to scan a ticket barcode so that I can validate entry            | **Given** I'm on the Scan Ticket page<br>**When** I scan a barcode (camera or manual input)<br>**Then** the system validates the ticket UUID<br>**And** shows ✅ Valid (with attendee name, event, seat), ❌ Invalid, or ⚠️ Already Scanned<br>**And** a timestamp is recorded in `scanned_at` | [Figma] | Works on mobile browsers                     | Web      | -    |
| US-11 | As an admin, I want to publish/unpublish an event so that I control visibility                       | **Given** I'm on the event detail page<br>**When** I click "Publish" (or "Unpublish")<br>**Then** the event status changes to `published` (or `draft`)<br>**And** the event becomes visible (or hidden) on the public catalog                                                                  | [Figma] | Cannot unpublish if tickets are sold         | Web      | -    |

### 6.2 User Side

| ID    | User Story                                                                                   | Acceptance Criteria                                                                                                                                                                                                                                                                                                            | Design  | Notes                                               | Platform | JIRA |
| ----- | -------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------- | --------------------------------------------------- | -------- | ---- |
| US-12 | As a user, I want to browse upcoming events so that I can find one to attend                 | **Given** I'm on the Browse Events page (/events)<br>**When** the page loads<br>**Then** I see published event cards with: image, name, date, venue, price range<br>**And** I can search by keyword and filter by date, location                                                                                               | [Figma] | Show "No events found" empty state                  | Web      | -    |
| US-13 | As a user, I want to view event details so that I can decide to buy tickets                  | **Given** I click on an event card<br>**When** the event detail page loads<br>**Then** I see: full description, schedule, venue info with map, organiser details, available ticket types with prices and remaining quantity                                                                                                    | [Figma] | Show sold-out badge if no availability              | Web      | -    |
| US-14 | As a user, I want to checkout and purchase a ticket so that I can attend the event           | **Given** I'm on the event detail page and logged in<br>**When** I select a ticket type, select a seat, upload payment proof, and confirm<br>**Then** a ticket is created with status "pending" (or "confirmed" if free)<br>**And** a payment record is created<br>**And** I'm redirected to the success page                  | [Figma] | Free tickets skip payment proof                     | Web      | -    |
| US-15 | As a user, I want to see my consolidated activity so that I can track my engagement          | **Given** I'm on the My Activity page<br>**When** the page loads<br>**Then** I see a timeline of: ticket purchases, event check-ins, testimonials submitted, profile updates<br>**And** each entry shows date, action type, and relevant details                                                                               | [Figma] | Source from ActivityLog + Payments + Tickets        | Web      | -    |
| US-16 | As a user, I want to display my ticket barcode full-screen so that admin can scan it         | **Given** I'm on my ticket detail page<br>**When** I click "Show Ticket"<br>**Then** a full-screen overlay displays: barcode/QR code, my name, event name, seat number<br>**And** screen brightness is maximised<br>**And** the display auto-locks to prevent sleep                                                            | [Figma] | Use secure_token to prevent screenshot fraud        | Web      | -    |
| US-17 | As a user, I want to manage my profile so that my information is up to date                  | **Given** I'm on the Profile page<br>**When** I update my name, email, phone, avatar, or password<br>**Then** the changes are saved<br>**And** I see a success notification<br>**And** avatar upload accepts JPG/PNG up to 2MB                                                                                                 | [Figma] | Email change requires re-verification (future)      | Web      | -    |
| US-18 | As a user, I want to view my ticket history so that I can see all past and upcoming events   | **Given** I'm on the Ticket History page<br>**When** the page loads<br>**Then** I see two sections: "Upcoming" (future events) and "Past" (completed events)<br>**And** each ticket shows: event name, date, seat, type, status badge<br>**And** upcoming tickets have "Show Ticket" CTA, past tickets have "Leave Review" CTA | [Figma] | Sort by event date descending                       | Web      | -    |
| US-19 | As a user, I want to view my ticket detail so that I can see all information about my ticket | **Given** I'm on my Ticket History and click a ticket<br>**When** the Ticket Detail page loads<br>**Then** I see: event name & date, venue, seat (section, row, number), ticket type, price paid, payment status, barcode image, purchase date, check-in status                                                                | [Figma] | Show "Checked In ✅" if scanned_at is set           | Web      | -    |
| US-20 | As a user, I want to preview my ticket as a visual card so that I can share or save it       | **Given** I'm on my Ticket Detail page<br>**When** I click "Preview Ticket"<br>**Then** a styled ticket card is displayed with: event poster, event name, date, venue, seat, barcode, holder name<br>**And** I can download the card as an image or share it                                                                   | [Figma] | Ticket card designed as shareable asset             | Web      | -    |
| US-21 | As a user, I want to leave a testimonial for a past event so that I can share my experience  | **Given** I have a ticket for a past event without an existing testimonial<br>**When** I click "Leave Review" and submit a rating (1-5) and text comment<br>**Then** the testimonial is saved and linked to my ticket<br>**And** I see it reflected in my activity timeline                                                    | [Figma] | One testimonial per ticket; edit not allowed in MVP | Web      | -    |

---

## 7. Analytics & Tracking

### 7.1 Admin Events

| Event Name                  | Trigger                    | Page                        | Parameters                                                  |
| --------------------------- | -------------------------- | --------------------------- | ----------------------------------------------------------- |
| `admin.event.created`       | Admin creates a new event  | Admin > Events > Create     | `event_id`, `event_name`, `venue_id`, `organizer_id`        |
| `admin.event.published`     | Admin publishes an event   | Admin > Events > Detail     | `event_id`, `event_name`, `status`                          |
| `admin.ticket_type.created` | Admin adds ticket type     | Admin > Events > Edit       | `event_id`, `ticket_type_id`, `price`, `quantity`           |
| `admin.venue.created`       | Admin creates a venue      | Admin > Venues > Create     | `venue_id`, `venue_name`, `capacity`                        |
| `admin.organizer.created`   | Admin creates an organiser | Admin > Organisers > Create | `organizer_id`, `organizer_name`                            |
| `admin.seat.created`        | Admin creates seats        | Admin > Venues > Seats      | `venue_id`, `seat_count`, `section`                         |
| `admin.ticket.scanned`      | Barcode scanned            | Scan Ticket                 | `ticket_id`, `event_id`, `result` (valid/invalid/duplicate) |
| `admin.user.viewed`         | Admin views user detail    | Admin > Users > Detail      | `target_user_id`, `admin_user_id`                           |

### 7.2 User Events

| Event Name                   | Trigger                                 | Page                   | Parameters                                      |
| ---------------------------- | --------------------------------------- | ---------------------- | ----------------------------------------------- |
| `user.event.viewed`          | User opens event detail                 | Events > Show          | `event_id`, `event_name`, `user_id` (if auth)   |
| `user.event.browsed`         | User visits event catalog               | Events > Index         | `search_query`, `filters`, `page`               |
| `user.checkout.started`      | User begins checkout                    | Checkout               | `event_id`, `ticket_type_id`, `price`           |
| `user.checkout.completed`    | Checkout success                        | Checkout > Success     | `ticket_id`, `event_id`, `payment_id`, `amount` |
| `user.checkout.abandoned`    | User leaves checkout without completing | Checkout               | `event_id`, `ticket_type_id`, `step`            |
| `user.ticket.shown`          | User opens full-screen ticket           | Ticket > Show for Scan | `ticket_id`, `event_id`                         |
| `user.ticket.previewed`      | User previews ticket card               | Ticket > Preview       | `ticket_id`, `event_id`                         |
| `user.testimonial.submitted` | User submits testimonial                | Ticket > Testimonial   | `ticket_id`, `event_id`, `rating`               |
| `user.profile.updated`       | User updates profile                    | Profile > Edit         | `fields_updated[]`                              |
| `user.activity.viewed`       | User views activity page                | My Activity            | `user_id`                                       |

### 7.3 Example Event Structure

```json
{
    "Trigger": "Click",
    "TriggerValue": "Complete Checkout",
    "Page": "Checkout",
    "Data": {
        "EventId": 42,
        "EventName": "Summer Music Festival 2026",
        "TicketTypeId": 7,
        "TicketTypeName": "VIP",
        "SeatId": 156,
        "Amount": 350000,
        "PaymentMethod": "manual_upload",
        "UserId": 1023
    },
    "Description": "User completes ticket purchase and payment proof upload"
}
```

```json
{
    "Trigger": "Scan",
    "TriggerValue": "Barcode Scanned",
    "Page": "Scan Ticket",
    "Data": {
        "TicketId": 891,
        "TicketUUID": "a4b8d1b6-0b3b-4b1a-9c1a-1a2b3c4d5e6f",
        "EventId": 42,
        "Result": "valid",
        "ScannedBy": 5,
        "ScannedAt": "2026-03-15T19:45:22+07:00"
    },
    "Description": "Staff scans ticket barcode at event entrance"
}
```

---

## 8. Detailed Feature Specifications

### 8.1 Admin Side — Master Data Module

#### 8.1.1 Master Data: Events

**Route:** `admin/events` (resource)

| Action      | URL                               | Method | Description                                    |
| ----------- | --------------------------------- | ------ | ---------------------------------------------- |
| List        | `/admin/events`                   | GET    | Paginated list with search/filter              |
| Create Form | `/admin/events/create`            | GET    | Form with venue/organiser dropdowns            |
| Store       | `/admin/events`                   | POST   | Validate & save event                          |
| Show        | `/admin/events/{event}`           | GET    | Event detail with ticket types, issued tickets |
| Edit Form   | `/admin/events/{event}/edit`      | GET    | Pre-filled form                                |
| Update      | `/admin/events/{event}`           | PUT    | Validate & update                              |
| Delete      | `/admin/events/{event}`           | DELETE | Soft-delete with confirmation                  |
| Publish     | `/admin/events/{event}/publish`   | POST   | Change status to published                     |
| Unpublish   | `/admin/events/{event}/unpublish` | POST   | Change status to draft                         |

**Form Fields:**

- `name` — required, string, max 255
- `slug` — auto-generated, editable, unique
- `description` — required, textarea (rich text optional)
- `location` — optional, string (display address, separate from venue)
- `start_time` — required, datetime, must be in the future
- `end_time` — required, datetime, must be after start_time
- `venue_id` — required, select from venues
- `organizer_id` — required, select from organisers
- `status` — enum: draft, published, completed, cancelled

#### 8.1.2 Master Data: Ticket Types

**Route:** Nested under events: `admin/events/{event}/ticket-types`

| Action      | URL                                              | Method |
| ----------- | ------------------------------------------------ | ------ |
| List        | `/admin/events/{event}/ticket-types`             | GET    |
| Create Form | `/admin/events/{event}/ticket-types/create`      | GET    |
| Store       | `/admin/events/{event}/ticket-types`             | POST   |
| Edit        | `/admin/events/{event}/ticket-types/{type}/edit` | GET    |
| Update      | `/admin/events/{event}/ticket-types/{type}`      | PUT    |
| Delete      | `/admin/events/{event}/ticket-types/{type}`      | DELETE |

**Form Fields:**

- `name` — required, string (e.g., "VIP", "Regular", "Early Bird")
- `description` — optional, text
- `price` — required, decimal ≥ 0
- `quantity` — required, integer ≥ 1
- `sale_start_date` — optional, datetime
- `sale_end_date` — optional, datetime (after sale_start_date)

#### 8.1.3 Master Data: Venues

**Route:** `admin/venues` (resource)

**Form Fields:**

- `name` — required, string, max 255
- `description` — optional, text
- `address` — required, string
- `city` — required, string
- `state` — optional, string
- `country` — required, string
- `postal_code` — optional, string
- `capacity` — required, integer ≥ 1

#### 8.1.4 Master Data: Seats

**Route:** Nested under venues: `admin/venues/{venue}/seats`

**Form Fields:**

- `section` — required, string (e.g., "A", "B", "VIP")
- `row` — required, string (e.g., "1", "2")
- `number` — required, string (e.g., "1", "2", "3")
- `status` — enum: available, reserved, maintenance
- `type` — enum: regular, vip, accessible

**Bulk Actions:**

- Bulk create: specify section, row range, number range → auto-generate seats
- Bulk status update: select multiple seats → change status

#### 8.1.5 Master Data: Organisers

**Route:** `admin/organizers` (resource)

**Form Fields:**

- `name` — required, string, max 255
- `description` — optional, text
- `website` — optional, URL
- `email` — required, email, unique
- `phone` — optional, string

---

### 8.2 Admin Side — Event & Ticket Management

#### 8.2.1 List Events / Tickets

- **Existing:** `admin/tickets` resource with CRUD
- **Enhancement:** Add event-centric view alongside existing ticket-centric view
- **Filters:** Status (draft/published/completed), date range, venue, organiser
- **Sorting:** By date, name, ticket count, revenue
- **Actions:** View, edit, export (PDF/CSV), preview ticket

#### 8.2.2 List Registered Users

- **Existing:** `admin/users` resource (admin-only)
- **Enhancement:** Add ticket count column, last login date, join date
- **Filters:** Role, registration date range
- **Search:** Name, email
- **Actions:** View detail, edit role, create user

---

### 8.3 Admin Side — User Management & History

#### 8.3.1 User Detail Page

**Route:** `admin/users/{user}` (show)

**Tabs:**

1. **Profile** — Name, email, role, phone, avatar, registration date, last login
2. **Tickets** — All tickets purchased by this user (event, type, seat, status)
3. **Payments** — All payments made (invoice #, amount, status, date, linked tickets)
4. **Activity** — Activity log entries for this user (actions taken)

---

### 8.4 Admin Side — My Activity

**Route:** `admin/my-activity` or `/my/history` (existing)

**Enhancement:**

- Filter by action type: `event_created`, `ticket_validated`, `user_updated`, `ticket_created`
- Filter by date range
- Pagination with 50 entries per page
- Each entry shows: timestamp, action description, affected entity link

---

### 8.5 Admin Side — Scan Ticket

**Existing:** `/scan` route with camera/manual input

**Enhancement:**

- Larger scan result area with clear status icons
- Sound feedback (beep on valid, buzz on invalid)
- History of scanned tickets in current session
- Offline mode support (cache scan results, sync when online)
- Statistics: total scanned today, valid/invalid ratio

---

### 8.6 User Side — Browse Event

**Existing:** `/events` public route

**Enhancement:**

- Hero banner with featured events
- Category/tag filters
- Location-based search (city filter)
- Date range picker
- Price range filter
- Event card shows: image placeholder, name, date range, venue name, price starting from
- Responsive grid layout (3 columns desktop, 2 tablet, 1 mobile)

---

### 8.7 User Side — Checkout

**Existing:** `POST /events/{slug}/checkout`

**Enhancement:**

- Step indicator (1. Select Ticket → 2. Select Seat → 3. Payment → 4. Confirm)
- Seat map visualization (if venue has seat layout)
- Order summary sidebar
- Payment proof upload with preview
- Free ticket: auto-confirm without payment step
- Success page with confetti animation and ticket UUID

---

### 8.8 User Side — My Activity

**New Route:** `user/activity`

**Features:**

- Unified timeline view
- Activity types: purchase, check-in, testimonial, profile update
- Each entry: icon, title, description, timestamp, link to related entity
- Filter by type
- Infinite scroll or pagination

**Data Sources:**

- `payments` table (purchases)
- `tickets` table, `scanned_at` field (check-ins)
- `testimonials` table (reviews)
- `activity_logs` table (all actions)

---

### 8.9 User Side — Show Ticket for Scanning

**New Route:** `user/tickets/{ticket}/scan-display`

**Features:**

- Full-screen overlay/modal
- Large barcode/QR code centered on screen
- Ticket holder name displayed prominently
- Event name and seat information
- `secure_token` encoded in barcode (not just UUID) for security
- Screen wake lock API to prevent display sleep
- Maximum brightness request (where browser API supports)
- Close button to return to ticket detail

---

### 8.10 User Side — Profile

**Existing:** `/profile` route

**Features (existing, enhance):**

- Edit name, email, phone
- Upload/change avatar (image crop)
- Change password (current + new + confirm)
- Notification preferences toggle
- Account deletion request (deferred to MVP 2)

---

### 8.11 User Side — Ticket History

**Existing:** `user/tickets`

**Enhancement:**

- Segmented into "Upcoming" and "Past" sections
- Status badges: `confirmed`, `pending`, `cancelled`, `checked-in`
- Quick actions: "Show Ticket" (upcoming), "Leave Review" (past), "View Details"
- Sort by event date
- Empty state with "Browse Events" CTA

---

### 8.12 User Side — Ticket Detail

**Existing:** `user/tickets/{ticket}`

**Enhancement:**

- Full event information section
- Seat map highlight (if available)
- Payment information section
- Barcode image with tap-to-enlarge
- Check-in status with timestamp
- "Show Ticket" button → full-screen display
- "Preview Ticket" button → visual card
- "Leave Testimonial" button (if past event, no existing testimonial)

---

### 8.13 User Side — Preview Ticket / Testimonial

**New Route:** `user/tickets/{ticket}/preview`

**Ticket Preview Card:**

- Designed as a shareable visual card (like a concert ticket)
- Contains: event name, date, venue, seat, barcode, holder name, ticket type
- Download as PNG/JPG
- Share via Web Share API (mobile)

**Testimonial Form:**

- Rating: 1-5 stars (interactive)
- Comment: textarea (max 500 characters)
- Submit button
- Display existing testimonial if already submitted (read-only)

---

## 9. Technical Specifications

### 9.1 Database Schema (Existing)

| Model          | Table            | Key Fields                                                                                                                                                            |
| -------------- | ---------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `User`         | `users`          | id, name, email, password, role, phone, avatar, notification_preferences                                                                                              |
| `Event`        | `events`         | id, name, slug, description, location, start_time, end_time, venue_id, organizer_id, status                                                                           |
| `TicketType`   | `ticket_types`   | id, event_id, name, description, price, quantity, sold, sale_start_date, sale_end_date                                                                                |
| `Venue`        | `venues`         | id, name, description, address, city, state, country, postal_code, capacity                                                                                           |
| `Organizer`    | `organizers`     | id, user_id, name, description, website, email, phone                                                                                                                 |
| `Seat`         | `seats`          | id, venue_id, section, row, number, status, type                                                                                                                      |
| `Ticket`       | `tickets`        | id, uuid, user_id, event_id, ticket_type_id, seat_id, user_name, user_email, seat_number, price, type, payment_status, barcode_data, scanned_at, secure_token, status |
| `Payment`      | `payments`       | id, user_id, invoice_number, amount, status, payment_proof_url, confirmed_at, confirmed_by, notes                                                                     |
| `Testimonial`  | `testimonials`   | id, user_id, ticket_id, rating, comment                                                                                                                               |
| `LoyaltyPoint` | `loyalty_points` | id, user_id, points, reason                                                                                                                                           |
| `ActivityLog`  | `activity_logs`  | id, user_id, action, description, properties, ip_address                                                                                                              |

### 9.2 Entity Relationships

```
User ─┬── hasMany → Ticket
      ├── hasMany → Payment
      ├── hasMany → Testimonial
      ├── hasMany → LoyaltyPoint
      └── hasMany → ActivityLog

Event ─┬── hasMany → Ticket
       ├── hasMany → TicketType
       ├── belongsTo → Venue
       └── belongsTo → Organizer

TicketType ── belongsTo → Event
           └── hasMany → Ticket

Venue ─┬── hasMany → Event
       └── hasMany → Seat

Seat ── belongsTo → Venue
     └── hasMany → Ticket

Organizer ── hasMany → Event
          └── belongsTo → User

Ticket ─┬── belongsTo → User
        ├── belongsTo → Event
        ├── belongsTo → TicketType
        ├── belongsTo → Seat
        ├── belongsToMany → Payment (via payment_tickets)
        └── hasOne → Testimonial

Payment ── belongsTo → User
        └── belongsToMany → Ticket (via payment_tickets)

Testimonial ── belongsTo → User
            └── belongsTo → Ticket
```

### 9.3 Role-Based Access Control

| Role        | Access                                                                                               |
| ----------- | ---------------------------------------------------------------------------------------------------- |
| `admin`     | Full access: dashboard, master data CRUD, user management, ticket management, scan, activity history |
| `staff`     | Dashboard, ticket management (CRUD), scan, activity history. No user management                      |
| `volunteer` | Scan ticket only (dedicated scan interface)                                                          |
| `user`      | User portal: browse events, checkout, my tickets, my activity, profile, testimonials                 |

### 9.4 Middleware Stack

| Middleware                   | Purpose                                |
| ---------------------------- | -------------------------------------- |
| `auth`                       | Require authentication                 |
| `guest`                      | Redirect if authenticated              |
| `role:admin`                 | Restrict to admin role                 |
| `role:admin,staff`           | Restrict to admin or staff             |
| `role:admin,staff,volunteer` | Restrict to admin, staff, or volunteer |
| `role:user`                  | Restrict to user role                  |

### 9.5 New Routes Required

```php
// Admin Master Data
Route::middleware(['role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    // Venues
    Route::resource('venues', Admin\VenueController::class);
    Route::resource('venues.seats', Admin\SeatController::class)->shallow();

    // Organisers
    Route::resource('organizers', Admin\OrganizerController::class);

    // Events (full resource, replacing limited existing)
    Route::resource('events', Admin\EventController::class);
    Route::post('events/{event}/publish', [Admin\EventController::class, 'publish'])->name('events.publish');
    Route::post('events/{event}/unpublish', [Admin\EventController::class, 'unpublish'])->name('events.unpublish');

    // Ticket Types (nested under events)
    Route::resource('events.ticket-types', Admin\TicketTypeController::class)->shallow();
});

// Admin User Management (admin only)
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/history', [Admin\UserController::class, 'history'])->name('users.history');
});

// User Portal (new routes)
Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('activity', [User\ActivityController::class, 'index'])->name('activity.index');
    Route::get('tickets/{ticket}/scan-display', [User\TicketController::class, 'scanDisplay'])->name('tickets.scan-display');
    Route::get('tickets/{ticket}/preview', [User\TicketController::class, 'preview'])->name('tickets.preview');
});
```

### 9.6 New Controllers Required

| Controller                   | Namespace                    | Actions                                                               |
| ---------------------------- | ---------------------------- | --------------------------------------------------------------------- |
| `Admin\VenueController`      | `App\Http\Controllers\Admin` | index, create, store, show, edit, update, destroy                     |
| `Admin\SeatController`       | `App\Http\Controllers\Admin` | index, create, store, edit, update, destroy                           |
| `Admin\OrganizerController`  | `App\Http\Controllers\Admin` | index, create, store, show, edit, update, destroy                     |
| `Admin\EventController`      | `App\Http\Controllers\Admin` | index, create, store, show, edit, update, destroy, publish, unpublish |
| `Admin\TicketTypeController` | `App\Http\Controllers\Admin` | index, create, store, edit, update, destroy                           |
| `User\ActivityController`    | `App\Http\Controllers\User`  | index                                                                 |

### 9.7 New Views Required

| View                                  | Path                       |
| ------------------------------------- | -------------------------- |
| `admin/venues/index.blade.php`        | Venue list                 |
| `admin/venues/create.blade.php`       | Venue create form          |
| `admin/venues/edit.blade.php`         | Venue edit form            |
| `admin/venues/show.blade.php`         | Venue detail with seats    |
| `admin/seats/index.blade.php`         | Seat list for venue        |
| `admin/seats/create.blade.php`        | Seat create form           |
| `admin/seats/edit.blade.php`          | Seat edit form             |
| `admin/organizers/index.blade.php`    | Organiser list             |
| `admin/organizers/create.blade.php`   | Organiser create form      |
| `admin/organizers/edit.blade.php`     | Organiser edit form        |
| `admin/events/index.blade.php`        | Event list (admin)         |
| `admin/events/create.blade.php`       | Event create form          |
| `admin/events/edit.blade.php`         | Event edit form            |
| `admin/events/show.blade.php`         | Event detail               |
| `admin/ticket-types/create.blade.php` | Ticket type create form    |
| `admin/ticket-types/edit.blade.php`   | Ticket type edit form      |
| `admin/users/show.blade.php`          | User detail with tabs      |
| `user/activity/index.blade.php`       | My Activity timeline       |
| `user/tickets/scan-display.blade.php` | Full-screen ticket display |
| `user/tickets/preview.blade.php`      | Visual ticket card         |

---

## 10. Open Questions

| #     | Question                                                                                  | Owner     | Status | Due Date | Notes                                      |
| ----- | ----------------------------------------------------------------------------------------- | --------- | ------ | -------- | ------------------------------------------ |
| OQ-01 | Should we support multiple payment methods in MVP 1 or only manual proof upload?          | PO        | Open   | [Date]   | Currently manual only                      |
| OQ-02 | Do we need real-time seat availability updates (WebSocket) or is page refresh sufficient? | Tech Lead | Open   | [Date]   | Page refresh for MVP 1                     |
| OQ-03 | Should testimonials be moderated before public display?                                   | PO        | Open   | [Date]   | Auto-publish in MVP, moderate in MVP 2     |
| OQ-04 | What is the maximum number of ticket types per event?                                     | PO        | Open   | [Date]   | Suggest 10                                 |
| OQ-05 | Should admin be able to issue complimentary tickets (bypass checkout)?                    | PO        | Open   | [Date]   | Existing admin ticket creation covers this |
| OQ-06 | Do we need event image/poster upload or use placeholder?                                  | PO/Design | Open   | [Date]   | Placeholder for MVP 1                      |
| OQ-07 | Should the ticket preview card include a downloadable PDF option?                         | PO        | Open   | [Date]   | PNG download for MVP 1                     |
| OQ-08 | How should we handle refunds/cancellations?                                               | PO        | Open   | [Date]   | Deferred to MVP 2                          |
| OQ-09 | Should seat selection be a visual seat map or a dropdown list?                            | Design    | Open   | [Date]   | Dropdown for MVP 1, visual map for MVP 2   |
| OQ-10 | Do we need to support bulk seat CSV import?                                               | Tech Lead | Open   | [Date]   | Nice-to-have for MVP 1                     |

---

## 11. Notes & Considerations

### 11.1 Technical Considerations

- **Performance:** Event listing should use eager loading for venue and organiser relations to avoid N+1 queries
- **Security:** Ticket scan display uses `secure_token` (64-char random) for barcode data, not just UUID
- **File Storage:** Payment proofs and avatars stored via Laravel's Storage facade (local disk for MVP, S3 for production)
- **Caching:** Event catalog page should cache published events for 5 minutes (Cache::remember)
- **Validation:** All form inputs validated server-side via Form Request classes
- **Soft Deletes:** Events with issued tickets should be soft-deleted, not hard-deleted

### 11.2 Business Considerations

- **Free Events:** The platform must support free events (price = 0) with automatic ticket confirmation
- **Volunteer Simplicity:** Volunteer role has access ONLY to the scan page — minimal UI
- **Data Privacy:** User personal data (email, phone) visible only to admin role, not staff
- **Audit Trail:** All admin actions logged via existing `LogsActivity` trait

### 11.3 Design Considerations

- **Dark Premium Aesthetic:** The application uses a premium dark theme with glassmorphism, gradients, and micro-animations (established in user portal)
- **Responsive:** All pages must be fully responsive (mobile-first approach)
- **Accessibility:** WCAG 2.1 AA compliance for colour contrast and keyboard navigation
- **Consistency:** Admin layout uses `layouts/admin.blade.php`, user portal uses `user/layouts/app.blade.php`, public pages use `layouts/public.blade.php`

### 11.4 Migration Considerations

- **Existing Data:** Tickets created via legacy admin flow (without event_id) should remain functional
- **Backward Compatibility:** Existing routes (`/scan`, `admin/tickets`) must continue to work
- **Database:** No destructive migrations; all changes are additive

---

## 12. Appendix

### 12.1 References

| Resource                        | Link                                                           |
| ------------------------------- | -------------------------------------------------------------- |
| Laravel 11 Documentation        | [https://laravel.com/docs/11.x](https://laravel.com/docs/11.x) |
| Existing Master Data Schema PRD | `prompter/ticketing-master-data-schema/prd.md`                 |
| User Event Discovery Proposal   | `prompter/changes/implement-user-event-discovery/`             |
| User Ticket Portal Proposal     | `prompter/changes/implement-user-ticket-portal/`               |
| Current Routes                  | `routes/web.php`                                               |

### 12.2 Glossary

| Term              | Definition                                                                     |
| ----------------- | ------------------------------------------------------------------------------ |
| **Event**         | A scheduled occurrence (concert, conference, etc.) that users can attend       |
| **Ticket**        | An issued entry pass linking a user to an event, with seat assignment          |
| **Ticket Type**   | A category of ticket for an event (e.g., VIP, Regular) with price and quantity |
| **Venue**         | A physical location where events are held, with capacity and address           |
| **Organiser**     | An entity (person or company) that organises events                            |
| **Seat**          | A specific seating position within a venue (section, row, number)              |
| **Barcode / QR**  | A scannable code on the ticket used for event entry validation                 |
| **Payment Proof** | An uploaded image or file confirming payment was made (manual verification)    |
| **Testimonial**   | A user review/rating submitted after attending an event                        |
| **Activity Log**  | A record of user or admin actions within the platform                          |
| **UUID**          | Universally Unique Identifier assigned to each ticket                          |
| **Secure Token**  | A 64-character random string used for barcode encoding to prevent fraud        |
| **MVP**           | Minimum Viable Product — the smallest set of features for initial release      |

### 12.3 Application Flow Summary

#### Admin Side Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                        ADMIN DASHBOARD                              │
├───────────┬───────────┬──────────┬───────────┬──────────┬──────────┤
│           │           │          │           │          │          │
▼           ▼           ▼          ▼           ▼          ▼          │
Master    List Event  List       Browse     Manage    My         Scan
Data      / Tickets   Users      Events     User &    Activity   Ticket
│                                            History              │
├── Events                                                        │
├── Ticket Types                                                  │
├── Seats                                                         │
├── Venues                                                        │
└── Organisers                                                    │
└─────────────────────────────────────────────────────────────────────┘
```

#### User Side Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                        USER PORTAL                                  │
├──────────┬─────────┬──────────┬──────────┬─────────┬───────────────┤
│          │         │          │          │         │               │
▼          ▼         ▼          ▼          ▼         ▼               │
Browse   Checkout  My         Show       Profile  Ticket           │
Event              Activity   Ticket              History          │
│                             for Scan             │               │
│                                                  ├── Ticket      │
│                                                  │   Detail      │
│                                                  └── Preview /   │
│                                                      Testimonial │
└─────────────────────────────────────────────────────────────────────┘
```

---

_Document generated: 2026-02-11_
_Last updated: 2026-02-11_
_Status: Draft — Pending stakeholder review_
