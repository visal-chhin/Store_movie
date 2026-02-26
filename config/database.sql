CREATE DATABASE movie_store;

USE movie_store;

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(500),
    title VARCHAR(255),
    price DECIMAL(10,2),
    quality VARCHAR(50),
    status VARCHAR(50)
);

INSERT INTO movies (image, title, price, quality, status) VALUES
('https://imgs.search.brave.com/6kjjKCDLu2IDG-IyxQCMvvSRwnHLBUHp-4Miyd3qXNU/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9wb3N0ZXJzcHkuY29tL3dwLWNvbnRlbnQvdXBs/b2Fkcy8yMDI0LzEw/L0Rvb21zZGF5LWJ5/LVZJU0NPTS5qcGc', 'Movie One', 10.00, 'HD', 'Available'),

('https://imgs.search.brave.com/EAVqB892sKbyuSOtGeUnczXdBFqPGBLsvsWASF8ETjI/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/ODF6SDM4ZjlCSUwu/anBn', 'Movie Two', 12.00, 'Full HD', 'Available'),

('https://imgs.search.brave.com/ZU2QLG9ZAV_QXksZX1xPRW50PvYtW7ThEQJDimm3pgE/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9paDEu/cmVkYnViYmxlLm5l/dC9pbWFnZS41OTQ1/NDgwMjQ3LjMzNDYv/ZnBvc3RlcixzbWFs/bCx3YWxsX3RleHR1/cmUsc3F1YXJlX3By/b2R1Y3QsNjAweDYw/MC5qcGc', 'Movie Three', 8.00, '4K', 'Sold'),

('https://imgs.search.brave.com/7V-6PecykECOe5dGJvl_CgOZUdCPE4jW62Pu91vUKnE/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tb25kb3Nob3AuY29tL2Nkbi9zaG9wL3Byb2R1Y3RzL1RheWxvcl9C/bGFja1BhbnRoZXJf/UmVnLUxnLmpwZz92/PTE2NDk5ODg2MjUm/d2lkdGg9NTcw', 'Movie Four', 15.00, 'HD', 'Available');