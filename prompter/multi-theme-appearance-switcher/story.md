## 🧾 Story: Multi-Theme Appearance Switcher (Night, Day, System)

### 🧑 As an application user,
I want to toggle between Night, Day, and System color themes 
so that I can customize my viewing experience according to my environment and preference.

### 🔨 Acceptance Criteria (BDD Format)
- **Given** I am on any page of the application, **When** I access the theme switcher, **Then** I should see three distinct options: Night, Day, and System.
- **Given** I select "Night", **When** the preference is saved, **Then** the application appearance should switch to dark mode immediately.
- **Given** I select "Day", **When** the preference is saved, **Then** the application appearance should switch to light mode immediately.
- **Given** I select "System", **When** my device's operating system setting is Dark, **Then** the application should automatically apply the Night theme.
- **Given** I select "System", **When** my device's operating system setting is Light, **Then** the application should automatically apply the Day theme.
- **Given** I change the theme, **When** the styles are updated, **Then** the transition between colors should be smooth and visually appealing.
- **Given** I have set a theme preference, **When** I refresh the page or start a new session, **Then** my previous selection should be maintained.
- **Given** I am browsing on a mobile or desktop screen, **When** I use the theme switcher, **Then** it should be responsive and correctly positioned in the user interface.

### 📌 Expected Result
- A persistent theme switcher component (likely in the top navigation or sidebar).
- Clear visual indicators (icons or labels) for each state: Day (Sun), Night (Moon), System (Display/Auto).
- CSS variables used for colors to ensure theme consistency across all components.
- Smooth CSS transitions for color and background properties.

### 🚫 Non-Goals
- Per-component theme overrides (all components follow the global theme).
- Custom color palette creation for users (only the 3 predefined themes).

### 🗒️ Notes
- Recommendation: Use `localStorage` to persist the user's choice.
- Reference `prefers-color-scheme` media query for the "System" option.
- Ensure cross-browser compatibility (Chrome, Firefox, Safari, Edge).
