# HNGx CRUD API Documentation

Welcome to the CRUD API documentation Laravel application. This API allows you to Create, Read, Update, and Delete user records.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [API Endpoints](#api-endpoints)
- [Request and Response Formats](#request-and-response-formats)
- [Sample Usage](#sample-usage)

## Getting Started

### Prerequisites

Before you start, make sure you have the following prerequisites installed on your system:

- PHP (>= 7.4)
- Composer
- Laravel (>= 8.x)
- Database (e.g., MySQL, PostgreSQL)

### Installation

1. Clone this repository:

   ```bash
   git clone https://github.com/GoodnewsPerfect/HNGx-task2
   cd HNGx-task2 
   ```

2. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```
3. Create a .env file by copying the .env.example file and configure your database settings:
    ```bash
    cp .env.example .env
    ```
    Configure the database config variables as follows:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```
4. Run the migrations:
    ```bash
    php artisan migrate
    ```
5. Start the development server:
    ```bash
    php artisan serve

    ```
    Laravel API is now up and running on {127.0.0.1:8000} which is the base url!

### API Endpoints

### Request and Response Formats
The API uses JSON for both requests and responses. The following table describes the JSON format for the requests and responses:

<table>
    <thead>
        <th> Requests </th>
        <th> Response </th>
    </thead>
    <tbody>
        <tr>
            <td>POST /api</td>
            <td>201 Created with the newly created user in the response body</td>
        </tr>
        <tr>
            <td>GET /api</td>
            <td>200 OK with an array of users in the response body.</td>
        </tr>
        <tr>
            <td>GET /api/{id}</td>
            <td>200 OK with the user with the specified id in the response body.</td>
        </tr>
        <tr>
            <td>PUT /api/{id}</td>
            <td>200 OK with the updated user in the response body.</td>
        </tr>
        <tr>
            <td>DELETE /api/{id}</td>
            <td>204 No Content</td>
        </tr>
    </tbody>
</table>

### Sample Usage

## Adding a new user (201 Created)

<img src="documentation/create.png" alt="Create new user" />

## Fetch a user detail (200 OK)

<img src="documentation/get.png" alt="fetch a user" />

## Modify the details of an existing user (200 OK)

<img src="documentation/update.png" alt="modify the details of an existing user" />

## Remove a user (204 No Content)

<img src="documentation/delete.png" alt="remove a user" />

## Fetch users (200 OK)

<img src="documentation/viewAll.png" alt="fetch all users" />