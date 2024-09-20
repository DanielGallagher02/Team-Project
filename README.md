# iHotel - Hotel Reservation System

Welcome to iHotel, a hotel reservation system developed as a group project as part of my final year project for the BSc in Computing. The system allows customers to search, compare, and book hotel rooms, while providing hotel staff with tools to manage reservations, customer data, and hotel services.

## Table of Contents
1. [Project Overview](#project-overview)
2. [Features](#features)
   - [Customer Side](#customer-side)
   - [Staff Side](#staff-side)
3. [Database Structure](#database-structure)
4. [Installation](#installation)
   - [Dependencies](#dependencies)
   - [Installing](#installing)
   - [Executing Program](#executing-program)
5. [Usage](#usage)
   - [Customer Portal](#customer-portal)
   - [Staff Portal](#staff-portal)
6. [Contributors](#contributors)
7. [License](#license)

## Project Overview

The iHotel system aims to improve the hotel booking experience by providing customers with an easy-to-navigate platform and real-time room availability. It also simplifies hotel staff's ability to manage bookings, customer information, and additional services.

This project was developed using:
* **PHP** for server-side logic
* **MySQL** for database management
* **HTML, CSS, and JavaScript** for the front-end
* **Apache (XAMPP/WAMP)** as the web server

The platform was developed using an agile approach, focusing on customer and staff requirements, with scalability in mind.

## Features

### Customer Side
* **User Registration & Login**: Customers can create accounts, log in, and manage their profiles.
* **Room Booking**: Real-time room availability based on check-in and check-out dates. Customers can view rooms and book their stays.
* **Extras Management**: Customers can add additional services such as room service, car rentals, etc., during their booking.
* **View Reservations**: Customers can view their booking history and details of upcoming reservations.
* **Secure Payments**: A dummy payment system is integrated for processing credit card information.
* **Review System**: After completing their stay, customers can leave reviews and ratings for the hotel.

### Staff Side
* **Login System**: Staff members can securely log in to manage hotel operations.
* **Room Management**: Staff can add, update, and delete rooms from the system.
* **Reservation Management**: Staff can view, modify, and cancel customer reservations. The check-in/check-out system helps manage guest flow.
* **Extras Management**: Staff can update the list of extras available for booking.
* **Customer Interaction**: Staff can access customer profiles and assist with their reservations.

## Database Structure

The system uses a well-structured **MySQL** database to store customer, room, reservation, and staff information. Below is an overview of the main database tables:

* **customer**: Stores customer details, including login info, personal details, and credit card info.
* **reservation**: Manages booking details such as room number, check-in and check-out dates, and customer ID.
* **booked_extras**: Links extras to reservations, allowing customers to customize their stay.
* **extra_list**: Contains a predefined list of available extra services (e.g., room service, car rentals).
* **review**: Stores customer reviews and ratings.
* **room**: Stores room information such as room type, price, and availability.
* **staff**: Manages hotel staff login credentials and personal information.

```sql
-- Example: Table structure for 'customer'
CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerLogin` varchar(32) NOT NULL,
  `CustomerPassword` varchar(32) NOT NULL,
  `CustomerEmail` varchar(32) NOT NULL,
  `CustomerName` varchar(32) NOT NULL,
  `CustomerSurname` varchar(32) NOT NULL,
  `CustomerPhoneNum` varchar(32) NOT NULL,
  `CreditCard` varchar(32) DEFAULT NULL,
  `CreditCardExpire` varchar(8) DEFAULT NULL,
  `CreditCardSecurity` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Installation 

## Dependencies 
- XAMPP or WAMP server
- PHP 7.x or higher
- MYSQL 5.x or higher
- Web browser (e.g., Chrome, Firefox)

## Installing
1. **Clone the Repository:**

2. **Set Up the Database:**
   - Import the SQL dump file (`hotel.sql`) into your MySQL database using phpMyAdmin or the MySQL       command line:
     ```bash
     mysql -u yourusername -p hotel < hotel.sql
     ```
3. **Configure the Database Connection:**
   - Update the database connection settings in the `config.php` file with your local database          details:
     ```php
     $dbHost = 'localhost';
     $dbUsername = 'root';
     $dbPassword = '';
     $dbName = 'hotel';
     ```
     
4. **Set up a Local Web Server:**
   - Move the project files to the `htdocs` directory (for XAMPP) or `www` directory (for WAMP).
   - Start your Apache and MySQL services.

### Excuting Program

1. **Run the Application:**
   - Open your web browser and navigate to:
   ```
   http://localhost/ihotel
   ```

2. **Log in as a customer or staff member** using your credentials

## Usage

### Customer Portal

- **Room Availability**: Customers input check-in and check-out dates to see available rooms.
- **Booking**: After selecting a room, customers can proceed with booking and add extra services if desired.
- **Manage Bookings**: Customers can view, modify, or cancel their reservations.
- **Leave Reviews**: After their stay, customers can leave reviews for their experience.

### Staff Portal

- **Manage Rooms**: Staff members can add, edit, or remove room listings.
- **Manage Reservations**: View, modify, or cancel customer reservations.
- **Check-In/Check-Out**: Staff can manage guest check-in and check-out processes.
- **Manage Extras**: Staff can update and manage additional services (extras) available for booking.

## Contributors

- **Daniel Gallagher** - Back-End Developer responsible for the booking and reservation system.
- **Oksana Aleksandrovica** - Front-End Developer responsible for UI design and customer login systems.
- **Eryk Gloginski** - Full Stack Developer focused on room management and database design.
- **Donal McGinty** - Full Stack Developer contributing to check-in/check-out system and form validation.

## License

This project is licensed under the MIT License - see the LICENSE.md file for details.   


     

