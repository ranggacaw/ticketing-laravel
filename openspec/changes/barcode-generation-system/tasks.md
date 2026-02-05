## 1. Environment and Dependencies

- [x] 1.1 Install `simplesoftwareio/simple-qrcode` via composer.
- [x] 1.2 Install `milon/barcode` via composer.
- [x] 1.3 Install `barryvdh/laravel-dompdf` for PDF generation.

## 2. Database and Models

- [x] 2.1 Create migration for `tickets` table with `uuid`, `seat_number`, `user_name`, `user_email`, `price`, and `type`.
- [x] 2.2 Add unique index to `tickets` for `seat_number`.
- [x] 2.3 Create `Ticket` model and set up fillable attributes.

## 3. Barcode Logic

- [x] 3.1 Create a `BarcodeService` to handle QR and 1D barcode generation.
- [x] 3.2 Implement a method to generate unique data strings for encoding.

## 4. Admin Dashboard UI

- [x] 4.1 Define routes for ticket management (index, create, store, show).
- [x] 4.2 Create Admin Controller for handling ticket CRUD.
- [x] 4.3 Build the Ticket Creation form using Blade/Tailwind.
- [x] 4.4 Build the Ticket List view with preview links.

## 5. Output and Export

- [x] 5.1 Design the Ticket Blade template for printing.
- [x] 5.2 Implement PDF export route and controller logic using `DomPDF`.
- [x] 5.3 Add "Live Preview" modal to the ticket list.
