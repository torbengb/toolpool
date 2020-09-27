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
	owner int(11) NOT NULL COMMENT 'users.id of owner',
	offered BOOLEAN DEFAULT FALSE DEFAULT FALSE COMMENT 'TRUE if owner currently offers to loan this tool',
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
	taxonomy VARCHAR(50) NOT NULL COMMENT 'name of the taxonomy',
	parent INT(11) DEFAULT 0 COMMENT 'taxonomy.id of the parent of this taxonomy, or zero for top level'
);

INSERT INTO taxonomy (id,created,lastupdated,deleted,name,parent) 
VALUES 
 (0,SYSDATE(),NULL,NULL,'(none)',0)
,(1,SYSDATE(),NULL,NULL,'(not specified)',0)
;

CREATE TABLE countries (
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
	deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
	code VARCHAR(2) PRIMARY KEY COMMENT '2-char ISO country code',
	name VARCHAR(50) NOT NULL
);
INSERT INTO countries (created,lastupdated,deleted,code,name) 
VALUES 
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','0','(not specified)',0)
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','Austria',0)
;

CREATE TABLE regions (
	created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	lastupdated TIMESTAMP DEFAULT '0000-00-00 00:00:00',
	deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
	country VARCHAR(2) NOT NULL COMMENT 'countries.code of the region',
	code VARCHAR(10) PRIMARY KEY COMMENT 'national region code',
	name VARCHAR(80) NOT NULL
);
INSERT INTO regions (created,lastupdated,country,deleted,name) 
VALUES 
 (SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','0','0','(not specified)',0)
 (SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','0','(not specified)',0)
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','AM','Amstetten')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','BN','Baden')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','BZ','Bludenz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','BR','Braunau')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','B','Bregenz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','BL','Bruck an der Leitha')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','BM','Bruck-Mürzzuschlag')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','DL','Deutschlandsberg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','DO','Dornbirn')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','EF','Eferding')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','E','Eisenstadt – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','EU','Eisenstadt / Umgebung')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','FK','Feldkirch')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','FE','Feldkirchen')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','FR','Freistadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GM','Gmunden')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GD','Gmünd')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','G','Graz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GU','Graz/Umgebung')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GR','Grieskirchen')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GB','Gröbming')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GS','Güssing')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','GF','Gänserndorf')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','HA','Hallein')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','HF','Hartberg-Fürstenfeld')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','HE','Hermagor')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','HL','Hollabrunn')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','HO','Horn')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','IM','Imst')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','I','Innsbruck – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','IL','Innsbruck/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','JE','Jennersdorf')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KI','Kirchdorf an der Krems')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KB','Kitzbühel')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','K','Klagenfurt – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KL','Klagenfurt/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KO','Korneuburg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KR','Krems')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KS','Krems an der Donau – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','KU','Kufstein')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LA','Landeck')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LB','Leibnitz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LE','Leoben – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LN','Leoben/Umgebung')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LZ','Lienz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LI','Liezen')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LF','Lilienfeld')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','L','Linz – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','LL','Linz/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','MA','Mattersburg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','ME','Melk')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','MI','Mistelbach')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','MU','Murau')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','MT','Murtal')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','MD','Mödling')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','NK','Neunkirchen')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','ND','Neusiedl am See')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','OP','Oberpullendorf')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','OW','Oberwart')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','PE','Perg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','RE','Reutte')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','RI','Ried im Innkreis')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','RO','Rohrbach')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','S','Salzburg – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SL','Salzburg/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SB','Scheibbs')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SZ','Schwaz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SW','Schwechat')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SD','Schärding')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SP','Spittal an der Drau')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','JO','St. Johann im Pongau')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','P','St. Pölten – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','PL','St. Pölten/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SV','St. Veit an der Glan')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SR','Steyr – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SE','Steyr/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','SO','Südoststeiermark')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','TA','Tamsweg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','TU','Tulln')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','UU','Urfahr/Umgebung')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','VI','Villach')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','VL','Villach/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','VO','Voitsberg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','VB','Vöcklabruck')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','VK','Völkermarkt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WT','Waidhofen an der Thaya')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WY','Waidhofen an der Ybbs')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WZ','Weiz')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WE','Wels – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WL','Wels/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','W','Wien')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WU','Wien/Umgebung')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WN','Wiener Neustadt – Stadt')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WB','Wiener Neustadt/Land')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','WO','Wolfsberg')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','ZE','Zell am See')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','ZT','Zwettl')
;

