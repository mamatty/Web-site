/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : smartgym

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-08-11 16:20:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('4', 'Matteo', 'Novembre', 'matteo.novembre94@gmail.com', '$2y$10$wutP4.t5jaSf1xWySUIXsuY1PRjwhnpxMA0AVlzS/al0lGBGvsEVK', '7ef605fc8dba5425d6965fbd4c8fbe1f', '1');
INSERT INTO `account` VALUES ('16', 'marco', 'angius', 'marco.angius@gmail.it', '$2y$10$tYzqwDb/VHRTqZGkHdmrgu1lmSFTyAiQcQyhQ8npNqsJp9RZBjJ22', '303ed4c69846ab36c2904d3ba8573050', '1');
INSERT INTO `account` VALUES ('17', 'sergio', 'micalizzi', 'sergio.micalizzi@gmail.com', '$2y$10$eroxuw2oHCffRa8l73grhuyl/HNMIlktzZIH/tz/OhVPUFOoPGJ/a', '46922a0880a8f11f8f69cbb52b1396be', '1');
INSERT INTO `account` VALUES ('18', 'Francesco', 'Ziparo', 'zipareddu@gmail.com', '$2y$10$A8esQpH/rRPfnNOpN3CMpO10Ozgu1DtReNgFfO2sawwtBM07bc8kq', 'b137fdd1f79d56c7edf3365fea7520f2', '1');

-- ----------------------------
-- Table structure for `exercise`
-- ----------------------------
DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise` (
  `id_exercise` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `muscolar_zone` text NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id_exercise`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of exercise
-- ----------------------------
INSERT INTO `exercise` VALUES ('1', 'distensioni con bilancere su panca', 'qualcosa', 'petto', 'prova1');
INSERT INTO `exercise` VALUES ('2', 'distensioni con manubri su panca inclinata', 'qualcosa1', 'petto', '');
INSERT INTO `exercise` VALUES ('3', 'butterfly', 'qualcosa2', 'petto', 'prova');
INSERT INTO `exercise` VALUES ('4', 'french press', 'qualcosa3', 'petto', '');
INSERT INTO `exercise` VALUES ('5', 'tricipes machine', 'qualcosa4', 'tricipiti', '');
INSERT INTO `exercise` VALUES ('6', 'lat machine', 'qualcosa5', 'schiena', '');
INSERT INTO `exercise` VALUES ('7', 'curl bilancere', 'qualcosa6', 'bicipiti', '');
INSERT INTO `exercise` VALUES ('8', 'leg extension', 'qualcosa7', 'gambe', '');
INSERT INTO `exercise` VALUES ('9', 'panca hyperextension', 'qualcosa8', 'spalle', '');
INSERT INTO `exercise` VALUES ('10', 'shoulder press', 'qualcosa9', 'spalle', '');

-- ----------------------------
-- Table structure for `exercise_list`
-- ----------------------------
DROP TABLE IF EXISTS `exercise_list`;
CREATE TABLE `exercise_list` (
  `id_list` int(11) NOT NULL AUTO_INCREMENT,
  `id_schedule` int(11) NOT NULL,
  `id_exercise` int(11) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '1',
  `ripetitions` int(11) NOT NULL,
  `weight` float NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id_list`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of exercise_list
-- ----------------------------
INSERT INTO `exercise_list` VALUES ('2', '2', '1', '3', '2', '15', 'qualcosa');

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `image` text NOT NULL,
  `send_date` date NOT NULL,
  `destination` text NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('1', 'r', 'rr', '', '2018-04-23', 'Multicast');
INSERT INTO `messages` VALUES ('2', 'nol', 'nilnj', '', '2018-04-28', 'Multicast');
INSERT INTO `messages` VALUES ('3', 'ciaoq', 'come va', '', '2018-05-10', 'Multicast');
INSERT INTO `messages` VALUES ('4', '', '', '', '2018-05-10', 'All');

-- ----------------------------
-- Table structure for `room`
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of room
-- ----------------------------

-- ----------------------------
-- Table structure for `schedules`
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `id_schedule` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `token_auth` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `details` varchar(250) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `num_days` int(11) DEFAULT '1',
  `objective` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_schedule`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of schedules
-- ----------------------------
INSERT INTO `schedules` VALUES ('5', '1', '', 'vdf', 'efv', '2018-05-05', '2018-05-05', '5', 'efv');

-- ----------------------------
-- Table structure for `subscription`
-- ----------------------------
DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `id_subscription` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `price` float NOT NULL,
  `expiration_date` date NOT NULL,
  PRIMARY KEY (`id_subscription`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of subscription
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `birth_date` text NOT NULL,
  `address` text NOT NULL,
  `phone` text,
  `image` text NOT NULL,
  `id_subscription` int(11) NOT NULL DEFAULT '0',
  `tipology` set('trainer','subscriber') NOT NULL DEFAULT 'subscriber',
  `active` int(1) DEFAULT '0',
  `token_aut` varchar(100) DEFAULT NULL,
  `token_firebase` text,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `token_aut` (`token_aut`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Matteo', 'Novembre', 'matteo.novembre94@gmail.com', '$2y$10$w/VhH2Fbx7fN5LicLLDdDeZ1mK5T5g4xZC3RAlbE/s0oucw6XqPTe', '1994-08-06', 'Via Quarnaro I, n.41', '0', '', '5', 'subscriber', '0', null, null);
INSERT INTO `user` VALUES ('2', 'Irene', 'Raimondi', 'ireraim@gmail.com', '$2y$10$.ahTbMa.wqeVje48mgYK1uJzwapMBXCSUxcb4qPuGo9NvUYm1fSRa', '1991-07-14', 'Via Monte Grappa 61', '0', '', '2', 'subscriber', '0', null, null);
INSERT INTO `user` VALUES ('3', 'Sergio', 'Micalizzi', 'sergio.micalizzi@gmail.com', '$2y$10$CTDkeY8TYUwybx5qJqGr9uvEwclgIg6Qd13xRZbu8/gBskgnims5G', '1992-01-01', 'via prova', '0', '', '1', 'subscriber', '0', null, null);
INSERT INTO `user` VALUES ('4', 'ciao', 'ciao', 'ciao', '1234', 'csdvv', 'via prova', '3333333333333', '', '0', 'subscriber', '0', null, '');
INSERT INTO `user` VALUES ('5', 'matto', 'matto', 'matto@it.it', '$2y$10$jn0JEJ3/tEXyOsftQwTJJuDxYKUtbFvovGVEoP3a2vbOlAWD2WM5a', '', 'via prova', '3333333333', '', '1', 'subscriber', '0', null, '');
