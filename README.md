# Getting started

## Installation

Clone the repository

    git clone https://github.com/janehernandez/expense-manager.git

Switch to the repo folder

    cd expense-manager

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Optionally, if you want to seed your database with initial data:

    php artisan db:seed

Install Node dependencies

    npm install

Start the local development server

    npm run dev

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/janehernandez/expense-manager.git
    cd expense-manager
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan db:seed

**Install node dependencies**

    npm install
    npm run dev
