# Product Brief: Event Ticketing System (Laravel)

## Project Overview

A web-based **event ticketing** platform built with PHP Laravel. The application provides three distinct interfaces: a **public event browsing** frontend, a **user portal** for ticket holders, and a **Filament-based admin panel** for organizers and staff. It includes QR/barcode-based ticket validation for on-site entry.

> **Note:** This is NOT a transportation ticketing system. It is purpose-built for events (concerts, conferences, festivals, etc.).

---

## 🎨 Design Requirements

### Frontend (Public & User Portal)

- **CSS Framework**: DaisyUI v5 (beta) on Tailwind CSS v4
- **Font**: Plus Jakarta Sans (via `@fontsource`), Spline Sans (user dashboard)
- **Icons**: Material Icons + Material Symbols Outlined + inline SVGs
- **Color Palette**:
    - Primary Red: `#e61f27` (public pages, event cards, CTAs)
    - Primary Black: `#101010` (text)
    - Primary White: `#ffffff` (backgrounds)
- **Design Principles**:
    - Mobile-first responsive design
    - DaisyUI light/dark theme support (auto via `prefers-color-scheme`)
    - Glassmorphism effects on admin/user portal (backdrop-blur, translucent cards)
    - Three distinct visual modes: public (red-primary), user portal (dark immersive slate), admin (indigo accent with glass cards)

### Admin Panel

- **Framework**: Filament v3.x
- **Theme**: Default Filament theme (configurable)
- **Features**: Native Filament resources, widgets, and pages

### User Portal

- **Layout**: Desktop sidebar + mobile bottom navigation bar
- **Theme**: Dark immersive (`bg-slate-900`) with glassmorphism
- **Alpine.js**: Used for interactive components (toast notifications, scan mode switcher)

---

## 🔧 Technical Stack

### Implemented Technologies

- **Backend Framework**: Laravel 12.x
- **PHP Version**: 8.2+
- **Frontend**: DaisyUI v5.5.1-beta.2 + Tailwind CSS v4
- **Build Tool**: Vite 7 with `laravel-vite-plugin` v2 and `@tailwindcss/vite`
- **Admin Panel**: Filament v3 (Livewire/Blade)
- **Database**: SQLite (dev) / MySQL 8.0+ / PostgreSQL 13+ (production)
- **Package Manager**: Composer (backend), NPM (frontend)

### Key Dependencies

| Package                          | Purpose                        |
| -------------------------------- | ------------------------------ |
| `barryvdh/laravel-dompdf`        | PDF ticket generation & export |
| `simplesoftwareio/simple-qrcode` | QR code generation for tickets |
| `milon/barcode`                  | Code128 barcode generation     |
| `@tailwindcss/forms`             | Form element styling           |
| `@tailwindcss/typography`        | Prose content styling          |
| `@tailwindcss/container-queries` | Container query utilities      |
| `daisyui` v5 beta                | UI component library           |
| `material-icons`                 | Icon font                      |
| `pestphp/pest`                   | Testing framework              |

### What is NOT Used (contrary to original brief)

- **Filament Laravel** → Used for Admin Panel (v3.x)
- ~~Laravel Breeze / Jetstream~~ → Custom AuthController
- ~~Laravel Sanctum~~ → No API authentication
- ~~Stripe / Xendit / Midtrans~~ → No payment gateway (immediate confirmation MVP)
- ~~Redis / Memcached~~ → No caching layer configured
- ~~WebSockets~~ → No real-time features

---

## 👤 User Roles & Access

| Role        | Access Level                                                        |
| ----------- | ------------------------------------------------------------------- |
| `admin`     | Full access: all CRUD, user management, system config               |
| `staff`     | Admin panel access: ticket/event management, history, scan/validate |
| `volunteer` | Scan/validate tickets only                                          |
| `user`      | Public browsing, checkout, user portal (tickets, payments, profile) |

Role enforcement is via custom `RoleMiddleware` supporting comma-separated roles and negation (`!`).

---

## 👤 Customer-Facing Features (Implemented)

### 1. Authentication System

- **User Registration**: Email + password, auto-login after registration, rate-limited (3/min)
- **User Login**: Email + password, role-based redirect after login, rate-limited (5/min)
- **Password Reset**: Forgot password flow via email token
- **Logout**: Session invalidation + regeneration
- **Activity Logging**: Login, logout, and failed login attempts are auto-logged with IP/user-agent

> **Not implemented**: Social auth (Google/Facebook), email verification enforcement, "Remember me", phone verification

### 2. Event Discovery

- **Public Event Listing**: Paginated grid (9 per page) of published events
- **Event Detail Page**: Full event info with venue, organizer, available ticket types
- **Visibility Control**: Only `published` events shown publicly; admin/staff can preview unpublished

> **Not implemented**: Search/filter by category, date, price range, location. No autocomplete. No sorting options.

### 3. Checkout / Ticket Purchase

- **Ticket Type Selection**: Choose from available ticket types (e.g., VIP, Standard, GA)
- **Quantity Selection**: Purchase 1–10 tickets per transaction
- **Pessimistic Locking**: `lockForUpdate()` prevents overselling during concurrent purchases
- **Immediate Confirmation**: Tickets issued with `status=issued`, `payment_status=confirmed` (no actual payment gateway)
- **Success Page**: Displays purchased ticket details with UUID

> **Not implemented**: Step-by-step wizard, seat selection during checkout, promo codes, payment gateway, booking expiration timer

### 4. User Portal (Dashboard)

- **Dashboard Stats**: Active ticket count, pending payments, total loyalty points
- **My Tickets**: List with upcoming/past tabs (filtered by event start time), paginated (12)
- **Ticket Detail**: View ticket info with QR code + barcode
- **My Payments**: Payment list (paginated 10) + detail view
- **Profile Management**: Edit name, email, phone, avatar (1MB max). Password change with current password verification.
- **Testimonials**: Submit rating (1–5) + comment for past events. Awards 10 loyalty points. One review per event per user.
- **Wishlist**: View favorite events (managed via `FavoriteController`).
- **Activity History**: View own activity logs with filters (action type, date range), paginated (25)

> **Not implemented**: E-ticket PDF download from user side, booking cancellation, saved passengers, notification preferences, payment method management

### 5. Ticket Scanning & Validation

- **QR/Barcode Scanner**: Camera-based scanning UI (Alpine.js) for on-site entry validation
- **Manual Entry**: Barcode code or UUID text input
- **Validation Logic**: Checks ticket exists → checks not already scanned → marks as scanned with timestamp
- **Duplicate Detection**: Already-scanned tickets return `duplicate` status
- **Validated Tickets List**: View all scanned tickets, paginated (20)
- **Access**: Admin, staff, and volunteer roles

---

## 🛠️ Admin Panel Features (Filament)

Powered by **Filament v3**, providing a robust CRUD interface for:

### 1. Core Resources

- **Events**: Full management (title, slug, venue, dates, images, ticket types).
- **Tickets**: Management of issued tickets, PDF generation, and scanning status.
- **Users**: Management of Admin, Staff, Volunteer, and Customer accounts.
- **Venues & Organizers**: Master data management.

### 2. Dashboard

- **Widgets**: Key metrics (Total Tickets, Sales, Validation Count).
- **Charts**: Visual data representation.

### 3. Access Control

- **Policies**: Filament policies enforce role-based access (Admin/Staff).

---

## 📊 Database Schema (Actual)

### Core Tables (11)

| Table             | Key Columns                                                                                                 | Purpose                                         |
| ----------------- | ----------------------------------------------------------------------------------------------------------- | ----------------------------------------------- |
| `users`           | name, email, password, role, phone, avatar, email_verified_at                                               | All user accounts (admin/staff/volunteer/user)  |
| `events`          | name, slug, description, start_time, end_time, status, venue_id, organizer_id, image                        | Event definitions                               |
| `venues`          | name, description, address, city, state, country, postal_code, capacity                                     | Event locations                                 |
| `seats`           | venue_id, section, row, number, type, status                                                                | Individual seats within venues                  |
| `organizers`      | user_id, name, email, phone, website, description                                                           | Event organizer profiles                        |
| `ticket_types`    | event_id, name, description, price, quantity, sold, sale_start_date, sale_end_date                          | Ticket pricing tiers per event                  |
| `tickets`         | uuid, secure_token, user_id, event_id, ticket_type_id, seat_id, barcode, status, payment_status, scanned_at | Individual issued tickets                       |
| `payments`        | user_id, amount, status, payment_method, transaction_id                                                     | Payment records                                 |
| `payment_tickets` | payment_id, ticket_id                                                                                       | Many-to-many pivot                              |
| `testimonials`    | user_id, event_id, ticket_id, rating, comment                                                               | User reviews for past events                    |
| `loyalty_points`  | user_id, points, source, description                                                                        | Points earned from actions (e.g., testimonials) |
| `activity_logs`   | user_id, action, resource_type, resource_id, metadata, description, ip_address, user_agent                  | Polymorphic audit trail                         |

### Key Relationships

- **One-to-Many**: Venue → Events, Event → TicketTypes, Event → Tickets, User → Tickets, User → Payments
- **Many-to-Many**: Payment ↔ Ticket (via `payment_tickets`)
- **Belongs-To**: Ticket → TicketType, Ticket → Event, Ticket → User, Ticket → Seat, Event → Venue, Event → Organizer, Organizer → User
- **Polymorphic**: ActivityLog → any model (via `resource_type`/`resource_id`)
- **Has-Many**: User → Testimonials, User → LoyaltyPoints, User → ActivityLogs

### Legacy Fields on Tickets

The `tickets` table retains `user_name`, `user_email`, `seat_number`, `type` as legacy columns for backward compatibility. Normalized versions use `user_id`, `seat_id`, and `ticket_type_id` foreign keys.

---

## 🔒 Security (Implemented)

1. **Authentication & Authorization**:
    - Custom authentication controller with rate limiting (IP-based)
    - CSRF protection on all forms (Blade `@csrf` directives)
    - Role-based middleware (`RoleMiddleware`) with multi-role and negation support
    - Policy-based authorization (`TicketPolicy`, `PaymentPolicy`, `TicketTypePolicy`)

2. **Data Protection**:
    - Eloquent ORM (SQL injection prevention)
    - Blade templating (XSS protection via `{{ }}` escaping)
    - Input validation on all forms (Form Requests + inline validation)
    - Password hashing (bcrypt via Laravel)
    - Session invalidation on logout

3. **Ticket Security**:
    - UUID-based ticket identification
    - `secure_token` for additional verification
    - CRC32-based deterministic barcode generation
    - Pessimistic locking during checkout to prevent race conditions

> **Not implemented**: HTTPS enforcement config, encryption at rest for PII, JWT/API tokens, PCI DSS compliance, payment tokenization

---

## ⚡ Architecture & Patterns

### Backend

- **Admin**: Filament v3 (Resources, Pages, Widgets) in `app/Filament/`.
- **Public/User**: `@extends`/`@section`/`@yield` Blade inheritance.
- **Activity Logging**: `LogsActivity` trait auto-logs Eloquent create/update/delete events; `ActivityLogger` service for manual logging.
- **Services**: `BarcodeService` (QR + Code128), `ActivityLogger`.
- **Validation**: Form Request classes and Filament validations.
- **PDF Generation**: DomPDF for ticket export.

### Frontend

- **Build**: Vite 7 with Tailwind CSS v4 + DaisyUI v5
- **JS**: Alpine.js (CDN, user portal), vanilla JS (admin theme switcher, sidebar)
- **CSS**: Single entry point (`resources/css/app.css`) with Tailwind v4 config
- **Interactivity**: Camera-based barcode scanning, form validation, toast notifications

### View Structure

```
resources/views/
├── layouts/           (app, admin, public)
├── auth/              (login, register, forgot/reset password)
├── events/            (index, show)
├── checkout/          (success)
├── scan.blade.php     (barcode scanner)
├── result.blade.php   (scan result)
├── user/
│   ├── layouts/       (app)
│   └── components/    (toast)
│   ├── dashboard, profile/, tickets/, payments/
├── admin/             (Legacy/Custom views if any - mostly Filament now)
│   └── events/        (Custom pages if not using Resources)
├── my/history/        (user's own activity log)
└── tickets/validated  (scanned tickets list)
```

---

## 📱 Responsive Design

- **Public layout**: DaisyUI drawer for mobile navigation
- **Admin layout**: Collapsible sidebar for mobile/tablet
- **User portal**: Desktop sidebar + dedicated mobile bottom navigation bar
- **Breakpoints**: Tailwind CSS v4 defaults (sm: 640px, md: 768px, lg: 1024px, xl: 1280px, 2xl: 1536px)

---

## 🧪 Testing (Current State)

### Framework

- **Pest PHP** (v3.8) on PHPUnit
- `RefreshDatabase` trait per test class

### Test Coverage (21 tests)

| Test File                           | Tests | Coverage                                                                     |
| ----------------------------------- | ----- | ---------------------------------------------------------------------------- |
| `Feature/EventDiscoveryTest`        | 3     | Published event listing, detail, unpublished 404                             |
| `Feature/CheckoutTest`              | 3     | Guest blocked, user purchase + DB verification, sold-out prevention          |
| `Feature/TicketPriceManagementTest` | 7     | Admin CRUD for ticket types, validation, delete-with-sales guard, role auth  |
| `Feature/MasterDataTest`            | 3     | Event-venue-organizer relations, availability logic, secure_token uniqueness |
| `Feature/UserPortalTest`            | 3     | Dashboard access, view own tickets, 403 on other's tickets                   |
| `Feature/ExampleTest`               | 1     | Homepage returns 200                                                         |
| `Unit/ExampleTest`                  | 1     | Boilerplate assertion                                                        |

### Untested Areas (~80% of features)

- Authentication flow (login, register, password reset)
- All admin CRUD controllers (events, venues, seats, organizers, users, tickets)
- Admin dashboard
- Barcode scanning & validation
- User payments, testimonials, profile management
- Activity history & CSV export
- Services (`BarcodeService`, `ActivityLogger`)
- Policies (`PaymentPolicy`, `TicketPolicy`, `TicketTypePolicy`)
- `RoleMiddleware` (only minimally tested via ticket type auth)

---

## 📦 Seeders

| Seeder              | Creates                                                                                                                                                 |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `DatabaseSeeder`    | Admin user (`admin@admin.com`, password: `password`) + 10 random tickets with full factory chain                                                        |
| `SampleEventSeeder` | "Grand Hall" venue (NY, 100 capacity), "Tech Conference 2026" event, VIP ($500, qty 20) & Standard ($150, qty 80) ticket types, 100 seats (5 rows × 20) |

---

## 🚀 Future Enhancements (Not Yet Implemented)

### High Priority

- Payment gateway integration (Stripe/Midtrans/Xendit)
- Event search, filtering, and sorting
- Email notifications (booking confirmation, reminders)
- E-ticket PDF download from user portal
- Booking cancellation and refund flow
- Seat selection during checkout

### Medium Priority

- Promo codes and discount system
- Admin dashboard charts and analytics
- Bulk ticket import (CSV/Excel)
- Admin reporting with export (PDF/Excel)
- System configuration panel
- Email verification enforcement

### Low Priority / Optional

- Social authentication (Google, Facebook)
- Multi-language support (i18n)
- Multi-currency support
- Real-time seat availability (WebSocket)
- Customer support / chat system
- Mobile application (React Native/Flutter)
- Loyalty program expansion
- Group booking discounts
- Travel/event insurance integration
- API layer with Sanctum/JWT

---

## 📋 Development Notes

- Uses PSR-4 autoloading
- Eloquent ORM for all database operations
- Blade templating with `@extends`/`@section` pattern (no Blade x-components for layouts)
- Form Request validation for ticket type CRUD; inline validation elsewhere
- `composer dev` script runs server + queue + Vite concurrently
- `composer setup` script handles full installation
- Factory chain: Ticket → TicketType → Event → Venue + Organizer
- No soft deletes on any model
- Event slug auto-generation with collision handling in model `booted()` method

---

## 🎯 Current Project Status

### Fully Functional

- Authentication (login, register, password reset, logout)
- Public event browsing and detail pages
- Ticket checkout with oversell protection
- User portal (dashboard, tickets, payments, profile, testimonials)
- Admin panel (events, venues, seats, organizers, ticket types, tickets, users, history)
- QR/barcode ticket scanning and validation
- PDF ticket export
- Comprehensive activity audit logging
- Loyalty points (via testimonials)
- Role-based access control (4 roles)

### MVP Limitations

- No real payment processing (immediate confirmation)
- No search/filter/sort on event listing
- No email notifications sent
- Limited test coverage (~20%)
- No API layer
- `user/dashboard.blade.php` is standalone (doesn't extend user layout — inconsistency)
