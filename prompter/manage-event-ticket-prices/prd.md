# Event Ticket Price Management PRD

| Metadata           | Details                       |
| :----------------- | :---------------------------- |
| **Product Name**   | Event Ticket Price Management |
| **Status**         | Draft                         |
| **Target Release** | Q2 2026                       |
| **Owner**          | Product Team                  |
| **Designers**      | UX/UI Team                    |
| **Tech Lead**      | Engineering Lead              |
| **QA**             | QA Team                       |

## 1. Quick Links

- [Design Prototype] (TBD)
- [Technical Specifications] (TBD)
- [JIRA Project] (TBD)

---

## 2. Background

### Context

Event organizers need a flexible and reliable way to manage ticket pricing for their events. Currently, the system may lack a dedicated, structured interface for managing complex pricing scenarios such as multiple categories (VIP, Regular) and pricing tiers (Early Bird, Standard).

### Problem Statement

Without a dedicated module to manage master data for event ticket prices, organizers face difficulties in setting up and adjusting prices efficiently. This can lead to pricing errors, inconsistencies across events, and a poor administrative experience.

### Current State

(Assumption) Pricing might be hardcoded or managed via direct database access or a very basic, non-validated form.

---

## 3. Objectives

### Business Objectives

1.  **Scalability**: Support multiple events and diverse pricing structures without code changes.
2.  **Data Integrity**: Ensure 100% of price inputs are validated for consistency (e.g., non-negative prices, valid dates).
3.  **Efficiency**: Reduce the time required to configure event pricing by 50%.

### User Objectives

1.  **Control**: Give Event Admins full CRUD capabilities over ticket prices.
2.  **Clarity**: Provide immediate feedback and summaries of the pricing structure.
3.  **Confidence**: Ensure that entered data is accurate through robust validation and error handling.

---

## 4. Success Metrics

| Metric                    | Baseline      | Target   | Measurement Method                                    |
| :------------------------ | :------------ | :------- | :---------------------------------------------------- |
| **Time to Setup Pricing** | 10 mins (est) | < 5 mins | Time measuring typical setup workflow                 |
| **Pricing Entry Errors**  | 5%            | < 1%     | Log analysis of validation errors vs successful saves |
| **Admin Satisfaction**    | N/A           | 4.5/5    | Post-release survey                                   |

---

## 5. Scope

### MVP 1 (In Scope) ✅

- **Create**: Add new ticket pricing tiers linked to specific events.
- **Read**: View a list/summary of all ticket prices for an event.
- **Update**: Modify existing ticket categories, prices, and quotas.
- **Delete**: Remove pricing tiers (with soft delete or confirmation).
- **Validation**: Server-side and client-side validation for inputs (Price > 0, Quota >= 0).
- **Categories**: Support for standard categories (VIP, Regular, Student).
- **Output Summary**: Display a confirmation summary after operations.

### Out of Scope ❌

- Dynamic/Algorithmic pricing based on demand.
- Multi-currency support (Phase 2).
- Bundled packages (e.g., Ticket + Merchandise).
- Coupon/Discount code management (Separate module).

---

## 6. User Flow

```mermaid
graph TD
    A[Start: Admin Dashboard] --> B[Select "Manage Events"]
    B --> C[Select Specific Event]
    C --> D[Navigate to "Ticket Prices" Tab]

    D --> E{Action?}
    E -->|Create| F[Click "Add Ticket Tier"]
    E -->|Edit| G[Select Existing Tier -> Edit]
    E -->|Delete| H[Select Tier -> Delete]

    F --> I[Enter Details: Category, Price, Quota]
    G --> I

    I --> J[Click "Save"]
    J --> K{Validation Passed?}
    K -->|No| L[Show Error Messages]
    L --> I
    K -->|Yes| M[Save to Database]
    M --> N[Show Success Summary]
    N --> D
```

---

## 7. User Stories

| ID        | User Story                                                                                                                      | Acceptance Criteria                                                                                                                                                                   | Platform | Priority |
| :-------- | :------------------------------------------------------------------------------------------------------------------------------ | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | :------- | :------- |
| **US-01** | As an **Event Admin**, I want to **create a new ticket price tier** for an event so that I can sell different types of tickets. | **Given** I am on the Event Pricing page<br>**When** I fill in the Category (e.g., VIP), Price, and Quota and click verify<br>**Then** the new tier is saved and appears in the list. | Web      | High     |
| **US-02** | As an **Event Admin**, I want to **view all ticket prices** for an event so that I can audit the current setup.                 | **Given** I have selected an event<br>**When** I load the Pricing tab<br>**Then** I see a table of all active price tiers with their details.                                         | Web      | High     |
| **US-03** | As an **Event Admin**, I want to **update existing prices** so that I can adjust for market changes.                            | **Given** a price tier exists<br>**When** I change the price value and save<br>**Then** the system updates the record and confirms the change.                                        | Web      | Medium   |
| **US-04** | As an **Admin**, I want the system to **validate my inputs** so that I don't create invalid data.                               | **Given** I enter a negative price or existing category name<br>**When** I try to submit<br>**Then** the system prevents saving and highlights the error.                             | Web      | High     |
| **US-05** | As an **Admin**, I want to **delete a ticket tier** that was created by mistake.                                                | **Given** a tier exists<br>**When** I click delete and confirm<br>**Then** the tier is removed from the list.                                                                         | Web      | Medium   |

---

## 8. Analytics & Tracking

### Event Tracking

| Event Name                      | Trigger                                    | Properties                                   | Description                     |
| :------------------------------ | :----------------------------------------- | :------------------------------------------- | :------------------------------ |
| `ticket_price_created`          | User successfully creates a new price tier | `event_id`, `category`, `price`, `currency`  | Track creation of new inventory |
| `ticket_price_updated`          | User updates an existing tier              | `event_id`, `price_tier_id`, `field_changed` | Track modifications             |
| `ticket_price_validation_error` | User triggers a validation error           | `event_id`, `error_type`, `field`            | Identify UX friction points     |

### JSON Example

```json
{
    "Trigger": "Click",
    "TriggerValue": "Save Price Tier",
    "Page": "Event Pricing Management",
    "Data": {
        "EventID": "evt_12345",
        "Category": "VIP",
        "Price": 150.0,
        "Quota": 50
    },
    "Description": "Admin adds a new VIP pricing tier"
}
```

---

## 9. Open Questions

| Question                                                                     | Assignee      | Status             |
| :--------------------------------------------------------------------------- | :------------ | :----------------- |
| How do we handle price changes for tickets already sold?                     | Product Owner | Pending Discussion |
| Should we allow "Unlimited" quota represented by a specific value (e.g. -1)? | Tech Lead     | To Decide          |
| Do we need to display tax calculations in this view?                         | Finance/PO    | Open               |

---

## 10. Notes & Considerations

- **Scalability**: The database schema must allow for `1:N` relationship between Events and TicketPrices.
- **Concurrency**: Locking might be needed if multiple admins try to edit the same event's pricing simultaneously (unlikely for MVP but worth noting).
- **Audit Log**: Consider logging "Who changed what" for security purposes in future iterations.

---

## 11. Appendix

### Glossary

- **SKU**: Stock Keeping Unit, refers to a specific ticket type.
- **Tier**: A specific price point and set of benefits (e.g., Early Bird vs. Standard).
- **Master Data**: The core data that defines the business entities (in this case, the pricing configurations).
