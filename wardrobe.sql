CREATE DATABASE wardrobe;

USE wardrobe;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

INSERT INTO products (name, price) VALUES 
('Red hoodie', 20.00),
('Black sneakers', 60.00),
('Grey straight Trouser', 50.00),
('Orange jacket', 50.00),
('Orange Denim', 300.00),
('Maroon jacket', 600.00),
('Pack of 3 socks', 10.00),
('Black Fossil watch', 50.00),
('Roadstar watch', 50.00),
('Black running sneakers', 50.00),
('Grey comfort shoes', 50.00),







('Black narrow Trouser', 50.00);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

select * from cart;
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
create table users(

 Id INT AUTO_INCREMENT PRIMARY KEY,
full_name varchar(128),
email varchar(255),
password varchar(255)
);
select * from orders;
select * from users;

