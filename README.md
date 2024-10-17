<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Task Manager

A simple task management application built with Laravel and Vue.js. This application allows users to create, update, delete, and manage tasks. Tasks can be filtered based on their status (pending or completed) and are paginated for easy navigation.

## Features

- User authentication
- Create, update, delete tasks
- Filter tasks by status (all, pending, completed)
- Pagination for tasks
- Responsive design

## Installation Guide

### Prerequisites

- PHP >= 7.3
- Composer
- Node.js & npm
- Git

### Steps

1. **Clone the repository**

   ```sh
   git clone https://github.com/Athukoralaa/task-mgr.git
   cd task-mgr

2. **Install PHP dependencies**
    
    ```bash
    composer install

3. **Install Node.js dependencies**
    
    ```bash
    npm install

4. **Copy the .env.example file to .env**

    ```bash
    cp .env.example .env

5. **Generate an application key**

    ```sh
    php artisan key:generate

6. **Configure your database**
    Update the .env file with your database credentials:

    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task-manager
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

7. **Run database migrations and seeders**
    Start the mysql server (Workbench or XAMP), then run

    ```sh
    php artisan migrate --seed

8. **Build the frontend assets**

    ```sh
    npm run dev

9. **Start the development server**

    ```sh
    php artisan serve
        `or`
    ```sh
    php -S localhost:8000 -t public

10. **Access the application**

    Open your browser and go to http://localhost:8000

### Usage

1. Register a new user or log in with an existing user.
    (Email Address:john@example.com     Password:password)
2. Create new tasks by clicking the "Create Task" button.
3. Edit or delete tasks using the buttons in the task list.
4. Filter tasks by clicking on the tabs (All, Pending, Completed).
5. Navigate through pages using the pagination controls.