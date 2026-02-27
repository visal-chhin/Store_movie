CREATE DATABASE movie_store;

USE movie_store;

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(500),
    title VARCHAR(55),
    price DECIMAL(10,2),
    quality VARCHAR(50),
    status VARCHAR(50)
);
