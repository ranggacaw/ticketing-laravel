# Design: Light Mode Standardization

## 1. Architecture Changes
No structural architecture changes. This is a frontend-logic and styling refactor.

## 2. Component Updates

### Layouts
- **Admin Layout (`admin.blade.php`)**:
    - The inline script in `<head>` that checks `localStorage` and `matchMedia` will be removed.
    - The Theme Switcher UI component (buttons) will be removed from the top bar.
    - The `updateThemeUI` and `setTheme` functions will be deleted.
    - `dark:` classes on text and backgrounds will be removed.
    - The `html` tag will default to `data-theme="light"` (via DaisyUI default).

### Styling Strategy
- **Tailwind/DaisyUI**:
    - Modify `@plugin "daisyui"` config to remove `dark` theme.
    - Remove `@media (prefers-color-scheme: dark)` blocks if any exist.
- **Glassmorphism**:
    - The `.glass-card` class currently has `dark:bg-black/40`. This will be removed. 
    - Verify `bg-white/60` provides sufficient contrast on `bg-base-200` (light grey).

## 3. Data Migration
- **Local Storage**: We will explicitly remove the `theme` key from `localStorage` once via a one-time script or simply ignore it since the logic to read it is removed. (Decision: Ignore/Passive removal).

## 4. User Experience
- **User Portal**: Currently "Immersive Dark". It will now use `bg-base-200` (light grey) matching the rest of the app. This unifies the experience.
