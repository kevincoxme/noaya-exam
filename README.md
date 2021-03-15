## Noaya Exam

### Instruction
When writing PHP and using the Laravel framework everything is prepared to write good and maintainable code based on the SOLID principle, with a TDD pattern.

We want you to record your screen while doing this task, and explain your choices.
You should write tests that verifies the requirements in this document

Initialize a new Laravel project.

We need two models with migrations,
Company and Employee with CRUD functionality
Companies DB table must have these fields:
·     Name (Required)
·     Email
·     Logo
·     Website

Employees DB Table must have these fields:
·     First name (required)
·     Last name (required)
·     Email
·     Phone
·     Is_active

A company can have multiple Employees.
A employee can log in to the application

Store the company logo in storage/app/public

Your task is to create an api, with the CRUD-endpoints. The “is_active” column must be 1 to be able to access the api. You don’t need to implement jwt-token, just use session based authentication on this.

When a user is created there must be sent an email with an automatic generated 8 character long password. You don’t have to style the email.

Upload the code to github, and share the link.

## Installation

Copy .env.example to .env file and setup the configuration. 
Run the following commands:

- composer install
- php artisan key:generate
- npm install && npm run dev
- php artisan migrate
- php artisan storage:link

## Deploy
- php artisan serve

## Login

To test the login feature navigate to http://127.0.0.1:8000/login.

