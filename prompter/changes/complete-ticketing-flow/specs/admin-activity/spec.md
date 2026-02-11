## ADDED Requirements

### Requirement: Admin Dashboard Activity feed

The admin dashboard MUST show a feed of recent administrative actions to allow monitoring of system usage.

#### Scenario: View recent admin actions

Given I am on the admin dashboard
When I look at the "Recent Activity" widget
Then I see a list of recent creation/update events by admins

### Requirement: Enhanced Ticket Scanning Feedback

The ticket scanning interface MUST provide immediate visual feedback and history of recent scans to improve throughput.

#### Scenario: Scan multiple tickets

Given I am on the scan page
When I scan a valid ticket code
Then I see a success message
And the scan is added to a "Recent Scans" list on the same page

### Requirement: Comprehensive User History for Admins

Admins MUST be able to view a user's full history including purchases and scans to provide support.

#### Scenario: Inspect user activity via admin panel

Given I am viewing a user's details
When I click the "History" tab
Then I see their ticket purchases, scan logs, and profile updates
