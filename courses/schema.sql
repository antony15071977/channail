CREATE TABLE commentos (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  dt_add        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  name          CHAR(128) NOT NULL,
  comment_text  TEXT NOT NULL,
  moderation    int NOT NULL default 0  
);
