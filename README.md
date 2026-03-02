# Musanze Market Order Slip

## 1. Problem Statement & Stakeholders

### Problem Statement

Potato aggregators and cooperative collection points in Musanze face financial losses and operational inefficiencies. These issues stem from inaccurate order calculations (quantity multiplied by price), misplaced or lost receipts, disagreements that arise during pickup, and the use of disorganized paper-based or WhatsApp-based record-keeping.

### Stakeholders

*   **Potato Aggregators:** Buyers who purchase potatoes in bulk from farmers or cooperatives.
*   **Cooperative Collection Points:** Locations where farmers bring their produce to be sold.
*   **Farmers/Suppliers:** The producers of the potatoes.

## 2. User Stories & Acceptance Criteria

1.  **User Story:** As an aggregator, I want to register a new supplier so I can easily track who I am buying from.
    *   **Acceptance Criteria:**
        *   The system must allow me to enter a supplier's name and contact information.
        *   Each supplier must have a unique identifier.
        *   I should be able to see a list of all registered suppliers.

2.  **User Story:** As an aggregator, I want to create a new order so that I can record a transaction with a supplier.
    *   **Acceptance Criteria:**
        *   I can select a supplier from the registered list.
        *   I can input the quantity of potatoes and the unit price.
        *   The system must automatically calculate the total price.
        *   I can specify a pickup location for the order.

3.  **User Story:** As an aggregator, I want to view a printable receipt for each order so I have a physical record for the supplier.
    *   **Acceptance Criteria:**
        *   The receipt must show the supplier's name, order details (quantity, price, total), and pickup location.
        *   The receipt page should be simple and easy to print.

4.  **User Story:** As an aggregator, I want a dashboard to see a summary of today's business so I can quickly understand my daily operations.
    *   **Acceptance Criteria:**
        *   The dashboard must show the total number of orders created today.
        *   The dashboard must show the total value of all orders today.
        *   The dashboard must display a list of the most recent orders.

5.  **User Story:** As an aggregator, I need to log in to the system to ensure that my order data is private and secure.
    *   **Acceptance Criteria:**
        *   The system must have a login page with a username and password.
        *   Only authenticated users can access the order management pages.

6.  **User Story:** As a cooperative manager, I want to view all orders from my collection point to avoid disputes at pickup time.
    *   **Acceptance Criteria:**
        *   I can filter the order list by pickup location.
        *   The system shows me the same order details as the aggregator.

## 3. Scope, Out-of-Scope, & NFRs

### In Scope

*   User registration and login (for aggregators).
*   Supplier/farmer registration and management.
*   Creating new orders with automated total calculations.
*   Generating a printable receipt for each order.
*   A dashboard with daily statistics and recent orders.
*   Storing all order data in a MySQL database.

### Out-of-Scope

*   Payment processing or integration with payment gateways.
*   Inventory management for potatoes.
*   Complex reporting and analytics beyond the dashboard.
*   Real-time notifications or messaging.
*   Support for multiple languages.
*   User roles beyond a single "aggregator/admin" type.

### Non-Functional Requirements (NFRs)

*   **Security:** The application must be secure, protecting against common web vulnerabilities (e.g., SQL injection, XSS). User passwords must be hashed.
*   **Performance:** The application should load quickly, even on slower internet connections. Database queries must be optimized.
*   **Usability:** The interface should be simple, intuitive, and easy to use for non-technical users.
*   **Reliability:** The system should be available and function correctly during business hours. Totals must be calculated accurately.
*   **Maintainability:** The code should be well-structured and commented to allow for future development and maintenance.

## 4. Page Map / Navigation Flow

1.  **/login**: The user starts here. After successful login, they are redirected to the Dashboard.
2.  **/dashboard (Home)**:
    *   Displays today's total orders, total value, and a list of recent orders.
    *   Navigation links to:
        *   **Create Order**
        *   **View All Orders**
        *   **Manage Suppliers**
        *   **Logout**
3.  **/orders/new (Create Order Page)**:
    *   A form to create a new order.
    *   Fields: Supplier (dropdown), Quantity, Unit Price, Pickup Location.
    *   Auto-calculates the total.
    *   On submission, saves the order and redirects to the receipt page.
4.  **/orders/receipt?id={order_id} (Receipt Page)**:
    *   Displays the details of a specific order.
    *   Provides a "Print" button.
5.  **/orders (View All Orders Page)**:
    *   A table showing all past orders.
    *   Each row shows key order details and a link to the receipt.
6.  **/suppliers (Manage Suppliers Page)**:
    *   A list of all registered suppliers.
    *   A form to add a new supplier.
