# Proposal: Standardize Application to Light Mode Only

## 1. Summary
This proposal aims to simplify the application's visual experience by removing all dark mode functionality and establishing Light Mode as the single, permanent theme. This reduction in complexity will streamline UI maintenance, ensure consistent branding, and eliminate potential visual bugs associated with theme switching.

## 2. Problem Statement
The current application supports both light and dark modes, with a specific "Immersive Dark" mode for the User Portal and a toggle for the Admin dashboard. Maintaining two distinct themes increases the surface area for visual bugs, complicates CSS maintenance, and creates inconsistency in the user experience across different modules.

## 3. Proposed Solution
We will:
- Remove the theme switcher UI from the Admin dashboard and any other location.
- Remove all JavaScript logic related to theme preference storage (localStorage) and detection (system preference).
- Update Tailwind/DaisyUI configuration to support only the `light` theme.
- Clean up `app.css` by removing `dark:` variant overrides, ensuring all components look correct in light mode.
- Update the User Portal to use the standard Light theme instead of the forced Dark theme.

## 4. Scope
- **In Scope:**
    - `resources/views/layouts/admin.blade.php`: Remove toggle and logic.
    - `resources/css/app.css`: Remove dark mode config and styles.
    - `tailwind.config.js` (if present/relevant): Update config.
    - `resources/views/layouts/app.blade.php`: Verify light mode rendering.
- **Out of Scope:**
    - Major redesign of the User Portal layout (only color scheme changes).

## 5. Risks
- Users accustomed to the "Immersive Dark" portal might find the change jarring.
- Some "glassmorphism" effects might need tuning for light mode visibility on white backgrounds.

## 6. Success Criteria
- No "dark mode" code exists in the codebase.
- Application defaults to light mode on all devices.
- No console errors on load.
