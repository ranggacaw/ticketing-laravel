# livewire-integration Specification

## Purpose

Integration of Livewire v3 for real-time ticket scanning and payment status updates.
## Requirements
### Requirement: Livewire Framework Integration

The system SHALL include Livewire v3 as a Composer dependency, enabling reactive server-driven UI components across both user-facing and admin areas.

#### Scenario: Livewire assets loaded on user pages

- **WHEN** a user visits any page using the user layout
- **THEN** Livewire's JavaScript and CSS assets are injected (auto or manual)
- **AND** no page-load errors or console warnings appear

#### Scenario: Livewire component rendering

- **WHEN** a Blade template includes a `@livewire('component-name')` directive
- **THEN** the component renders server-side and becomes interactive without full-page reload

### Requirement: Live Ticket Scanner Component

The system SHALL provide a `LiveTicketScanner` Livewire component that validates ticket barcodes in real-time without requiring a full-page form submission.

#### Scenario: Scan barcode and display result

- **WHEN** a staff or volunteer scans a barcode using the scanner component
- **THEN** the component sends the barcode to the server via Livewire
- **AND** the validation result (valid/invalid/already scanned) is displayed inline within 500ms
- **AND** no full-page reload occurs

#### Scenario: Invalid barcode handling

- **WHEN** a barcode that does not match any ticket is scanned
- **THEN** the component displays an "Invalid ticket" error message inline
- **AND** the scanner remains ready for the next scan

### Requirement: Live Payment Status Component

The system SHALL provide a `LivePaymentStatus` Livewire component that displays real-time payment approval status on the checkout success page.

#### Scenario: Payment status polling

- **WHEN** a user views their checkout success page for a pending payment
- **THEN** the component polls the server every 10 seconds for status updates
- **AND** when the payment is approved, the status indicator changes to "Confirmed" without page reload

#### Scenario: Payment rejected notification

- **WHEN** an admin rejects a user's payment while the user is viewing the success page
- **THEN** the component updates to show "Rejected" status with the rejection reason

