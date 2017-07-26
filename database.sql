CREATE DATABASE IF NOT EXISTS blog;

USE blog;

CREATE TABLE users(
id  int(255) auto_increment not null,
rol VARCHAR(255),
name VARCHAR(255),
surname VARCHAR (255),
email VARCHAR (255),
password VARCHAR (255),
imagen VARCHAR (255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE categories(
id  int(255) auto_increment not null,
name VARCHAR(255),
description VARCHAR (255),
CONSTRAINT pk_categories PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE entries(
id  int(255) auto_increment not null,
user_id int(255) not null,
category_id int(255) not null,
title VARCHAR(255),
content text,
status VARCHAR (20),
imagen VARCHAR (255),
CONSTRAINT pk_entries PRIMARY KEY(id),
CONSTRAINT fk_entries_users FOREIGN KEY (user_id) REFERENCES users(id),
CONSTRAINT fk_entries_category FOREIGN KEY (category_id) REFERENCES categories(id)
)ENGINE=InnoDb;

CREATE TABLE tags(
id  int(255) auto_increment not null,
name VARCHAR(255),
description VARCHAR(255),
CONSTRAINT pk_tags PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE entry_tags(
id  int(255) auto_increment not null,
entry_id int (255) not null,
tag_id int (255) not null,
CONSTRAINT pk_entry_tags PRIMARY KEY(id),
CONSTRAINT fk_entries_tags_entries FOREIGN KEY (entry_id) REFERENCES entries(id),
CONSTRAINT fk_entries_tags_tags FOREIGN KEY (tag_id) REFERENCES tags(id)
)ENGINE=InnoDb;