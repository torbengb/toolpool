/* *************************************************************************************
 * BASE DATA
 * These entries will be inserted automatically by 'install.php'.
 ************************************************************************************* */

CREATE TABLE IF NOT EXISTS countries
( created  TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP                      NULL     DEFAULT NULL,
  deleted  TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  code     VARCHAR(2) PRIMARY KEY COMMENT '2-char ISO country code',
  name     VARCHAR(50) CHARACTER SET utf8 NOT NULL COMMENT 'name of the country'
)
;

CREATE INDEX index_countries_code ON countries ( code )
;

INSERT INTO countries ( created, modified, deleted, code, name )
VALUES ( SYSDATE(), NULL, NULL, '0', '(not specified)' )
	 , ( SYSDATE(), NULL, NULL, 'AT', 'Austria' )
	 , ( SYSDATE(), NULL, NULL, 'DE', 'Germany' )
;
