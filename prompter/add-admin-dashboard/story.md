## 🧾 Story: Add Admin Dashboard with Ticket Overview

### 🧑 As an Administrator,
I want to access a dedicated Dashboard containing a comprehensive overview of ticket data
so that I can quickly monitor ticket status, guest details, and sales performance in a central interface.

### 🔨 Acceptance Criteria (BDD Format)
- **Given** I am a logged-in Administrator
- **When** I navigate to the application sidebar or menu
- **Then** I should see a new menu item labeled "Dashboard"

- **Given** I am on the new Dashboard page
- **When** the page loads
- **Then** I should see a data table compatible with the existing Ticket Management design
- **And** the table should display the following ticket columns: Ticket ID, Guest Info (Name/Email), Seat, Type, Status, and Price
- **And** the "Status" column should visually distinguish between "Validated" and "Pending" tickets
- **And** the "Type" column should use the existing color-coded badges (VVIP, VIP, Festival, etc.)

- **Given** I am viewing the ticket list on the Dashboard
- **When** I look at the "Actions" column
- **Then** I should see options to View Details, Export PDF, and Delete the ticket, matching existing functionality

### 📌 Expected Result
- A new `DashboardController` and associated route (`/admin/dashboard`) are created.
- A new view `admin.dashboard` is created, extending the main admin layout.
- The "Dashboard" link is added to the global navigation `layouts.app` or `layouts.admin`.
- The dashboard UI mirrors the "Ticket Management" table style (glassmorphism/Tailwind) from the index page.

### 🚫 Non-Goals
- Creating charts or graphs (unless strictly required by "organized", but keeping it to the "lines 33-119" data table requirement for this story).
- modifying the underlying `Ticket` model logic.

### 🗒️ Notes
- Reuse the existing `Ticket` model and query logic to populate the dashboard.
- Ensure the extraction of code from `index.blade.php` (lines 33-119) is refactored cleanly or duplicated appropriately if a separate view component is not used.
