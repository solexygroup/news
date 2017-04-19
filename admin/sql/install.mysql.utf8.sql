DROP TABLE IF EXISTS `#__news`;

CREATE TABLE `#__news` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `asset_id` INT(10) NOT NULL DEFAULT '0',
 `greeting` varchar(25) NOT NULL,
 `intro` varchar(25) NOT NULL,
 `state` tinyint(1) NOT NULL DEFAULT '0',
 `catid` int(11) NOT NULL DEFAULT '0',
 `ordering` INT(11) NOT NULL DEFAULT '0',
 `params` TEXT NOT NULL DEFAULT '',
 PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__news` (`greeting`) VALUES
 ('test1'),
 ('test2!');