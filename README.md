<div align="center">
 <img  width="600" height="350" src="https://banners.beyondco.de/Parking%20Microservices.png?theme=dark&packageManager=&packageName=&pattern=formalInvitation&style=style_1&description=Parking+Lot+Management+Using+Microservices&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg" alt="Parking">
</div>

# Parking Microservices

Parking Management System Using Microservices Architecture

[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/built-with-swag.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/powered-by-black-magic.svg)](https://forthebadge.com)

## Local Development

This project uses
[Docker](https://docker.com) with [Docker Compose](https://docs.docker.com/compose/) to manage
its local development stack. For more detailed usage instructions take a look at
the [official documentation](https://docs.docker.com/compose/).

## Links

- **Auth Service** <https://auth.voyarge.ml>
- **Vehicles Service** <https://vehicles.voyarge.ml>
- **Registrations Service** <https://registrations.voyarge.ml>
- **Payments Management Service** <https://payments.voyarge.ml>

## Important
Each folder contains a Laravel Project, each of them must have its own .env files.

For testing just change the .env.example of each folder to .env

## Start the development servers

First we create a docker network called web

```shell
docker network create proxy 
```
Change de .env.example files to .env

```shell
cp .env.example .env 
```

After you can start de containers

```shell
docker-compose up -d
```

## Contact
If you found any problems, please contact me:
<a href="mailto:cativo23.kt@gmail.com">cativo23.kt@gmail.com</a>