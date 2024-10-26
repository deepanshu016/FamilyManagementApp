# FamilyManagement App Setup

This project is a Laravel application developed as part of a task assignment.

## Prerequisites

Before getting started, ensure that you have the following installed:
- **PHP** (version 8.0+)
- **Composer**
- **MySQL** or **MariaDB**

## Installation

Follow the steps below to clone and set up the project locally.

### 1. Clone the Repository

Clone this repository using the following command:

```bash
git clone https://github.com/deepanshu016/FamilyManagementApp.git
cd FamilyManagementApp
```
## Composer Installation
```bash
composer install
```
## Setup Basic Environment Variable
```bash
cp .env.example .env
php artisan key:generate
```



## DB migration
```bash
php artisan migrate
```

## RUN APP
```bash
php artisan serve
```



