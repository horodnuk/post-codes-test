Configure projects:

1. Copy ```.env.example``` to ```.env```
2. Run ```docker compose up -d --build```
3. Open mysql container ```docker compose exec mysql bash```
4. Import database schema ```mysql -u root -p < docker-entrypoint-initdb.d/schema.sql```
5. Open php container ```docker compose exec php bash```
6. Run composer ```composer install```
7. Run import postal codes command
``` php
php bin/console.php app:postal_code:import {file_path}
```
8. Open ```http://0.0.0.0:8080/```