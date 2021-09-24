CREATE TABLE IF NOT EXISTS tools
( id             INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified       TIMESTAMP NULL     DEFAULT NULL,
  deleted        TIMESTAMP NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  owner          INT(11) UNSIGNED NOT NULL COMMENT 'users.id of owner',
  offered        BOOLEAN DEFAULT FALSE COMMENT 'TRUE if owner currently offers to loan this tool',
  toolname       VARCHAR(30) CHARACTER SET utf8 NOT NULL COMMENT 'what is this tool called',
  brand          VARCHAR(50) CHARACTER SET utf8 COMMENT 'the make of this tool',
  model          VARCHAR(50) CHARACTER SET utf8 COMMENT 'the model of this tool',
  dimensions     VARCHAR(50) CHARACTER SET utf8 COMMENT 'size of e.g. drill bit or saw blade',
  weight         VARCHAR(50) CHARACTER SET utf8 COMMENT 'weight of this tool',
  privatenotes   VARCHAR(50) CHARACTER SET utf8 COMMENT 'notes that only the user can read',
  publicnotes    VARCHAR(50) CHARACTER SET utf8 COMMENT 'notes that all users can read',
  taxonomy1      INT(11) UNSIGNED NOT NULL DEFAULT 2 COMMENT 'taxonomy.id of the broadest classification of this tool',
  taxonomy2      INT(11) UNSIGNED NULL     DEFAULT 1 COMMENT 'taxonomy.id of the classification',
  taxonomy3      INT(11) UNSIGNED NULL     DEFAULT 1 COMMENT 'taxonomy.id of the classification',
  taxonomy4      INT(11) UNSIGNED NULL     DEFAULT 1 COMMENT 'taxonomy.id of the classification',
  taxonomy5      INT(11) UNSIGNED NULL     DEFAULT 1 COMMENT 'taxonomy.id of the narrowest classification of this tool',
  electrical230v BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool requires 230V AC',
  electrical400v BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool requires 400V AC',
  electricalbatt BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool is battery powered',
  combustion     BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool uses combustion engine',
  hydraulic      BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool uses oil pressure',
  pneumatic      BOOLEAN                   DEFAULT 0 COMMENT 'TRUE if the tool uses air pressure'
,CONSTRAINT fk_tools_users_owner FOREIGN KEY ( owner ) REFERENCES users ( id )
)
;

CREATE INDEX index_tools_id ON tools ( id )
;

/*
,CONSTRAINT tools_users_owner_fk FOREIGN KEY ( OWNER ) REFERENCES users ( id )
,CONSTRAINT tools_taxonomy_tax1_fk FOREIGN KEY ( taxonomy1 ) REFERENCES taxonomy ( id )
,CONSTRAINT tools_taxonomy_tax2_fk FOREIGN KEY ( taxonomy2 ) REFERENCES taxonomy ( id )
,CONSTRAINT tools_taxonomy_tax3_fk FOREIGN KEY ( taxonomy3 ) REFERENCES taxonomy ( id )
,CONSTRAINT tools_taxonomy_tax4_fk FOREIGN KEY ( taxonomy4 ) REFERENCES taxonomy ( id )
,CONSTRAINT tools_taxonomy_tax5_fk FOREIGN KEY ( taxonomy5 ) REFERENCES taxonomy ( id )
 */
