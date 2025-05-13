
## Claim-Service Project

## Overview

This project is a claim management system where users can create and manage claims in various formats such as text, image, video, and voice. The system is built with Docker to ensure easy deployment and consistent development environments. Docker will be used to manage both the application and the database, allowing you to set up the project locally without needing to install dependencies manually.

To make it easier to get started, all necessary services (including a database) are encapsulated in Docker containers.

## Installation

docker-compose up --build

## Run Migrations

docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

( http://127.0.0.1:8000 ) base_url 

Claims

GET  ------> /api/claims

POST  ------> /api/claims

GET  ------> /api/claims/{id}

PUT  ------> /api/claims/{id}

DELETE  ------> /api/claims/{id}

Reaction

POST  ------> /api/claims/{claim}/reactions

## The Address of Project

(  )
