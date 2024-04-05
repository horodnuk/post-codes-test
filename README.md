Configure projects:

1. Copy ```.env.example``` to ```.env```
2. Run docker compose up -d --build
3. Open mysql container ```docker compose exec mysql bash```
4. Run command for import database schema ```cd docker-entrypoint-initdb.d; mysql -u root -p < shecma.sql```
5. Open php container ```docker compose exec php bash```
6. Run import postal codes command
``` php
php bin/console.php app:postal_code:import {file_path}
```
