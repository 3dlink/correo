INSERT INTO `user_group_permissions` VALUES ('319', '1', 'Communications', 'documentStatus', '1');
INSERT INTO `user_group_permissions` VALUES ('320', '2', 'Communications', 'documentStatus', '1');
INSERT INTO `user_group_permissions` VALUES ('321', '3', 'Communications', 'documentStatus', '1');
INSERT INTO `user_group_permissions` VALUES ('322', '1', 'Communications', 'updateTemporal', '1');
INSERT INTO `user_group_permissions` VALUES ('323', '2', 'Communications', 'updateTemporal', '1');
INSERT INTO `user_group_permissions` VALUES ('324', '3', 'Communications', 'updateTemporal', '1');
INSERT INTO `user_group_permissions` VALUES ('325', '1', 'Redirections', 'redirectCommunication', '1');
INSERT INTO `user_group_permissions` VALUES ('326', '2', 'Redirections', 'redirectCommunication', '1');
INSERT INTO `user_group_permissions` VALUES ('327', '3', 'Redirections', 'redirectCommunication', '1');

alter table uploads add hashnopdf varchar (255);

alter table users add reditect_only int (11);



