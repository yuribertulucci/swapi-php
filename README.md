# Star Wars API Wrapper
This is a simple PHP wrapper for the Star Wars API (SWAPI) with an interface that allows you to easily fetch and see
data about Star Wars characters, planets, starships, and more.

Made based on an interview assignment to demonstrate PHP skills and API integration.

## Features
- Fetch data about characters, planets, starships, vehicles, species, and films from the Star Wars universe.
- Easy-to-use functions to get specific information.
- Handles API requests and responses.

## API Documentation
For detailed information on how to use the API endpoints, please refer to the [API Use Documentation](docs/api_use_documentation.md) document.

There also is a Swagger UI available to explore the API endpoints and their documentation.
If you have set up the application using Docker, you can access the Swagger UI at:
```
http://localhost:{APP_PORT}/swagger
```
Replace `{APP_PORT}` with the port number specified in your `.env` file (default is 8010).

## Improvements Made
This project has undergone some improvements from the base assignment.
For a detailed list of the improvements made, please refer to the [Improvements Made Document](docs/improvements.md) (written in portuguese for the interviewer).

## Running the Code
For more detailed installation instructions, please refer to the [Detailed Installation Instructions](docs/detailed_installation_instructions.md) document.

### Prerequisites
- Docker (for Docker instructions)
- PHP and Composer (for local instructions)
- Internet connection to access the SWAPI
- Env file with necessary configurations (if applicable)
- Terminal or command prompt access

### Docker Instructions
1. Make sure you have Docker installed on your machine.
2. Clone this repository to your local machine.
3. Navigate to the project directory in your terminal.
4. Run the compose command to build and start the Docker container:
```bash
 docker compose up --build
 ```
5. Once the container is running, you can access the application as specified in the project documentation.

### Local Instructions
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
