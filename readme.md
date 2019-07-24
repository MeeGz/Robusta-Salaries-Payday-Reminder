# Robusta Salary Reminder #

## Documentation, Instructions and UserGuide ##
This is a simple application that helps companies to not forget to pay for their employees :D

App reminds admins by sending emails before 2 days of any payment for employees contain payment details which if it is bonus or salary payment and amount and also it STORE data into database to overcome adding new employees effect from calculating bonus for previous month and to get history of payment also.

To enable sending remindering emails cron service must be enabled and add this job to it
```
* * * * * cd /path/to/project/directory && php artisan schedule:run >> /dev/null 2>&1
```
DO NOT FORGET to enable cron service 

DO NOT FORGET to add .env file configurations
```
APP_URL={url}
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={database_name}
DB_USERNAME={database_user}
DB_PASSWORD={database_password}
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME={email}
MAIL_PASSWORD={app_password}
MAIL_ENCRYPTION=tls
```
Or any other alternatives.

After pulling you must run these commands
```
composer install
php artisan migrate
php artisan passport:install
```

Now, you are ready to go :)

## Authentication ##
In this app user default authentication is overridden with custom auth via view due to email and password are in separated tables.

We have here FULL auth Functions with passport package (without registrations as it is not a right way to make any employee or admin to add himself in this system but admins to add them)

There is an admin inserted via migration and after running migration command (php artisan migrate) you can login with this account.

### default admin authentication ###
```
email: meegz.mm@gmail.com
password: strong_secret_password
```
After successfully login you will get access token (that is VERY IMPORTANT to import in every single request except authentication APIs)

Logout feature that destroys the token from database.

Forgot password feature that sends an email for your email account and follow steps to reset password via link passed into email.


## APIs ##
There is file Robusta-Salary-Reminder.postman_collection.json which conains examples for all APIs installed in this app.<br>
For responses, You will get the standard codes like (200 - 400 - 401 - 403 - 404) amd messages if needed

### Auth ###
#### Login ####
```
post: {app_url}api/v1.0/login
body:
{
    "email": {email},
    "password": {password}
}
success response - code: 200:
{
    "id": {id},
    "name": {name},
    "email": {email},
    "token": {token}
}
```

#### Logout ####
```
post: {app_url}api/v1.0/logout
header:
{
    "token": "bearer token",
    "Accept": "application/json"
}
success response - code: 200:
{null}
```

#### Forgot Password ####
```
post: {app_url}api/v1.0/password/email
body:
{
    "email": {email}
}
success response - code: 200:
{null}
```

### BEARER TOKEN MUST BE INCLUDED IN ALL REQUESTS BELOW ###

### Employees ###
#### Get All Employees ####
```
get: {app_url}api/v1.0/employees
success response - code: 200:
[
    {
        "user_id": {user_id},
        "salary": {salary},
        "bonus_rate": {bonus_rate},
        "user": {
            "id": {id},
            "name": {name},
            "email": {email}
        }
    },
    {
        "user_id": {user_id},
        "salary": {salary},
        "bonus_rate": {bonus_rate},
        "user": {
            "id": {id},
            "name": {name},
            "email": {email}
        }
    }
]
```
#### Set Employee ####
```
post: {app_url}api/v1.0/employees
body:
{
    "name": {name},
    "email": {email},
    "salary": {salary},
    "bonus_rate": {rate}
}
success response - code: 200:
{null}
```

#### Get an Employee ####
```
get: {app_url}api/v1.0/employees/{user_id}
success response - code: 200:
{
    "user_id": {user_id},
    "salary": {salary},
    "bonus_rate": {bonus_rate},
    "user": {
        "id": {id},
        "name": {name},
        "email": {email}
    }
}
```
#### Update an Employee ####
```
put: {app_url}api/v1.0/employees/user_{id}
body:
{
    "name": {name},
    "email": {email},
    "salary": {salary},
    "bonus_rate": {rate}
}
success response - code: 200:
{null}
```
#### Delete an Employee ####
```
delete: {app_url}api/v1.0/employees/user_{id}
success response - code: 200:
{null}
```
### Admins ###
#### Get All Admins ####
```
get: {app_url}api/v1.0/admins
success response - code: 200:
[
    {
        "user_id": {user_id},
        "user": {
            "id": {id},
            "name": {name},
            "email": {email}
        }
    },
    {
        "user_id": {user_id},
        "user": {
            "id": {id},
            "name": {name},
            "email": {email}
        }
    }
]
```
#### Set Admin ####
```
post: {app_url}api/v1.0/admins
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
success response - code: 200:
{null}
```

#### Get an Admin ####
```
get: {app_url}api/v1.0/admins/{user_id}
success response - code: 200:
{
    "user_id": {user_id},
    "user": {
        "id": {id},
        "name": {name},
        "email": {email}
    }
}
```
#### Update an Admin ####
```
put: {app_url}api/v1.0/admins/{user_id}
body:
{
    "name": {name},
    "email": {email},
    "password": {password}
}
success response - code: 200:
{null}
```

#### Delete an Admin ####
When success the delete admin's token will be destroyed to not be able to use if again
```
delete: {app_url}api/v1.0/admins/{user_id}
success response - code: 200:
{null}
```
### Payments ###
#### Get All Stored Payments ####
All stored payments
```
get: {app_url}api/v1.0/payments
success response - code: 200:
[
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    },
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    }
]
```
#### Get All Stored Payments for this year and the remainder till end of this year ####
All stored payments and coming till end of this year
```
get: {app_url}api/v1.0/payments/year
success response - code: 200:
[
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    },
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    }
]
```
#### Get Remainder Payments for this year ####
Remainder payments from this month till end of the year
```
get: {app_url}api/v1.0/payments/year/remainder
success response - code: 200:
[
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    },
    {
        "month": {month},
        "salaries_total": {salaries_total},
        "salaries_payment_day": {salaries_payment_day},
        "bonus_total": {bonus_total},
        "bonus_payment_day": {bonus_payment_day},
        "payments_total": {payments_total}
    }
]
```

### Notes ###
There is no need to add admin middleware as it's already separated by database tables
