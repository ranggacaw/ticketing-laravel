# Tasks: Standardize Light Mode

- [ ] Update `resources/css/app.css` to remove dark theme from DaisyUI config <!-- id: 0 -->
- [ ] Remove `dark:` variants and dark-specific variables from `resources/css/app.css` <!-- id: 1 -->
- [ ] Remove theme toggle UI and JS logic from `resources/views/layouts/admin.blade.php` <!-- id: 2 -->
- [ ] Remove `dark:` Tailwind classes from `resources/views/layouts/admin.blade.php` <!-- id: 3 -->
- [ ] Remove any leftover dark mode classes from components in `resources/views/components` (if any found during grep) <!-- id: 4 -->
- [ ] Verify User Portal `resources/views/layouts/app.blade.php` renders correctly in light mode <!-- id: 5 -->
- [ ] Run build `npm run build` to regenerate CSS <!-- id: 6 -->
- [ ] Manual verification of Admin and User dashboards <!-- id: 7 -->
