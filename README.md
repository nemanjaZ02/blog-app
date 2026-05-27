# Blog App

A simple blog application built with Laravel REST API and Vue.js frontend, with Docker support.

## Requirements

- Docker Desktop
- Git

## Setup & Installation

1. Clone the repository:

```bash
git clone https://github.com/nemanjaZ02/blog-app.git
cd blog-app
```

2. Start Docker containers:

```bash
docker compose up --build
```

3. Open in browser:

```bash
http://localhost:3000
```

## Seeding

The database is seeded automatically on every `docker compose up` via a built-in script. To seed manually:

```bash
docker compose exec backend php artisan db:seed
```

## Running Tests

```bash
docker compose exec backend php artisan test
```

## Default Accounts

| Email | Password | Role |

| admin@example.com | password | Admin |

| alice@example.com | password | User |

| bob@example.com | password | User |

## Screenshots

<img width="1905" alt="1" src="https://github.com/user-attachments/assets/bff33c10-29fb-403b-8dd0-fcbc85e773a2" />
<img width="1905" alt="2" src="https://github.com/user-attachments/assets/9c81e118-0061-410b-90fd-6dfbc7ee1a9b" />
<img width="1905" alt="3" src="https://github.com/user-attachments/assets/0bf6a314-8d9b-4e41-a30e-a8546fb90dad" />
