CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('lost', 'found') NOT NULL,
    category VARCHAR(50) NOT NULL,
    city VARCHAR(100) NOT NULL,
    location_text VARCHAR(255) NOT NULL,
    description VARCHAR(500) NOT NULL,
    whatsapp VARCHAR(30) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    status ENUM('active', 'resolved') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
