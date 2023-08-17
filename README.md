[https://rfc.stitcher.io/](https://rfc.stitcher.io/)

This is a small app meant to gather feedback on how RFCs are received in the PHP community.

# Local Development

## Laravel Sail
Follow the official [docs](https://laravel.com/docs/10.x/sail#introduction).

For `browsershot` to work properly add the following in `.env` file:
```dotenv
CHROME_BINARY_PATH=/usr/bin/google-chrome-stable
NODE_BINARY_PATH=/usr/bin/node
NPM_BINARY_PATH=/usr/bin/npm
```

For macOS (If you want to use Google Chrome):
```dotenv
CHROME_BINARY_PATH="/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"
```


For horizon to work properly make sure that you have the following in `.env` file:
```dotenv
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# And the following as well
QUEUE_CONNECTION=redis
```
