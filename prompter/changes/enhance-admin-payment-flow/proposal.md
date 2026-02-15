# Change: Enhance Admin Payment Flow & Dashboard

## Why

The admin panel lacks filtering capabilities on the dashboard, making it hard to locate tickets quickly. Event organizers have no way to see which users are participating in a given event. The current checkout flow skips payment entirely (MVP simulator), so there is no proof-of-payment workflow, no bank selection, and no admin approval step. Additionally, when a user buys multiple tickets in one transaction, each ticket already gets a unique UUID but the barcode data derivation could collide under certain hash conditions — the uniqueness guarantee needs to be explicit and enforced.

## What Changes

### 1. Admin Dashboard Filtering
- Add search/filter controls to the Recent Tickets table on the admin dashboard (filter by status, ticket type, date range, and keyword search on guest name/email/UUID).

### 2. Event Participants Page
- New dedicated page `/admin/events/{event}/participants` listing all users who purchased tickets for a given event, with filters (name, email, ticket type, status).

### 3. Ticket Barcode Uniqueness (1 Barcode = 1 Ticket)
- Enforce that every ticket row has a globally unique `barcode_data` value. Add a unique DB constraint and update `BarcodeService::formatBarcodeData()` to guarantee collision-free codes even when purchasing multiple tickets in one transaction.

### 4. Payment Bank Masterdata
- Create a `banks` master table seeded with common Indonesian banks (BCA, Mandiri, BNI, BRI, BSI, CIMB Niaga, etc.).
- Add `bank_id` and `account_number` columns to the `payments` table so users select a destination bank during checkout.

### 5. Payment Proof Upload
- During checkout, after selecting tickets and bank, users upload a proof-of-payment image (JPG/PNG/PDF, max 2 MB).
- Tickets are created with `payment_status = 'pending'` instead of `'confirmed'`.
- The proof file is stored under `storage/app/public/payment-proofs/`.
- A `Payment` record is created linking the uploaded proof to the tickets.

### 6. Admin Payment Approval
- New admin page `/admin/payments` listing all pending payments with proof thumbnails.
- Admins can view the uploaded proof, then approve or reject each payment.
- Approving sets `payments.status = 'confirmed'`, `confirmed_at`, `confirmed_by`, and flips linked tickets to `payment_status = 'confirmed'`.
- Rejecting sets `payments.status = 'cancelled'` with a reason note, and linked tickets to `payment_status = 'cancelled'`.

## Impact

- **New specs**: `admin-dashboard-filters`, `event-participants`, `ticket-barcode-uniqueness`, `payment-bank-masterdata`, `payment-proof-upload`, `admin-payment-approval`
- **Affected code**:
  - Controllers: `Admin\DashboardController`, `Admin\EventController` (or new `Admin\ParticipantController`), `CheckoutController`, new `Admin\PaymentController`
  - Models: `Payment` (add `bank_id`), `Ticket` (barcode constraint), new `Bank` model
  - Migrations: new `banks` table, alter `payments` (add `bank_id`, `account_number`), unique index on `tickets.barcode_data`
  - Views: `admin.dashboard` (add filters), new `admin.events.participants`, new `admin.payments.*`, updated checkout views
  - Services: `BarcodeService` (collision-free generation)
  - Routes: new admin routes for payments and participants
  - Seeder: `BankSeeder`
