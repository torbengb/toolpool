CREATE DATABASE toolpool_dev;

USE toolpool_dev;

CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP,
	lastupdated TIMESTAMP,
	deleted TIMESTAMP,
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
	privatenotes VARCHAR(50) COMMENT 'notes that only the user can read',
	publicnotes VARCHAR(50) COMMENT 'notes that all users can read'
);

CREATE TABLE tools (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP,
	lastupdated TIMESTAMP,
	deleted TIMESTAMP,
	owner int(11) NOT NULL COMMENT 'user-id of owner',
	offered BOOLEAN COMMENT 'TRUE if owner currently offers to loan this tool',
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
	electrical230v BOOLEAN COMMENT 'TRUE if the tool requires 230V AC',
	electrical400v BOOLEAN COMMENT 'TRUE if the tool requires 400V AC',
	hydraulic BOOLEAN COMMENT 'TRUE if tool operates with oil pressure',
	pneumatic BOOLEAN COMMENT 'TRUE if tool operates with air pressure'
);

CREATE TABLE loans (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	created TIMESTAMP,
	active BOOLEAN COMMENT 'TRUE if this loan is ongoing, FALSE if kept for historical records',
	owner int(11) NOT NULL COMMENT 'user-id of owner',
	loanedto int(11) NOT NULL COMMENT 'user-id that is currently borrowing this tool',
	agreedstart DATE COMMENT 'agreed date of loan start',
	agreedend DATE COMMENT 'agreed date of loan end',
	actualstart DATE COMMENT 'actual date of loan start',
	actualend DATE COMMENT 'actual date of loan end'
);

