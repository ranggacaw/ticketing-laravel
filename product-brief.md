# Enhanced Prompt: PHP Laravel Ticketing System Development

## Project Overview
Develop a comprehensive web-based ticketing system using PHP Laravel framework, inspired by the functionality and user experience of tiket.com. The application must feature two distinct interfaces: a customer-facing frontend and an administrative backend.

---

## 🎨 Design Requirements

### Frontend (Customer Interface)
- **Framework**: DaisyUI (Tailwind CSS components)
- **Mandatory Color Palette**:
  - Primary Red: `#e61f27`
  - Primary Black: `#101010`
  - Primary White: `#ffffff`
- **Design Principles**:
  - Fully responsive design (mobile-first approach)
  - Modern, clean, and intuitive user interface
  - Fast loading times and optimized performance
  - Accessibility compliance (WCAG 2.1 Level AA)

### Backend (Admin Panel)
- **Framework**: Filament Laravel (v3.x recommended)
- **Interface**: Professional admin dashboard with default Filament styling (customizable to match brand colors)

---

## 🔧 Technical Stack

### Required Technologies
- **Backend Framework**: Laravel 10.x or 11.x
- **Frontend Framework**: DaisyUI with Tailwind CSS 3.x
- **Admin Panel**: Filament Laravel
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **PHP Version**: 8.1 or higher
- **Package Manager**: Composer (backend), NPM/Yarn (frontend)

### Additional Dependencies
- Laravel Breeze or Jetstream (for authentication scaffolding)
- Laravel Sanctum (API authentication if needed)
- Laravel Queue (for email notifications and background jobs)
- Laravel Storage (for file uploads and management)

---

## 👤 Customer-Facing Features

### 1. Authentication System
- **User Registration**:
  - Email and password registration
  - Email verification required
  - Social authentication (Google, Facebook - optional)
  - Phone number verification (optional enhancement)
  
- **User Login**:
  - Email/username and password
  - "Remember me" functionality
  - Password reset via email
  - Account lockout after failed attempts

### 2. Ticket Search & Discovery
- **Search Functionality**:
  - Search by origin and destination
  - Date range picker (departure and return)
  - Passenger count selector (adults, children, infants)
  - Filter options: price range, departure time, airlines/operators, class type
  - Autocomplete suggestions for locations
  
- **Search Results Display**:
  - List view with sorting options (price, duration, departure time)
  - Direct and transit routes
  - Real-time availability status
  - Price comparison view

### 3. Booking System
- **Ticket Selection**:
  - Detailed ticket information (schedule, facilities, terms)
  - Seat selection interface (if applicable)
  - Multiple passenger details form
  - Contact information collection
  
- **Booking Flow**:
  - Step-by-step booking wizard
  - Real-time price calculation
  - Promo code/discount application
  - Booking summary review page
  - Session timeout warning (prevent booking expiry)

### 4. Payment Integration
- **Payment Methods**:
  - Credit/Debit card processing (Stripe/Xendit/Midtrans)
  - Bank transfer (virtual accounts)
  - E-wallets (GoPay, OVO, Dana, ShopeePay)
  - PayPal integration (optional)
  
- **Payment Process**:
  - Secure payment gateway integration
  - Payment confirmation page
  - Automatic booking expiration (e.g., 30 minutes)
  - Receipt generation and email delivery
  - Payment status tracking

### 5. User Dashboard
- **My Bookings**:
  - Active and past bookings list
  - Booking details view
  - E-ticket download (PDF format)
  - Booking cancellation (with refund rules)
  
- **Profile Management**:
  - Personal information editing
  - Saved passengers (frequent travelers)
  - Notification preferences
  - Payment method management

### 6. Additional User Features
- Email notifications (booking confirmation, reminders, updates)
- SMS notifications (optional enhancement)
- Booking history export
- Customer support chat/ticket system
- Travel insurance purchase option (optional)
- Multi-language support (optional)

---

## 🛠️ Admin Panel Features (Filament)

### 1. Dashboard & Analytics
- Key metrics overview (total bookings, revenue, active users)
- Sales charts and graphs (daily, weekly, monthly)
- Recent transactions list
- Popular routes and destinations
- Real-time booking notifications

### 2. Ticket Management
- **CRUD Operations**:
  - Create, read, update, delete tickets
  - Bulk import tickets (CSV/Excel)
  - Bulk update pricing and availability
  
- **Ticket Configuration**:
  - Route management (origin, destination, stops)
  - Schedule configuration (date, time, duration)
  - Pricing tiers (economy, business, first class)
  - Seat inventory management
  - Ticket categories (bus, train, flight, event)
  - Dynamic pricing rules (peak/off-peak)

### 3. User Management
- **Customer Management**:
  - View all registered users
  - User details and booking history
  - Account status management (active, suspended, banned)
  - Password reset for users
  
- **Admin User Management**:
  - Role-based access control (RBAC)
  - Permission management
  - Admin user CRUD operations
  - Activity logs and audit trails

### 4. Transaction Management
- **Booking Management**:
  - View all bookings with filters (status, date, user)
  - Booking details and passenger information
  - Manual booking creation/modification
  - Refund processing
  - Booking cancellation with audit trail
  
- **Payment Management**:
  - Payment status tracking (pending, paid, failed, refunded)
  - Payment reconciliation
  - Manual payment confirmation
  - Transaction reports and exports

### 5. Content Management
- **Operators/Providers**:
  - Manage airlines, bus operators, train services
  - Operator profiles and contact information
  
- **Location Management**:
  - Cities, terminals, airports, stations
  - Location details and codes
  
- **Promotional Management**:
  - Promo code creation and management
  - Discount rules configuration
  - Banner and advertisement management

### 6. Reporting & Analytics
- Sales reports (by period, route, operator)
- Revenue reports with filters
- User registration trends
- Booking conversion analytics
- Payment method statistics
- Export functionality (PDF, Excel, CSV)

### 7. System Configuration
- General settings (site name, logo, contact info)
- Email template configuration
- Payment gateway settings
- Notification settings
- System maintenance mode
- API key management

---

## 📊 Database Schema Requirements

### Core Tables
1. **users** - Customer and admin accounts
2. **tickets** - Available ticket inventory
3. **bookings** - Customer booking records
4. **booking_passengers** - Passenger details for each booking
5. **payments** - Payment transaction records
6. **locations** - Cities, terminals, stations
7. **operators** - Transportation providers
8. **promo_codes** - Discount and promotional codes
9. **notifications** - System notifications
10. **settings** - Application configuration

### Relationships
- One-to-Many: User → Bookings, Operator → Tickets
- Many-to-Many: Tickets ↔ Categories, Users ↔ Roles
- Polymorphic: Payments (bookable_type, bookable_id)

---

## 🔒 Security Requirements

1. **Authentication & Authorization**:
   - Laravel's built-in authentication
   - CSRF protection on all forms
   - Rate limiting on API endpoints
   - JWT tokens for API authentication

2. **Data Protection**:
   - Encrypted sensitive data (personal information, payment details)
   - HTTPS enforcement
   - SQL injection prevention (Eloquent ORM)
   - XSS protection
   - Input validation and sanitization

3. **Payment Security**:
   - PCI DSS compliance for payment handling
   - No storage of credit card details (tokenization)
   - Secure payment gateway integration

---

## ⚡ Performance Optimization

1. **Backend Optimization**:
   - Query optimization and indexing
   - Eager loading to prevent N+1 problems
   - Redis/Memcached for caching
   - Laravel Queue for background tasks
   - Database connection pooling

2. **Frontend Optimization**:
   - Asset minification and bundling (Vite)
   - Lazy loading for images
   - Code splitting
   - Browser caching strategies
   - CDN integration for static assets

---

## 📱 Responsive Design Breakpoints

- Mobile: 320px - 640px
- Tablet: 641px - 1024px
- Desktop: 1025px - 1440px
- Large Desktop: 1441px+

---

## 🧪 Testing Requirements

- Unit tests for core business logic
- Feature tests for critical user flows
- Browser testing (Chrome, Firefox, Safari, Edge)
- Mobile device testing (iOS, Android)
- Payment gateway testing (sandbox environment)

---

## 📦 Deliverables

1. Complete Laravel application source code
2. Database migration files and seeders
3. Installation and deployment documentation
4. API documentation (if applicable)
5. User manual for admin panel
6. Environment configuration examples (.env.example)

---

## 🚀 Optional Enhancements

- Multi-currency support
- Integration with external ticketing APIs
- Mobile application (React Native/Flutter)
- Advanced analytics with machine learning
- Customer loyalty program
- Travel itinerary builder
- Real-time seat availability (WebSocket integration)
- Booking modification system
- Group booking discounts
- Travel insurance integration

---

## 📋 Implementation Notes

- Follow Laravel best practices and coding standards (PSR-12)
- Use Eloquent ORM for all database operations
- Implement repository pattern for business logic
- Use Laravel's validation for all form inputs
- Create reusable Blade components
- Implement proper error handling and logging
- Use Laravel's localization for multi-language support readiness
- Ensure all Filament resources follow proper authorization policies

---

## 🎯 Success Criteria

- All core features functional and bug-free
- Responsive design working across all specified breakpoints
- Payment integration fully tested in sandbox
- Admin panel accessible with proper role-based permissions
- Application passing all security audit checks
- Page load time under 3 seconds on standard connections
- Successful booking completion rate > 95%