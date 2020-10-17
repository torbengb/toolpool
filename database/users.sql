CREATE TABLE IF NOT EXISTS users (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  modified TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
  username VARCHAR(30) NOT NULL COMMENT 'screen name of user',
  email VARCHAR(50) NOT NULL COMMENT 'obvious',
  firstname VARCHAR(50) COMMENT 'obvious',
  lastname VARCHAR(50) COMMENT 'obvious',
  phone VARCHAR(20) COMMENT '0043-555-2100-1234',
  addr_country VARCHAR(50) COMMENT 'obvious',
  addr_region VARCHAR(50) COMMENT 'e.g. state',
  addr_city VARCHAR(50) COMMENT '',
  addr_zip VARCHAR(8) COMMENT '',
  addr_street VARCHAR(80) COMMENT '',
  addr_number VARCHAR(50) COMMENT '',
  privatenotes VARCHAR(50) COMMENT 'notes that only the user can read' DEFAULT 'Only you can see what you type here.',
  publicnotes VARCHAR(50) COMMENT 'notes that all users can read' DEFAULT 'This user has no public comments.'
);

INSERT INTO users (created,modified,deleted,username,email,firstname,lastname,phone,addr_country,addr_region,addr_city,addr_zip,addr_street,addr_number,privatenotes,publicnotes)
VALUES (SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','torbengb','torben@g-b.dk','Torben','G-B','123123123','AT','NO','Kbg','2100','Jag','15','hemli','nemli')
;

