CREATE TABLE IF NOT EXISTS loans (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP NULL DEFAULT NULL,
  deleted TIMESTAMP NULL DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  active BOOLEAN DEFAULT FALSE COMMENT 'TRUE if this loan is ongoing, FALSE if kept for historical records',
  tool int(11) NOT NULL COMMENT 'tools.id of the borrowed tool',
  owner int(11) NOT NULL COMMENT 'users.id of owner',
  loanedto int(11) NOT NULL COMMENT 'users.id that is currently borrowing this tool',
  agreedstart DATE COMMENT 'agreed date of loan start',
  agreedend DATE COMMENT 'agreed date of loan end',
  actualstart DATE COMMENT 'actual date of loan start',
  actualend DATE COMMENT 'actual date of loan end'
);
