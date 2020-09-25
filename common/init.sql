-- CREATE DATABASE IF NOT EXISTS toolpool_dev; -- this was moved into 'install.php'!

-- USE toolpool_dev; -- this was moved into 'install.php'!

CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
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

CREATE TABLE tools (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
	deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
	owner int(11) NOT NULL COMMENT 'user-id of owner',
	offered BOOLEAN DEFAULT FALSE DEFAULT FALSE COMMENT 'TRUE if owner currently offers to loan this tool',
	toolname VARCHAR(30) NOT NULL COMMENT 'what is this tool called',
	brand VARCHAR(50) COMMENT 'the make of this tool',
	model VARCHAR(50) COMMENT 'the model of this tool',
	dimensions VARCHAR(50) COMMENT 'size of e.g. drill bit or saw blade',
	weight VARCHAR(50) COMMENT 'weight of this tool',
	privatenotes VARCHAR(50) COMMENT 'notes that only the user can read',
	publicnotes VARCHAR(50) COMMENT 'notes that all users can read',
	taxonomy1 VARCHAR(30) COMMENT 'broadest classification of this tool',
	taxonomy2 VARCHAR(30) COMMENT '',
	taxonomy3 VARCHAR(30) COMMENT '',
	taxonomy4 VARCHAR(30) COMMENT '',
	taxonomy5 VARCHAR(30) COMMENT 'narrowest classification of this tool',
	electrical230v BOOLEAN DEFAULT FALSE COMMENT 'TRUE if the tool requires 230V AC' DEFAULT 0,
	electrical400v BOOLEAN DEFAULT FALSE COMMENT 'TRUE if the tool requires 400V AC' DEFAULT 0,
	hydraulic BOOLEAN DEFAULT FALSE COMMENT 'TRUE if tool operates with oil pressure' DEFAULT 0,
	pneumatic BOOLEAN DEFAULT FALSE COMMENT 'TRUE if tool operates with air pressure' DEFAULT 0
);

CREATE TABLE loans (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
	deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
	active BOOLEAN DEFAULT FALSE COMMENT 'TRUE if this loan is ongoing, FALSE if kept for historical records',
	tool int(11) NOT NULL COMMENT 'tools.id of the borrowed tool',
	owner int(11) NOT NULL COMMENT 'users.id of owner',
	loanedto int(11) NOT NULL COMMENT 'users.id that is currently borrowing this tool',
	agreedstart DATE COMMENT 'agreed date of loan start',
	agreedend DATE COMMENT 'agreed date of loan end',
	actualstart DATE COMMENT 'actual date of loan start',
	actualend DATE COMMENT 'actual date of loan end'
);

CREATE TABLE taxonomy (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
	deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
	taxonomy VARCHAR(50) NOT NULL COMMENT 'the taxonomy of a tool',
	parent INT(11) DEFAULT 0 COMMENT 'the parent of this taxonomy, or zero for top level'
);

