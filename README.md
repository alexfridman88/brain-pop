<div style="text-align: center;">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</div>

<div style="text-align: center;">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</div>

https://github.com/alexfridman88/brain-pop

# Install

## Windows:

* Go to the docker folder and run `.\build.bat` file on your computer.
* Next, in same `docker` folder, run `docker compose up -d` command for install docker containers.
* After that, run `.\terminal.bat` to open the Docker command line (CLI).
* Inside Docker, run `composer install` to get what the project needs.
* Finally, run `php artisan migrate` in Docker CLI to set everything up.

## Mac:

* Go to the docker folder and
  run `docker run --rm -it -v ${PWD}/../:/var/www/html montebal/laradev:php80-2204 -c "composer install"` command.
* Next, in same `docker` folder, run `docker compose up -d` command for install docker containers.
* After that, run `- docker exec -it pop_api bash` to open the Docker command line (CLI).
* Inside Docker, run `composer install` to get what the project needs.
* Finally, run `php artisan migrate` in Docker CLI to set everything up.

### After install

* Change in the `.env` file line `DB_HOST=127.0.0.1` to `DB_HOST=mysql` line.
* Make a new database for this project and add it to `.env` as `DB_DATABASE=brain_pop`.

***

# API Documentation

## Register

### Register a new student (store)

    Description: Register a new student.

    POST /api/students

    Body Parameters:
    {
        "username": "string",
        "password": "min:6",
        "full_name": "string",
        "grade": "integer|between:0,12"
    }

    Response:
    {
        "message": "string"
    }


### Register a new teacher (store)

    Description: Register a new teacher.
    
    POST /api/teachers

    Body Parameters:
    {
        "username": "string",
        "password": "min:6",
        "full_name": "string",
        "email": "email"
    }

    Response:
    {
        "message": "string"
    }

    Status: 201

## Login

### Login as a student

    Description: Login as a student.

    POST /api/students/login
 
    Body Parameters:
    {
        "username": "string",
        "password": "min:6"
    }

    Response:
    {
        "token": "string",
        "full_name": "string",
    }

    Status: 200

### Login as a teacher

    Description: Login as a teacher.

    POST /api/teachers/login

    Body Parameters:
    {
        "username": "string",
        "password": "min:6"
    }

    Response:
    {
        "token": "string",
        "full_name": "string",
    }

    Status: 200

## Students Authenticated

### Get all students (index)

    Description: 
        * Get all students.
        * Send a `period_id` or/and `teacher_id` to get students by given period or/and teacher. 

    GET /api/students

    Authorization: Bearer {token}

    Query Parameters:
    {
        "period_id": "numeric",
        "teacher_id": "numeric",
    }

    Response:
    [
        {
            "id": "integer",
            "username": "string",
            "full_name": "string",
            "grade": "integer",
        }
    ]

    Status: 200

### Show a student (show)

    Description: Show a student by id.

    GET /api/students/{id}

    Authorization: Bearer {token}

    Response:
    {
        "id": "integer",
        "username": "string",
        "full_name": "string",
        "grade": "integer",
    }

    Status: 200

### Update a student (update)

    Description: Associated students can only update their own accounts.
    
    PUT /api/students/{id}

    Authorization: Bearer {token}

    Body Parameters:
    {
        "full_name": "string",
        "email": "between:1,12"
    }

    Response:
    {
        "message": "string"
    }

    Status: 200

### Delete a student (destroy)

    Description: Associated students can only delete their own accounts.

    DELETE /api/students/{id}

    Authorization: Bearer {token}

    Response:
    {
        "message": "string"
    }

    Status: 200

## Teachers Authenticated

### Get all teachers (index)

    Description: Get all teachers.

    GET /api/teachers

    Authorization: Bearer {token}

    Response:
    [
        {
            "id": "integer",
            "full_name": "string",
            "username": "string",
            "email": "string",
        }
    ]

    Status: 200

### Show a teacher (show)
    
    Description: Show a teacher by id.

    GET /api/teachers/{id}

    Authorization: Bearer {token}

    Response:
    {
        "id": "integer",
        "username": "string",
        "full_name": "string",
        "email": "string",
    }

    Status: 200

### Update a teacher (update)
    
    Description: Associated teachers can only update their own accounts.
    
    PUT /api/teachers/{id}

    Authorization: Bearer {token}

    Body Parameters:
    {
        "full_name": "string",
        "email": "between:1,12"
    }

    Response:
    {
        "message": "string"
    }

    Status: 200

### Delete a teacher (destroy)
    
    Description: Associated teachers can only delete their own accounts.

    DELETE /api/teachers/{id}

    Authorization: Bearer {token}

    Response:
    {
        "message": "string"
    }

    Status: 200

## Periods

### Get all periods (index)

    Description: 
        * Get all periods.
        * Send a `teacher_id` to get periods by teacher. 

    GET /api/periods

    Authorization: Bearer {token}

    Query Parameters:
    {
        "teacher_id": "numeric",
    }

    Response:
    [
        {
            "id": "integer",
            "name": "string",
            "teacher_id": "integer",
        }
    ]

    Status: 200

### Show a period (show)
    
    Description: Show a period by id.

    GET /api/periods/{id}

    Authorization: Bearer {token}

    Response:
    {
        "id": "integer",
        "name": "string",
        "teacher_id": "integer",
    }

    Status: 200

### Store a period (store)
    
    Description: New period instance is created and associated with the authorized teacher.

    POST /api/periods

    Authorization: Bearer {token}

    Body Parameters:
    {
        "name": "string",
    }

    Response:
    {
        "message": "string"
    }

    Status: 201

### Update a period (update)
    
    Description: Associated teachers can only update their own periods.
    
    PUT /api/periods/{id}

    Authorization: Bearer {token}

    Body Parameters:
    {
        "name": "string",
    }

    Response:
    {
        "message": "string"
    }

    Status: 200

### Delete a period (destroy)

    Description: Associated teachers can only delete their own periods.

    DELETE /api/periods/{id}

    Authorization: Bearer {token}

    Response:
    {
        "message": "string"
    }

    Status: 200

### Add a students to a period

    Description: Only Teacher can add a namy students or Student can add itself to period

    POST /api/periods/{id}/attach

    Authorization: Bearer {token}

    Body Parameters:
    {
        [
            'id': 'integer',
            'grade': 'integer|between:0,12',
        ],
    }

    Response:
    {
        "message": "string"
    }

    Status: 201

### Remove a students from a period
    
    Description: Only Teacher can remove a namy students or Student can remove itself from period

    POST /api/periods/{id}/detach

    Authorization: Bearer {token}

    Body Parameters:
    {
        [
            'id': 'integer',
            'grade': 'integer|between:0,12',
        ],
    }

    Response:
    {
        "message": "string"
    }

    Status: 200
