CREATE DATABASE IF NOT EXISTS testdb;

create table if not exists testdb.postal_codes
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

