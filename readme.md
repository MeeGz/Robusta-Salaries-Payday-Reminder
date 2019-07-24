# Robusta Salary Reminder #

## Documentation and User Guide ##
============================
This is a simple application that helps companies to not forget to pay for their employees :D

App reminds admins by sending emails before 2 days of any payment for employees contain payment details which if it is bonus or salary payment and amount and also it STORE data into database to overcome adding new employees effect from calculating bonus for previous month and to get history of payment also.

## Authentication ##
==============
In this app user default authentication is overridden with custom auth via view email and password are in separated tables.

We have here FULL auth Functions with passport package (without registrations as it is not a right way to make any employee or admin to add himself in system)

There is an admin inserted via migration and after running migration command (php artisan migrate) you can login with this account.

default admin authentication:<br>
email: meegz.mm@gmail.com<br>
password: strong_secret_password<br>

After successfully login you will get access token (that is VERY IMPORTANT to import in every single request except authentication APIs)

Logout feature that destroys the token from database.

Forgot password feature that sends an email for your email account and follow steps to reset password via link passed into email.


## APIs ##
===
There is file Robusta-Salary-Reminder.postman_collection.json which conains examples for all APIs installed in this app

**Login:**<br>
post: {app_url}api/v1.0/login<br>
```javascript
body:
{
	"email": {email},
	"password": "{password}"
}
```

**Logout:**<br>
post: {app_url}api/v1.0/logout<br>
```javascript
header:
{
	"token": "bearer token",
    "Accept": "application/json"
}
```

**Forgot Password:**<br>
post: {app_url}api/v1.0/password/email<br>
```javascript
body:
{
	"email": {email}
}
```

**BEARER TOKEN MUST BE INCLUDED IN ALL REQUESTS BELOW**
===================================================

**Employees**
=========
**Get All Employees:**<br>
get: {app_url}api/v1.0/employees<br>

**Set Employee:**<br>
post: {app_url}api/v1.0/employees<br>
```javascript
body:
{
    "name": {name},
    "email": {email},
    "salary": {salary},
    "bonus_rate": {rate},
}
```

**Get an Employee:**<br>
get: {app_url}api/v1.0/employees/{id}<br>

**Update an Employee:**<br>
put: {app_url}api/v1.0/employees/{id}<br>
```javascript
body:
{
    "name": {name},
    "email": {email},
    "salary": {salary},
    "bonus_rate": {rate},
}
```

**Delete an Employee:**<br>
delete: {app_url}api/v1.0/employees/{id}<br>

**Admins**
=========
**Get All Admins:**<br>
get: {app_url}api/v1.0/admins<br>

**Set Admin:**<br>
post: {app_url}api/v1.0/admins<br>
```javascript
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
```

**Get an Admin:**<br>
get: {app_url}api/v1.0/admins/{id}<br>

**Update an Admin:**<br>
put: {app_url}api/v1.0/admins/{id}<br>
```javascript
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
```

**Delete an Admin:**<br>
delete: {app_url}api/v1.0/admins/{id}<br>

Payments
========
**Get All Stored Payments:**<br>
get: {app_url}api/v1.0/payments<br>

**Get All Stored Payments for this year and the remainder till end of this year:**<br>
get: {app_url}api/v1.0/payments/year<br>

**Get Remainder Payments for this year:**<br>
get: {app_url}api/v1.0/payments/year/remainder<br>



**Notes**
=====
There is no need to add admin middleware as it's already separated by database tables