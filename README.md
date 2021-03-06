# Projects and tasks


# QUICK INSTALLATION

* download
 
```bash
git clone https://github.com/cmsrs/tasks.git && cd tasks
```

* run script 

```bash
./go_install.sh
```


# INSALLATION

* download
 
```bash
git clone https://github.com/cmsrs/tasks.git &&  cd tasks
```

* create user and database

```bash
./go_create_user_and_db.sh
```
 
* change file .env:
 
```bash
cp .env.tasks .env
```

* install dependency

```bash
composer install
```

* laravel and jwt config (create tokens):

```bash
php artisan key:generate && php artisan jwt:secret
```
 
* create database tables and create admin users: 

admin - (email: admin@tasks.pl, pass: tasks123) 

client - (email: client@tasks.pl, pass: tasks456)

```bash
php artisan migrate  && php artisan db:seed --class=UserSeeder
```
 
* set permission 
 
```bash
./go_privilege.sh
```
 
* start server
 
```bash
php artisan serve
```

# RUN TESTS

* prepare testing:

```bash
./go_create_test_db.sh
cp .env .env.testing 
```
 
change in file .env.testing:

```bash
DB_DATABASE=tasks_testing
```

* run tests: 

```bash
./go_privilege.sh
./vendor/bin/phpunit
```
 
# React source code:

https://github.com/cmsrs/cmsrs3-react

# Print screen

<img src="https://github.com/cmsrs/tasks/blob/main/rs/admin.png" />
<img src="https://github.com/cmsrs/tasks/blob/main/rs/client.png" />
<img src="https://github.com/cmsrs/tasks/blob/main/rs/tests.png" />

# schema db

<img src="https://github.com/cmsrs/tasks/blob/main/rs/tasks.svg" />

# video

https://youtu.be/hzgFw0wsnDM
