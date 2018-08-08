
CREATE TABLE IF NOT EXISTS `cmc_coins` (
  `cmcid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `website_slug` varchar(50) NOT NULL,
  PRIMARY KEY (`cmcid`),
  UNIQUE KEY `name` (`name`,`symbol`,`website_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

