## ADDED Requirements

### Requirement: Ticket Preview
The system SHALL display a live preview of the ticket design, including the generated barcode and ticket details.

#### Scenario: Preview ticket design
- **WHEN** the admin clicks the "Preview" button
- **THEN** the system SHALL show an overlay or page with the ticket layout, barcode, and data

### Requirement: Export to PDF/HTML
The system SHALL allow exporting the ticket as a PDF or printable HTML page.

#### Scenario: Export ticket
- **WHEN** the admin clicks "Export PDF"
- **THEN** the system SHALL download a PDF file containing the ticket with high-resolution scannable barcode
