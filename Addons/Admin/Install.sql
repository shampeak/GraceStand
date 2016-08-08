-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2016 �?07 �?12 �?18:11
-- 服务器版本: 5.5.47
-- PHP 版本: 5.5.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `my`
--

-- --------------------------------------------------------

--
-- 表的结构 `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(16) CHARACTER SET utf8 NOT NULL,
  `dt` int(11) NOT NULL DEFAULT '0',
  `action` varchar(16) NOT NULL DEFAULT 'buy' COMMENT 'buy/sail',
  `num` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '单价',
  `shnum` int(11) NOT NULL DEFAULT '0',
  `junjia` decimal(10,3) NOT NULL DEFAULT '0.000',
  `fees` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '手续费',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `shares`
--

INSERT INTO `shares` (`id`, `code`, `dt`, `action`, `num`, `price`, `shnum`, `junjia`, `fees`) VALUES
(24, 'sh600157', 1468315192, 'buy', 5000, '4.230', 5000, '4.230', '0.000');

-- --------------------------------------------------------

--
-- 表的结构 `shareslist`
--

CREATE TABLE IF NOT EXISTS `shareslist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(16) NOT NULL,
  `title` varchar(16) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `shareslist`
--

INSERT INTO `shareslist` (`id`, `code`, `title`, `num`, `price`) VALUES
(1, 'sh601006', '大秦铁路', 0, '0.000'),
(7, 'sh601007', '金陵饭店', 0, '0.000'),
(6, 'sh600157', '永泰能源', 5000, '4.230');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
