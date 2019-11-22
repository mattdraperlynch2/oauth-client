# oauth-client
This is a test client for the oauth application. Set the oauth va
## Client Setup
You can create new clients by using the application's UI or running the following command:
```bash
php artisan passport:client
```
You can read more about this [here](https://laravel.com/docs/6.x/passport#managing-clients).

## Developer Setup
Clone the repository and then `cd` into the repo on your local machine. Copy the `.env.example` file to a file named `.env`
You can also configure a default user to use to log into the app in the `.env` file by setting the values in this section of the file:
```bash
SEEDER_USER_EMAIL="admin@lynch2.com"
SEEDER_USER_PASSWORD="password"
SEEDER_USER_NAME="John Doe"
```
Then run the following commands:
```bash
composer install
npm install
npm run dev
php artisan migrate:fresh --seed
```

You should be able to login to the app using the user credentials you specified in the `.env`
