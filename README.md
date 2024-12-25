# Task Management Project

## Project Structure
This project consists of separate services located in the `app/Services` directory.  
Each service includes its own entities and is relatively isolated from the other services.

Tests for each service are placed in its respective `Tests` directory.  
To execute the tests, simply run the following command:
```bash
composer tests
```

---

## Service Explanations

### User Registration and Login
The logic for this section is located in the `app/Services/User` directory.

The following routes are defined for user registration and login:
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`

Various authentication approaches are supported in this project. For this implementation, I chose Laravel Sanctum to enhance my experience.

Tests related to authentication can be found in:  
`app/Services/User/Tests/Auth`

---

### Defining Access Levels
The resources and logic for defining access levels are located in the `app/Services/AccessLevel` directory.

While this project utilizes the Spatie package, I implemented a simplified custom approach to better illustrate the details of the process.

Four resources are used for access level management:
- `roles`
- `role_user`
- `permission`
- `role_permission`

The middleware `Services/AccessLevel/Http/MiddleWares/EnsureHasPermission.php`  
is responsible for verifying whether a user has the necessary permissions for the requested action.

This middleware is applied to all actions related to task creation. Permissions are cached until either a change occurs, causing a cache flush, or the cache expires naturally.

Assigning permission example:
```php
$role = Role::create(['title' => 'admin', 'description' => '']);  
$role->permissions()->create(['title' => 'can-create-task', 'description' => '']);  
$user->roles()->save($role);  
$user->hasPermission('can-create-task'); // true  
```

---

### Task Management
All logic for creating, updating, and deleting tasks is located in the `app/Services/Task` directory.  
Tests related to this functionality are in the `app/Services/Task/Tests` directory.

A user can create, edit, and delete tasks.

The related logic is in:  
`app/Services/Task/Http/Controllers/V1/TaskController.php`

And the routes are defined in:
`app/Services/Task/Routes/V1/routes.php`


Actions are defined outside the controller and include:
- Task creation
- Task editing
- Task deletion
- Retrieving a list of tasks with filters, search, and caching

Users can change a task's status via web services. Additionally, a better approach using the **State Design Pattern** is implemented, which, while not essential for this project, can be useful for more complex logic.  
This logic resides in:  
`app/Services/Task/Http/Controllers/V1/StateController.php`

The tests for this functionality are in:  
`app/Services/Task/Tests/TaskStateChangeTest.php`

---

### Logging
A custom logger service is implemented in `app/Services/Support/LoggerService`.

This logger listens for any event that implements the following contract:  
`app/Services/Support/LoggerService/Contracts/HasSensitiveLog.php`

Captured data is passed to the log repository for storage. The repository can handle additional processing, such as normalization, buffering, or asynchronous operations.

For example, the event `app/Services/Task/Events/TaskResourceModified.php` implements the `HasSensitiveLog` contract and is listened to by the logger.

This event is triggered by the observer `app/Services/Task/Models/Observers/TaskHistoryRecorder.php`, which tracks changes to tasks and logs details, including the user who made the modifications.

---

All defined web service endpoints in the system:

- `GET|HEAD    /api/user`
- `POST        /api/v1/auth/login`
- `POST        /api/v1/auth/logout`
- `POST        /api/v1/auth/register`
- `GET|HEAD    /api/v1/task`
- `POST        /api/v1/task`
- `GET|HEAD    /api/v1/task/create`
- `GET|HEAD    /api/v1/task/{task}`
- `PUT|PATCH   /api/v1/task/{task}`
- `DELETE      /api/v1/task/{task}`
- `GET|HEAD    /api/v1/task/{task}/edit`
- `POST        /api/v1/task/{task}/state/next`
- `POST        /api/v1/task/{task}/state/previous`
- `GET|HEAD    /api/v1/user`
- `PUT|PATCH   /api/v1/user`


## Docker Setup
To set up the project using Docker, navigate to the `laradock` directory and run:
```bash
docker-compose up -d nginx php-fpm redis postgres workspace
```  

The project will then be accessible at:  
[http://localhost](http://localhost)

---

## `.env` Configuration
```dotenv
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=secret_redis
REDIS_PORT=6379
```
