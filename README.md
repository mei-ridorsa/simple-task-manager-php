# Simple task manager
This project implements a simple task manager using Symfony.

## How to use

This project is made using PHP 8.1, so make sure you have that version of PHP installed. You also will need to have Composer installed, and you will need to run `composer install` in the root of the project. If you have any trouble, you can check: https://symfony.com/doc/current/setup.html.

This application is console based. The user has the following commands available:

Output a table listing all the tasks:

    bin/console task-manager:list-tasks

Create a new task:

    task-manager:create-task *title* *description* *due_date*
* Please note that the due date must be in format dd-mm-yyy

Delete a task:

    bin/console task-manager:delete-task *id*
Edit a task:

    bin/console task-manager:change-title *id* *title*
    bin/console task-manager:change-description *id* *description*
    bin/console task-manager:change-duedate *id* *due_date*
    bin/console task-manager:mark-completed *id*

* Please note that the due date must be in format dd-mm-yyy

## Project structure
This project is structured following Domain Driven Design principles. As the application is very small, there is only one bounded context (Manager) and a Domain (Task). This domain is divided in the three common DDD layers:
* Application: This layer contains the use cases of creating, updating and removing tasks.
* Domain: Here live the definition of the aggregate Root, the value objects, the repository interface and the exceptions.
* Infrastructure: Here live the persistence implementation (more on that in the next section) and the different Symfony commands.

## Persistence
Tasks are persisted in a CSV file located in the root of the project called `input.csv`. As a result, repository methods are a bit inefficient. For instance, the `remove` function creates a whole new file with all the records but the one being deleted. This is not ideal, but it's no issue with a project this size.

## Testing
Unit tests can be run using `php bin/phpunit`