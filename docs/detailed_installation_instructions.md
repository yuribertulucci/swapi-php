# Detailed Installation Instructions

## Prerequisites
- Docker installed on your machine (for Docker instructions)
- PHP and Composer installed on your machine (for local instructions)
- Internet connection to access the SWAPI
- Env file with necessary configurations (if applicable)
- Terminal or command prompt access

## Env File Setup
1. Copy the `.env.example` file to create a new `.env` file in the project root directory:
```bash
cp .env.example .env
```
2. Open the `.env` file in a text editor and configure any necessary settings, such as API keys or environment variables.
3. Save the changes to the `.env` file.

## Env File Details
### Application Environment
- `APP_PORT`: The port on which the application will run (default is 8010).
- `UID`: User ID for file permissions (default is 1000).
- `GID`: Group ID for file permissions (default is 1000).
- `SWAPI_URL`: The base URL for the Star Wars API (default is https://swapi.py4e.com/api/).
- `SWAGGER_PORT`: The port for the Swagger UI (default is 8080).
- `SWAGGER_FILE`: The path to the Swagger specification file (default is ./docs/swagger.yaml).
- `DEBUG`: Enable debug mode if set to 1 (optional, default is 0).
### Database Configuration
- `DB_DRIVER`: The database driver to use (default is mysql).
- `DB_HOST`: The database host (default is db for use within the docker network).
- `FORWARD_DB_PORT`: The port for database connection forwarding (default is 3372).
- `DB_USER`: The database username (default is staruser).
- `DB_PASSWORD`: The database password (default is starpassword).
- `DB_ROOT_PASSWORD`: The root password for the database (default is rootpassword).
- `DB_NAME`: The name of the database (default is starwarsdb).

## Docker Instructions
1. Make sure you have Docker installed on your machine.
2. Clone this repository to your local machine.
3. Navigate to the project directory in your terminal.
4. Run the compose command to build and start the Docker container:
```bash
docker compose up --build
```
5. Once the container is running, you can access the application in your web browser at `http://localhost:8010` (or the port you specified in the `.env` file).

## Local Instructions
1. Make sure you have PHP and Composer installed on your machine.
2. Clone this repository to your local machine.
3. Navigate to the project directory in your terminal.
4. Install the required dependencies using Composer:
```bash
composer install
```
5. Run the application using the PHP built-in server:
```bash
php -S localhost:8000
```
6. Open your web browser and go to `http://localhost:8000` to access the application.