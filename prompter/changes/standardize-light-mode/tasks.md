# Tasks: Standardize Light Mode

- [x] Update `resources/css/app.css` to remove dark theme from DaisyUI config <!-- id: 0 -->
- [x] Remove `dark:` variants and dark-specific variables from `resources/css/app.css` <!-- id: 1 -->
- [x] Remove theme toggle UI and JS logic from `resources/views/layouts/admin.blade.php` <!-- id: 2 -->
- [x] Remove `dark:` Tailwind classes from `resources/views/layouts/admin.blade.php` <!-- id: 3 -->
- [x] Remove any leftover dark mode classes from components in `resources/views/components` (if any found during grep) <!-- id: 4 -->
- [x] Verify User Portal `resources/views/layouts/app.blade.php` renders correctly in light mode <!-- id: 5 -->
- [x] Run build `npm run build` to regenerate CSS <!-- id: 6 -->
- [x] Manual verification of Admin and User dashboards <!-- id: 7 -->
