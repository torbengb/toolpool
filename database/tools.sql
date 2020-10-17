CREATE TABLE IF NOT EXISTS tools (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP NULL DEFAULT NULL,
  deleted TIMESTAMP NULL DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  owner int(11) NOT NULL COMMENT 'users.id of owner',
  offered BOOLEAN DEFAULT FALSE COMMENT 'TRUE if owner currently offers to loan this tool',
  toolname VARCHAR(30) NOT NULL COMMENT 'what is this tool called',
  brand VARCHAR(50) COMMENT 'the make of this tool',
  model VARCHAR(50) COMMENT 'the model of this tool',
  dimensions VARCHAR(50) COMMENT 'size of e.g. drill bit or saw blade',
  weight VARCHAR(50) COMMENT 'weight of this tool',
  privatenotes VARCHAR(50) COMMENT 'notes that only the user can read',
  publicnotes VARCHAR(50) COMMENT 'notes that all users can read',
  taxonomy1 INT(11) NOT NULL DEFAULT 0 COMMENT 'taxonomy.id of the broadest classification of this tool',
  taxonomy2 INT(11) NOT NULL DEFAULT 0 COMMENT 'taxonomy.id of the classification',
  taxonomy3 INT(11) NOT NULL DEFAULT 0 COMMENT 'taxonomy.id of the classification',
  taxonomy4 INT(11) NOT NULL DEFAULT 0 COMMENT 'taxonomy.id of the classification',
  taxonomy5 INT(11) NOT NULL DEFAULT 0 COMMENT 'taxonomy.id of the narrowest classification of this tool',
  electrical230v BOOLEAN DEFAULT FALSE COMMENT 'TRUE if the tool requires 230V AC' DEFAULT 0,
  electrical400v BOOLEAN DEFAULT FALSE COMMENT 'TRUE if the tool requires 400V AC' DEFAULT 0,
  hydraulic BOOLEAN DEFAULT FALSE COMMENT 'TRUE if tool operates with oil pressure' DEFAULT 0,
  pneumatic BOOLEAN DEFAULT FALSE COMMENT 'TRUE if tool operates with air pressure' DEFAULT 0
);
