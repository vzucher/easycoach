-- Example: you may adapt or replace with real migration files
CREATE TABLE players (
  id INT PRIMARY KEY,
  name VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
