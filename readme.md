# Robusta Salary Reminder #

## Documentation and User Guide ##
This is a simple application that helps companies to not forget to pay for their employees :D

App reminds admins by sending emails before 2 days of any payment for employees contain payment details which if it is bonus or salary payment and amount and also it STORE data into database to overcome adding new employees effect from calculating bonus for previous month and to get history of payment also.

## Authentication ##
In this app user default authentication is overridden with custom auth via view email and password are in separated tables.

We have here FULL auth Functions with passport package (without registrations as it is not a right way to make any employee or admin to add himself in system)

There is an admin inserted via migration and after running migration command (php artisan migrate) you can login with this account.

**default admin authentication:**<br>
```javascript
email: meegz.mm@gmail.com
password: strong_secret_password
```
After successfully login you will get access token (that is VERY IMPORTANT to import in every single request except authentication APIs)

Logout feature that destroys the token from database.

Forgot password feature that sends an email for your email account and follow steps to reset password via link passed into email.


## APIs ##
There is file Robusta-Salary-Reminder.postman_collection.json which conains examples for all APIs installed in this app

### Login### <br>
```javascript
post: {app_url}api/v1.0/login
body:
{
	"email": {email},
	"password": "{password}"
}
```

### Logout### <br>
```javascript
post: {app_url}api/v1.0/logout
header:
{
    "token": "bearer token",
    "Accept": "application/json"
}
```

### Forgot Password### <br>
```javascript
post: {app_url}api/v1.0/password/email
body:
{
	"email": {email}
}
```

### BEARER TOKEN MUST BE INCLUDED IN ALL REQUESTS BELOW ###

### Employees###<br>
**Get All Employees:**<br>
```javascript
get: {app_url}api/v1.0/employees<br>
```
**Set Employee:**<br>
```javascript
post: {app_url}api/v1.0/employees
body:
{
    "name": {name},
    "email": {email},
    "salary": {salary},
    "bonus_rate": {rate},
}
```

**Get an Employee:**<br>
```javascript
get: {app_url}api/v1.0/employees/{id}
```
**Update an Employee:**<br>
```javascript
put: {app_url}api/v1.0/employees/{id}
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

### Admins###<br>
**Get All Admins:**<br>
```javascript
get: {app_url}api/v1.0/admins<br>
```
**Set Admin:**<br>
```javascript
post: {app_url}api/v1.0/admins
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
```

**Get an Admin:**<br>
```javascript
get: {app_url}api/v1.0/admins/{id}
```
**Update an Admin:**<br>
```javascript
put: {app_url}api/v1.0/admins/{id}
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
```

**Delete an Admin:**<br>
```javascript
delete: {app_url}api/v1.0/admins/{id}
```
### Payments###<br>
**Get All Stored Payments:**<br>
```javascript
get: {app_url}api/v1.0/payments
```
**Get All Stored Payments for this year and the remainder till end of this year:**<br>
```javascript
get: {app_url}api/v1.0/payments/year
```
**Get Remainder Payments for this year:**<br>
```javascript
get: {app_url}api/v1.0/payments/year/remainder
```


**Notes**
There is no need to add admin middleware as it's already separated by database tables