-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 13-05-15 13:22 
-- 서버 버전: 5.0.95
-- PHP 버전: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `mediaply_music`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` int(11) NOT NULL auto_increment,
  `comment` text,
  `msg_id_fk` int(11) default NULL,
  `uid_fk` int(11) default NULL,
  `ip` varchar(30) default NULL,
  `created` int(11) default '1269249260',
  PRIMARY KEY  (`com_id`),
  KEY `msg_id_fk` (`msg_id_fk`),
  KEY `uid_fk` (`uid_fk`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `friend_id` int(11) NOT NULL auto_increment,
  `friend_one` int(11) default NULL,
  `friend_two` int(11) default NULL,
  `role` varchar(5) default NULL,
  PRIMARY KEY  (`friend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_album`
--

CREATE TABLE IF NOT EXISTS `ft_album` (
  `aid` int(11) NOT NULL auto_increment,
  `uid_fk` int(11) default NULL,
  `gid_fk` int(11) default NULL,
  `artistname` varchar(255) NOT NULL,
  `albumname` varchar(255) default NULL,
  `explain` text,
  `album_pic` varchar(255) NOT NULL default 'default.png',
  `album_recommend` int(11) NOT NULL default '0',
  `recommend_cnt` int(11) NOT NULL default '0',
  `reg_date` date default NULL,
  `reg_time` time default NULL,
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_album_recommend`
--

CREATE TABLE IF NOT EXISTS `ft_album_recommend` (
  `arid` int(11) NOT NULL auto_increment,
  `aid_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`arid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_chart`
--

CREATE TABLE IF NOT EXISTS `ft_chart` (
  `cid` int(11) NOT NULL auto_increment,
  `tid_fk` int(11) NOT NULL,
  `year` int(5) NOT NULL,
  `month` int(3) NOT NULL,
  `day` int(3) NOT NULL,
  `buy_cnt` int(11) NOT NULL,
  `download_cnt` int(11) NOT NULL,
  `streaming_cnt` int(11) NOT NULL,
  `playlist_cnt` int(11) NOT NULL,
  `recommend_cnt` int(11) NOT NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=355 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_config`
--

CREATE TABLE IF NOT EXISTS `ft_config` (
  `upd_date` date NOT NULL,
  `upd_time` time NOT NULL,
  `impossible_username` text NOT NULL,
  `impossible_nickname` text NOT NULL,
  `impossible_artistname` text NOT NULL,
  `music_indr` text NOT NULL,
  `terms` text NOT NULL,
  `privacy` text NOT NULL,
  `per_buy` int(11) NOT NULL,
  `per_download` int(11) NOT NULL,
  `per_streaming` int(11) NOT NULL,
  `per_playlist` int(11) NOT NULL,
  `per_recommend` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_download`
--

CREATE TABLE IF NOT EXISTS `ft_download` (
  `did` int(11) NOT NULL auto_increment,
  `tid_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_genre`
--

CREATE TABLE IF NOT EXISTS `ft_genre` (
  `gid` int(11) NOT NULL auto_increment,
  `genre` varchar(255) default NULL,
  PRIMARY KEY  (`gid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_notice`
--

CREATE TABLE IF NOT EXISTS `ft_notice` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_paid`
--

CREATE TABLE IF NOT EXISTS `ft_paid` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('track','present') default NULL,
  `uid_fk` int(11) NOT NULL,
  `artist_uid_fk` int(11) NOT NULL,
  `tid_fk` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `state` enum('N','A','W','Y') NOT NULL default 'N',
  `paid_date` date NOT NULL,
  `paid_time` time NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_payment`
--

CREATE TABLE IF NOT EXISTS `ft_payment` (
  `tid` varchar(255) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `unitprice` int(11) NOT NULL,
  `paymethod` varchar(255) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_time` time NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_playlist`
--

CREATE TABLE IF NOT EXISTS `ft_playlist` (
  `pid` int(11) NOT NULL auto_increment,
  `cid_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `tid_fk` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_recommend`
--

CREATE TABLE IF NOT EXISTS `ft_recommend` (
  `rid` int(11) NOT NULL auto_increment,
  `cid_fk` int(11) NOT NULL,
  `tid_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `ft_track`
--

CREATE TABLE IF NOT EXISTS `ft_track` (
  `tid` int(11) NOT NULL auto_increment,
  `aid_fk` int(11) default NULL,
  `gid_fk` int(11) default NULL,
  `artistname` varchar(255) NOT NULL,
  `trackname` varchar(255) default NULL,
  `track_file` varchar(255) default NULL,
  `lyric` text,
  `price` int(11) NOT NULL default '0',
  `free_download` enum('N','Y') NOT NULL default 'N',
  `free_streaming` enum('N','Y') NOT NULL default 'N',
  `state` enum('N','Y','D') NOT NULL default 'N',
  `reg_date` date default NULL,
  `reg_time` time default NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=150 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL auto_increment,
  `message` text,
  `uid_fk` int(11) default NULL,
  `ip` varchar(30) default NULL,
  `created` int(11) default '1269249260',
  `uploads` varchar(30) default NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `uid_fk` (`uid_fk`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=209 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `profile_pic` varchar(255) NOT NULL,
  `profile_bg` varchar(255) NOT NULL,
  `bg_repeat` enum('N','Y') NOT NULL default 'N',
  `mypage_title` varchar(255) default NULL,
  `friend_count` int(11) default '0',
  `status` int(1) default '1',
  `nickname` varchar(255) default NULL,
  `artistname` varchar(255) default '아티스트',
  `label` varchar(255) default NULL,
  `gid_fk1` int(11) default NULL,
  `gid_fk2` int(11) default NULL,
  `introduce` text,
  `bank_name` varchar(255) default NULL,
  `bank_account` varchar(255) default NULL,
  `bank_holder` varchar(255) default NULL,
  `type` enum('listener','artist','admin') default 'artist',
  `is_secret` enum('N','Y') NOT NULL default 'Y',
  `recommend_name` varchar(255) default NULL,
  `recommend_pic` varchar(255) NOT NULL default 'default.png',
  `recommend_introduce` text,
  `recommend_cnt` int(11) NOT NULL default '0',
  `reg_date` date default NULL,
  `reg_time` time default NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `users_recommend`
--

CREATE TABLE IF NOT EXISTS `users_recommend` (
  `urid` int(11) NOT NULL auto_increment,
  `target_uid_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`urid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `user_uploads`
--

CREATE TABLE IF NOT EXISTS `user_uploads` (
  `id` int(11) NOT NULL auto_increment,
  `image_path` varchar(255) default NULL,
  `uid_fk` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `uid_fk` (`uid_fk`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
