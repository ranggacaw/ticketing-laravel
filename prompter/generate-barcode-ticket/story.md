## 🧾 Story: Generate Single Ticket with Barcode

### 🧑 As a Ticketing Administrator,
I want to input specific ticket details (Seat, Price, Type, User Info) and generate a valid barcode,
so that I can issue compliant tickets that work with our existing external scanners.

### 🔨 Acceptance Criteria (BDD Format)
- **Given** the administrator is logged into the Internal Ticket Barcode Generation System
- **When** they fill in the "Seat Number", "Ticket Type", "Price", and "User Details" fields
- **And** they submit the form for generation
- **Then** the system should validate that the Seat Number is not already assigned (preventing duplicates)
- **And** the system should generate a unique barcode string compliant with external scanner formats (e.g., Code128/QR)
- **And** the interface should display the successful creation status along with a visual preview of the generated barcode
- **And** the ticket record should be saved in the database for future lookups

### 📌 Expected Result
- A user-friendly form for data entry.
- Instant feedback on validation errors (e.g., duplicate seat).
- A generated barcode image visible on the screen immediately after creation.
- The barcode data string matches the required format for integration.

### 🚫 Non-Goals (if applicable)
- Batch generation of tickets (this story focuses on single creation).
- Printing the ticket (this is a separate "Export/Preview" step, though preview on screen is okay).
- Payment processing for the ticket.

### 🗒️ Notes (optional)
- Need to confirm the exact barcode symbology (QR vs Code128) from dependencies before final dev: assumed standard support for now.
- Ensure the "User Details" field captures minimal necessary info (Name/ID) as per admin needs.
