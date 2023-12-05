# Hacked branch

This branch is a hacked version of the original repo. It is used to make local slide development easier.

## Hacked stuff

- Infinite credits
- Become a teacher
- All shop items added 10x to your inventory
- Free indefinite screen time shop item
- No need to manually type Secret Tick Key

## 🛠 Getting Started

**Note:** these instructions are only correct if you attent Curio in Breda. If you attend a different school good luck figuring it out.

1. Ask a teacher to give you a AMO Client ID and Secret callback URL should be `http://localhost:8000/callback` if running on the default port. If you are running on a different port, change the callback URL accordingly.

2. Read the [README.md](./README.md) to get the project up and running

3. Change the default user in the [Development Seeder](database/seeders/DevelopmentSeeder.php#L22) on line 22 to your own user:
    - id = i + student number
    - name = your name
    - email = D + student number + @edu.rocwb.nl
    - type = teacher or student (teacher allows you access to the admin panel)
    - credits = the amount of credits you want to have (9999999999999999 is probably enough)

4. Change the approver_id to be your own user id in the [Development Seeder](database/seeders/DevelopmentSeeder.php#L48) on line 48

5. Run `php artisan migrate:fresh --seed` to reset the database and seed it with your user

6. Run `php artisan serve` to start the server
