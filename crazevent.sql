-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 27 Novembre 2014 à 10:01
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE SCHEMA IF NOT EXISTS `crazevent` DEFAULT CHARACTER SET utf8;
USE `crazevent`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `crazevent`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_friendship`(id_user int, id_contact int)
BEGIN
if (id_user = id_contact) then
	select 'error';
elseif (id_user < id_contact) then
	insert friendship(user_id1, user_id2) values(id_user, id_contact);
	select * from friendship where user_id1 = id_user AND user_id2 = id_contact;
else
	insert friendship(user_id1, user_id2) values(id_contact, id_user);
	select * from friendship where user_id1 = id_contact AND user_id2 = id_user;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_activity`(eventID INT, activityContent VARCHAR(45))
BEGIN
	DECLARE activityID INT DEFAULT -1;    
    SELECT id INTO activityID FROM activity WHERE content = activityContent;
    
    -- insertion of activity if it doesn't exist
	IF(activityID = -1) THEN
		INSERT INTO activity VALUES(NULL, activityContent);
        SELECT LAST_INSERT_ID() INTO activityID;
    END IF;
    
    -- association of event and activity
    INSERT INTO activity_specification (event_id, activity_id) VALUES (eventID, activityID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_keyword`(eventID INT, keywordContent VARCHAR(45))
BEGIN
	DECLARE keywordID INT DEFAULT -1;    
    SELECT id INTO keywordID FROM keyword WHERE content = keywordContent;
    
    -- insertion of keyowrd if it doesn't exist
	IF(keywordID = -1) THEN
		INSERT INTO keyword VALUES(NULL, keywordContent);
        SELECT LAST_INSERT_ID() INTO keywordID;
    END IF;
    
    -- association of event and keyword
    INSERT INTO keyword_specification (event_id, keyword_id) VALUES (eventID, keywordID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `join_private_event`(id_user int, id_event int)
BEGIN

delete from invitation where user_id = id_user AND event_id = id_event;

insert participation(event_id, user_id) values(id_event, id_user);
select * from participation where user_id = id_user AND event_id = id_event;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `join_public_event`(id_user int, id_event int)
BEGIN

insert participation(event_id, user_id) values(id_event, id_user);
select * from participation where user_id = id_user AND event_id = id_event;

END$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `conected_user_id`() RETURNS int(11)
BEGIN
RETURN @connected_user_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `is_friendship`(id_user int, id_contact int) RETURNS int(11)
BEGIN
if (id_user = id_contact) then
	return 2;
elseif (id_user < id_contact) then
	if (select exists(select * from friendship where user_id1 = id_user AND user_id2 = id_contact)) then
		return 1;
	else
		return 0;
	end if;
else
	if (select exists(select * from friendship where user_id1 = id_contact AND user_id2 = id_user)) then
		return 1;
	else
		return 0;
	end if;
end if;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `is_participation`(id_user int, id_event int) RETURNS int(11)
BEGIN
if (select exists(select * from participation where user_id = id_user AND event_id = id_event)) then
	return 1;
else
	return 0;
end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `activity`
--

INSERT INTO `activity` (`id`, `content`) VALUES
(1, 'Boire'),
(2, 'Manger'),
(3, 'taguer'),
(4, 'théâtre'),
(5, 'Treck'),
(6, 'Saut à ski'),
(7, 'fondue');

-- --------------------------------------------------------

--
-- Structure de la table `activity_specification`
--

CREATE TABLE IF NOT EXISTS `activity_specification` (
  `activity_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`event_id`),
  KEY `fk_activity_has_event_event1_idx` (`event_id`),
  KEY `fk_activity_has_event_activity1_idx` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `invitation_suggestion_allowed` tinyint(1) DEFAULT '0',
  `description` longtext NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `inscription_deadline` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT '1',
  `start_place` varchar(255) DEFAULT NULL,
  `participant_max_nbr` int(11) DEFAULT NULL,
  `participant_minimum_age` int(11) DEFAULT '0',
  `organizer` int(11) NOT NULL,
  `individual_proposition_suggestion_allowed` tinyint(1) DEFAULT '0',
  `region_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKOrganization_idx` (`organizer`),
  KEY `fk_event_region_idx` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id`, `name`, `private`, `invitation_suggestion_allowed`, `description`, `start_date`, `inscription_deadline`, `duration`, `start_place`, `participant_max_nbr`, `participant_minimum_age`, `organizer`, `individual_proposition_suggestion_allowed`, `region_id`) VALUES
(2, 'test', 1, 0, 'test', '2014-11-27 18:00:00', '2014-11-27 11:00:00', 1, NULL, NULL, 0, 1, 0, 19);

-- --------------------------------------------------------

--
-- Structure de la table `event_disscussion_thread_message`
--

CREATE TABLE IF NOT EXISTS `event_disscussion_thread_message` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `fk_disscussionThreadMessage_event1_idx` (`event_id`),
  KEY `fk_disscussionThreadMessage_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

CREATE TABLE IF NOT EXISTS `friendship` (
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  PRIMARY KEY (`user_id1`,`user_id2`),
  KEY `fk_user_has_user_user2_idx` (`user_id2`),
  KEY `fk_user_has_user_user1_idx` (`user_id1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `individual_proposition`
--

CREATE TABLE IF NOT EXISTS `individual_proposition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_dealing_with_it` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_individualProposition_event1_idx` (`event_id`),
  KEY `fk_individualProposition_user1_idx` (`user_dealing_with_it`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`event_id`),
  KEY `fk_invitation_user1_idx` (`user_id`),
  KEY `fk_invitation_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `keyword`
--

INSERT INTO `keyword` (`id`, `content`) VALUES
(1, 'house party'),
(2, 'TAG'),
(3, 'feutre'),
(4, 'marche'),
(5, 'montagnes'),
(6, 'paysage');

-- --------------------------------------------------------

--
-- Structure de la table `keyword_specification`
--

CREATE TABLE IF NOT EXISTS `keyword_specification` (
  `event_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`keyword_id`),
  KEY `fk_event_has_keyword_keyword1_idx` (`keyword_id`),
  KEY `fk_event_has_keyword_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mandatory_checklist_item`
--

CREATE TABLE IF NOT EXISTS `mandatory_checklist_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mandatoryCheckListItemUnique` (`content`,`event_id`),
  KEY `fk_mandatoryCheckListItem_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `participable_event`
--
CREATE TABLE IF NOT EXISTS `participable_event` (
`id` int(11)
,`name` varchar(45)
,`private` tinyint(1)
,`invitation_suggestion_allowed` tinyint(1)
,`description` longtext
,`start_date` datetime
,`inscription_deadline` datetime
,`duration` int(11)
,`start_place` varchar(255)
,`participant_max_nbr` int(11)
,`participant_minimum_age` int(11)
,`organizer` int(11)
,`individual_proposition_suggestion_allowed` tinyint(1)
,`region_id` int(11)
);
-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE IF NOT EXISTS `participation` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `fk_event_has_user_user1_idx` (`user_id`),
  KEY `fk_event_has_user_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_UNIQUE` (`content`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `region`
--

INSERT INTO `region` (`id`, `content`) VALUES
(1, 'Aigle'),
(20, 'Berne'),
(19, 'Bienne'),
(2, 'Echallens'),
(17, 'Fribourg'),
(11, 'Genève'),
(13, 'La Chaux-de-Fonds'),
(6, 'Lausanne'),
(15, 'Martigny'),
(10, 'Montreux'),
(4, 'Morges'),
(12, 'Neuchâtel'),
(7, 'Nyon'),
(3, 'Payerne'),
(18, 'Romont'),
(16, 'Sion'),
(14, 'Ste-Croix'),
(21, 'Vallée de Joux'),
(9, 'Vallorbe'),
(8, 'Vevey'),
(5, 'Yverdon-les-Bains');

-- --------------------------------------------------------

--
-- Structure de la table `start_date_open_option`
--

CREATE TABLE IF NOT EXISTS `start_date_open_option` (
  `date` datetime NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`date`,`event_id`),
  KEY `fk_startDateOpenOptions_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `start_date_open_option_agreeing_user`
--

CREATE TABLE IF NOT EXISTS `start_date_open_option_agreeing_user` (
  `start_date_open_options_date` datetime NOT NULL,
  `start_date_open_options_event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`start_date_open_options_date`,`start_date_open_options_event_id`,`user_id`),
  KEY `fk_startDateOpenOptions_has_user_user1_idx` (`user_id`),
  KEY `fk_startDateOpenOptions_has_user_startDateOpenOptions1_idx` (`start_date_open_options_date`,`start_date_open_options_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `start_place_open_option`
--

CREATE TABLE IF NOT EXISTS `start_place_open_option` (
  `start_place` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`start_place`,`event_id`),
  UNIQUE KEY `startPlaceOpenOptionUnique` (`start_place`,`event_id`),
  KEY `fk_startPlaceOpenOptions_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `start_place_open_option_agreeing_user`
--

CREATE TABLE IF NOT EXISTS `start_place_open_option_agreeing_user` (
  `start_place_open_options_start_place` varchar(255) NOT NULL,
  `start_place_open_options_event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`start_place_open_options_start_place`,`start_place_open_options_event_id`,`user_id`),
  UNIQUE KEY `startPlaceOpenOptionAgreeingUserUnique` (`start_place_open_options_start_place`,`start_place_open_options_event_id`,`user_id`),
  KEY `fk_startPlaceOpenOptions_has_user_user1_idx` (`user_id`),
  KEY `fk_startPlaceOpenOptions_has_user_startPlaceOpenOptions1_idx` (`start_place_open_options_start_place`,`start_place_open_options_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(45) NOT NULL,
  `region_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_region_idx` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `surname`, `password`, `birthdate`, `email`, `region_id`, `is_admin`, `active`) VALUES
(1, 'Dominique', 'Jollien', '1a1dc91c907325c69271ddf0c944bc72', '1993-06-22', 'dominiquejollien@hotmail.com', 16, 0, 0),
(3, 'popo', 'a', '1a1dc91c907325c69271ddf0c944bc72', '1993-06-22', 'popo@popo.com', 1, 0, 0),
(4, 'Calixte', 'Maillard', '81dc9bdb52d04dc20036dbd8313ed055', '1111-11-11', 'calixte@heig.ch', 7, 0, 1),
(5, 'Simone', 'Righittho', '81dc9bdb52d04dc20036dbd8313ed055', '1111-11-11', 'simone@heig.ch', 18, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_inbox_message`
--

CREATE TABLE IF NOT EXISTS `user_inbox_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text,
  `content` longtext NOT NULL,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKSender_idx` (`sender`),
  KEY `FKRecepient_idx` (`recipient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `visible_event`
--
CREATE TABLE IF NOT EXISTS `visible_event` (
`id` int(11)
,`name` varchar(45)
,`private` tinyint(1)
,`invitation_suggestion_allowed` tinyint(1)
,`description` longtext
,`start_date` datetime
,`inscription_deadline` datetime
,`duration` int(11)
,`start_place` varchar(255)
,`participant_max_nbr` int(11)
,`participant_minimum_age` int(11)
,`organizer` int(11)
,`individual_proposition_suggestion_allowed` tinyint(1)
,`region_id` int(11)
);
-- --------------------------------------------------------

--
-- Structure de la vue `participable_event`
--
DROP TABLE IF EXISTS `participable_event`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `participable_event` AS select `subquery`.`id` AS `id`,`subquery`.`name` AS `name`,`subquery`.`private` AS `private`,`subquery`.`invitation_suggestion_allowed` AS `invitation_suggestion_allowed`,`subquery`.`description` AS `description`,`subquery`.`start_date` AS `start_date`,`subquery`.`inscription_deadline` AS `inscription_deadline`,`subquery`.`duration` AS `duration`,`subquery`.`start_place` AS `start_place`,`subquery`.`participant_max_nbr` AS `participant_max_nbr`,`subquery`.`participant_minimum_age` AS `participant_minimum_age`,`subquery`.`organizer` AS `organizer`,`subquery`.`individual_proposition_suggestion_allowed` AS `individual_proposition_suggestion_allowed`,`subquery`.`region_id` AS `region_id` from `visible_event` `subquery` where ((`subquery`.`start_date` >= now()) and (`subquery`.`inscription_deadline` >= now()));

-- --------------------------------------------------------

--
-- Structure de la vue `visible_event`
--
DROP TABLE IF EXISTS `visible_event`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visible_event` AS select `event`.`id` AS `id`,`event`.`name` AS `name`,`event`.`private` AS `private`,`event`.`invitation_suggestion_allowed` AS `invitation_suggestion_allowed`,`event`.`description` AS `description`,`event`.`start_date` AS `start_date`,`event`.`inscription_deadline` AS `inscription_deadline`,`event`.`duration` AS `duration`,`event`.`start_place` AS `start_place`,`event`.`participant_max_nbr` AS `participant_max_nbr`,`event`.`participant_minimum_age` AS `participant_minimum_age`,`event`.`organizer` AS `organizer`,`event`.`individual_proposition_suggestion_allowed` AS `individual_proposition_suggestion_allowed`,`event`.`region_id` AS `region_id` from `event` where ((`event`.`private` = 0) or `event`.`id` in (select `event`.`id` from (`event` join `participation` on((`participation`.`event_id` = `event`.`id`))) where ((`event`.`private` = 1) and (`participation`.`user_id` = `conected_user_id`()))) or `event`.`id` in (select `event`.`id` from (`event` join `invitation` on((`invitation`.`event_id` = `event`.`id`))) where ((`event`.`private` = 1) and (`invitation`.`user_id` = `conected_user_id`()))));

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `activity_specification`
--
ALTER TABLE `activity_specification`
  ADD CONSTRAINT `fk_activity_has_event_activity1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activity_has_event_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FKOrganization` FOREIGN KEY (`organizer`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event_disscussion_thread_message`
--
ALTER TABLE `event_disscussion_thread_message`
  ADD CONSTRAINT `fk_disscussionThreadMessage_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_disscussionThreadMessage_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `fk_user_has_user_user1` FOREIGN KEY (`user_id1`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_user_user2` FOREIGN KEY (`user_id2`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `individual_proposition`
--
ALTER TABLE `individual_proposition`
  ADD CONSTRAINT `fk_individualProposition_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_individualProposition_user` FOREIGN KEY (`user_dealing_with_it`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `fk_invitation_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invitation_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `keyword_specification`
--
ALTER TABLE `keyword_specification`
  ADD CONSTRAINT `fk_event_has_keyword_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_has_keyword_keyword1` FOREIGN KEY (`keyword_id`) REFERENCES `keyword` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mandatory_checklist_item`
--
ALTER TABLE `mandatory_checklist_item`
  ADD CONSTRAINT `fk_mandatoryCheckListItem_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `fk_event_has_user_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `start_date_open_option`
--
ALTER TABLE `start_date_open_option`
  ADD CONSTRAINT `fk_startDateOpenOptions_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `start_date_open_option_agreeing_user`
--
ALTER TABLE `start_date_open_option_agreeing_user`
  ADD CONSTRAINT `fk_startDateOpenOptions_has_user_openOption` FOREIGN KEY (`start_date_open_options_date`, `start_date_open_options_event_id`) REFERENCES `start_date_open_option` (`date`, `event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_startDateOpenOptions_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `start_place_open_option`
--
ALTER TABLE `start_place_open_option`
  ADD CONSTRAINT `fk_startPlaceOpenOptions_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `start_place_open_option_agreeing_user`
--
ALTER TABLE `start_place_open_option_agreeing_user`
  ADD CONSTRAINT `fk_startPlaceOpenOptions_has_user_openOption` FOREIGN KEY (`start_place_open_options_start_place`, `start_place_open_options_event_id`) REFERENCES `start_place_open_option` (`start_place`, `event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_startPlaceOpenOptions_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_inbox_message`
--
ALTER TABLE `user_inbox_message`
  ADD CONSTRAINT `FKRecepient` FOREIGN KEY (`recipient`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FKSender` FOREIGN KEY (`sender`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
