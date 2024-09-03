# Calendar Events SPA Test project

NOTE: For startup need to be installed docker, docker-compose, composer, node

1. Clone (or unpack) project:
```git clone git@github.com:lemadior/calendarspa.git store```

cd to the ./store

2. Copy ```.env.exapmle``` to the ```.env```

3. Fill the corresponds variables in the ```.env```:

        DB_CONNECTION=mysql
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=teststore
        DB_USERNAME=<username>
        DB_PASSWORD=<user_password>
        DB_ROOT_PASSWORD=<root_password>

**IMPORTANT:** Also need to change ```APP_TIMEZONE``` parameter to correctly display current date!

4. Change access rights for the current folder:

```sudo chown -R 1000:33 $(pwd)```

5. Create the containers:

```docker-compose up -d```

6. Update the composer

```docker exec -it app composer install```

Update the node modules:

```npm install```

7. Create new application key:

```docker exec -it app php artisan key:generate --ansi```

8. Create symlink to the public storage folder:

```docker exec -it app php artisan storage:link ```

9. Fill database with the test data:

```docker exec -it app php artisan migrate --seed```

**NOTE**: the seeder will create only test user for testing purpose.

Test User credentials:

        email: test@example.com
        pass: password

**IMPORTANT:** Don't forget delete or change guest user's credentials after testing.

10.  Create new key for JWT token:

```docker exec -it app php artisan jwt:secret```

11. Before start type the command:

```npm run dev```

Then the URL http://localhost:5000 must be available to testing

12. API documentation available at URL http://localhost:5000/api/documentation
