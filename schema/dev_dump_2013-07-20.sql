# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: deployer
# Generation Time: 2013-07-20 09:22:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table github_payload
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_payload`;

CREATE TABLE `github_payload` (
  `id_github_payload` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_github_repository` int(11) unsigned NOT NULL,
  `fk_github_payload_user_pusher` int(11) unsigned DEFAULT NULL,
  `after` varchar(255) DEFAULT NULL,
  `before` varchar(255) DEFAULT NULL,
  `compare` varchar(255) DEFAULT NULL,
  `created` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `forced` tinyint(1) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_github_payload`),
  KEY `fk_github_payload_user_pusher` (`fk_github_payload_user_pusher`),
  KEY `fk_github_repository` (`fk_github_repository`),
  CONSTRAINT `github_payload_ibfk_2` FOREIGN KEY (`fk_github_repository`) REFERENCES `github_repository` (`id_github_payload_repository`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `github_payload_ibfk_1` FOREIGN KEY (`fk_github_payload_user_pusher`) REFERENCES `github_user` (`id_github_payload_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table github_payload_commit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_payload_commit`;

CREATE TABLE `github_payload_commit` (
  `id_github_payload_commit` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_github_payload` int(11) unsigned NOT NULL,
  `commit_id` varchar(255) NOT NULL DEFAULT '',
  `distinct` tinyint(1) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `head_commit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_github_payload_commit`),
  KEY `fk_github_payload` (`fk_github_payload`),
  CONSTRAINT `github_payload_commit_ibfk_1` FOREIGN KEY (`fk_github_payload`) REFERENCES `github_payload` (`id_github_payload`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table github_payload_commit_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_payload_commit_file`;

CREATE TABLE `github_payload_commit_file` (
  `id_github_payload_commit_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_github_payload_commit` int(11) unsigned NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `action` enum('ADDED','MODIFIED','REMOVED') DEFAULT NULL,
  PRIMARY KEY (`id_github_payload_commit_file`),
  KEY `fk_github_payload_commit` (`fk_github_payload_commit`),
  CONSTRAINT `github_payload_commit_file_ibfk_1` FOREIGN KEY (`fk_github_payload_commit`) REFERENCES `github_payload_commit` (`id_github_payload_commit`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table github_payload_commit_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_payload_commit_user`;

CREATE TABLE `github_payload_commit_user` (
  `id_github_payload_commit_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_github_payload_commit` int(11) unsigned NOT NULL,
  `fk_github_payload_user` int(11) unsigned NOT NULL,
  `role` enum('AUTHOR','COMMITTER') DEFAULT NULL,
  PRIMARY KEY (`id_github_payload_commit_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table github_repository
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_repository`;

CREATE TABLE `github_repository` (
  `id_github_payload_repository` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_github_user` int(11) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `description` text,
  `fork` tinyint(1) DEFAULT NULL,
  `forks` int(11) DEFAULT NULL,
  `has_downloads` tinyint(1) DEFAULT NULL,
  `has_issues` tinyint(1) DEFAULT NULL,
  `has_wiki` tinyint(1) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `github_id` int(11) unsigned NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `master_branch` varchar(255) DEFAULT 'master',
  `name` varchar(255) DEFAULT NULL,
  `open_issues` int(11) DEFAULT NULL,
  `private` tinyint(1) DEFAULT NULL,
  `pushed_at` timestamp NULL DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `stargazers` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `watchers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_github_payload_repository`),
  KEY `fk_github_user` (`fk_github_user`),
  CONSTRAINT `github_repository_ibfk_1` FOREIGN KEY (`fk_github_user`) REFERENCES `github_user` (`id_github_payload_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table github_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `github_user`;

CREATE TABLE `github_user` (
  `id_github_payload_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_github_payload_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
