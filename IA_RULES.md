# Universal AI Rules - TinyFrame

## Framework
TinyFrame 2.0.0

## Architecture Flow

Route
→ Middleware
→ Controller
→ Service
→ Model
→ Database
→ Service
→ Controller
→ View / JSON

## Folder Structure

/app
 ├── controllers
 ├── services
 ├── models
 ├── views
 ├── middlewares
 ├── libraries
 └── helpers.php

## CLI

Use generator:
- php create m Product
- php create s Product
- php create c Product
- php create mi Product
- php create li Product
- php create full Product

## Controllers

- Namespace App\Controllers
- Extend Core\Controller
- No SQL
- Use Services
- $req->verify()

## Services

- Business logic only
- Use Models

## Models

- Use Core\Databases\DB
- SQL only
- Prepared statements

## Routes
app/routes.php

## Security
- Validate input
- Sessions Core\Session
- JWT optional

## Forbidden
- No ORM
- No PDO
- No Laravel

## Docs
docs.html
