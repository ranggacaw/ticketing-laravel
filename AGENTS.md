# AGENTS — Project Knowledge Base

## 1. 📍 Project Summary
**Project Name:** Ticketing Laravel
**Type:** Web-based Event Ticketing Platform
**Overview:** A comprehensive event ticketing solution built with Laravel 12. It features a public-facing event discovery portal, a secure user dashboard for ticket management, and a robust admin panel for organizers. The system handles ticket issuance, PDF generation, and on-site entry validation via QR/Barcode scanning.
**Key differentiators:** Custom admin panel (no Filament), distinct UI themes per role, and a focus on event-specific workflows (not transport).

## 2. 🧱 Tech Stack
- **Framework:** Laravel 12.x (PHP 8.2+)
- **Frontend Stack:**
  - **CSS:** Tailwind CSS v4
  - **UI Library:** DaisyUI v5.5 (Beta)
  - **Templating:** Blade Templates
  - **Scripting:** Alpine.js (for interactivity like toasts/modals)
  - **Build Tool:** Vite 7 (with `@tailwindcss/vite`)
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
  - **Protected:** Middleware-guarded routes for User Portal and Admin Panel.
- **Middleware:** `RoleMiddleware` enforces access control (Admin/Staff/Volunteer/User).
- **Service Layer:** Logic separated into Services (e.g., `BarcodeService`) where appropriate, though simple logic remains in Controllers.

## 4. 📁 Folder Structure & Important Files
- `app/Http/Controllers/`:
  - `AuthController.php`: Custom authentication logic.
  - `CheckoutController.php`: Ticket purchase transaction logic.
  - `EventController.php`: Public event listing/display.
  - `TicketController.php`: User ticket management.
- `app/Models/`: Eloquent models (User, Event, Ticket, TicketType, etc.).
- `app/Http/Middleware/`:
  - `RoleMiddleware.php`: Role-based access control.
- `database/migrations/`: Database schema definitions.
- `resources/views/`:
  - `layouts/`: Master layouts (guest, app, admin).
  - `events/`: Public event pages.
  - `admin/`: Admin dashboard views.
  - `user/`: User portal views.
- `routes/web.php`: Central routing definition.

## 5. 🔑 Core Business Logic & Domain Rules
- **Ticket Purchase:**
  - Transactions are atomic.
  - Inventory is locked (`lockForUpdate`) during checkout to prevent overselling.
  - **MVP State:** Payments are assumed successful immediately (no gateway integration).
  - Tickets are generated with a unique UUID on purchase.
- **Access Control:**
  - **Admin:** Full system access.
  - **Staff:** Manage events/tickets, view history.
  - **Volunteer:** Scan tickets only.
  - **User:** Browse events, buy tickets, view their own history.
- **Ticket Validation:**
  - Tickets can be scanned (QR) or manually validated.
  - A ticket can only be "Checked In" once.
  - Validation records the timestamp and validator ID.
- **Rate Limiting:**
  - Login: 5 attempts/min.
  - Registration: 3 attempts/min.

## 6. 🗂️ Data Models / Entities
- **User**: Authentication entity + `role` (admin/staff/volunteer/user).
- **Event**: Core entity. Has `slug`, `title`, `venue`, `dates`, `status` (published/draft).
- **TicketType**: Defines pricing and inventory (e.g., "VIP", "General Admission") for an Event.
- **Ticket**: The issued credential. Belongs to Event, User, and TicketType. Has `uuid`, `status` (issued/scanned), `scanned_at`.
- **Payment**: Records transaction details (linked to User/Tickets).
- **Organizer**: Entity managing events.
- **Venue**: Location data for events.
- **ActivityLog**: Audit trail for system actions.

## 7. 🧠 Domain Vocabulary / Glossary
- **Scan/Redeem:** The act of validating a ticket at the venue entrance.
- **Issue:** Generating a valid ticket record and associated unique identifier (UUID/QR).
- **Portal:** The specific interface for authenticated ticket holders (`/dashboard`).
- **Slug:** URL-friendly string used for Event identification.

## 8. 👥 Target Users & Personas
- **Event Organizer (Admin):** Needs data visibility, configuration power, and sales tracking. Uses the "Indigo" theme interface.
- **Staff member:** Helps manage day-to-day operations.
- **Gate Volunteer:** Needs a simple, fast, mobile-friendly interface for scanning tickets.
- **Attendee (User):** Needs easy discovery, fast checkout, and quick access to tickets on mobile devices. Uses "Red/Black" (Public) or "Dark Mode" (Portal) themes.

## 9. ✨ UI/UX Principles
- **Distinct Visual Modes:**
  - **Public:** Red Primary (`#e61f27`), Clean White backgrounds.
  - **User Portal:** Immersive Dark (`bg-slate-900`) with glassmorphism key elements.
  - **Admin:** Professional Indigo, Glass cards `backdrop-blur-xl`.
- **Mobile First:** All layouts (especially Checkout and Scanning) must work perfectly on phones.
- **Feedback:** Use Toast notifications (Alpine.js) for actions like "Ticket Added" or "Scan Successful".
- **Font:** Plus Jakarta Sans (General), Spline Sans (Dashboards).

## 10. 🔒 Security / Privacy Rules
- **Authorization:** strict middleware checks on all non-public routes.
- **Data Isolation:** Users can strictly only view their own tickets/orders.
- **Validation:** Server-side validation for all inputs (especially quantity and ticket types).
- **Audit:** Sensitive actions (logins, failures) are logged to `activity_logs`.

## 11. 🤖 Coding Conventions & Standards
- **Style:** Follow PSR-12 and Laravel best practices.
- **Testing:** Use **Pest** for Feature and Unit tests.
- **Typing:** Use strict typing in PHP method signatures where possible.
- **Views:** specific `@section` usage (`content`, `scripts`, `styles`). avoid inline CSS; use Tailwind utility classes.
- **Controllers:** Keep thin; delegate complex logic to Services or Models (e.g. `Ticket::issue(...)`).

## 12. 🧩 Development Rules for AI Agents
- **No inventions:** Do not create new models, tables, or public-facing API endpoints without explicit instruction.
- **Consistency:** Match the existing Glassmorphism/DaisyUI styling in views.
- **Safety:** Always verify middleware protection when creating new controllers/routes.
- **Database:** If modifying DB, verify migrations do not conflict (check timestamps).
- **Process:**
  1.  Analyze the request.
  2.  Check existing Routes/Controllers.
  3.  Implement changes.
  4.  Verify with a matching Pest test if logic is complex.
- **Output:** When editing, use `replace_string_in_file` with sufficient context.

## 13. 🗺️ Integration Map
- **Internal:**
  - `dompdf` -> TicketController (PDF Generation)
  - `simple-qrcode` -> Ticket View (QR Display)
- **External:**
  - None currently (Payment Gateway is mocked internally).

## 14. 🗺️ Roadmap & Future Plans
- **Social Auth:** Add Google/Facebook login.
- **Real Payments:** Integrate Stripe or local gateways.
- **Email Verification:** Enforce email confirmation.
- **Live Updates:** WebSockets for real-time inventory decrement.

## 15. ⚠️ Known Issues / Limitations
- **Payments:** Checkout is immediate and free (Simulator mode).
- **Concurrency:** Basic row locking is implemented but untested under high load.
- **Caching:** No Redis configured; strictly database driver for cache/sessions.

## 16. 🧪 Testing Strategy
- **Framework:** Pest PHP.
- **Scope:**
  - **Unit:** Models and independent Services.
  - **Feature:** Application flows (Registration -> Checkout -> Ticket View).
- **Command:** `php artisan test`

## 17. 🧯 Troubleshooting Guide
- **Clear Cache:** `php artisan optimize:clear`
- **Rebuild Assets:** `npm run build`
- **Link Storage:** `php artisan storage:link` (Critical for QR/PDF generation if stored).
- **Database Reset:** `php artisan migrate:fresh --seed`

## 18. 📞 Ownership / Responsibility Map
- **Product Owner:** (User)
- **Tech Lead:** (AI Agent / Copilot)
