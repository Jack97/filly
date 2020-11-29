# Filly

A simple placeholder image service built with Silex.

```
# 256x256
https://filly.jackrobertson.uk/256

# 1024x768
https://filly.jackrobertson.uk/1024/768
```

## Development Setup

### Requirements

* Docker Engine 19.03.0+
* Docker Compose

If you're developing on a Mac, you'll need to [configure native NFS to work with Docker](https://sean-handley.medium.com/how-to-set-up-docker-for-mac-with-native-nfs-145151458adc).

### Steps

1. Create a `.env` file in the project root.

    ```bash
    # Navigate the the repository
    cd /path/to/repository
   
    # Create the file
    cp .env.example .env
   
    # Update the file to reflect your local environment
    vim .env
    ```

2. Build and start the services.

    ```bash
    docker-compose up
    ```
   
   The app will be served on port `8080`.

## Run the tests

```
docker-compose exec app ./vendor/bin/phpunit
```

## Todo

* Automated deployments
* Homepage
