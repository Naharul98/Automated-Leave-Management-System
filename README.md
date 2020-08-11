# Automated-Leave-Management-System
An automated system which checks holidays requested by employees, against a set of constraints and automatically approves/rejects and suggests alternative dates.

## Features
- Employees are able to submit holiday requests through the website
- They are also able to view list of previous holiday requests which also shows whether they were approved/rejected.
- When a holiday request is made by the employee
  - The system checks the profile of the employee and runs the holiday request against a set of constraint set by the system admin
  - Automatically approves or rejects the request based on the constraint.
  - Should a request get rejected, the employee is automatically informed of the reason on the spot.
  - In addition, nearest available alternative holiday dates are suggested (automatically) which does not break constraints.
- The application features a manager side, through which, the manager of the organization is able to monitor the system and view various reports.

### Running the website from source
To run the development version of the application, you must have composer (https://getcomposer.org) installed. After this, ensure you are in the project directory and run:

> composer install

After this, simply run the following command, and keep the terminal running: 

> php artisan serve

This will give an url, usually http://localhost:8000, which you can copy and paste into the browser to start the application.

### Running the tests from source
Ensure you are in the project directory and run and simply run the following command, and keep the terminal running:
> php artisan serve
 
This will give an url, usually http://localhost:8000, which you can copy and paste into the browser to start the application.
 
To run the tests, again ensure you have composer installed and php artisan serve running, then execute:
 
> vendor\bin\codecept run
 
This will run all the tests we have available, including all: unit, functional and acceptance tests. Bear in mind this can be quite time consuming and can last up to 5 minutes.

Please note that the acceptance tests will fail unless you have another copy of command prompt running php artisan serve in the background.

## API and Frameworks used
* [Bootstrap 4](https://getbootstrap.com)
* [Laravel](https://laravel.com)
* [Bootstrap select picker](https://developer.snapappointments.com/bootstrap-select/)
* [Codeception](https://codeception.com)
