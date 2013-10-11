-- Databases & Web Applications
-- Homework #3, Assignment #2.

-- Author: Dmitrii Cucleschin
-- Author: Nikolche Kolev
-- Author: Andrei Giurgiu


-- --------------------------------------------------------
-- Define table structures
-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--
CREATE TABLE IF NOT EXISTS `Admins` (
  `aid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `clearanceLevel` int(11) NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `FK_admin_eid` (`eid`)
);

--
-- Table structure for table `AuctionBids`
--
CREATE TABLE IF NOT EXISTS `AuctionBids` (
  `id` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL,
  `offerid` int(11) NOT NULL,
  `offerValue` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_auctionbids_buyerid` (`buyerid`),
  KEY `FK_auctionbids_offerid` (`offerid`)
);

--
-- Table structure for table `Auctions`
--
CREATE TABLE IF NOT EXISTS `Auctions` (
  `id` int(11) NOT NULL,
  `offerid` int(11) NOT NULL,
  `minprice` decimal(10,2) NOT NULL,
  `currentHighestBid` int(11) NOT NULL,
  `closingTime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_auctions_offerid` (`offerid`),
  KEY `FK_auctions_highestbid` (`currentHighestBid`)
);

--
-- Table structure for table `Categories`
--
CREATE TABLE IF NOT EXISTS `Categories` (
  `id` int(11) NOT NULL,
  `type` varchar(48) NOT NULL,
  `subtype` varchar(48) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeIndex` (`type`),
  KEY `subtypeIndex` (`subtype`)
);

--
-- Table structure for table `FixedPriceBids`
--
CREATE TABLE IF NOT EXISTS `FixedPriceBids` (
  `id` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL,
  `fixedPriceOfferID` int(11) NOT NULL,
  `bidtime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fixedpricebids_fpofferid` (`fixedPriceOfferID`),
  KEY `FK_fixedpricebids_buyerid` (`buyerid`)
);

--
-- Table structure for table `FixedPriceOffers`
--
CREATE TABLE IF NOT EXISTS `FixedPriceOffers` (
  `id` int(11) NOT NULL,
  `offerid` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fixedpriceoffers_offerid` (`offerid`)
);

--
-- Table structure for table `OfferRequests`
--
CREATE TABLE IF NOT EXISTS `OfferRequests` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `description` text NOT NULL,
  `maxprice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_offerrequest_userid` (`userid`),
  KEY `FK_offerrequest_catid` (`catid`)
);

--
-- Table structure for table `Offers`
--
CREATE TABLE IF NOT EXISTS `Offers` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `postTime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_offers_userid` (`userid`),
  KEY `FK_offers_catid` (`catid`)
);

--
-- Table structure for table `Subscriptions`
--
CREATE TABLE IF NOT EXISTS `Subscriptions` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_subscriptions_userid` (`userid`),
  KEY `FK_subscriptions_catid` (`catid`)
);

--
-- Table structure for table `Users`
--
CREATE TABLE IF NOT EXISTS `Users` (
  `eid` int(11) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `roomPhone` int(4) NOT NULL,
  `roomNumber` varchar(10) NOT NULL,
  `college` char(1) NOT NULL,
  `email` varchar(64) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`)
);

-- --------------------------------------------------------
-- Define constraints for the tables
-- --------------------------------------------------------

--
-- Constraints for table `Admins`
--
ALTER TABLE `Admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `Users` (`eid`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `AuctionBids`
--
ALTER TABLE `AuctionBids`
  ADD CONSTRAINT `auctionbids_ibfk_2` FOREIGN KEY (`offerid`) REFERENCES `Offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auctionbids_ibfk_1` FOREIGN KEY (`buyerid`) REFERENCES `Users` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Auctions`
--
ALTER TABLE `Auctions`
  ADD CONSTRAINT `auctions_ibfk_2` FOREIGN KEY (`currentHighestBid`) REFERENCES `AuctionBids` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`offerid`) REFERENCES `Offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `FixedPriceBids`
--
ALTER TABLE `FixedPriceBids`
  ADD CONSTRAINT `fixedpricebids_ibfk_2` FOREIGN KEY (`fixedPriceOfferID`) REFERENCES `FixedPriceOffers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixedpricebids_ibfk_1` FOREIGN KEY (`buyerid`) REFERENCES `Users` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `FixedPriceOffers`
--
ALTER TABLE `FixedPriceOffers`
  ADD CONSTRAINT `fixedpriceoffers_ibfk_1` FOREIGN KEY (`offerid`) REFERENCES `Offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `OfferRequests`
--
ALTER TABLE `OfferRequests`
  ADD CONSTRAINT `offerrequests_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `Categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerrequests_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Users` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Offers`
--
ALTER TABLE `Offers`
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `Categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Users` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Subscriptions`
--
ALTER TABLE `Subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `Categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Users` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE;
