<!-- PROMPTER:START -->

# Prompter Instructions

These instructions are for AI assistants working in this project.

Always open `@/prompter/AGENTS.md` when the request:

- Mentions planning or proposals (words like proposal, spec, change, plan)
- Introduces new capabilities, breaking changes, architecture shifts, or big performance/security work
- Sounds ambiguous and you need the authoritative spec before coding

Use `@/prompter/AGENTS.md` to learn:

- How to create and apply change proposals
- Spec format and conventions
- Project structure and guidelines
- Show Remaining Tasks

<!-- PROMPTER:END -->

# AGENTS — Project Knowledge Base

## 1. 📍 Project Summary

**Project Name:** Ticketing Laravel
**Type:** Web-based Event Ticketing Platform
**Overview:** A comprehensive event ticketing solution built with Laravel 12. It features a public-facing event discovery portal, a secure user dashboard for ticket management, and a robust admin panel for organizers (powered by Filament). The system handles ticket issuance, PDF generation, and on-site entry validation via QR/Barcode scanning.
**Key differentiators:** Filament-based Admin Panel, distinct UI themes per role, and a focus on event-specific workflows (not transport).

## 2. 🧱 Tech Stack

- **Framework:** Laravel 12.x (PHP 8.2+)
- **Frontend Stack:**
    - **CSS:** Tailwind CSS v4
    - **UI Library:** DaisyUI v5.5 (Beta)
    - **Templating:** Blade Templates
    - **Scripting:** Alpine.js (for interactivity like toasts/modals)
    - **Build Tool:** Vite 7 (with `@tailwindcss/vite`)
- **Admin Panel:**
    - **Filament:** v3.x (Panels, Resources, Widgets)
- **Database:**
    - **Dev:** SQLite
    - **Prod:** MySQL 8.0+ / PostgreSQL 13+
- **Key Packages:**
    - `barryvdh/laravel-dompdf`: PDF ticket generation
    - `simplesoftwareio/simple-qrcode`: QR Code generation
    - `milon/barcode`: Barcode generation (Code128)
    - `pestphp/pest`: Testing framework
- **Server:** Apache/Nginx (via Laragon in dev)

## 3. 🏗️ Architecture Overview

- **Pattern:** MVC (Model-View-Controller) Monolith
- **Routing:** Standard Laravel `web.php` routes.
    - **Public:** Event browsing, details.
    - **Auth:** Custom AuthController (Login/Register/Reset).
    - **Protected:** Middleware-guarded routes for User Portal.
    - **Admin:** Filament-managed routes (`/admin`).
- **Middleware:** `RoleMiddleware` enforces access control (Admin/Staff/Volunteer/User).
- **Service Layer:** Logic separated into Services (e.g., `BarcodeService`) where appropriate, though simple logic remains in Controllers.

## 4. 📁 Folder Structure & Important Files

- `app/Http/Controllers/`:
    - `AuthController.php`: Custom authentication logic.
    - `CheckoutController.php`: Ticket purchase transaction logic.
    - `EventController.php`: Public event listing/display.
    - `TicketController.php`: User ticket management & Scanning.
    - `FavoriteController.php`: Wishlist management.
- `app/Filament/`:
    - `Resources/`: Admin resources (Events, Tickets, Users, etc.).
    - `Pages/`: Custom admin pages.
- `app/Models/`: Eloquent models (User, Event, Ticket, TicketType, etc.).
- `app/Http/Middleware/`:
    - `RoleMiddleware.php`: Role-based access control.
- `database/migrations/`: Database schema definitions.
- `resources/views/`:
    - `layouts/`: Master layouts (guest, app).
    - `events/`: Public event pages.
    - `user/`: User portal views.
    - `auth/`: Login/Register views.
- `routes/web.php`: Central routing definition.

## 5. 🔑 Core Business Logic & Domain Rules

- **Ticket Purchase:**
    - Transactions are atomic.
    - Inventory is locked (`lockForUpdate`) during checkout.
    - Tickets are generated with a unique UUID on purchase.
    - **Pricing:** Dynamic ticket pricing supported (e.g. Early Bird, VIP).
    - **Currency:** IDR (Indonesian Rupiah).
- **Access Control:**
    - **Admin:** Full system access (Filament Panel).
    - **Staff:** Manage events/tickets, view history.
    - **Volunteer:** Scan tickets only.
    - **User:** Browse events, buy tickets, view history, wishlist events.
- **Ticket Validation:**
    - **Methods:** QR Scan (Auto) or Manual Input (Ticket ID).
    - **Status:** Tickets move from `pending` -> `scanned`.
    - **Validation:** Records timestamp and validator ID.
- **Rate Limiting:**
    - Login: 5 attempts/min.
    - Registration: 3 attempts/min.

## 6. 🗂️ Data Models / Entities

- **User**: Authentication entity + `role` (admin/staff/volunteer/user).
- **Event**: Core entity. Has `slug`, `title`, `venue`, `dates`, `status`, `banner`, `latitude`, `longitude`.
- **TicketType**: Defines pricing and inventory for an Event.
- **Ticket**: The issued credential. Belongs to Event, User, and TicketType. Has `uuid`, `status`, `scanned_at`, `secure_token`.
- **Payment**: Records transaction details.
- **Organizer**: Entity managing events.
- **Venue**: Location data for events.
- **Seat**: Seat management for events with seating charts.
- **Testimonial**: User reviews/ratings for events.
- **LoyaltyPoint**: Gamification system for users.
- **ActivityLog**: Audit trail.

## 7. 🧠 Domain Vocabulary / Glossary

- **Scan/Redeem:** The act of validating a ticket at the venue entrance.
- **Portal:** The specific interface for authenticated ticket holders (`/user/dashboard`).
- **Filament:** The Admin Panel framework used for backend management.
- **Wishlist:** User's list of favorite events.

## 8. 👥 Target Users & Personas

- **Event Organizer (Admin):** Uses the Filament Admin Panel for full control.
- **Staff member:** Helps manage day-to-day operations.
- **Gate Volunteer:** Uses mobile-friendly Scan interface.
- **Attendee (User):** Uses Public Portal for discovery and `User Dashboard` for ticket management.

## 9. ✨ UI/UX Principles

- **Distinct Visual Modes:**
    - **Public:** Red Primary (`#e61f27`), Clean White backgrounds.
    - **User Portal:** Immersive Dark (`bg-slate-900`) with glassmorphism key elements.
    - **Admin:** Filament Default (configurable).
- **Mobile First:** Optimized for Phones (Checkout, Scanning).
- **Interactive Elements:**
    - Dynamic Event Banners.
    - Interactive Maps (Leaflet/Google Maps integration).
    - Toast notifications.
- **Font:** Plus Jakarta Sans (General), Spline Sans (Dashboards).

## 10. 🔒 Security / Privacy Rules

- **Authorization:** Strict middleware checks + Filament Policies.
- **Data Isolation:** Users can strictly only view their own tickets/orders.
- **Validation:** Server-side validation for all inputs.
- **Audit:** Sensitive actions logged to `activity_logs`.

## 11. 🤖 Coding Conventions & Standards

- **Style:** Follow PSR-12 and Laravel best practices.
- **Testing:** Use **Pest** for Feature and Unit tests.
- **Typing:** Strict typing in PHP method signatures.
- **Views:** Tailwind utility classes, Blade Components.
- **Admin:** Use Filament Resources for CRUD operations instead of custom controllers where possible.

## 12. 🧩 Development Rules for AI Agents

- **No inventions:** Do not create new models, tables, or public-facing API endpoints without explicit instruction.
- **Consistency:** Match the existing Glassmorphism/DaisyUI styling in views.
- **Safety:** Verify middleware protection.
- **Database:** Check migrations.
- **Process:**
    1.  Analyze request.
    2.  Check for Filament Resource vs Custom Controller suitability.
    3.  Implement changes.
    4.  Verify with Pest test.
- **Output:** Use `replace_string_in_file` with sufficient context.

## 13. 🗺️ Integration Map

- **Internal:**
    - `dompdf` -> TicketController (PDF Generation)
    - `simple-qrcode` -> Ticket View (QR Display)
    - `Filament` -> Admin Panel
- **External:**
    - None currently.

## 14. 🗺️ Roadmap & Future Plans

- **Social Auth:** Add Google/Facebook login.
- **Real Payments:** Integrate Stripe or local gateways.
- **Email Verification:** Enforce email confirmation.
- **Live Updates:** WebSockets.

## 15. ⚠️ Known Issues / Limitations

- **Payments:** Checkout is immediate and free (Simulator mode).
- **Concurrency:** Basic row locking implemented.
- **Filament:** Some custom admin routes might be deprecated in favor of Filament resources.
- **CORS:** Potential issues with external image resources (check `cors.php`).

## 16. 🧪 Testing Strategy

- **Framework:** Pest PHP.
- **Scope:**
    - **Unit:** Models and independent Services.
    - **Feature:** Application flows (Registration -> Checkout -> Ticket View).
- **Command:** `php artisan test`

## 17. 🧯 Troubleshooting Guide

- **Clear Cache:** `php artisan optimize:clear`
- **Rebuild Assets:** `npm run build`
- **Link Storage:** `php artisan storage:link` (Critical for QR/PDF generation).
- **Database Reset:** `php artisan migrate:fresh --seed`

## 18. 📞 Ownership / Responsibility Map

- **Product Owner:** (User)
- **Tech Lead:** (AI Agent / Copilot)
