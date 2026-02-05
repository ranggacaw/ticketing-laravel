## Why

Ticketing administrators currently lack an efficient way to create compliant, valid tickets with specific user details that seamlessly integrate with existing external scanning infrastructure. This system will automate barcode generation and ticket management to improve operational efficiency and ensure compatibility.

## What Changes

- **Admin Dashboard**: A new interface for staff to manage ticket data (seat number, type, price, user details).
- **Barcode Generation Logic**: Integration of a library to generate unique scannable barcodes (QR or Code128).
- **Export System**: Functionality to preview and export tickets in HTML/PDF format with embedded barcodes.
- **Validation Rules**: Logic to prevent duplicate seat assignments and ensure data integrity.

## Capabilities

### New Capabilities
- `barcode-engine`: Generates unique, scannable barcodes based on ticket data.
- `ticket-dashboard`: Provides an interface for admins to enter and manage ticket details.
- `ticket-output`: Handles the preview and export of tickets/barcodes.

### Modified Capabilities
- (none)

## Impact

- **Database**: New tables for `tickets` and potentially `ticket_types`.
- **Routes**: New set of admin routes for ticket management.
- **Dependencies**: Addition of a barcode generation library (e.g., `milon/barcode` or `simplesoftwareio/simple-qrcode`).
- **UI**: New Blade components for ticket previews and admin forms.
