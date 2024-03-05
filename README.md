Configure projects:

Make sure the server opens the ```index.php``` file in the ```dist``` directory.
Or move the generated styles and scripts to the ```public``` folder.

1. Create table
``` sql
create table if not exists postal_codes
(
    post_code        varchar(5)   not null primary key,
    postal_code      varchar(5)   not null,
    region           varchar(255) not null,
    district_old     varchar(255) null,
    district_new     varchar(255) null,
    settlement       varchar(255) null,
    region_eng       varchar(255) null,
    district_new_eng varchar(255) null,
    settlement_eng   varchar(255) null,
    post_office      varchar(255) null,
    post_office_eng  varchar(255) null,
    is_imported      bool         default false,
    INDEX (postal_code)
);
```

2. Run import postal codes command
``` php
php bin/console.php app:postal_code:import {file_path}
```

3. Build frontend
``` bash
    npm i
    npm run build
```
