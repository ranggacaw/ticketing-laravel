# Technical Design Document

**Project:** Event Ticketing System (Laravel)
**Version:** 1.0
**Date:** 2026-02-19
**Author:** Solutions Architect (AI)
**Status:** Draft

---

## 1. Executive Summary

The Event Ticketing System is a comprehensive, web-based platform designed to facilitate the creation, management, and attendance of events. Unlike generic transportation ticketing, this solution is tailored for concerts, conferences, and festivals. It provides three distinct user interfaces: a public portal for event discovery and ticket purchase, a secure user dashboard for attendees to manage their bookings, and a robust admin panel for organizers to oversee events, sales, and validation.

Key technical decisions include the use of a Monolithic architecture based on Laravel 12, ensuring rapid development and strong type safety. The frontend leverages Tailwind CSS v4 and DaisyUI v5 for a modern, responsive implementation without the complexity of a decoupled SPA. Ticket validation is handled via a hybrid approach supporting both camera-based QR scanning (using Alpine.js) and manual entry, optimized for mobile devices.

The technology stack is centered on the TALL stack ecosystem (Tailwind, Alpine.js, Laravel, Livewire-adjacent native Blade), backed by SQLite for development and MySQL/PostgreSQL for production. This architecture prioritizes maintainability, SEO (via server-side rendering), and security.

## 2. System Architecture

### 2.1 Architecture Overview

The system follows a classic **Model-View-Controller (MVC) Monolithic Architecture**.

- **Presentation Layer:** Blade templates rendered on the server, enriched with Alpine.js for client-side interactivity (modals, toasts, scanner).
- **Business Logic Layer:** Encapsulated in Controllers, Services (e.g., `BarcodeService`, `ActivityLogger`), and Models.
- **Data Access Layer:** Eloquent ORM interacting with the relational database.

**Justification:** A monolith is chosen to reduce operational complexity, strictly enforce type safety across layers, and leverage Laravel's robust ecosystem (Auth, Validation, Eloquent) without the overhead of API serialization/deserialization.

### 2.2 Component Architecture

| Component             | Responsibility                              | Technology                  | Dependencies                      |
| --------------------- | ------------------------------------------- | --------------------------- | --------------------------------- |
| **Public Frontend**   | Event listing, details, and checkout flows  | Blade, Tailwind v4, DaisyUI | EventController, TicketController |
| **User Portal**       | Ticket management, profile, payment history | Blade, Alpine.js            | AuthController, TicketController  |
| **Admin Panel**       | Platform management (CRUD), sales reporting | **Filament v3**             | Filament Resources, Widgets       |
| **Scanner Interface** | Ticket validation (QR/Barcode)              | Alpine.js, HTML5 Camera API | BarcodeService                    |
| **PDF Generator**     | Generating downloadable ticket assets       | DomPDF                      | View Factory                      |

### 2.3 Deployment Architecture

- **Environment:**
    - **Dev:** Local (Laragon), SQLite.
    - **Production:** Dockerized or generic LEMP/LAMP stack.
- **Infrastructure:**
    - Web Server: Nginx/Apache.
    - PHP Runtime: PHP 8.2+.
    - Database: MySQL 8.0+ or PostgreSQL 13+.
- **CI/CD:** GitHub Actions (recommended) running `pest` tests and static analysis.

## 3. Data Architecture

### 3.1 Data Model

The data model focuses on the relationship between Events, Tickets, and Users.

**Key Entities:**

- **User:** Access management (Admin, Staff, Volunteer, User).
- **Event:** The core product, loosely coupled to Venues and Organizers.
- **Ticket:** The unit of value, uniquely identified by UUID and secured with a token.
- **TicketType:** Inventory and pricing definitions.

### 3.2 Database Design

**Technology:** MySQL 8.0+ / PostgreSQL 13+ (Production).

**Schema Design Decisions:**

- **UUIDs:** Used for `tickets.uuid` to prevent ID enumeration attacks.
- **Polymorphism:** `activity_logs` uses polymorphic relations (`resource_type`, `resource_id`) to track changes across any model.
- **Locking:** Pessimistic locking (`lockForUpdate`) is used on `ticket_types` during checkout to ensure inventory integrity.

**Indexing Strategy:**

- `tickets(uuid)`: Unique index for fast lookups during scanning.
- `tickets(secure_token)`: Search index for validation.
- `events(slug)`: Unique index for SEO-friendly routing.
- `users(email)`: Unique index for authentication.

### 3.3 Data Flow

1.  **Creation:** Admin creates Event -> TicketTypes -> Inventory.
2.  **Purchase:** User selects TicketType -> System Locks Row -> Decrements Inventory -> Creates Ticket (Status: `issued/pending`).
3.  **Validation:** Volunteer Scans QR -> System Decodes UUID -> Verifies Status -> Updates Status to `scanned` -> Logs Activity.

## 4. API Design (Internal Web Routes)

_Note: The system predominantly uses Web Routes (`web.php`). A REST API is currently out of scope._

### 4.1 Route Architecture

- **Public:** `GET /events`, `GET /events/{slug}`
- **Protected (User):** `GET /user/dashboard`, `POST /checkout`
- **Protected (Admin):** `GET/POST /admin/*`

### 4.2 Key Endpoint Specifications

_Described as Controller Actions corresponding to Routes._

**POST /checkout**

- **Purpose:** Process ticket purchase.
- **Authentication:** Required (User).
- **Request:**
    ```json
    {
        "ticket_type_id": "integer",
        "quantity": "integer (1-10)"
    }
    ```
- **Business Rules:**
    - Validates `quantity` <= `ticket_type.remaining_quantity`.
    - Uses DB Transaction with `lockForUpdate`.
    - Creates `Payment` (Confirmed) and `Ticket` records.

**POST /tickets/validate**

- **Purpose:** Validate and redeem a ticket.
- **Authentication:** Required (Admin/Staff/Volunteer).
- **Request:**
    ```json
    {
        "code": "string (UUID or Barcode)"
    }
    ```
- **Response:**
    ```json
    {
      "status": "success|error|duplicate",
      "ticket": { ... },
      "message": "Access Granted"
    }
    ```

### 4.3 Authentication & Authorization

- **Mechanism:** Session-based (Laravel default).
- **Role Control:** `RoleMiddleware` checks `user.role` column.
- **Policies:** Laravel Policies (`TicketPolicy`, etc.) authorize specific actions (e.g., users can only view their own tickets).

## 5. Component Design

### 5.1 Backend Services

**BarcodeService**

- **Responsibility:** Generate and decode ticket identifiers.
- **Key Functions:**
    - `generate(Ticket $ticket)`: Returns QR/Barcode string/SVG.
    - `validate(string $code)`: Lookup logic.
- **Dependencies:** `simplesoftwareio/simple-qrcode`, `milon/barcode`.

**ActivityLogger**

- **Responsibility:** Audit trail.
- **Key Functions:**
    - `log(string $action, Model $target)`: Writes to `activity_logs`.

### 5.2 Frontend Architecture

- **Framework:** Blade + Tailwind CSS v4.
- **Layouts:**
    - `app.blade.php`: Public layout (Red Primary).
    - `admin.blade.php`: Admin layout (Indigo Accent).
    - `user/app.blade.php`: User Portal (Dark/Glass).

**Key Wireframe Mappings:**
| Screen | Components | State Requirements |
|--------|------------|-------------------|
| **Event Index** | Grid of `event-card` | Pagination |
| **Ticket Scan** | Camera Viewport, Input Field | Alpine `x-data="{ scanning: true }"` |
| **User Dashboard** | Stats Cards, Ticket List | Tab state (Upcoming/Past) |

### 5.3 Integration Layer

- **PDF Export:** Integration with `dompdf` to render Views as PDF streams.
- **No External Integrations:** Currently no Payment Gateway or Email Service is actively configured for the MVP.

## 6. Security Design

### 6.1 Security Architecture

The system relies on defense-in-depth:

- **Network:** HTTPS (recommended for Prod).
- **Application:** Laravel middleware pipeline.
- **Data:** SQL Injection protection via Eloquent.

### 6.2 Security Controls

| Control                  | Implementation                                         |
| ------------------------ | ------------------------------------------------------ |
| **Rate Limiting**        | `ThrottleRequests` (Login: 5/min, Register: 3/min)     |
| **ticket_id protection** | UUID used externally; Auto-increment ID internal only. |
| **Validation**           | Server-side validation on all inputs.                  |
| **Authorization**        | Policies ensure users cannot access others' tickets.   |

## 7. Performance & Scalability

### 7.1 Performance Requirements

- **Page Load:** < 200ms TTFB.
- **Scan Response:** < 1 second for ticket validation.

### 7.2 Scalability Design

- **Horizontal:** Stateless PHP application (Sessions in file/db, can move to Redis).
- **Database:** Standard SQL optimization; indexed UUIDs.

### 7.3 Caching Strategy

- **Current:** None (MVP).
- **Future:** Redis for Session/Cache driver. Route Caching (`php artisan route:cache`) and Config Caching (`php artisan config:cache`).

## 8. Error Handling & Monitoring

### 8.1 Error Handling

- **User Facing:** Custom 404/500 Blade pages.
- **Validation:** Redirect back with `$errors` bag for form feedback.
- **API/Ajax:** JSON responses with status codes.

### 8.2 Logging

- **Application:** `storage/logs/laravel.log` (Daily rotation).
- **Audit:** Database `activity_logs` for business-critical actions (Login, Purchase, Scan).

## 9. Development Guidelines

### 9.1 Standards

- **Code:** PSR-12.
- **Style:** Tailwind Utility-first.
- **Commit:** Conventional Commits.

### 9.2 Testing Strategy

- **Framework:** Pest PHP.
- **Coverage Goal:** > 80% on Critical Flows (Checkout, Auth, Scan).
- **Types:**
    - **Feature:** End-to-End HTTP tests.
    - **Unit:** Complex Service logic.

## 10. Technical Risks & Mitigations

| Risk                 | Impact | Mitigation                                               |
| -------------------- | ------ | -------------------------------------------------------- |
| **Overselling**      | High   | Pessimistic Locking (`lockForUpdate`) on inventory rows. |
| **Ticket Reuse**     | High   | Validation logic checks `scanned_at` timestamp.          |
| **Barcode Spoofing** | Medium | Signed/Secure tokens or Dynamic QR (Future).             |

## 11. Dependencies & Assumptions

### 11.1 Dependencies

- `barryvdh/laravel-dompdf`: Critical for ticket delivery.
- `simplesoftwareio/simple-qrcode`: Critical for validation.

### 11.2 Assumptions

- Admin users are trusted (no strict 4-eyes principle).
- Event currency is fixed to IDR.
- Users have stable internet for Ticket Access (no offline wallet yet).

## 12. Appendices

### Appendix A: Technology Stack

- **Languages:** PHP 8.2, JavaScript.
- **Frameworks:** Laravel 12, Tailwind CSS 4.
- **Database:** MySQL/PostgreSQL.

### Appendix B: Glossary

- **Scan:** Validating a ticket at the venue.
- **Portal:** Authenticated area for ticket holders.
- **Filament:** Admin Panel Framework, actively used for backend management (Resources, Widgets).

---

_Note: A discrepancy was noted in `product-brief.md` which claimed Filament is "Not Used". This TDD rejects that claim based on the actual codebase structure (`app/Filament/Resources`) and validates Filament as the Admin Panel technology._
