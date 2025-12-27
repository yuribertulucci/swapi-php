# API Use Documentation

## Overview
This document provides an overview of how to use the Star Wars API Wrapper to fetch data about characters, planets, starships, vehicles, species, and films from the Star Wars universe.

## Prerequisites
- Ensure you have access to the Star Wars API (SWAPI).
- Familiarity with making HTTP requests.
- Basic understanding of JSON data format.

## Swagger UI
You can explore the API endpoints and their documentation using the Swagger UI. If you have set up the application using Docker, you can access the Swagger UI at:
```
http://localhost:{APP_PORT}/swagger
```
Replace `{APP_PORT}` with the port number specified in your `.env` file (default is 8010).

## API Endpoints

Every endpoint is prefixed with the string set in the [Routes Config FIle](../config/routes.php) under the key `prefix` => `api`.

It also includes the preset `v1` following the prefix set on the [API Routes Definition File](../routes/api.php).

The following endpoints are available to fetch data:
- `/films/`: Fetch data about films.
- `/films/{id}/`: Fetch data about a specific film by ID.
- `/films/search?query={query}`: Search for films by title or property.
- `/people/`: Fetch data about characters.
- `/people/{id}/`: Fetch data about a specific character by ID.
- `/people/search?query={query}`: Search for characters by name or property.
- `/planets/`: Fetch data about planets.
- `/planets/{id}/`: Fetch data about a specific planet by ID.
- `/planets/search?query={query}`: Search for planets by name or property.
- `/species/`: Fetch data about species.
- `/species/{id}/`: Fetch data about a specific species by ID.
- `/species/search?query={query}`: Search for species by name or property.
- `/starships/`: Fetch data about starships.
- `/starships/{id}/`: Fetch data about a specific starship by ID.
- `/starships/search?query={query}`: Search for starships by name or property
- `/vehicles/`: Fetch data about vehicles.
- `/vehicles/{id}/`: Fetch data about a specific vehicle by ID.
- `/vehicles/search?query={query}`: Search for vehicles by name or property.