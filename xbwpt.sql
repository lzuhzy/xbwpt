-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: 202.201.1.235    Database: pt
-- ------------------------------------------------------
-- Server version	5.1.73-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adclicks`
--

DROP TABLE IF EXISTS `adclicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adclicks` (
  `adid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adminpanel`
--

DROP TABLE IF EXISTS `adminpanel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminpanel` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(256) NOT NULL DEFAULT '',
  `info` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertisements`
--

DROP TABLE IF EXISTS `advertisements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertisements` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('bbcodes','xhtml','text','image','flash') NOT NULL,
  `position` enum('header','footer','belownav','belowsearchbox','torrentdetail','comment','interoverforums','forumpost','popup') NOT NULL,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `parameters` text NOT NULL,
  `code` text NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agent_allowed_exception`
--

DROP TABLE IF EXISTS `agent_allowed_exception`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_allowed_exception` (
  `family_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `peer_id` varchar(20) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `comment` varchar(200) NOT NULL DEFAULT '',
  KEY `family_id` (`family_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agent_allowed_family`
--

DROP TABLE IF EXISTS `agent_allowed_family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_allowed_family` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `family` varchar(50) NOT NULL DEFAULT '',
  `start_name` varchar(100) NOT NULL DEFAULT '',
  `peer_id_pattern` varchar(200) NOT NULL,
  `peer_id_match_num` tinyint(3) unsigned NOT NULL,
  `peer_id_matchtype` enum('dec','hex') NOT NULL DEFAULT 'dec',
  `peer_id_start` varchar(20) NOT NULL,
  `agent_pattern` varchar(200) NOT NULL,
  `agent_match_num` tinyint(3) unsigned NOT NULL,
  `agent_matchtype` enum('dec','hex') NOT NULL DEFAULT 'dec',
  `agent_start` varchar(100) NOT NULL,
  `exception` enum('yes','no') NOT NULL DEFAULT 'no',
  `allowhttps` enum('yes','no') NOT NULL DEFAULT 'no',
  `comment` varchar(200) NOT NULL DEFAULT '',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9004 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `allowedemails`
--

DROP TABLE IF EXISTS `allowedemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowedemails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `width` smallint(6) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `filename` varchar(256) NOT NULL DEFAULT '',
  `dlkey` char(32) NOT NULL,
  `filetype` varchar(50) NOT NULL DEFAULT '',
  `filesize` bigint(20) unsigned NOT NULL DEFAULT '0',
  `location` varchar(256) NOT NULL,
  `downloads` mediumint(8) NOT NULL DEFAULT '0',
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `inuse` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pid` (`userid`,`id`),
  KEY `dateline` (`added`,`isimage`,`downloads`)
) ENGINE=MyISAM AUTO_INCREMENT=22238 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `audiocodecs`
--

DROP TABLE IF EXISTS `audiocodecs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audiocodecs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `image` varchar(256) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `avps`
--

DROP TABLE IF EXISTS `avps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avps` (
  `arg` varchar(20) NOT NULL DEFAULT '',
  `value_s` text NOT NULL,
  `value_i` int(11) NOT NULL DEFAULT '0',
  `value_u` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`arg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bannedemails`
--

DROP TABLE IF EXISTS `bannedemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannedemails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bans`
--

DROP TABLE IF EXISTS `bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bans` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `first` bigint(20) NOT NULL,
  `last` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `first_last` (`first`,`last`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `betgames`
--

DROP TABLE IF EXISTS `betgames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betgames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `undertext` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `endtime` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `sort` int(1) NOT NULL DEFAULT '0',
  `creator` int(10) NOT NULL,
  `fix` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `betlog`
--

DROP TABLE IF EXISTS `betlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `bonus` int(11) NOT NULL DEFAULT '0',
  `msg` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `userid_2` (`userid`,`bonus`)
) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `betoptions`
--

DROP TABLE IF EXISTS `betoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betoptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gameid` int(11) NOT NULL DEFAULT '0',
  `text` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `odds` double NOT NULL DEFAULT '0',
  `win` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gameid` (`gameid`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gameid` int(11) NOT NULL DEFAULT '0',
  `bonus` int(11) NOT NULL DEFAULT '0',
  `optionid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gameid` (`gameid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bettop`
--

DROP TABLE IF EXISTS `bettop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bettop` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `bonus` int(11) NOT NULL DEFAULT '0',
  `winbonus` int(11) NOT NULL DEFAULT '0',
  `lossbonus` int(11) NOT NULL DEFAULT '0',
  `winnum` int(11) NOT NULL DEFAULT '0',
  `lossnum` int(11) NOT NULL COMMENT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bitbucket`
--

DROP TABLE IF EXISTS `bitbucket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitbucket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=623 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blackjack`
--

DROP TABLE IF EXISTS `blackjack`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blackjack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `status` enum('playing','waiting') COLLATE utf8_bin NOT NULL DEFAULT 'playing',
  `cards` text COLLATE utf8_bin NOT NULL,
  `date` int(11) DEFAULT '0',
  `gameover` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  PRIMARY KEY (`userid`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6351 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `blockid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userfriend` (`userid`,`blockid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bonuses`
--

DROP TABLE IF EXISTS `bonuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `postid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bonus` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrentid_id` (`torrentid`,`id`),
  UNIQUE KEY `postid_id` (`postid`,`id`),
  KEY `torrentid_userid` (`torrentid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmarks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid_torrentid` (`userid`,`torrentid`)
) ENGINE=MyISAM AUTO_INCREMENT=4052 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `points` int(11) NOT NULL DEFAULT '0',
  `pic` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `mode` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `class_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL,
  `name_chs` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_index` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mode_sort` (`mode`,`sort_index`)
) ENGINE=MyISAM AUTO_INCREMENT=13011 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `caticons`
--

DROP TABLE IF EXISTS `caticons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caticons` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `folder` varchar(256) NOT NULL,
  `cssfile` varchar(255) NOT NULL DEFAULT '',
  `multilang` enum('yes','no') NOT NULL DEFAULT 'no',
  `secondicon` enum('yes','no') NOT NULL DEFAULT 'no',
  `designer` varchar(50) NOT NULL DEFAULT '',
  `comment` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cheaters`
--

DROP TABLE IF EXISTS `cheaters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheaters` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `torrentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `anctime` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `seeders` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `leechers` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dealtby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dealtwith` tinyint(1) NOT NULL DEFAULT '0',
  `comment` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chronicle`
--

DROP TABLE IF EXISTS `chronicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chronicle` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `txt` text,
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `codecs`
--

DROP TABLE IF EXISTS `codecs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codecs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `torrent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text,
  `ori_text` text,
  `editedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `editdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `offer` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `request` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `torrent_id` (`torrent`,`id`),
  KEY `offer_id` (`offer`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29565 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `flagpic` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `downloadspeed`
--

DROP TABLE IF EXISTS `downloadspeed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `downloadspeed` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drawlottery`
--

DROP TABLE IF EXISTS `drawlottery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drawlottery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `num1` int(10) NOT NULL DEFAULT '0',
  `num2` int(10) NOT NULL DEFAULT '0',
  `num3` int(10) NOT NULL DEFAULT '0',
  `num4` int(10) NOT NULL DEFAULT '0',
  `num5` int(10) NOT NULL DEFAULT '0',
  `drawtime` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` smallint(5) unsigned NOT NULL,
  `lang_id` smallint(5) unsigned NOT NULL DEFAULT '6',
  `type` enum('categ','item') NOT NULL DEFAULT 'item',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `categ` smallint(5) unsigned NOT NULL DEFAULT '0',
  `order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=478 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM AUTO_INCREMENT=1975183 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forummods`
--

DROP TABLE IF EXISTS `forummods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forummods` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `forumid` smallint(5) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forumid` (`forumid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL,
  `description` varchar(256) NOT NULL DEFAULT '',
  `minclassread` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `minclasswrite` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `postcount` int(10) unsigned NOT NULL DEFAULT '0',
  `topiccount` int(10) unsigned NOT NULL DEFAULT '0',
  `minclasscreate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `forid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `freshman`
--

DROP TABLE IF EXISTS `freshman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freshman` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer4` varchar(255) NOT NULL,
  `answer8` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='新手任务答题';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `freshmananswer`
--

DROP TABLE IF EXISTS `freshmananswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freshmananswer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `questionid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL,
  `friendid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userfriend` (`userid`,`friendid`)
) ENGINE=MyISAM AUTO_INCREMENT=1833 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fun`
--

DROP TABLE IF EXISTS `fun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fun` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text,
  `title` varchar(256) NOT NULL DEFAULT '',
  `status` enum('normal','dull','notfunny','funny','veryfunny','banned') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `funds`
--

DROP TABLE IF EXISTS `funds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usd` decimal(8,2) NOT NULL DEFAULT '0.00',
  `cny` decimal(8,2) NOT NULL DEFAULT '0.00',
  `user` mediumint(8) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `memo` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `funvotes`
--

DROP TABLE IF EXISTS `funvotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funvotes` (
  `funid` mediumint(8) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote` enum('fun','dull') NOT NULL DEFAULT 'fun',
  PRIMARY KEY (`funid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `givebonus`
--

DROP TABLE IF EXISTS `givebonus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `givebonus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bonusfromuserid` mediumint(8) unsigned NOT NULL,
  `bonustotorrentid` mediumint(8) unsigned NOT NULL,
  `bonus` decimal(10,1) unsigned NOT NULL,
  `type` int(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invites`
--

DROP TABLE IF EXISTS `invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inviter` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invitee` varchar(80) NOT NULL DEFAULT '',
  `hash` char(32) NOT NULL,
  `time_invited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`(3))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `iplog`
--

DROP TABLE IF EXISTS `iplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iplog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL,
  `access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=9293 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `isp`
--

DROP TABLE IF EXISTS `isp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `isp` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(50) NOT NULL,
  `flagpic` varchar(256) NOT NULL DEFAULT '',
  `sub_lang` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rule_lang` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `site_lang` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `site_lang_folder` varchar(256) NOT NULL DEFAULT '',
  `trans_state` enum('up-to-date','outdate','incomplete','need-new','unavailable') NOT NULL DEFAULT 'unavailable',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(256) NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `location_main` varchar(200) NOT NULL,
  `location_sub` varchar(200) NOT NULL,
  `flagpic` varchar(50) DEFAULT NULL,
  `start_ip` varchar(20) NOT NULL,
  `end_ip` varchar(20) NOT NULL,
  `theory_upspeed` int(10) unsigned NOT NULL DEFAULT '10',
  `practical_upspeed` int(10) unsigned NOT NULL DEFAULT '10',
  `theory_downspeed` int(10) unsigned NOT NULL DEFAULT '10',
  `practical_downspeed` int(10) unsigned NOT NULL DEFAULT '10',
  `hit` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginattempts`
--

DROP TABLE IF EXISTS `loginattempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginattempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `attempts` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` enum('login','recover') NOT NULL DEFAULT 'login',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=174139 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lottery`
--

DROP TABLE IF EXISTS `lottery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lottery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ownerid` int(10) DEFAULT NULL,
  `selfkey` text CHARACTER SET utf8 NOT NULL,
  `drawid` int(10) NOT NULL DEFAULT '0',
  `num1` int(10) NOT NULL DEFAULT '0',
  `num2` int(10) NOT NULL DEFAULT '0',
  `num3` int(10) NOT NULL DEFAULT '0',
  `num4` int(10) NOT NULL DEFAULT '0',
  `num5` int(10) NOT NULL DEFAULT '0',
  `shoptime` date NOT NULL DEFAULT '0000-00-00',
  `isencase` int(1) NOT NULL DEFAULT '0',
  `encasetime` date NOT NULL DEFAULT '0000-00-00',
  `multiple` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `lotteryowner` (`ownerid`)
) ENGINE=MyISAM AUTO_INCREMENT=244 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `receiver` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(128) NOT NULL DEFAULT '',
  `msg` text,
  `unread` enum('yes','no') NOT NULL DEFAULT 'yes',
  `location` smallint(6) NOT NULL DEFAULT '1',
  `saved` enum('no','yes') NOT NULL DEFAULT 'no',
  `goto` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`)
) ENGINE=MyISAM AUTO_INCREMENT=491385 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modpanel`
--

DROP TABLE IF EXISTS `modpanel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modpanel` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(256) NOT NULL DEFAULT '',
  `info` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1020 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text,
  `title` varchar(255) NOT NULL DEFAULT '',
  `notify` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offers` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(225) NOT NULL,
  `descr` text,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `allowedtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `yeah` smallint(5) unsigned NOT NULL DEFAULT '0',
  `against` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `allowed` enum('allowed','pending','denied') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=2627 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `offervotes`
--

DROP TABLE IF EXISTS `offervotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offervotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offerid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vote` enum('yeah','against') NOT NULL DEFAULT 'yeah',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=35021 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `overforums`
--

DROP TABLE IF EXISTS `overforums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overforums` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` varchar(256) NOT NULL DEFAULT '',
  `minclassview` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peers`
--

DROP TABLE IF EXISTS `peers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `peer_id` binary(20) NOT NULL,
  `ip` varchar(64) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') NOT NULL DEFAULT 'no',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prev_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `agent` varchar(60) NOT NULL DEFAULT '',
  `finishedat` int(10) unsigned NOT NULL DEFAULT '0',
  `downloadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uploadoffset` bigint(20) unsigned NOT NULL DEFAULT '0',
  `passkey` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `torrent` (`torrent`)
) ENGINE=MEMORY AUTO_INCREMENT=1047 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmboxes`
--

DROP TABLE IF EXISTS `pmboxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmboxes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL,
  `boxnumber` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pollanswers`
--

DROP TABLE IF EXISTS `pollanswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pollanswers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pollid` mediumint(8) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL,
  `selection` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`),
  KEY `selection` (`selection`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `question` varchar(255) NOT NULL DEFAULT '',
  `option0` varchar(40) NOT NULL DEFAULT '',
  `option1` varchar(40) NOT NULL DEFAULT '',
  `option2` varchar(40) NOT NULL DEFAULT '',
  `option3` varchar(40) NOT NULL DEFAULT '',
  `option4` varchar(40) NOT NULL DEFAULT '',
  `option5` varchar(40) NOT NULL DEFAULT '',
  `option6` varchar(40) NOT NULL DEFAULT '',
  `option7` varchar(40) NOT NULL DEFAULT '',
  `option8` varchar(40) NOT NULL DEFAULT '',
  `option9` varchar(40) NOT NULL DEFAULT '',
  `option10` varchar(40) NOT NULL DEFAULT '',
  `option11` varchar(40) NOT NULL DEFAULT '',
  `option12` varchar(40) NOT NULL DEFAULT '',
  `option13` varchar(40) NOT NULL DEFAULT '',
  `option14` varchar(40) NOT NULL DEFAULT '',
  `option15` varchar(40) NOT NULL DEFAULT '',
  `option16` varchar(40) NOT NULL DEFAULT '',
  `option17` varchar(40) NOT NULL DEFAULT '',
  `option18` varchar(40) NOT NULL DEFAULT '',
  `option19` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text,
  `ori_body` text,
  `editedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `editdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `topicid_id` (`topicid`,`id`),
  KEY `added` (`added`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM AUTO_INCREMENT=2165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `processings`
--

DROP TABLE IF EXISTS `processings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prolinkclicks`
--

DROP TABLE IF EXISTS `prolinkclicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prolinkclicks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=443 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `readposts`
--

DROP TABLE IF EXISTS `readposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `readposts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpostread` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=11112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regimages`
--

DROP TABLE IF EXISTS `regimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regimages` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `imagehash` varchar(32) NOT NULL DEFAULT '',
  `imagestring` varchar(8) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `addedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reportid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('torrent','user','offer','request','post','comment','subtitle') NOT NULL DEFAULT 'torrent',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `dealtby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dealtwith` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=573 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `req`
--

DROP TABLE IF EXISTS `req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `req` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '1000',
  `name` varchar(255) DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `introduce` text,
  `ori_introduce` text,
  `amount` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `ori_amount` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0',
  `finish` enum('yes','no','cancel') NOT NULL DEFAULT 'no',
  `finished_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resetdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finish` (`finish`,`name`,`added`,`amount`,`introduce`(10))
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(15) NOT NULL,
  `userid` int(11) NOT NULL,
  `finish` int(11) NOT NULL,
  `request` int(11) NOT NULL,
  `descr` int(11) NOT NULL,
  `ori_descr` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `ori_amount` int(11) NOT NULL,
  `added` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resreq`
--

DROP TABLE IF EXISTS `resreq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resreq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reqid` int(11) NOT NULL DEFAULT '0',
  `torrentid` int(11) NOT NULL DEFAULT '0',
  `chosen` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `reqid` (`reqid`,`chosen`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rules`
--

DROP TABLE IF EXISTS `rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rules` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lang_id` smallint(5) unsigned NOT NULL DEFAULT '6',
  `title` varchar(255) NOT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `ip` varchar(14) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `searchbox`
--

DROP TABLE IF EXISTS `searchbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searchbox` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `showsubcat` tinyint(1) NOT NULL DEFAULT '0',
  `showsource` tinyint(1) NOT NULL DEFAULT '0',
  `showmedium` tinyint(1) NOT NULL DEFAULT '0',
  `showcodec` tinyint(1) NOT NULL DEFAULT '0',
  `showstandard` tinyint(1) NOT NULL DEFAULT '0',
  `showprocessing` tinyint(1) NOT NULL DEFAULT '0',
  `showteam` tinyint(1) NOT NULL DEFAULT '0',
  `showaudiocodec` tinyint(1) NOT NULL DEFAULT '0',
  `catsperrow` smallint(5) unsigned NOT NULL DEFAULT '7',
  `catpadding` smallint(5) unsigned NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `secondicons`
--

DROP TABLE IF EXISTS `secondicons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secondicons` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `medium` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `codec` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `standard` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `processing` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `audiocodec` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shoutbox`
--

DROP TABLE IF EXISTS `shoutbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoutbox` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `type` enum('sb','hb') NOT NULL DEFAULT 'sb',
  `ip` varbinary(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29776 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `signin`
--

DROP TABLE IF EXISTS `signin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `signin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signinleave` text NOT NULL,
  `note` text NOT NULL,
  `userid` int(11) NOT NULL,
  `signindate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sitelog`
--

DROP TABLE IF EXISTS `sitelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sitelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `txt` text NOT NULL,
  `security_level` enum('normal','mod') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM AUTO_INCREMENT=121950234 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snatched`
--

DROP TABLE IF EXISTS `snatched`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snatched` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `torrentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seedtime` int(10) unsigned NOT NULL DEFAULT '0',
  `leechtime` int(10) unsigned NOT NULL DEFAULT '0',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `startdat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finished` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `torrentid_userid` (`torrentid`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=738888 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sources` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `staffmessages`
--

DROP TABLE IF EXISTS `staffmessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffmessages` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `sender` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `msg` text,
  `subject` varchar(128) NOT NULL DEFAULT '',
  `answeredby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `answered` tinyint(1) NOT NULL DEFAULT '0',
  `answer` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `standards`
--

DROP TABLE IF EXISTS `standards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `standards` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stylesheets`
--

DROP TABLE IF EXISTS `stylesheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stylesheets` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `addicode` text,
  `designer` varchar(50) NOT NULL DEFAULT '',
  `comment` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subs`
--

DROP TABLE IF EXISTS `subs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent_id` mediumint(8) unsigned NOT NULL,
  `lang_id` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uppedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `anonymous` enum('yes','no') NOT NULL DEFAULT 'no',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ext` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `torrentid_langid` (`torrent_id`,`lang_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1268 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `suggest`
--

DROP TABLE IF EXISTS `suggest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suggest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `adddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `keywords` (`keywords`(4)),
  KEY `adddate` (`adddate`)
) ENGINE=MyISAM AUTO_INCREMENT=43165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sysoppanel`
--

DROP TABLE IF EXISTS `sysoppanel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sysoppanel` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(256) NOT NULL DEFAULT '',
  `info` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3028 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `thanks`
--

DROP TABLE IF EXISTS `thanks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thanks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrentid_id` (`torrentid`,`id`),
  KEY `torrentid_userid` (`torrentid`,`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=56320 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(128) NOT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `forumid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `firstpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `sticky` enum('no','yes') NOT NULL DEFAULT 'no',
  `hlcolor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `subject` (`subject`),
  KEY `forumid_lastpost` (`forumid`,`lastpost`),
  KEY `forumid_sticky_lastpost` (`forumid`,`sticky`,`lastpost`)
) ENGINE=MyISAM AUTO_INCREMENT=1134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `torrents`
--

DROP TABLE IF EXISTS `torrents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torrents` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `info_hash` binary(20) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `save_as` varchar(255) NOT NULL DEFAULT '',
  `descr` text,
  `small_descr` varchar(255) NOT NULL DEFAULT '',
  `ori_descr` text,
  `category` smallint(5) unsigned NOT NULL DEFAULT '0',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `medium` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `codec` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `standard` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `processing` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `audiocodec` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` enum('single','multi') NOT NULL DEFAULT 'single',
  `numfiles` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `times_completed` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `leechers` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `seeders` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `nfo` blob,
  `sp_state` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `promotion_time_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `promotion_until` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `anonymous` enum('yes','no') NOT NULL DEFAULT 'no',
  `url` int(10) unsigned DEFAULT NULL,
  `dburl` int(10) NOT NULL,
  `pos_state` enum('normal','sticky') NOT NULL DEFAULT 'normal',
  `cache_stamp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `picktype` enum('hot','classic','recommended','normal') NOT NULL DEFAULT 'normal',
  `picktime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_reseed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pos_state_until` int(20) unsigned NOT NULL,
  `status` enum('normal','recycle','candidate','') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`),
  UNIQUE KEY `info_hash` (`info_hash`),
  KEY `owner` (`owner`),
  KEY `visible_pos_id` (`visible`,`pos_state`,`id`),
  KEY `url` (`url`),
  KEY `category_visible_banned` (`category`,`visible`,`banned`),
  KEY `visible_banned_pos_id` (`visible`,`banned`,`pos_state`,`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=31452 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `torrents_state`
--

DROP TABLE IF EXISTS `torrents_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torrents_state` (
  `global_sp_state` tinyint(3) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uploadspeed`
--

DROP TABLE IF EXISTS `uploadspeed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploadspeed` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(40) NOT NULL DEFAULT '',
  `passhash` varchar(32) NOT NULL DEFAULT '',
  `secret` varbinary(20) NOT NULL,
  `email` varchar(80) NOT NULL DEFAULT '',
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_home` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_offer` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `forum_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_staffmsg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_pm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_comment` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_post` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_browse` int(10) unsigned NOT NULL DEFAULT '0',
  `last_music` int(10) unsigned NOT NULL DEFAULT '0',
  `last_catchup` int(10) unsigned NOT NULL DEFAULT '0',
  `editsecret` varbinary(20) NOT NULL DEFAULT '',
  `privacy` enum('strong','normal','low') NOT NULL DEFAULT 'normal',
  `stylesheet` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `caticon` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fontsize` enum('small','medium','large') NOT NULL DEFAULT 'medium',
  `info` text,
  `acceptpms` enum('yes','friends','no') NOT NULL DEFAULT 'yes',
  `commentpm` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `page` text NOT NULL,
  `class` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `max_class_once` tinyint(3) NOT NULL DEFAULT '1',
  `avatar` varchar(256) NOT NULL DEFAULT '',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seedtime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `leechtime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `country` smallint(5) unsigned NOT NULL DEFAULT '8',
  `notifs` varchar(500) DEFAULT '0',
  `modcomment` text,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatars` enum('yes','no') NOT NULL DEFAULT 'yes',
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `donated` decimal(8,2) NOT NULL DEFAULT '0.00',
  `donated_cny` decimal(8,2) NOT NULL DEFAULT '0.00',
  `donoruntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `warned` enum('yes','no') NOT NULL DEFAULT 'no',
  `warneduntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `noad` enum('yes','no') NOT NULL DEFAULT 'no',
  `noaduntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torrentsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `topicsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `postsperpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `clicktopic` enum('firstpage','lastpage') NOT NULL DEFAULT 'firstpage',
  `deletepms` enum('yes','no') NOT NULL DEFAULT 'yes',
  `savepms` enum('yes','no') NOT NULL DEFAULT 'no',
  `showhot` enum('yes','no') NOT NULL DEFAULT 'yes',
  `showclassic` enum('yes','no') NOT NULL DEFAULT 'yes',
  `support` enum('yes','no') NOT NULL DEFAULT 'no',
  `picker` enum('yes','no') NOT NULL DEFAULT 'no',
  `stafffor` varchar(255) NOT NULL DEFAULT '',
  `supportfor` varchar(255) NOT NULL DEFAULT '',
  `pickfor` varchar(255) NOT NULL DEFAULT '',
  `supportlang` varchar(50) NOT NULL DEFAULT '',
  `passkey` varchar(32) NOT NULL DEFAULT '',
  `promotion_link` varchar(32) DEFAULT NULL,
  `uploadpos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `forumpost` enum('yes','no') NOT NULL DEFAULT 'yes',
  `downloadpos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `clientselect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `signatures` enum('yes','no') NOT NULL DEFAULT 'yes',
  `signature` varchar(800) NOT NULL DEFAULT '',
  `lang` smallint(5) unsigned NOT NULL DEFAULT '25',
  `cheat` smallint(6) NOT NULL DEFAULT '0',
  `download` int(10) unsigned NOT NULL DEFAULT '0',
  `upload` int(10) unsigned NOT NULL DEFAULT '0',
  `isp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `invites` smallint(5) unsigned NOT NULL DEFAULT '0',
  `invited_by` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `gender` enum('Male','Female','N/A') NOT NULL DEFAULT 'N/A',
  `vip_added` enum('yes','no') NOT NULL DEFAULT 'no',
  `vip_until` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seedbonus` decimal(10,1) NOT NULL DEFAULT '0.0',
  `charity` decimal(10,1) NOT NULL DEFAULT '0.0',
  `bonuscomment` text,
  `parked` enum('yes','no') NOT NULL DEFAULT 'no',
  `leechwarn` enum('yes','no') NOT NULL DEFAULT 'no',
  `leechwarnuntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastwarned` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeswarned` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `warnedby` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sbnum` smallint(5) unsigned NOT NULL DEFAULT '70',
  `sbrefresh` smallint(5) unsigned NOT NULL DEFAULT '120',
  `hidehb` enum('yes','no') DEFAULT 'no',
  `showimdb` enum('yes','no') DEFAULT 'yes',
  `showdescription` enum('yes','no') DEFAULT 'yes',
  `showcomment` enum('yes','no') DEFAULT 'yes',
  `showclienterror` enum('yes','no') NOT NULL DEFAULT 'no',
  `showdlnotice` tinyint(1) NOT NULL DEFAULT '1',
  `tooltip` enum('minorimdb','medianimdb','off') NOT NULL DEFAULT 'off',
  `shownfo` enum('yes','no') DEFAULT 'yes',
  `timetype` enum('timeadded','timealive') DEFAULT 'timealive',
  `appendsticky` enum('yes','no') DEFAULT 'yes',
  `appendnew` enum('yes','no') DEFAULT 'yes',
  `appendpromotion` enum('highlight','word','icon','off') DEFAULT 'highlight',
  `appendpicked` enum('yes','no') DEFAULT 'yes',
  `dlicon` enum('yes','no') DEFAULT 'yes',
  `bmicon` enum('yes','no') DEFAULT 'yes',
  `showsearchbox` enum('yes','no') NOT NULL DEFAULT 'no',
  `showsmalldescr` enum('yes','no') NOT NULL DEFAULT 'yes',
  `showcomnum` enum('yes','no') DEFAULT 'yes',
  `showlastcom` enum('yes','no') DEFAULT 'no',
  `showlastpost` enum('yes','no') NOT NULL DEFAULT 'no',
  `pmnum` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `school` smallint(5) unsigned NOT NULL DEFAULT '35',
  `showfb` enum('yes','no') NOT NULL DEFAULT 'yes',
  `salarynum` smallint(11) unsigned NOT NULL DEFAULT '0',
  `salary` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `up_class` int(11) NOT NULL DEFAULT '0',
  `bjwins` int(10) NOT NULL DEFAULT '0',
  `bjlosses` int(10) NOT NULL DEFAULT '0',
  `stealtime` time DEFAULT NULL,
  `stealstatus` smallint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status_added` (`status`,`added`),
  KEY `ip` (`ip`),
  KEY `uploaded` (`uploaded`),
  KEY `downloaded` (`downloaded`),
  KEY `country` (`country`),
  KEY `last_access` (`last_access`),
  KEY `enabled` (`enabled`),
  KEY `warned` (`warned`),
  KEY `cheat` (`cheat`),
  KEY `class` (`class`),
  KEY `passkey` (`passkey`(8))
) ENGINE=MyISAM AUTO_INCREMENT=148162 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-15 22:26:32
