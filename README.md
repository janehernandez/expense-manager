# Getting started

## Sample Screenshots
![image](https://github.com/janehernandez/expense-manager/assets/35588528/0944cef7-a480-45ce-850f-e5c0bfe07609)
![image](https://github.com/janehernandez/expense-manager/assets/35588528/9eb956af-71ad-480a-8820-4b1a1b50fba8)


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

You can now access the server at http://localhost:5173 by default

**TL;DR command list**

    git clone https://github.com/janehernandez/expense-manager.git
    cd expense-manager
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate

**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate
    php artisan db:seed

**Install node dependencies**

    npm install
    npm run dev
