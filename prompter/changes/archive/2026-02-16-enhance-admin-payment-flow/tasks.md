## 1. Database & Schema

- [x] 1.1 Create migration: `create_banks_table` (id, name, code, logo_url, account_name, account_number, is_active, timestamps)
- [x] 1.2 Create migration: `add_bank_fields_to_payments_table` (bank_id FK, sender_account_name, sender_account_number, rejection_reason)
- [x] 1.3 Create migration: `add_unique_barcode_data_to_tickets` — backfill any null/duplicate `barcode_data`, then add unique index
- [x] 1.4 Create `Bank` model with fillable fields and `scopeActive` query scope
- [x] 1.5 Update `Payment` model: add `bank()` relationship, add new fillable fields
- [x] 1.6 Create `BankSeeder` with BCA, Mandiri, BNI, BRI, BSI, CIMB Niaga (include account_name, account_number placeholders)
- [x] 1.7 Register `BankSeeder` in `DatabaseSeeder`
- [x] 1.8 Run migrations and seeder locally; verify schema

## 2. Barcode Uniqueness

- [x] 2.1 Update `BarcodeService::formatBarcodeData()` to use UUID + ticket ID for collision-free short codes
- [x] 2.2 Update `Ticket` model boot: ensure `barcode_data` uses UUID directly (unique per ticket)
- [x] 2.3 Write Pest test: creating multiple tickets in one transaction yields unique barcode_data values

## 3. Checkout Flow Update (Payment Proof + Bank)

- [x] 3.1 Update `CheckoutController::store()` — validate `bank_id`, `sender_account_name`, `sender_account_number`, `payment_proof` (file, max 2MB, jpg/png/pdf)
- [x] 3.2 Store uploaded proof in `storage/app/public/payment-proofs/` with unique filename
- [x] 3.3 Create `Payment` record (status pending) and attach tickets via pivot
- [x] 3.4 Set ticket `payment_status = 'pending'` instead of `'confirmed'`
- [x] 3.5 Update checkout Blade view: add bank selector dropdown, sender account fields, file upload input
- [x] 3.6 Update checkout success view to show "Payment Under Review" message
- [x] 3.7 Write Pest feature test: checkout creates pending payment with proof and pending tickets

## 4. Admin Dashboard Filtering

- [x] 4.1 Update `Admin\DashboardController::index()` — accept query params: `search`, `status`, `type`, `date_from`, `date_to`; apply filters to tickets query
- [x] 4.2 Update `admin.dashboard` Blade view: add filter bar (search input, status dropdown, type dropdown, date pickers, clear button)
- [x] 4.3 Ensure filter values persist in form inputs after submission and across pagination
- [x] 4.4 Write Pest feature test: dashboard filters return correct subset of tickets

## 5. Event Participants Page

- [x] 5.1 Add `participants()` method to admin `EventController` (or create `Admin\ParticipantController`)
- [x] 5.2 Create route `GET /admin/events/{event}/participants` → `admin.events.participants`
- [x] 5.3 Create `admin.events.participants` Blade view with table: name, email, ticket type, status, purchase date; filter inputs for keyword, type, status
- [x] 5.4 Add "View Participants" button to `admin.events.show` view
- [x] 5.5 Write Pest feature test: participants page lists users with tickets for the event

## 6. Admin Payment Approval

- [x] 6.1 Create `Admin\PaymentController` with `index`, `show`, `approve`, `reject` methods
- [x] 6.2 Add routes: `GET /admin/payments`, `GET /admin/payments/{payment}`, `POST /admin/payments/{payment}/approve`, `POST /admin/payments/{payment}/reject`
- [x] 6.3 Create `admin.payments.index` Blade view: table with invoice, user, amount, bank, status, date; pending-first sorting
- [x] 6.4 Create `admin.payments.show` Blade view: full detail with proof image/PDF preview, bank info, linked tickets list, approve/reject buttons
- [x] 6.5 Implement approve logic: update payment status, confirmed_at/by, update linked tickets to confirmed
- [x] 6.6 Implement reject logic: require reason, update payment status to cancelled, update linked tickets to cancelled, decrement ticket type sold count
- [x] 6.7 Add payment link to admin sidebar navigation
- [x] 6.8 Write Pest feature tests: approve sets confirmed, reject sets cancelled with reason and restores inventory

## 7. Final Verification

- [x] 7.1 Run `php artisan test` — all tests pass
- [x] 7.2 Run `php artisan storage:link` if not already linked
- [x] 7.3 Manual smoke test: full flow from checkout → pending → admin approve/reject
