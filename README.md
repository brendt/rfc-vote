# RFC Vote

[https://rfc.stitcher.io/](https://rfc.stitcher.io/)

This is a webapp meant to gather feedback on how RFCs are received in the PHP community.

## Local Development

> **Remember to run `composer qa` before committing a PR**

### Sail

The app supports Laravel Sail. See [docs](https://laravel.com/docs/10.x/sail#introduction) for details.

1. install dependency via docker
``` bash
docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php82-composer:latest \
   composer install --ignore-platform-reqs
   ```
2. copy `.env.example` to `.env`
    * fill `DB_USERNAME` and `DB_PASSWORD` fields with your custom values.
3. run `./vendor/bin/sail up -d`
4. run `./vendor/bin/sail artisan key:generate`
5. run `./vendor/bin/sail npm install && npm run build`
6. run `./vendor/bin/sail artisan migrate:fresh --seed`

### browsershot
For `browsershot` to work properly add the following in `.env` file:
```dotenv
CHROME_BINARY_PATH=/usr/bin/google-chrome-stable
NODE_BINARY_PATH=/usr/bin/node
NPM_BINARY_PATH=/usr/bin/npm
```
### macOS
For macOS (If you want to use Google Chrome):
```dotenv
CHROME_BINARY_PATH="/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"
```
### horizon
For horizon to work properly make sure that you have the following in `.env` file:
```dotenv
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# And the following as well
QUEUE_CONNECTION=redis
```
# Laravel Dusk

### Setting Laravel Dusk with Sail
Please follow the official docs for [Laravel Dusk](https://laravel.com/docs/10.x/dusk) and also look at
the specific documentation on Sail page for [Laravel Dusk](https://laravel.com/docs/10.x/sail#laravel-dusk)

1. **Environment Configuration**:

    In your `.env` file, add the following line:

    ```dotenv
    # For Apple Silicon (m1, m2) replace the value with seleniarm/standalone-chromium, see https://laravel.com/docs/10.x/sail#laravel-dusk for more details
    SELENIUM_IMAGE=selenium/standalone-chrome
    ```
   This enables the choice of selenium image as per your system's architecture. For more context on this, please refer to [this PR discussion](https://github.com/brendt/rfc-vote/pull/234#issuecomment-1700920222)

2. **Database Configuration:**

   To configure your testing environment, copy .env.dusk.local.example to .env.dusk.local and verify the database connection values. By default, Sail creates a specific testing database for testing. Therefore, in your .env.dusk.local, the `DB_DATABASE` environment variable should hold the value testing.
3. **Running Tests:**

   After properly setting up your environment, you can run your Laravel Dusk tests in the Sail environment using:

    ```shell
     ./vendor/bin/sail artisan dusk
    ```
   Remember to ensure your Sail environment is already running before initiating the tests.
   The official [Laravel Dusk](https://laravel.com/docs/10.x/dusk) documentation and [Sail](https://laravel.com/docs/10.x/sail#introduction) page provide more information and details about further customization and advanced usage.
### Styling guides

- For green and red colors for `yes` and `no` votes, use custom colors defined in `tailwind.config.js` file.
- For global CSS variables, use `_variables.css` file in the `resources/css` directory.
