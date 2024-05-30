-   Note API Laravel Docs

1. Open terminal
2. Run `git clone https://github.com/karlebh/api-laravel.git`
3. cd into the application with `cd api-laravel`
4. Run `composer i`
5. Make sure you are have php and any sql client install, i'd suggest xampp or laragon
6. Open the sql client and create a database, say, `api_laravel`
7. Copy the database name to your .env file like so `DB_DATABASE=api_laravel`. Then the username and password can be left like so `DB_USERNAME=root`, `DB_PASSWORD=`.
8. Run `php artisan api:prepare`. This is an artisan command that prepares your app by running the migration, seeding the database and starting the server.

-   Test Runing

- How To Use The API

1. Registration: `api/register` .

It takes 4 parameters: `name`, `email`, `password`, `password_confirmation`

2. Login: `api/login`

It take 2 parameters: `email`, `password`

3. Logout: `api/logout`

4. Create Note: `api/note/store` - `POST`. It requires authentication token

It takes 2 paramaters: `title`, `body`

5. Create Note: `api/note/{note-id}` - `PATCH`. It requires authentication token

It takes 2 optional parameters: `title`, `body`

6. Delete Note: `api/note/store` - `DELETE`. It requires authentication token

7. Get a Single Note: `api/note/{note-id}` - `GET`. 

8. Get All Notes: `api/notes` - `GET`.

