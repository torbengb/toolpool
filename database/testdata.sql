/* *************************************************************************************
 * TEST DATA 
 * These entries will be inserted automatically by 'install.php' in non-prod environments
 ************************************************************************************* */

INSERT INTO users ( created, modified, deleted, username, email, firstname, lastname, phone, addr_country, addr_region,
                    addr_city, addr_zip, addr_street, addr_number, privatenotes, publicnotes )
VALUES ( SYSDATE(), NULL, NULL, 'albert', 'torben@g-b.dk', 'Torben', 'G-B', '123123123', 'AT', 'KO', 'Kbg', '2100', 'Jag', '15', 'hemli', 'nemli' )
	 , ( SYSDATE(), NULL, NULL, 'beatrice', 'torben@g-b.dk', 'Torben', 'G-B', '123123123', 'AT', 'KO', 'Kbg', '2100', 'Jag', '15', 'hemli', 'nemli' )
	 , ( SYSDATE(), NULL, NULL, 'chuck', 'torben@g-b.dk', 'Torben', 'G-B', '123123123', 'AT', 'KO', 'Kbg', '2100', 'Jag', '15', 'hemli', 'nemli' )
;

INSERT INTO users (created,modified,deleted,username,email,firstname,lastname,phone,addr_country,addr_region,addr_city,addr_zip,addr_street,addr_number,privatenotes,publicnotes) 
VALUES
 ('2020-09-17 12:35:51.0','2020-09-17 13:46:32.0',NULL,'alice','won','Als','Erland','','AT','KO','','','','','','')
,('2020-09-17 12:35:51.0','2020-09-17 13:46:32.0',NULL,'bob','two','Bob','''s Burgers','','AT','KO','','','','','','')
,('2020-09-17 13:11:29.0','2020-09-17 13:47:15.0',NULL,'charlie','three','Charlie','Chaplin','','AT','KO','','','','','','')
,('2020-09-17 13:34:49.0','2020-09-17 13:47:20.0',NULL,'dennis','four','Dennis','Menace','','AT','KO','','','','','','')
,('2020-09-17 17:37:22.0','2020-09-17 13:47:25.0',NULL,'eric','five','Eric','Half-a-Bee','','AT','KO','','','','', '', '')
,('2020-09-20 12:36:29.0',NULL,'2020-09-17 10:48:45.0','deleted','','','','','AT','KO','','','','','','')
,('2020-09-17 10:46:47.0','2020-09-17 10:48:14.0','2020-09-17 12:55:27.0','updated','','','','','AT','KO','','','','','','')
,('2020-09-17 12:35:51.0','2020-09-17 12:36:06.0','2020-09-17 12:36:22.0','another','','','','','AT','KO','','','','','','')
,('2020-09-17 13:11:29.0','2020-09-17 13:47:31.0',NULL,'fred','six','Fred','Flintstone','123123','DE','Z','qwe','2111','asdf','11','private','public')
,('2020-09-17 13:34:49.0','2020-09-17 13:35:09.0','2020-09-17 13:35:22.0','88','88','99','99','','DE','Z','','','','','','')
,('2020-09-17 17:37:22.0',NULL,'2020-09-17 17:37:31.0','remove this','','','','','DE','Z','','','','','','')
,('2020-09-21 20:42:09.0','2020-09-23 13:08:24.0',NULL,'clever','smart','clever!','smart','','DE','Z','','','','','','')
;

INSERT INTO tools ( created, modified, deleted, owner, offered, toolname, brand, model, dimensions, weight,
                    privatenotes, publicnotes, taxonomy1, taxonomy2, taxonomy3, taxonomy4, taxonomy5, electrical230v,
                    electrical400v, hydraulic, pneumatic )
VALUES ( SYSDATE(), NULL, NULL, 1, 1, 'twister', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'tangled net', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 2, 1, 'turpentine', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'angle grinder', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'acid', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'anchor', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'blueprint', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'bobbin', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'bluetack', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'chainsaw', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'cider', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
	 , ( SYSDATE(), NULL, NULL, 1, 1, 'chain', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL )
;
INSERT INTO tools (created,modified,deleted,owner,offered,toolname,brand,model,dimensions,weight,privatenotes,publicnotes,taxonomy1,taxonomy2,taxonomy3,taxonomy4,taxonomy5,electrical230v,electrical400v,hydraulic,pneumatic)
VALUES 
 ('2020-09-17 13:34:17.0','2020-09-22 10:49:37.0',NULL,1,1,'hammer','','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 15:33:24.0','2020-09-17 17:35:06.0',NULL,2,1,'small hand saw','','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 16:39:50.0','2020-09-17 17:33:22.0',NULL,3,1,'bandsaw','','','','','','',0,0,0,0,0,1,0,0,0)
,('2020-09-17 17:29:26.0','2020-09-17 16:39:16.0',NULL,4,0,'nail gun','','','','','','',0,0,0,0,0,0,0,0,1)
,('2020-09-20 12:46:34.0','2020-09-22 10:56:45.0',NULL,5,0,'rail gun','','','','','','',0,0,0,0,0,0,1,0,0)
,('2020-09-20 12:48:04.0','2020-09-17 16:38:34.0',NULL,5,0,'wrench M32','','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 10:52:04.0','2020-09-17 17:33:17.0',NULL,4,1,'table saw','','','','','','',0,0,0,0,0,1,0,0,0)
,('2020-09-17 12:36:42.0','2020-09-17 12:38:19.0','2020-09-17 12:38:57.0',1,0,'newiewy','','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 13:10:22.0','2020-09-17 16:38:08.0','2020-09-21 18:41:08.0',2,1,'screwdriver #3','','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 13:34:08.0',NULL,'2020-09-17 13:35:37.0',9,9,'99','99','','','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-17 13:34:17.0','2020-09-17 13:35:46.0','2020-09-17 13:35:55.0',7,9,'99','99','','','','','',0,0,0,0,0,0,0,0,0)
,('2020-09-17 15:33:24.0','2020-09-17 16:39:00.0',NULL,4,1,'glue gun','','','','','','',0,0,0,0,0,1,0,0,0)
,('2020-09-17 16:39:50.0',NULL,NULL,4,1,'compressor','','','','','','',0,0,0,0,0,1,NULL,NULL,NULL)
,('2020-09-17 17:29:26.0','2020-09-17 17:31:18.0',NULL,2,1,'jack','','','max.2000kg','','','',0,0,0,0,0,0,0,1,0)
,('2020-09-20 12:46:34.0','2020-09-25 13:22:12.0',NULL,12,1,'large nail gun','weber','punch','up to 90mm nails!','7kg','','',0,0,0,0,0,NULL,NULL,NULL,1)
,('2020-09-20 12:48:04.0',NULL,NULL,12,1,'mallet','','','80cm shaft','4kg','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-20 12:49:49.0',NULL,'2020-09-20 12:50:37.0',5,NULL,'','','','','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-20 12:50:02.0',NULL,'2020-09-20 12:50:34.0',5,NULL,'','','','','','','',0,0,0,0,0,1,NULL,1,1)
,('2020-09-20 12:50:22.0',NULL,'2020-09-20 12:50:30.0',5,NULL,'','','','','','','',0,0,0,0,0,NULL,1,NULL,1)
,('2020-09-20 12:51:32.0',NULL,NULL,12,1,'wheelbarrow','HÃ¼egli','','BHT 50x40x75cm','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-20 12:52:45.0','2020-09-26 15:01:46.0',NULL,12,1,'pick-axe','rusty','','60cm shaft','','','',3,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-21 20:41:17.0','2020-09-26 15:27:25.0',NULL,12,1,'charger','voltcraft','powerX','','','','',9,0,0,0,0,1,NULL,NULL,NULL)
,('2020-09-22 15:14:59.0',NULL,'2020-09-22 15:18:18.0',5,1,'yo','','','','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-22 15:18:04.0',NULL,'2020-09-24 13:02:29.0',5,NULL,'big thing','','','','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-22 15:31:12.0','2020-09-26 15:27:59.0',NULL,12,1,'blinker fluid pump','','','','','','',9,0,0,0,0,1,NULL,1,NULL)
,('2020-09-24 13:01:22.0',NULL,NULL,9,1,'bucket press','','','','','','',0,0,0,0,0,NULL,NULL,1,NULL)
,('2020-09-25 12:25:03.0','2020-09-25 14:36:05.0',NULL,12,NULL,'test dummy','b2','stig','180cm','60kg','private','public',0,0,0,0,0,1,1,1,1)
,('2020-09-25 12:39:38.0',NULL,'2020-09-25 12:54:20.0',12,NULL,'scrambler bomb','wotc','rr01','','','','',0,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-26 13:53:08.0','2020-09-26 15:28:26.0',NULL,5,1,'cart','wilson','wheel','','','','',15,0,0,0,0,NULL,NULL,NULL,NULL)
,('2020-09-26 14:19:11.0','2020-09-26 15:07:39.0',NULL,5,1,'roof nailer','foo','bar','','','','',3,10,11,1,0,1,NULL,NULL,NULL)
,('2020-09-26 14:44:46.0',NULL,'2020-09-26 14:45:16.0',5,1,'arst','','','','','','',9,0,0,0,0,NULL,NULL,NULL,NULL)
;

INSERT INTO loans ( id, created, modified, deleted, active, tool, owner, loanedto, agreedstart, agreedend, actualstart,
                    actualend )
VALUES ( 1, '2021-09-22 20:03:48', NULL, NULL, 1, 7, 4, 1, NULL, NULL, NULL, NULL ),
       ( 2, '2021-09-22 20:03:54', NULL, NULL, 1, 5, 3, 1, NULL, NULL, NULL, NULL ),
       ( 3, '2021-09-22 20:03:58', NULL, NULL, 1, 3, 2, 1, NULL, NULL, NULL, NULL ),
       ( 4, '2021-09-22 20:04:13', NULL, NULL, 1, 4, 3, 2, NULL, NULL, NULL, NULL ),
       ( 5, '2021-09-22 20:04:17', NULL, NULL, 1, 8, 4, 2, NULL, NULL, NULL, NULL ),
       ( 6, '2021-09-22 20:04:21', NULL, NULL, 1, 12, 1, 2, NULL, NULL, NULL, NULL ),
       ( 7, '2021-09-22 20:04:35', NULL, NULL, 1, 1, 2, 3, NULL, NULL, NULL, NULL ),
       ( 8, '2021-09-22 20:04:40', NULL, NULL, 1, 7, 4, 3, NULL, NULL, NULL, NULL ),
       ( 9, '2021-09-22 20:04:44', NULL, NULL, 1, 10, 1, 3, NULL, NULL, NULL, NULL ),
       ( 10, '2021-09-22 20:05:01', NULL, NULL, 1, 1, 2, 4, NULL, NULL, NULL, NULL );

INSERT INTO loans (created,modified,deleted,active,tool,owner,loanedto,agreedstart,agreedend,actualstart,actualend) 
VALUES 
 ('2020-09-26 19:28:53.0',NULL,'2020-09-26 19:30:44.0',1,4,5,5,NULL,NULL,NULL,NULL)
,('2020-09-25 14:46:12.0','2020-09-25 20:15:58.0',NULL,NULL,12,2,3,NULL,NULL,NULL,NULL)
,('2020-09-21 20:42:35.0',NULL,NULL,1,3,4,13,NULL,NULL,NULL,NULL)
,('2020-09-17 19:48:39.0','2020-09-26 18:43:06.0',NULL,1,1,1,2,NULL,NULL,NULL,NULL)
,('2020-09-17 19:48:34.0',NULL,'2020-09-17 20:03:33.0',1,2,2,4,NULL,NULL,NULL,NULL)
,('2020-09-17 19:48:27.0',NULL,NULL,1,2,2,3,NULL,NULL,NULL,NULL)
,('2020-09-17 19:47:31.0','2020-09-25 20:15:33.0',NULL,NULL,3,1,4,NULL,NULL,NULL,NULL)
,('2020-09-17 19:42:19.0','2020-09-20 21:46:09.0',NULL,1,4,1,2,NULL,NULL,NULL,NULL)
,('2020-09-17 19:48:27.0','2020-09-20 22:02:58.0',NULL,1,6,8,3,NULL,NULL,NULL,NULL)
,('2020-09-17 19:47:31.0','2020-09-20 21:52:52.0',NULL,0,3,8,9,NULL,NULL,NULL,NULL)
;
