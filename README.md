# iHotel - Hotel Reservation System

Welcome to iHotel, a hotel reservation system developed as part of a final year project for the BSc in Computing. The system allows customers to search, compare, and book hotel rooms, while providing hotel staff with tools to manage reservations, customer data, and hotel services.

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

