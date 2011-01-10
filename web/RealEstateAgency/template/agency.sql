-- CREATE DATABASE `agency` default character set cp1251 collate cp1251_ukrainian_ci;

-- use agency;

create table r_e_object 
(
obj_id    BIGINT UNSIGNED AUTO_INCREMENT,
broker_id    BIGINT UNSIGNED,
started    DATETIME NOT NULL,
updated    DATETIME NOT NULL,
price    FLOAT UNSIGNED NOT NULL,
type    TINYINT UNSIGNED NOT NULL,
rooms    SMALLINT UNSIGNED NOT NULL,
rooms_type    TINYINT UNSIGNED,
settlement_id    BIGINT UNSIGNED,
location_text    VARCHAR(250),
settl_area_id     BIGINT UNSIGNED,
street_text    VARCHAR(100) NOT NULL,
house_num    VARCHAR(10),
sq_all    FLOAT UNSIGNED,
sq_live    FLOAT UNSIGNED,
sq_kitchen    FLOAT UNSIGNED,
obj_level    SMALLINT UNSIGNED,
obj_levels    SMALLINT UNSIGNED,
external    TINYINT UNSIGNED,
wc_num    TINYINT UNSIGNED,
bath_num    TINYINT UNSIGNED,
tel    TINYINT UNSIGNED,
description    VARCHAR(1000),
/* rights      bigint unsigned, if this record is only for internal use */
PRIMARY KEY (`obj_id`)
);

/* version 1.4 - areas like Obolon, Podol, etc. */
alter table r_e_object add column settl_sub_part_name varchar(64) after settl_area_id;

/* version 1.5 - operation type */
alter table r_e_object add column op_type tinyint unsigned not null after obj_id;

/* version 1.5 - rent period */
alter table r_e_object add column rent_period varchar(10) after tel;

/* version 1.6 - square land */
alter table r_e_object add column sq_land float unsigned after sq_kitchen;

create table area
(
obj_id           bigint unsigned auto_increment,
obj_name         varchar(255),
country          bigint unsigned,
PRIMARY KEY (`obj_id`)
);

create table district
(
obj_id           bigint unsigned auto_increment,
obj_name         varchar(255),
area             bigint unsigned,
PRIMARY KEY (`obj_id`)
);

create table settlement
(
obj_id           bigint unsigned auto_increment,
obj_name         varchar(255),
district         bigint unsigned,
PRIMARY KEY (`obj_id`)
);

create table settlement_part
(
obj_id           bigint unsigned auto_increment,
obj_name         varchar(255),
settlement       bigint unsigned,
PRIMARY KEY (`obj_id`)
);

create table users
(
user_reg_id      bigint unsigned auto_increment,
login_name       varchar(255),
password         varchar(255),
first_name       varchar(255),
family_name      varchar(255),
agency           bigint unsigned,
image_file       varchar(255),
description_file varchar(255),
show_details     tinyint unsigned,
rights           bigint unsigned,
PRIMARY KEY (`user_reg_id`)
);

create table agency
(
obj_id           bigint unsigned auto_increment,
its_name         varchar(255),
image_file       varchar(255),
description_file varchar(255),
PRIMARY KEY (`obj_id`)
);

create table events_list
(
obj_id           bigint unsigned auto_increment,
log_date         datetime, /* chas stvorennia zapisu */
log_name       varchar(128),
log_string       varchar(1000),
log_status     tinyint unsigned,
PRIMARY KEY (`obj_id`)
);


