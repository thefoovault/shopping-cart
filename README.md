# Installation
Run `make build` in order to install all application dependencies (you must have Docker installed).

For more commands, type `make help`

# Basic usage

Once project is downloaded, we will execute:
- `make start`, to start the container.
- `make stop`, to stop the container.
- `make shell`, to use the interactive shell.

# How to use this app
This app allows interact with a shopping cart via REST-API.

Go to the `{PROJECT_FOLDER}/docs/endpoints/cart.http` file, and you'll find some prepared requests.
- If you are using `phpStorm`, the IDE will show a `Run all requests` option when opening the said file. You should run with `run with 'dev' environment`.
- If you prefer going with another HTTP client (like Postman or a web-browser), the file contains all the necessary information to help you to create your own requests.

## What about testing?
Simply execute `make test` to run all unit and integration tests. Please note this command needs the app to be turned on.

# Endpoints

|     Endpoint    | Verb |                                                                             Description                                                                            |
|:---------------|:----:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| /api/carts   | POST | Creates an empty cart                                                                                                                    |
| /api/carts{id}   | GET | Gets a cart                                                                                                                    |
| /api/carts{id}   | POST | Adds a product to a specific cart                                                                                                                    |
| /api/carts{id}   | DELETE | Deletes a cart                                                                                                                    |
| /api/carts{id}/items/{productId}   | PATCH | Changes product quantity in a specific cart                                                                                                                    |
