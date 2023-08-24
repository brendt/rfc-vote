# RFC Vote

[https://rfc.stitcher.io/](https://rfc.stitcher.io/)

This is a small app meant to gather feedback on how RFCs are received in the PHP community.

## Local Development
> prerequisite: PHP >= 8.2

The app relies on Laravel Sail. See [docs](https://laravel.com/docs/10.x/sail#introduction) for details.

1. `composer install`
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

### Styling guides

- For green and red colors for `yes` and `no` votes, use custom colors defined in `tailwind.config.js` file.
- For global CSS variables, use `_variables.css` file in the `resources/css` directory.
