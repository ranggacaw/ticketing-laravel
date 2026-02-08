# Spec: Responsive User Portal

## Overview

Ensure the user portal provides a modern, responsive experience across all devices.

---

## ADDED Requirements

### Requirement: Responsive Layout System

The user portal SHALL adapt to different screen sizes.

#### Scenario: Mobile layout

- **WHEN** user accesses portal on device less than 640px width
- **THEN** single-column design is used
- **AND** bottom navigation bar is displayed
- **AND** touch targets are minimum 44x44 pixels

#### Scenario: Tablet layout

- **WHEN** user accesses portal on device between 640px-1024px width
- **THEN** collapsible sidebar is displayed
- **AND** cards display in 2-column grid

#### Scenario: Desktop layout

- **WHEN** user accesses portal on device greater than 1024px width
- **THEN** full sidebar is displayed
- **AND** cards display in 3+ column grid

---

### Requirement: Navigation Components

Navigation SHALL be intuitive for all screen sizes.

#### Scenario: Mobile bottom navigation

- **WHEN** user is on mobile device
- **THEN** fixed bottom nav shows: Home, Tickets, Payments, Profile
- **AND** current section is highlighted

#### Scenario: Sidebar navigation

- **WHEN** user is on tablet or desktop
- **THEN** sidebar with navigation items is displayed
- **AND** current page is highlighted

#### Scenario: Profile dropdown

- **WHEN** user clicks profile avatar/name in header
- **THEN** dropdown appears with: Profile link, Logout button

---

### Requirement: Modern Visual Design

The portal SHALL apply consistent modern aesthetic.

#### Scenario: Glass card design

- **WHEN** user views cards
- **THEN** semi-transparent glass effect with backdrop blur is applied

#### Scenario: Color scheme applied

- **WHEN** user views any page
- **THEN** design uses defined palette: Indigo primary, Emerald secondary, Amber accent

#### Scenario: Typography applied

- **WHEN** user views any page
- **THEN** Inter font family is used with appropriate heading sizes

---

### Requirement: Interactive Feedback

The portal SHALL provide clear feedback for user interactions.

#### Scenario: Loading states

- **WHEN** page is loading data
- **THEN** skeleton loaders are displayed
- **AND** smooth transition occurs when data loads

#### Scenario: Toast notifications

- **WHEN** user completes an action
- **THEN** toast notification appears
- **AND** auto-dismisses after 4 seconds

---

### Requirement: Performance Optimization

The portal SHALL load quickly on all devices.

#### Scenario: No horizontal scroll

- **WHEN** user views any page on any device
- **THEN** no horizontal scrollbar appears
- **AND** all content fits within viewport width

---

## Technical Notes

- Use CSS Grid and Flexbox for layouts
- Breakpoints: 640px (tablet), 1024px (desktop)
- Font: Inter from Google Fonts
- Mobile-first approach
