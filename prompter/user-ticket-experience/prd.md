# Product Requirements Document (PRD)

# User Ticket Experience Enhancement

---

## Overview

| Attribute          | Details                            |
| ------------------ | ---------------------------------- |
| **Feature Name**   | User Ticket Experience Enhancement |
| **Target Release** | Q1 2026 (February - March 2026)    |
| **Product Owner**  | [TBD]                              |
| **Tech Lead**      | [TBD]                              |
| **Designer**       | [TBD]                              |
| **QA Lead**        | [TBD]                              |
| **Status**         | Draft                              |
| **Version**        | 1.0                                |
| **Last Updated**   | February 8, 2026                   |

---

## Quick Links

| Resource                | Link          |
| ----------------------- | ------------- |
| **Design Mockups**      | [Figma - TBD] |
| **Technical Spec**      | [TBD]         |
| **JIRA Epic**           | [TBD]         |
| **API Documentation**   | [TBD]         |
| **Analytics Dashboard** | [TBD]         |

---

## Background

### Context

The current ticketing application serves as an internal tool for admin, staff, and volunteers to manage and validate tickets. However, there is a significant gap in the user-facing experience. **Ticket holders (customers)** currently have no dedicated portal to:

- View their purchased tickets
- Receive notifications about their tickets
- Confirm payments
- Leave reviews or testimonials
- Track their payment history

This creates friction in the customer journey and limits engagement opportunities. To enhance the overall user experience and increase customer satisfaction, we need to build a comprehensive **User Portal** that provides a modern, clean, and responsive interface for ticket holders.

### Current State

| Metric                | Current Value            | Source           |
| --------------------- | ------------------------ | ---------------- |
| User Portal           | ❌ Does not exist        | System           |
| User Roles            | Admin, Staff, Volunteer  | `User.php` model |
| Ticket Relationship   | No `user_id` foreign key | `tickets` table  |
| Notification System   | ❌ Not implemented       | System           |
| Payment Confirmation  | ❌ Not implemented       | System           |
| Review System         | ❌ Not implemented       | System           |
| Mobile Responsiveness | Partial (admin area)     | UI Audit         |

### Problem Statement

**Problem:** Ticket holders have no visibility into their ticket status, payment history, or a way to engage with the platform post-purchase. This leads to:

- Increased support requests for ticket information
- No mechanism for collecting customer feedback
- Manual payment confirmation processes
- Reduced customer engagement and satisfaction

**Impact:**

- **Operations:** High volume of manual support inquiries
- **Revenue:** Missed opportunities for upselling and repeat purchases
- **Customer Satisfaction:** Poor post-purchase experience

### Current Workarounds

1. **Ticket Information:** Users receive tickets via email PDF (if implemented) with no online access
2. **Payment Confirmation:** Manual coordination via external messaging apps
3. **Reviews:** No system in place; feedback collected informally
4. **Notifications:** No automated notifications to users

---

## Objectives

### Business Objectives

| #   | Objective                        | Success Criteria                                                             |
| --- | -------------------------------- | ---------------------------------------------------------------------------- |
| 1   | **Reduce Support Load**          | Decrease ticket-related support inquiries by 60% within 3 months post-launch |
| 2   | **Increase Customer Engagement** | Achieve 40% of ticket holders logging into the user portal within 2 months   |
| 3   | **Collect Customer Feedback**    | Obtain reviews/ratings for at least 25% of completed events                  |
| 4   | **Streamline Payment Process**   | Reduce payment confirmation time by 70% through WhatsApp integration         |
| 5   | **Improve Customer Retention**   | Increase repeat ticket purchases by 15% through improved UX                  |

### User Objectives

| User              | Objective                                                             |
| ----------------- | --------------------------------------------------------------------- |
| **Ticket Holder** | Easily access, view, and manage my purchased tickets from any device  |
| **Ticket Holder** | Receive timely notifications about my ticket status and event updates |
| **Ticket Holder** | Quickly confirm my payment via WhatsApp for seamless transactions     |
| **Ticket Holder** | Share my experience through reviews and ratings to help other users   |
| **Ticket Holder** | Track all my payment history in one convenient location               |
| **New User**      | Register and login easily to purchase tickets                         |

---

## Success Metrics

| Metric Type   | Metric                    | Current Baseline   | Target                 | Measurement Method                              | Review Timeline |
| ------------- | ------------------------- | ------------------ | ---------------------- | ----------------------------------------------- | --------------- |
| **Primary**   | User Portal Login Rate    | 0%                 | 40%                    | Analytics: unique logins / total ticket holders | Monthly         |
| **Primary**   | Payment Confirmation Time | ~24 hours (manual) | <1 hour (via WhatsApp) | Time from purchase to confirmation              | Weekly          |
| **Primary**   | Support Ticket Reduction  | Baseline TBD       | -60%                   | Zendesk/Support system metrics                  | Monthly         |
| **Secondary** | Review Submission Rate    | 0%                 | 25% of events          | Reviews submitted / total tickets sold          | Per Event       |
| **Secondary** | Mobile Usage Rate         | 0%                 | 65%                    | Google Analytics: device breakdown              | Monthly         |
| **Secondary** | User Registration Rate    | N/A                | Track conversion       | Registration completions                        | Weekly          |
| **Tertiary**  | Average Review Rating     | N/A                | ≥ 4.0 stars            | Aggregate star ratings                          | Monthly         |
| **Tertiary**  | Notification Open Rate    | N/A                | ≥ 30%                  | Notification analytics                          | Weekly          |

---

## Scope

### MVP 1: Core User Portal (Target: 4-6 weeks)

**Goal:** Establish the foundation of the user portal with essential features for ticket holders.

#### ✅ In Scope - MVP 1

| Feature                       | Description                                                                   | Priority      |
| ----------------------------- | ----------------------------------------------------------------------------- | ------------- |
| **User Registration & Login** | Allow new users to register and existing users to login                       | P0 - Critical |
| **Ticket Details View**       | Display comprehensive ticket information (seat, type, price, status, barcode) | P0 - Critical |
| **Payment History**           | Show all past payments and their statuses                                     | P0 - Critical |
| **Modern Responsive UI**      | Clean, modern design optimized for mobile, tablet, and desktop                | P0 - Critical |
| **User Dashboard**            | Central hub for user to see all their tickets and activities                  | P0 - Critical |
| **Profile Management**        | Basic profile view and edit functionality                                     | P1 - High     |

#### ❌ Out of Scope - MVP 1

| Feature                            | Reason                                        | Future Phase |
| ---------------------------------- | --------------------------------------------- | ------------ |
| **WhatsApp Payment Confirmation**  | Requires third-party API integration planning | MVP 2        |
| **Notification System**            | Needs notification infrastructure setup       | MVP 2        |
| **Review/Testimonial System**      | Depends on event completion tracking          | MVP 2        |
| **Social Login (Google/Facebook)** | Nice-to-have, not critical for launch         | MVP 3        |
| **In-App Ticket Purchase**         | Requires payment gateway integration          | Phase 2      |
| **Multi-language Support**         | Future internationalization                   | Phase 3      |

---

### MVP 2: Engagement Features (Target: 3-4 weeks after MVP 1)

**Goal:** Add communication and feedback capabilities.

#### ✅ In Scope - MVP 2

| Feature                           | Description                                              | Priority      |
| --------------------------------- | -------------------------------------------------------- | ------------- |
| **Notification System**           | In-app and email notifications for ticket status, events | P0 - Critical |
| **WhatsApp Payment Confirmation** | Send payment confirmation requests via WhatsApp          | P0 - Critical |
| **Review & Rating System**        | Star ratings (1-5) and text comments for events          | P1 - High     |
| **Notification Preferences**      | User can toggle notification types                       | P1 - High     |

---

### Future Iterations Roadmap

| Phase       | Features                                             | Target Timeline |
| ----------- | ---------------------------------------------------- | --------------- |
| **MVP 3**   | Social Login, Ticket QR Download, Push Notifications | Q2 2026         |
| **Phase 2** | In-App Ticket Purchase, Payment Gateway Integration  | Q2-Q3 2026      |
| **Phase 3** | Multi-language, Loyalty Points, Referral System      | Q3-Q4 2026      |

---

## User Flows

### 1. User Registration Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                     USER REGISTRATION FLOW                       │
└─────────────────────────────────────────────────────────────────┘

[Landing Page]
     │
     ▼
[Click "Register" or "Create Account"]
     │
     ▼
┌─────────────────────────────────────┐
│         REGISTRATION FORM            │
│  ○ Full Name (required)              │
│  ○ Email Address (required)          │
│  ○ Password (required, min 8 chars)  │
│  ○ Confirm Password (required)       │
│  ○ Phone Number (optional)           │
│  [  Create Account  ]                │
└─────────────────────────────────────┘
     │
     ├── Validation Error ──► [Show inline errors, stay on form]
     │
     ▼
[Email Verification Sent] ──► [User Clicks Link] ──► [Email Verified]
     │
     ▼
[Redirect to Dashboard]
     │
     ▼
[Welcome Modal / First-time User Guide]
```

### 2. User Login Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                        USER LOGIN FLOW                           │
└─────────────────────────────────────────────────────────────────┘

[Landing Page / Login Page]
     │
     ▼
┌─────────────────────────────────────┐
│            LOGIN FORM                │
│  ○ Email Address                     │
│  ○ Password                          │
│  ○ [Remember Me] checkbox            │
│  [  Login  ]                         │
│  ─────────────────────────           │
│  Forgot Password? | Register         │
└─────────────────────────────────────┘
     │
     ├── Invalid Credentials ──► [Show error "Invalid email or password"]
     │
     ├── Unverified Email ──► [Prompt to verify email]
     │
     ▼
[Role Check]
     │
     ├── Role = 'user' ──► [Redirect to User Dashboard]
     │
     └── Role = 'admin/staff/volunteer' ──► [Redirect to Admin Dashboard]
```

### 3. Ticket Details View Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    TICKET DETAILS FLOW                           │
└─────────────────────────────────────────────────────────────────┘

[User Dashboard]
     │
     ▼
[My Tickets Grid/List]
     │
     ├── Active Tickets (upcoming events)
     ├── Past Tickets (completed events)
     └── Pending Tickets (awaiting payment confirmation)
     │
     ▼
[Click on Ticket Card]
     │
     ▼
┌─────────────────────────────────────┐
│         TICKET DETAILS PAGE          │
│  ┌─────────────────────────────┐    │
│  │      TICKET PREVIEW         │    │
│  │   [QR/Barcode Display]      │    │
│  │   Event: Concert XYZ        │    │
│  │   Date: Feb 15, 2026        │    │
│  │   Seat: A-12                │    │
│  │   Type: VIP                 │    │
│  │   Price: Rp 500,000         │    │
│  └─────────────────────────────┘    │
│                                      │
│  Status: [✓ CONFIRMED]              │
│                                      │
│  [ Download Ticket ] [ Share ]      │
│  [ Leave Review ] (if event passed) │
└─────────────────────────────────────┘
```

### 4. Payment History Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                   PAYMENT HISTORY FLOW                           │
└─────────────────────────────────────────────────────────────────┘

[User Dashboard]
     │
     ▼
[Navigate to "Payment History" via Sidebar/Menu]
     │
     ▼
┌─────────────────────────────────────┐
│        PAYMENT HISTORY PAGE          │
│  ┌─────────────────────────────────┐│
│  │ Filter: [All ▼] [Date Range ▼] ││
│  │ Search: [________________]      ││
│  └─────────────────────────────────┘│
│                                      │
│  ┌─────────────────────────────────┐│
│  │ Payment #INV-2026-001           ││
│  │ Date: Feb 5, 2026               ││
│  │ Amount: Rp 500,000              ││
│  │ Status: ✓ Confirmed             ││
│  │ [View Details]                  ││
│  └─────────────────────────────────┘│
│                                      │
│  ┌─────────────────────────────────┐│
│  │ Payment #INV-2026-002           ││
│  │ Date: Feb 3, 2026               ││
│  │ Amount: Rp 250,000              ││
│  │ Status: ⏳ Pending               ││
│  │ [Confirm via WhatsApp]          ││
│  └─────────────────────────────────┘│
└─────────────────────────────────────┘
     │
     ▼
[Click "View Details"]
     │
     ▼
[Payment Detail Modal/Page with breakdown]
```

### 5. WhatsApp Payment Confirmation Flow (MVP 2)

```
┌─────────────────────────────────────────────────────────────────┐
│               WHATSAPP PAYMENT CONFIRMATION FLOW                 │
└─────────────────────────────────────────────────────────────────┘

[Payment History Page]
     │
     ▼
[Pending Payment Card - Click "Confirm via WhatsApp"]
     │
     ▼
┌─────────────────────────────────────┐
│    PAYMENT CONFIRMATION MODAL        │
│                                      │
│  Please confirm your payment:        │
│  Amount: Rp 500,000                  │
│  Invoice: INV-2026-001               │
│                                      │
│  Upload Payment Proof:               │
│  [ Choose File ]                     │
│                                      │
│  [ Send via WhatsApp ]               │
│                                      │
│  Note: You will be redirected to     │
│  WhatsApp with pre-filled message    │
└─────────────────────────────────────┘
     │
     ▼
[Open WhatsApp with Pre-filled Message]
     │
     Message Template:
     │  "Halo, saya ingin mengonfirmasi pembayaran
     │   Invoice: INV-2026-001
     │   Jumlah: Rp 500,000
     │   Nama: [User Name]
     │   [Attachment: Payment Proof]"
     │
     ▼
[User Sends Message]
     │
     ▼
[Admin Receives & Processes]
     │
     ▼
[Admin Confirms Payment in System]
     │
     ▼
[User Receives Notification: "Payment Confirmed!"]
```

### 6. Review & Testimonial Flow (MVP 2)

```
┌─────────────────────────────────────────────────────────────────┐
│                  REVIEW SUBMISSION FLOW                          │
└─────────────────────────────────────────────────────────────────┘

[Ticket Details Page (Past Event)]
     │
     ▼
[Click "Leave a Review"]
     │
     ▼
┌─────────────────────────────────────┐
│         REVIEW SUBMISSION            │
│                                      │
│  How was your experience?            │
│                                      │
│  Rating: ☆ ☆ ☆ ☆ ☆                  │
│         (Click to rate 1-5 stars)    │
│                                      │
│  Your Review:                        │
│  ┌─────────────────────────────┐    │
│  │ Write your experience...    │    │
│  │                             │    │
│  │                             │    │
│  └─────────────────────────────┘    │
│  (Min 10 characters, Max 500)       │
│                                      │
│  [ Submit Review ]                   │
└─────────────────────────────────────┘
     │
     ├── Validation Error ──► [Show inline errors]
     │
     ▼
[Review Submitted Successfully]
     │
     ▼
[Review Pending Admin Approval] or [Review Published Immediately]
     │
     ▼
[User Sees "Thank You" Message + Updated Ticket Card with Review Badge]
```

### 7. Notification Flow (MVP 2)

```
┌─────────────────────────────────────────────────────────────────┐
│                    NOTIFICATION FLOW                             │
└─────────────────────────────────────────────────────────────────┘

[System Events Trigger Notifications]
     │
     ├── Ticket Purchased ──► "Your ticket has been confirmed!"
     ├── Payment Received ──► "Payment of Rp 500,000 confirmed"
     ├── Event Reminder ──► "Your event is tomorrow at 7 PM"
     ├── Review Request ──► "How was the event? Leave a review!"
     └── Payment Pending ──► "Please confirm your payment"
     │
     ▼
[Notification Stored in Database]
     │
     ├── Send Email (if enabled)
     ├── Show In-App (always)
     └── Push Notification (if implemented - MVP 3)
     │
     ▼
[User Sees Notification Bell with Badge]
     │
     ▼
[User Clicks Notification]
     │
     ▼
┌─────────────────────────────────────┐
│       NOTIFICATION DROPDOWN          │
│                                      │
│  🔔 (3) New                          │
│  ─────────────────────               │
│  ● Payment Confirmed                 │
│    Your payment for INV-2026-001...  │
│    5 minutes ago                     │
│  ─────────────────────               │
│  ● Event Reminder                    │
│    Your event starts in 24 hours...  │
│    1 hour ago                        │
│  ─────────────────────               │
│  ○ Leave a Review                    │
│    How was the concert? Tell us...   │
│    1 day ago                         │
│  ─────────────────────               │
│  [ View All Notifications ]          │
└─────────────────────────────────────┘
```

---

## User Stories

### MVP 1: Core User Portal

| ID    | User Story                                                                                                           | Acceptance Criteria                                                                                                                                                                                                                                       | Design  | Notes                                 | Platform              | JIRA |
| ----- | -------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------- | ------------------------------------- | --------------------- | ---- |
| US-01 | As a **new user**, I want to **register an account** so that I can **access my tickets online**                      | **Given** I'm on the registration page<br>**When** I enter valid name, email, password, confirm password<br>**Then** my account is created<br>**And** I receive a verification email<br>**And** I'm logged in after verification                          | [Figma] | Email verification required           | Mobile/Tablet/Desktop | TBD  |
| US-02 | As a **returning user**, I want to **login to my account** so that I can **access my dashboard**                     | **Given** I'm on the login page<br>**When** I enter valid email and password<br>**Then** I'm redirected to my dashboard<br>**And** I see my profile info<br>**And** "Remember me" keeps me logged in for 30 days                                          | [Figma] | Rate limit: 5 attempts/min            | Mobile/Tablet/Desktop | TBD  |
| US-03 | As a **user**, I want to **see my dashboard** so that I can **have an overview of my tickets and activities**        | **Given** I'm logged in<br>**When** I access the dashboard<br>**Then** I see summary cards for: Active Tickets, Pending Payments, Past Events<br>**And** I see quick action buttons<br>**And** I see recent activity feed                                 | [Figma] | Cache for 5 minutes                   | Mobile/Tablet/Desktop | TBD  |
| US-04 | As a **user**, I want to **view a list of all my tickets** so that I can **see what events I have access to**        | **Given** I'm on the My Tickets page<br>**When** the page loads<br>**Then** I see all my tickets in a grid/list view<br>**And** tickets are categorized: Upcoming, Past, Pending<br>**And** each ticket shows event name, date, status                    | [Figma] | Pagination: 12 per page               | Mobile/Tablet/Desktop | TBD  |
| US-05 | As a **user**, I want to **view detailed ticket information** so that I can **see all relevant details and barcode** | **Given** I click on a ticket<br>**When** the ticket detail page loads<br>**Then** I see: Event name, date, time, venue, seat number, ticket type, price, barcode/QR<br>**And** I can download or share the ticket<br>**And** I see ticket status clearly | [Figma] | Barcode must be scannable from screen | Mobile/Tablet/Desktop | TBD  |
| US-06 | As a **user**, I want to **view my payment history** so that I can **track all my transactions**                     | **Given** I'm on the Payment History page<br>**When** the page loads<br>**Then** I see all payments sorted by date (newest first)<br>**And** each shows: Invoice #, Date, Amount, Status<br>**And** I can filter by status and date range                 | [Figma] | Export to PDF option                  | Mobile/Tablet/Desktop | TBD  |
| US-07 | As a **user**, I want to **view payment details** so that I can **see the breakdown of each transaction**            | **Given** I click on a payment<br>**When** the detail modal/page opens<br>**Then** I see: Invoice #, Date, Items purchased, Price breakdown, Payment method, Status, Associated tickets                                                                   | [Figma] | Link to related tickets               | Mobile/Tablet/Desktop | TBD  |
| US-08 | As a **user**, I want to **update my profile** so that I can **keep my information current**                         | **Given** I'm on the Profile page<br>**When** I edit my name, email, phone, or password<br>**Then** my changes are saved<br>**And** I receive confirmation<br>**And** password change requires current password                                           | [Figma] | Email change requires re-verification | Mobile/Tablet/Desktop | TBD  |
| US-09 | As a **user**, I want to **reset my password** so that I can **regain access if I forget it**                        | **Given** I'm on the login page<br>**When** I click "Forgot Password" and enter my email<br>**Then** I receive a reset link<br>**And** the link expires in 1 hour<br>**And** I can set a new password                                                     | [Figma] | Rate limit: 3 requests/hour           | Mobile/Tablet/Desktop | TBD  |
| US-10 | As a **user**, I want to **use the app on any device** so that I can **access my tickets anywhere**                  | **Given** I access the app on mobile, tablet, or desktop<br>**When** the page loads<br>**Then** the layout adapts to screen size<br>**And** all features are accessible<br>**And** touch targets are appropriately sized on mobile                        | [Figma] | Test on: iPhone 12+, iPad, Desktop    | Mobile/Tablet/Desktop | TBD  |

### MVP 2: Engagement Features

| ID    | User Story                                                                                                          | Acceptance Criteria                                                                                                                                                                                                                             | Design  | Notes                                            | Platform              | JIRA |
| ----- | ------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------- | ------------------------------------------------ | --------------------- | ---- |
| US-11 | As a **user**, I want to **receive notifications** so that I can **stay updated on my tickets and payments**        | **Given** a relevant event occurs (purchase, payment, reminder)<br>**When** the system processes the event<br>**Then** I receive an in-app notification<br>**And** I receive an email (if enabled)<br>**And** unread notifications show a badge | [Figma] | Queue via Laravel Jobs                           | Mobile/Tablet/Desktop | TBD  |
| US-12 | As a **user**, I want to **view all my notifications** so that I can **see all updates in one place**               | **Given** I click the notification bell<br>**When** the dropdown opens<br>**Then** I see recent notifications with read/unread status<br>**And** I can click to mark as read<br>**And** I can navigate to related item                          | [Figma] | Max 50 notifications stored                      | Mobile/Tablet/Desktop | TBD  |
| US-13 | As a **user**, I want to **manage notification preferences** so that I can **control what notifications I receive** | **Given** I'm on Settings > Notifications<br>**When** I toggle notification types<br>**Then** only selected notification types are sent<br>**And** in-app notifications cannot be fully disabled                                                | [Figma] | Categories: Payment, Events, Reviews, Promotions | Mobile/Tablet/Desktop | TBD  |
| US-14 | As a **user**, I want to **confirm payment via WhatsApp** so that I can **quickly verify my payment status**        | **Given** I have a pending payment<br>**When** I click "Confirm via WhatsApp"<br>**Then** WhatsApp opens with pre-filled message<br>**And** the message includes invoice #, amount, my name<br>**And** I can attach payment proof               | [Figma] | Use WhatsApp API or wa.me link                   | Mobile/Tablet/Desktop | TBD  |
| US-15 | As a **user**, I want to **leave a review for an event** so that I can **share my experience**                      | **Given** I attended an event<br>**When** I go to the ticket detail and click "Leave Review"<br>**Then** I can rate 1-5 stars<br>**And** I can write a text review (10-500 chars)<br>**And** I receive confirmation on submission               | [Figma] | One review per ticket                            | Mobile/Tablet/Desktop | TBD  |
| US-16 | As a **user**, I want to **view published reviews** so that I can **see what others said about events**             | **Given** I'm on an event/ticket page<br>**When** reviews exist<br>**Then** I see average rating<br>**And** I see individual reviews with user name, rating, date, comment<br>**And** reviews are paginated (10 per page)                       | [Figma] | Moderation required before publish               | Mobile/Tablet/Desktop | TBD  |
| US-17 | As a **user**, I want to **edit my review** so that I can **update my feedback if needed**                          | **Given** I submitted a review<br>**When** I view my review<br>**Then** I can click "Edit"<br>**And** I can modify rating and text<br>**And** edited reviews show "Edited" badge                                                                | [Figma] | Edit window: 7 days                              | Mobile/Tablet/Desktop | TBD  |

### Admin Stories (Supporting User Features)

| ID    | User Story                                                                                             | Acceptance Criteria                                                                                                                                                                                 | Design  | Notes                     | Platform | JIRA |
| ----- | ------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------- | ------------------------- | -------- | ---- |
| US-18 | As an **admin**, I want to **link tickets to user accounts** so that **users can see their tickets**   | **Given** I create/edit a ticket<br>**When** I select a user or enter email<br>**Then** the ticket is associated with that user<br>**And** the user sees it in their dashboard                      | [Figma] | Create user if not exists | Desktop  | TBD  |
| US-19 | As an **admin**, I want to **view and moderate reviews** so that **inappropriate content is filtered** | **Given** I'm on Reviews management<br>**When** I view pending reviews<br>**Then** I can Approve, Reject, or Request Edit<br>**And** reason is logged<br>**And** user is notified                   | [Figma] | Auto-approve option       | Desktop  | TBD  |
| US-20 | As an **admin**, I want to **confirm user payments** so that **tickets are activated**                 | **Given** I receive a WhatsApp confirmation<br>**When** I mark payment as confirmed in system<br>**Then** ticket status updates<br>**And** user receives notification<br>**And** activity is logged | [Figma] | Link to payment proof     | Desktop  | TBD  |

---

## Analytics & Tracking

### Event Tracking Table

| Event Name                 | Trigger      | Page/Location         | Description                  |
| -------------------------- | ------------ | --------------------- | ---------------------------- |
| `user_registered`          | Form Submit  | Registration Page     | User completes registration  |
| `user_logged_in`           | Form Submit  | Login Page            | User successfully logs in    |
| `user_logged_out`          | Button Click | Header                | User logs out                |
| `ticket_viewed`            | Page Load    | Ticket Details        | User views ticket details    |
| `ticket_downloaded`        | Button Click | Ticket Details        | User downloads ticket        |
| `payment_history_viewed`   | Page Load    | Payment History       | User views payment history   |
| `payment_detail_viewed`    | Modal Open   | Payment History       | User views payment details   |
| `whatsapp_confirm_clicked` | Button Click | Payment Card          | User clicks WhatsApp confirm |
| `review_submitted`         | Form Submit  | Review Modal          | User submits a review        |
| `notification_clicked`     | Click        | Notification Dropdown | User clicks a notification   |
| `profile_updated`          | Form Submit  | Profile Page          | User updates profile         |

### Event Structure Examples

```json
{
    "event": "user_registered",
    "timestamp": "2026-02-08T12:00:00Z",
    "user_id": 12345,
    "data": {
        "registration_source": "organic",
        "referrer": "google",
        "device_type": "mobile"
    }
}
```

```json
{
    "event": "ticket_viewed",
    "timestamp": "2026-02-08T14:30:00Z",
    "user_id": 12345,
    "data": {
        "ticket_id": "abc-123-xyz",
        "ticket_type": "VIP",
        "event_date": "2026-02-15",
        "view_duration_seconds": 45
    }
}
```

```json
{
    "event": "review_submitted",
    "timestamp": "2026-02-08T16:00:00Z",
    "user_id": 12345,
    "data": {
        "ticket_id": "abc-123-xyz",
        "rating": 5,
        "review_length": 150,
        "has_text": true
    }
}
```

```json
{
    "event": "whatsapp_confirm_clicked",
    "timestamp": "2026-02-08T10:15:00Z",
    "user_id": 12345,
    "data": {
        "payment_id": "INV-2026-001",
        "amount": 500000,
        "currency": "IDR",
        "pending_duration_hours": 2
    }
}
```

---

## Technical Considerations

### Database Schema Changes

#### New Tables

```sql
-- User Payment History
CREATE TABLE payments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    invoice_number VARCHAR(50) UNIQUE,
    amount DECIMAL(12, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    payment_proof_url VARCHAR(500),
    confirmed_at TIMESTAMP NULL,
    confirmed_by BIGINT NULL,
    notes TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (confirmed_by) REFERENCES users(id)
);

-- Ticket-Payment Relationship
CREATE TABLE payment_tickets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    payment_id BIGINT NOT NULL,
    ticket_id BIGINT NOT NULL,
    FOREIGN KEY (payment_id) REFERENCES payments(id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

-- Reviews/Testimonials
CREATE TABLE reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    ticket_id BIGINT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    moderated_by BIGINT NULL,
    moderated_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE (ticket_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

-- Notifications
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id, read_at)
);
```

#### Existing Table Modifications

```sql
-- Add user relationship to tickets
ALTER TABLE tickets ADD COLUMN user_id BIGINT NULL;
ALTER TABLE tickets ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE tickets ADD COLUMN payment_status ENUM('pending', 'confirmed') DEFAULT 'pending';

-- Add phone to users
ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL;
ALTER TABLE users ADD COLUMN notification_preferences JSON DEFAULT '{"email": true, "payment": true, "events": true, "reviews": true}';
```

### API Endpoints (Suggested)

| Method | Endpoint                            | Description                   |
| ------ | ----------------------------------- | ----------------------------- |
| `POST` | `/api/auth/register`                | User registration             |
| `POST` | `/api/auth/login`                   | User login                    |
| `POST` | `/api/auth/logout`                  | User logout                   |
| `POST` | `/api/auth/password/forgot`         | Request password reset        |
| `POST` | `/api/auth/password/reset`          | Reset password                |
| `GET`  | `/api/user/profile`                 | Get user profile              |
| `PUT`  | `/api/user/profile`                 | Update user profile           |
| `GET`  | `/api/user/tickets`                 | Get user's tickets            |
| `GET`  | `/api/user/tickets/{id}`            | Get ticket details            |
| `GET`  | `/api/user/payments`                | Get payment history           |
| `GET`  | `/api/user/payments/{id}`           | Get payment details           |
| `POST` | `/api/user/payments/{id}/confirm`   | Request WhatsApp confirmation |
| `GET`  | `/api/user/notifications`           | Get notifications             |
| `PUT`  | `/api/user/notifications/{id}/read` | Mark notification as read     |
| `POST` | `/api/reviews`                      | Submit review                 |
| `PUT`  | `/api/reviews/{id}`                 | Update review                 |
| `GET`  | `/api/reviews/ticket/{ticketId}`    | Get reviews for ticket        |

### UI/UX Design Guidelines

#### Color Palette

| Usage          | Light Mode              | Dark Mode               |
| -------------- | ----------------------- | ----------------------- |
| Primary        | `#6366F1` (Indigo 500)  | `#818CF8` (Indigo 400)  |
| Secondary      | `#10B981` (Emerald 500) | `#34D399` (Emerald 400) |
| Accent         | `#F59E0B` (Amber 500)   | `#FBBF24` (Amber 400)   |
| Background     | `#FFFFFF`               | `#0F172A` (Slate 900)   |
| Surface        | `#F8FAFC` (Slate 50)    | `#1E293B` (Slate 800)   |
| Text Primary   | `#1E293B` (Slate 800)   | `#F1F5F9` (Slate 100)   |
| Text Secondary | `#64748B` (Slate 500)   | `#94A3B8` (Slate 400)   |
| Success        | `#22C55E` (Green 500)   | `#4ADE80` (Green 400)   |
| Warning        | `#F59E0B` (Amber 500)   | `#FBBF24` (Amber 400)   |
| Error          | `#EF4444` (Red 500)     | `#F87171` (Red 400)     |

#### Typography

| Element | Font  | Size        | Weight |
| ------- | ----- | ----------- | ------ |
| H1      | Inter | 30px / 36px | 700    |
| H2      | Inter | 24px / 30px | 600    |
| H3      | Inter | 20px / 26px | 600    |
| Body    | Inter | 16px / 24px | 400    |
| Small   | Inter | 14px / 20px | 400    |
| Caption | Inter | 12px / 16px | 400    |

#### Responsive Breakpoints

| Breakpoint | Size           | Usage                           |
| ---------- | -------------- | ------------------------------- |
| Mobile     | < 640px        | Single column, bottom nav       |
| Tablet     | 640px - 1024px | 2 columns, side nav collapsible |
| Desktop    | > 1024px       | 3+ columns, full side nav       |

#### Key UI Components

1. **Glass Card Design** - Semi-transparent cards with backdrop blur
2. **Floating Action Buttons** - Quick actions on mobile
3. **Skeleton Loading** - Content placeholders during load
4. **Pull to Refresh** - Native mobile feel
5. **Smooth Transitions** - 200-300ms ease-out animations
6. **Toast Notifications** - Non-intrusive feedback
7. **Empty States** - Illustrated, helpful prompts

### Dependencies & Integrations

| Dependency                     | Purpose                                        | Notes                        |
| ------------------------------ | ---------------------------------------------- | ---------------------------- |
| Laravel Notifications          | Email & Database notifications                 | Built-in                     |
| WhatsApp Business API or wa.me | Payment confirmation                           | Consider Twilio/Official API |
| Barcode/QR Library             | php-barcode-generator or chillerlan/php-qrcode | Already used                 |
| Laravel Sanctum                | API Authentication                             | Recommended                  |
| Vite + TailwindCSS             | Frontend build                                 | Already configured           |
| Pusher/Soketi                  | Real-time notifications                        | Optional for MVP 2           |

---

## Open Questions

| ID    | Question                                                | Status | Owner    | Due Date     | Resolution           |
| ----- | ------------------------------------------------------- | ------ | -------- | ------------ | -------------------- |
| OQ-01 | Should email verification be required for registration? | Open   | Product  | Feb 10, 2026 | -                    |
| OQ-02 | What is the WhatsApp number for payment confirmations?  | Open   | Business | Feb 10, 2026 | -                    |
| OQ-03 | Should reviews require moderation before publishing?    | Open   | Product  | Feb 10, 2026 | Suggest: Yes         |
| OQ-04 | What is the maximum number of tickets per user?         | Open   | Business | Feb 10, 2026 | -                    |
| OQ-05 | Should we support multiple languages in MVP 1?          | Open   | Product  | Feb 10, 2026 | Suggest: No, Phase 3 |
| OQ-06 | Integration with existing payment gateway?              | Open   | Tech     | Feb 12, 2026 | -                    |
| OQ-07 | Should reviews show real user names or anonymize?       | Open   | Product  | Feb 10, 2026 | -                    |

---

## Notes & Considerations

### Business Considerations

1. **WhatsApp API Costs** - Consider using `wa.me` deep links for MVP (free) before investing in WhatsApp Business API
2. **Review Moderation** - Plan for moderation workflow to avoid inappropriate content
3. **Data Privacy** - Ensure user data handling complies with local regulations
4. **Support Integration** - Consider how user portal affects support ticket flow

### Technical Considerations

1. **Existing User Role** - Current roles are `admin`, `staff`, `volunteer`. Need to add `user` role for ticket holders
2. **Ticket Association** - Tickets currently have `user_email` but no `user_id`. Need migration to link tickets to user accounts
3. **Performance** - Implement caching for dashboard data and ticket lists
4. **Security** - Rate limiting on auth endpoints, CSRF protection, input validation
5. **Mobile First** - Design for mobile first, then scale up for tablet/desktop

### Migration Notes

1. **Existing Tickets** - Create script to match existing tickets (`user_email`) to user accounts
2. **User Creation** - When linking ticket, auto-create user account if not exists
3. **Data Integrity** - Maintain `user_email` field for tickets without associated accounts

---

## Appendix

### References

- [Laravel Notifications Documentation](https://laravel.com/docs/notifications)
- [WhatsApp Business API](https://developers.facebook.com/docs/whatsapp)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [Laravel Sanctum (API Auth)](https://laravel.com/docs/sanctum)

### Glossary

| Term                     | Definition                                                         |
| ------------------------ | ------------------------------------------------------------------ |
| **Ticket Holder**        | End user who has purchased/received a ticket                       |
| **Payment Confirmation** | Process of verifying a payment was made                            |
| **Review**               | User feedback consisting of star rating and text comment           |
| **Notification**         | System message delivered to user about ticket/payment/event status |
| **Barcode/QR**           | Scannable code on ticket for event entry validation                |
| **User Portal**          | Web interface accessible to ticket holders                         |

---

_End of Document_

**Document Version:** 1.0  
**Created:** February 8, 2026  
**Author:** AI Assistant (PRD Generator)
