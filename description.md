# Musanze Market Dashboard

A web-based inventory and order management system designed for Musanze Market suppliers and traders. This application allows users to manage suppliers, create orders, generate receipts, and track activity history efficiently.

## Features

- **User Authentication**: Secure login and registration system.
- **Supplier Management**: Add, update, delete, and search for suppliers.
- **Order Processing**: Create orders, calculate totals automatically, and manage order history.
- **Receipt Generation**: Generate and print receipts for specific orders.
- **Activity History**: Track all user actions (logins, updates, deletions) for accountability.
- **Responsive Design**: Fully functional on both desktop and mobile devices.

## Tech Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Server Environment**: XAMPP (Apache)
- 

## Setup Instructions

## Deployment (InfinityFree)

To host this project on InfinityFree:

1. **Create an Account**:

   - Go to InfinityFree and sign up.
   - Verify your email address to activate your profile.

2. **Created a Hosting Account**:

   - Log in to the InfinityFree client area and click **"Create Account"**.
   - **Choose a Domain**: Selected a free subdomain (e.g., `musanzemarket.infinityfree.com`).
   - **Account Details**: They provide u with a unique password and click "Create Account".
   - Wait a few minutes for the account to be available.

3. **Upload Files**:

   - Open the **"File Manager"** from the control panel.
   - Navigate to the `htdocs` directory.
   - Delete the default `index2.html` file.
   - Upload all files from your local project folder to `htdocs`.

4. **Database Setup**:

   - Go to the Control Panel -&gt; **MySQL Databases**.
   - Create a new database (e.g., `markertorderslip`).
   - **Important**: Note the **MySQL Host Name**, **Database Name**, **MySQL User Name**, and **Password** are given to you in this section.
   - Click **"Admin"** to open phpMyAdmin and import your local database SQL file.

5. **Update Configuration**:

   - In the File Manager, edit `connect.php`.
   - Replace the local credentials (`localhost`, `root`, etc.) with the InfinityFree credentials provided to you in Step 4.

## AI Assistance in Development

This project was developed with the assistance of AI coding tools (such as GitHub Copilot and Gemini). These tools were utilized to enhance productivity and code quality in the following ways:

### 1. Testing

AI tools helped ensure the application is robust by suggesting testing strategies:

- **Scenario Generation**: AI suggested various user flows to test, such as attempting to access the dashboard without logging in (security testing).
- **Input Validation**: Assisted in identifying edge cases, such as entering negative numbers for order quantities or special characters in supplier names, ensuring the application handles them gracefully.

### 2. Debugging

AI acted as a pair programmer to troubleshoot issues:

- **Error Analysis**: When PHP or SQL errors occurred, AI tools analyzed the error messages to pinpoint the exact line and cause (e.g., syntax errors in SQL queries).
- **Logic Fixes**: Helped resolve issues where the "Update" function was not pre-filling data correctly or where the sidebar navigation was not closing on mobile devices.

### 3. The "Meaning of Things" (Code Explanation)

AI was used as an educational resource to understand the underlying concepts:

- **Security Functions**: Explained the purpose of functions like `password_hash()` and `mysqli_real_escape_string()`, clarifying *why* they are necessary for preventing SQL injection and securing user data.
- **CSS Layouts**: Explained how specific CSS properties (like `flex-direction` and `z-index`) work to create the responsive sidebar and modal overlays.
- **Session Management**: Clarified how `session_start()` works and how to prevent browser caching so users cannot click "Back" after logging out