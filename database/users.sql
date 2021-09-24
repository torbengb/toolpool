CREATE TABLE IF NOT EXISTS users
( id             INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified       TIMESTAMP                      NULL     DEFAULT NULL,
  deleted        TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  username       VARCHAR(30) CHARACTER SET utf8 NOT NULL COMMENT 'screen name of user',
  hashedpassword VARCHAR(60) DEFAULT 'xyzzy'    NOT NULL COMMENT 'hashed password',
  email          VARCHAR(50)                    NOT NULL COMMENT 'email address of the user',
  firstname      VARCHAR(50) CHARACTER SET utf8 COMMENT 'given name of the user',
  lastname       VARCHAR(50) CHARACTER SET utf8 COMMENT 'family name of the user',
  phone          VARCHAR(20)                    COMMENT '0043-555-2100-1234',
  addr_country VARCHAR(2)                       COMMENT 'countries.code of the country where the user is',
  addr_region VARCHAR(2)                        COMMENT 'regions.code of the region where the user is',
  addr_city      VARCHAR(50) CHARACTER SET utf8 COMMENT 'city where the user is',
  addr_zip       VARCHAR(8)  CHARACTER SET utf8 COMMENT 'postal code where the user is',
  addr_street    VARCHAR(80) CHARACTER SET utf8 COMMENT 'street name where the user is',
  addr_number    VARCHAR(50) CHARACTER SET utf8 COMMENT 'house number where the user is',
  privatenotes   VARCHAR(50) CHARACTER SET utf8 COMMENT 'notes that only the user can read' DEFAULT 'Only you can see what you type here.',
  publicnotes    VARCHAR(50) CHARACTER SET utf8 COMMENT 'notes that all users can read'     DEFAULT 'This user has no public comments.',
  CONSTRAINT fk_users_countries_code FOREIGN KEY ( addr_country ) REFERENCES countries ( code )
-- ,CONSTRAINT fk_users_regions_code FOREIGN KEY ( addr_region ) REFERENCES regions ( code )
)
;

CREATE INDEX index_users_id ON users ( id )
;

INSERT INTO users ( created, modified, deleted, username, hashedpassword, email, firstname, lastname, phone
                  , addr_country, addr_region, addr_city, addr_zip, addr_street, addr_number, privatenotes
                  , publicnotes )
VALUES ( SYSDATE(), NULL, NULL, 'torbengb', '$2y$10$gPZxo5h9q3RlDlReV6WJXuKXUjnYOStnsa71VRh4qp7S7vLV2ZCiK'
       , 'torben@g-b.dk', 'Torben', 'G-B', '123123123', 'AT', 'KO', 'Kbg', '2100', 'Jag', '15', 'hemli', 'nemli' )
;
