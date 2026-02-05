## Context

The system is a Laravel-based internal tool used by staff to manage and generate tickets with scannable barcodes. The existing infrastructure uses external scanners, requiring high fidelity and standard symbology in the generated outputs.

## Goals / Non-Goals

**Goals:**
- Provide a responsive admin dashboard for ticket management.
- Generate high-resolution, scannable QR and Code128 barcodes.
- Ensure 0% duplicate seat assignment within an event/category.
- Support PDF and HTML export formats for printing.

**Non-Goals:**
- Commercial payment processing or transactional banking.
- Public/Customer-facing ticket purchase portal.
- Maintenance of scanning hardware.

## Decisions

### 1. Barcode Library
**Decision**: Use `simplesoftwareio/simple-qrcode` for QR code generation and `milon/barcode` for 1D barcodes.
**Rationale**: These are standard, well-supported libraries in the Laravel ecosystem. QR codes are preferred for their higher data capacity and better scan success rates on mobile and dedicated hardware.

### 2. PDF Generation
**Decision**: Use `barryvdh/laravel-dompdf`.
**Rationale**: It allows for easy conversion of Blade templates to PDF, which simplifies the ticket layout design process using CSS.

### 3. Data Integrity
**Decision**: Implement a unique composite index on the `tickets` table for `seat_number` and `event_id` (if applicable).
**Rationale**: Database-level constraints are the most reliable way to prevent race conditions leading to duplicate seat assignments.

## Risks / Trade-offs

- **[Risk] Scanner Compatibility** → **Mitigation**: Perform a series of scan tests with the actual external hardware using different barcode densities and sizes during the development phase.
- **[Risk] PDF Rendering Complexity** → **Mitigation**: Keep the ticket CSS simple and avoid complex Flexbox/Grid features that `dompdf` might struggle with, favoring table layouts or simple floats if necessary.
