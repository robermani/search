# Symfony Backend

This is the backend for our project, built with Symfony.

## Requirements

- PHP 8.2
- Composer
- MySQL

## Setup

1. **Clone the repository**:
   - Run CLI: `git clone https://github.com/robermani/search.git`
   - enter to `search` directory
2. **Change `docker-entrypoint.sh` EOL to Unix Format**
   - Open `./docker/docker-entrypoint.sh` in Notepad++
   - Click `Edit` > `EOL convertion` > `Unix (LF)` and save
3. **Add DB Connection Configuration**:
   - Add `DATABASE_URL="mysql://symfony:symfony@db:3306/symfony?serverVersion=5.7"` in `.env` file
4. **Run On Docker**:
   - Run CLI: `docker-compose up --build`
5. **Use:**:
   - Go to `http://localhost:8080` in your browser
6. **Run Test:**:
   - Run CLI: `php bin/phpunit`


    

