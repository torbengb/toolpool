/* *************************************************************************************
 * BASE DATA
 * These entries will be inserted automatically by 'install.php'.
 ************************************************************************************* */

CREATE TABLE IF NOT EXISTS countries (
  created TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  modified TIMESTAMP DEFAULT '0000-00-00 00:00:00',
  deleted TIMESTAMP DEFAULT '0000-00-00 00:00:00' COMMENT 'treat as deleted when value is not zero',
  code VARCHAR(2) PRIMARY KEY COMMENT '2-char ISO country code',
  name VARCHAR(50) NOT NULL
);

INSERT INTO countries (created,modified,deleted,code,name)
VALUES
 (SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','0','(not specified)')
,(SYSDATE(),'0000-00-00 00:00:00','0000-00-00 00:00:00','AT','Austria')
;
