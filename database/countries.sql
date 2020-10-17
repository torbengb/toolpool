/* *************************************************************************************
 * BASE DATA
 * These entries will be inserted automatically by 'install.php'.
 ************************************************************************************* */

CREATE TABLE IF NOT EXISTS countries (
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP NULL DEFAULT NULL,
  deleted TIMESTAMP NULL DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  code VARCHAR(2) PRIMARY KEY COMMENT '2-char ISO country code',
  name VARCHAR(50) NOT NULL
);

INSERT INTO countries (created,modified,deleted,code,name)
VALUES
 (SYSDATE(),NULL,NULL,'0','(not specified)')
,(SYSDATE(),NULL,NULL,'AT','Austria')
;
