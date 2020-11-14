/* *************************************************************************************
 * BASE DATA
 * These entries will be inserted automatically by 'install.php'.
 ************************************************************************************* */

CREATE TABLE IF NOT EXISTS regions (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP NULL DEFAULT NULL,
  deleted TIMESTAMP NULL DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  country VARCHAR(2) NOT NULL COMMENT 'countries.code of the region',
  code VARCHAR(10) COMMENT 'national region code',
  name VARCHAR(80) NOT NULL
);

INSERT INTO regions (created,modified,deleted,country,code,name)
VALUES
 (SYSDATE(),NULL,NULL,'0','0','(not specified)')
,(SYSDATE(),NULL,NULL,'AT','0','(not specified)')
,(SYSDATE(),NULL,NULL,'AT','AM','Amstetten')
,(SYSDATE(),NULL,NULL,'AT','BN','Baden')
,(SYSDATE(),NULL,NULL,'AT','BZ','Bludenz')
,(SYSDATE(),NULL,NULL,'AT','BR','Braunau')
,(SYSDATE(),NULL,NULL,'AT','B','Bregenz')
,(SYSDATE(),NULL,NULL,'AT','BL','Bruck an der Leitha')
,(SYSDATE(),NULL,NULL,'AT','BM','Bruck-Mürzzuschlag')
,(SYSDATE(),NULL,NULL,'AT','DL','Deutschlandsberg')
,(SYSDATE(),NULL,NULL,'AT','DO','Dornbirn')
,(SYSDATE(),NULL,NULL,'AT','EF','Eferding')
,(SYSDATE(),NULL,NULL,'AT','E','Eisenstadt/Stadt')
,(SYSDATE(),NULL,NULL,'AT','EU','Eisenstadt/Umgebung')
,(SYSDATE(),NULL,NULL,'AT','FK','Feldkirch')
,(SYSDATE(),NULL,NULL,'AT','FE','Feldkirchen')
,(SYSDATE(),NULL,NULL,'AT','FR','Freistadt')
,(SYSDATE(),NULL,NULL,'AT','GM','Gmunden')
,(SYSDATE(),NULL,NULL,'AT','GD','Gmünd')
,(SYSDATE(),NULL,NULL,'AT','G','Graz')
,(SYSDATE(),NULL,NULL,'AT','GU','Graz/Umgebung')
,(SYSDATE(),NULL,NULL,'AT','GR','Grieskirchen')
,(SYSDATE(),NULL,NULL,'AT','GB','Gröbming')
,(SYSDATE(),NULL,NULL,'AT','GS','Güssing')
,(SYSDATE(),NULL,NULL,'AT','GF','Gänserndorf')
,(SYSDATE(),NULL,NULL,'AT','HA','Hallein')
,(SYSDATE(),NULL,NULL,'AT','HF','Hartberg-Fürstenfeld')
,(SYSDATE(),NULL,NULL,'AT','HE','Hermagor')
,(SYSDATE(),NULL,NULL,'AT','HL','Hollabrunn')
,(SYSDATE(),NULL,NULL,'AT','HO','Horn')
,(SYSDATE(),NULL,NULL,'AT','IM','Imst')
,(SYSDATE(),NULL,NULL,'AT','I','Innsbruck/Stadt')
,(SYSDATE(),NULL,NULL,'AT','IL','Innsbruck/Land')
,(SYSDATE(),NULL,NULL,'AT','JE','Jennersdorf')
,(SYSDATE(),NULL,NULL,'AT','KI','Kirchdorf an der Krems')
,(SYSDATE(),NULL,NULL,'AT','KB','Kitzbühel')
,(SYSDATE(),NULL,NULL,'AT','K','Klagenfurt/Stadt')
,(SYSDATE(),NULL,NULL,'AT','KL','Klagenfurt/Land')
,(SYSDATE(),NULL,NULL,'AT','KO','Korneuburg')
,(SYSDATE(),NULL,NULL,'AT','KR','Krems')
,(SYSDATE(),NULL,NULL,'AT','KS','Krems an der Donau/Stadt')
,(SYSDATE(),NULL,NULL,'AT','KU','Kufstein')
,(SYSDATE(),NULL,NULL,'AT','LA','Landeck')
,(SYSDATE(),NULL,NULL,'AT','LB','Leibnitz')
,(SYSDATE(),NULL,NULL,'AT','LE','Leoben/Stadt')
,(SYSDATE(),NULL,NULL,'AT','LN','Leoben/Umgebung')
,(SYSDATE(),NULL,NULL,'AT','LZ','Lienz')
,(SYSDATE(),NULL,NULL,'AT','LI','Liezen')
,(SYSDATE(),NULL,NULL,'AT','LF','Lilienfeld')
,(SYSDATE(),NULL,NULL,'AT','L','Linz/Stadt')
,(SYSDATE(),NULL,NULL,'AT','LL','Linz/Land')
,(SYSDATE(),NULL,NULL,'AT','MA','Mattersburg')
,(SYSDATE(),NULL,NULL,'AT','ME','Melk')
,(SYSDATE(),NULL,NULL,'AT','MI','Mistelbach')
,(SYSDATE(),NULL,NULL,'AT','MU','Murau')
,(SYSDATE(),NULL,NULL,'AT','MT','Murtal')
,(SYSDATE(),NULL,NULL,'AT','MD','Mödling')
,(SYSDATE(),NULL,NULL,'AT','NK','Neunkirchen')
,(SYSDATE(),NULL,NULL,'AT','ND','Neusiedl am See')
,(SYSDATE(),NULL,NULL,'AT','OP','Oberpullendorf')
,(SYSDATE(),NULL,NULL,'AT','OW','Oberwart')
,(SYSDATE(),NULL,NULL,'AT','PE','Perg')
,(SYSDATE(),NULL,NULL,'AT','RE','Reutte')
,(SYSDATE(),NULL,NULL,'AT','RI','Ried im Innkreis')
,(SYSDATE(),NULL,NULL,'AT','RO','Rohrbach')
,(SYSDATE(),NULL,NULL,'AT','S','Salzburg/Stadt')
,(SYSDATE(),NULL,NULL,'AT','SL','Salzburg/Land')
,(SYSDATE(),NULL,NULL,'AT','SB','Scheibbs')
,(SYSDATE(),NULL,NULL,'AT','SZ','Schwaz')
,(SYSDATE(),NULL,NULL,'AT','SW','Schwechat')
,(SYSDATE(),NULL,NULL,'AT','SD','Schärding')
,(SYSDATE(),NULL,NULL,'AT','SP','Spittal an der Drau')
,(SYSDATE(),NULL,NULL,'AT','JO','St. Johann im Pongau')
,(SYSDATE(),NULL,NULL,'AT','P','St. Pölten/Stadt')
,(SYSDATE(),NULL,NULL,'AT','PL','St. Pölten/Land')
,(SYSDATE(),NULL,NULL,'AT','SV','St. Veit an der Glan')
,(SYSDATE(),NULL,NULL,'AT','SR','Steyr/Stadt')
,(SYSDATE(),NULL,NULL,'AT','SE','Steyr/Land')
,(SYSDATE(),NULL,NULL,'AT','SO','Südoststeiermark')
,(SYSDATE(),NULL,NULL,'AT','TA','Tamsweg')
,(SYSDATE(),NULL,NULL,'AT','TU','Tulln')
,(SYSDATE(),NULL,NULL,'AT','UU','Urfahr/Umgebung')
,(SYSDATE(),NULL,NULL,'AT','VI','Villach')
,(SYSDATE(),NULL,NULL,'AT','VL','Villach/Land')
,(SYSDATE(),NULL,NULL,'AT','VO','Voitsberg')
,(SYSDATE(),NULL,NULL,'AT','VB','Vöcklabruck')
,(SYSDATE(),NULL,NULL,'AT','VK','Völkermarkt')
,(SYSDATE(),NULL,NULL,'AT','WT','Waidhofen an der Thaya')
,(SYSDATE(),NULL,NULL,'AT','WY','Waidhofen an der Ybbs')
,(SYSDATE(),NULL,NULL,'AT','WZ','Weiz')
,(SYSDATE(),NULL,NULL,'AT','WE','Wels/Stadt')
,(SYSDATE(),NULL,NULL,'AT','WL','Wels/Land')
,(SYSDATE(),NULL,NULL,'AT','W','Wien')
,(SYSDATE(),NULL,NULL,'AT','WU','Wien/Umgebung')
,(SYSDATE(),NULL,NULL,'AT','WN','Wiener Neustadt/Stadt')
,(SYSDATE(),NULL,NULL,'AT','WB','Wiener Neustadt/Land')
,(SYSDATE(),NULL,NULL,'AT','WO','Wolfsberg')
,(SYSDATE(),NULL,NULL,'AT','ZE','Zell am See')
,(SYSDATE(),NULL,NULL,'AT','ZT','Zwettl')
;
