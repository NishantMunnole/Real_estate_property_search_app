# Real Estate Listing Platform with AI Integration

A mini Real Estate Listing Platform built using PHP, MySQL, Bootstrap 5, AJAX, and AI API integration.

The application allows users to browse properties, view property details, and send enquiries. Administrators can securely manage properties, enquiries, and AI-powered content generation through the admin panel.

## Features-

- Public Website
- Home Page
- Property listing cards
- Featured image display
- Property price display
- Property type display
- City display
- View Details functionality
- Property Detail Page
- Full description
- Enquiry button
- AJAX Enquiry System
- Bootstrap Modal popup
- AJAX form submission
- Client-side validation
- Server-side validation
- Success/Error messages without page reload
- Admin Panel
- Authentication
- Secure Admin Login
- Logout functionality
- Property Management
  - Add Property
  - Edit Property
  - Delete Property
  - View Properties
- Enquiry Management
  - View all enquiries
  - Customer information
  - Property reference
  - Enquiry messages
- AI Property Description Generator
- Responsive design for desktop, tablet, and mobile devices
- Loading state while fetching data
- Clean and user-friendly interface

### AI Property Description Generator

Generate professional property descriptions automatically using AI.

Admin enters:

- Property Title
- Property Type
- City

AI generates:

- Professional Property Description

## Tech Stack-

- Frontend-
  - HTML5
  - CSS3
  - JavaScript
- Backend-
  - Laravel
- Database-
  - MySQL
- Other Libraries-
  - Bootstrap 5
  - jQuery
  - Tailwind CSS
  - AJAX
- AI-
  - Gemini AI

### Bonus Features Implemented-

- Search By City
- Delete Confirmation Popup
- Bootstrap 5 UI

## Setup Instructions

### Prerequisites

Before setting up the project, ensure the following software is installed on your system:

- XAMPP (Apache, PHP, and MySQL)
- Composer
- npm

Step 1: Install XAMPP

- Download and install XAMPP.
- Ensure that Apache, PHP, and MySQL are included during installation.
- Start the Apache service from the XAMPP Control Panel.

Step 2: Extract the Project

- Download the ZIP file provided with the submission:
  - Real_estate_property_search_app_feature_first_draft.zip
- Extract the ZIP file to your local machine.

Step 3: Place the Project in the XAMPP Directory

- After extraction, locate the project folder and copy it to:

```
  C:\xampp\htdocs\
```

- The final project structure should look like:

```
  C:\xampp\htdocs\Real_estate_property_search_app_feature_first_draft
```

Step 4: Install Composer

- Download Composer from:

```
https://getcomposer.org/download/
```

- Download and run Composer-Setup.exe.
- Complete the installation using the default settings.
- Composer should automatically detect the PHP installation from XAMPP.

Step 5: Enable ZIP Extension

- Open the XAMPP Control Panel.
- Navigate to:
- Apache → Config → php.ini
- Search for:
  "extension=zip"
- Uncomment the line:
  "extension=zip"
- Save the file.
- Restart Apache from the XAMPP Control Panel.

Step 6: Install Project Dependencies

- Open Command Prompt.
- Navigate to the project directory:

```
  cd C:\xampp\htdocs\Real_estate_property_search_app_feature_first_draft
```

- Run the following command:

```
  composer install
  npm install
```

- Wait for Composer to install all required dependencies.
- Verify that a vendor folder has been created in the project root directory.

Step 7: Create .env

- Open Command Prompt.
- Navigate to the root project directory:

```
copy .env.example .env
php artisan key:generate
```

Step 8: Create database

- Open Command Prompt
- run the below commands:

```
cd C:\xampp\mysql\bin
mysql -u root -p
CREATE DATABASE real_estate_db;
```

Step 9: Configure Database in .env

- Open .env file
- Comment out "DB_CONNECTION=sqlite"
- Paste the below commands-

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=real_estate_db
DB_USERNAME=root
DB_PASSWORD=
```

Step 10: Add Missing folders

- Open Command Prompt.
- Navigate to the root project directory
- Run below commands to add missing Files

```
mkdir storage\framework\views
mkdir storage\framework\cache
mkdir storage\framework\sessions
mkdir bootstrap\cache
```

Step 11: Run migration

- Open Command Prompt.
- Navigate to the root project directory

```
php artisan migrate --seed
```

Step 12: Build frontend assets

- Open Command Prompt.
- Navigate to the root project directory
- Run below command-

```
npm run build
```

Step 12: Serve the application

- Open Command Prompt.
- Navigate to the root project directory
- Run below command-

```
php artisan serve
```

### API Key Configuration

Step 1: Download & Install Gemini

- Open Command Prompt.
- Navigate to the root project directory:

```
composer require google-gemini-php/laravel
```

Step 2: Configure Environment Variables

- Go inside the project root directory:

```
C:\xampp\htdocs\Real_estate_property_search_app_feature_first_draft\.env
```

- Once installing gemini at the end of .env file get to see "GEMINI_API_KEY=" variable created, Copy the environment variables provided in the email there

```
TEST 1 (Environment Variable)
```

- Paste the contents into the .env file and save it.

### Running the Application

- After completing the setup and configuration steps:
  - Ensure Apache is running in XAMPP.

Done?

Congratulations, your setup is ready and you can access the application locally just by entering "http://127.0.0.1:8000" in browser.

## Troubleshooting

- Ensure Apache is running before accessing the application.
- Verify that Composer and npm dependencies have been installed successfully.
- Confirm that the .env file exists and contains the required configuration values.
- Restart Apache after making changes to php.ini.

## Author

Nishant Munnole

Email: munnolenishant@gmail.com

License

This project is developed as part of a technical assessment and is intended for evaluation purposes only.
