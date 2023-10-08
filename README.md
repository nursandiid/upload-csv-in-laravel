# Uploading CSV files in Laravel
A demo project with Laravel 10 to import large CSV file with batch jobs and laravel horizon to monitor it. In this project it uses a pusher websocket to update progress in realtime, so you need to register an account and setup to your project but you can use my credential to try it out.

<img src="https://raw.githubusercontent.com/sandinur157/upload-csv-in-laravel/main/public/img/screenshot-1.png" style="border-radius: 5px;">

## Installation
For the installation you can clone this project to your local computer.
```bash
git clone https://github.com/sandinur157/upload-csv-in-laravel
```

Navigate to the project folder.
```bash
cd upload-csv-in-laravel
```

Install required packages.
```bash
composer install
```

Create a new .env file and edit the database credentials there.
```bash
cp .env.example .env
```

## Configuration

### Database Connection
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=upload_csv_in_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Queue Connection
In this case, you can set the value to `database` or `redis`.

If you use `redis` as the value, sometimes you will find inconsistent data. I have tried several times using `redis` and I found the progress of jobs stuck at 56%, 75%, etc. Until the status changed to cancelled but the data was successfully imported to the database.

If you use `database` as the value, you need to run the queue command manually. If you use `redis` as the value you don't need to run queue command manually, you only need to run horizon command.

```bash
QUEUE_CONNECTION=database
```

### Redis Connection
```bash
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

### Pusher Connection
You can use this credentials to run your project, however I will delete them in one month after the project published.

```bash
BROADCAST_DRIVER=pusher

PUSHER_APP_ID="1683524"
PUSHER_APP_KEY="3ce7dfc6d3fab8ba50cc"
PUSHER_APP_SECRET="2d2a9b27b95e5c34b893"
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER="ap1"
```

## Run Commands
Generate new app key.
```bash
php artisan key:generate
```

Run migrations.
```bash
php artisan migrate
```

Generate symlink to view file in storage.
```bash
php artisan storage:link
```

Run queue command if you set the connection as database.
```bash
php artisan queue:listen
```

Run horizon command.
```bash
php artisan horizon
```

Run your app.
```bash
php artisan serve
```

That's it: 

- Launch the main URL http://127.0.0.1:8000
- Launch this url to monitor jobs http://127.0.0.1:8000/horizon