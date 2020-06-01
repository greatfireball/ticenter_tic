<?php
$sqlquery['captchas'] = "DROP TABLE IF EXISTS `captchas`;
CREATE TABLE `captchas` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `bindata` blob NOT NULL,
  `uploadtype` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`_id`)
);";

$sqlquery['gn4accounts'] = "DROP TABLE IF EXISTS `gn4accounts`;
CREATE TABLE `gn4accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `passwort` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `session` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pwdandern` int(11) NOT NULL DEFAULT '1',
  `galaxie` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `rang` int(11) NOT NULL DEFAULT '0',
  `allianz` int(11) NOT NULL DEFAULT '0',
  `authnick` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `scantyp` int(11) NOT NULL DEFAULT '0',
  `svs` bigint(11) NOT NULL DEFAULT '0',
  `sbs` bigint(20) NOT NULL DEFAULT '0',
  `deff` int(11) NOT NULL DEFAULT '0',
  `unreadnews` int(11) NOT NULL DEFAULT '1',
  `lastlogin` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastlogin_time` int(11) NOT NULL DEFAULT '0',
  `umod` varchar(21) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `scans` bigint(20) NOT NULL DEFAULT '0',
  `spy` int(11) NOT NULL DEFAULT '0',
  `pwdStore` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `handy` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `messangerID` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `infotext` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `zeitformat` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'hh:mm',
  `taktiksort` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0 asc',
  `help` int(1) NOT NULL DEFAULT '1',
  `tcausw` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1',
  `versuche` int(1) NOT NULL DEFAULT '0',
  `attplaner` tinyint(4) DEFAULT '0',
  `off_fleets` int(1) NOT NULL DEFAULT '1',
  `slack_nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `scananfragen` int(1) DEFAULT '0',
  PRIMARY KEY (`id`,`allianz`,`galaxie`,`planet`),
  UNIQUE KEY `name` (`name`)
);";

$sqlquery['gn4allianzen'] = "DROP TABLE IF EXISTS `gn4allianzen`;
CREATE TABLE `gn4allianzen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `tag` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `info_bnds` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `info_naps` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `info_inoffizielle_naps` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `info_kriege` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` int(11) NOT NULL DEFAULT '0',
  `blind` tinyint(4) NOT NULL DEFAULT '0',
  `display_pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`ticid`,`name`,`display_pos`)
);";

$sqlquery['gn4cron'] = "DROP TABLE IF EXISTS `gn4cron`;
CREATE TABLE `gn4cron` (
  `time` int(14) DEFAULT NULL,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(14) NOT NULL DEFAULT '0',
  KEY `time` (`time`,`ticid`,`count`)
);";

$sqlquery['gn4flottenbewegungen'] = "DROP TABLE IF EXISTS `gn4flottenbewegungen`;
CREATE TABLE `gn4flottenbewegungen` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `modus` int(2) NOT NULL DEFAULT '0',
  `angreifer_galaxie` int(5) NOT NULL DEFAULT '0',
  `angreifer_planet` int(3) NOT NULL DEFAULT '0',
  `verteidiger_galaxie` int(5) NOT NULL DEFAULT '0',
  `verteidiger_planet` int(3) NOT NULL DEFAULT '0',
  `save` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `eta` int(5) NOT NULL DEFAULT '0',
  `flugzeit` int(5) NOT NULL DEFAULT '0',
  `flottennr` int(2) NOT NULL DEFAULT '0',
  `ankunft` int(14) NOT NULL DEFAULT '0',
  `flugzeit_ende` int(14) NOT NULL DEFAULT '0',
  `ruckflug_ende` int(14) NOT NULL DEFAULT '0',
  `tparser` tinyint(4) NOT NULL DEFAULT '0',
  `erfasser` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `erfasst_am` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `reported_to_slack` int(5) DEFAULT '0',
  PRIMARY KEY (`id`,`ticid`),
  KEY `start_koords` (`angreifer_galaxie`,`angreifer_planet`,`ticid`),
  KEY `ziel_koords` (`verteidiger_galaxie`,`verteidiger_planet`,`ticid`),
  KEY `reported_to_slack` (`reported_to_slack`)
);";

$sqlquery['gn4flottenbewegungen_kommentare'] = "DROP TABLE IF EXISTS `gn4flottenbewegungen_kommentare`;
CREATE TABLE `gn4flottenbewegungen_kommentare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g` int(5) DEFAULT NULL,
  `p` int(5) DEFAULT NULL,
  `erfasser_g` int(5) DEFAULT NULL,
  `erfasser_p` int(5) DEFAULT NULL,
  `kommentar` text COLLATE utf8_bin,
  `t` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peter` (`g`,`p`,`t`)
);";

$sqlquery['gn4forum'] = "DROP TABLE IF EXISTS `gn4forum`;
CREATE TABLE `gn4forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `autorid` int(11) NOT NULL DEFAULT '0',
  `zeit` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `belongsto` int(11) NOT NULL DEFAULT '0',
  `topic` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `allianz` int(11) NOT NULL DEFAULT '0',
  `priority` bigint(20) NOT NULL DEFAULT '0',
  `wichtig` int(11) NOT NULL DEFAULT '0',
  `lastpost` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `geandert` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);";

$sqlquery['gn4galfleetupdated'] = "DROP TABLE IF EXISTS `gn4galfleetupdated`;
CREATE TABLE `gn4galfleetupdated` (
  `gal` int(9) NOT NULL,
  `t` int(14) NOT NULL,
  `erfasser` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`gal`,`t`)
);
CREATE TRIGGER `hist_i` AFTER INSERT ON `gn4galfleetupdated`
 FOR EACH ROW INSERT INTO gn4galfleetupdated_hist (t,gal,erfasser) VALUES (NEW.t,NEW.gal,NEW.erfasser);
CREATE TRIGGER `hist_u` AFTER UPDATE ON `gn4galfleetupdated`
 FOR EACH ROW INSERT INTO gn4galfleetupdated_hist (t,gal,erfasser) VALUES (NEW.t,NEW.gal,NEW.erfasser);
";

$sqlquery['gn4galfleetupdated_hist'] = "DROP TABLE IF EXISTS `gn4galfleetupdated_hist`;
CREATE TABLE `gn4galfleetupdated_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gal` int(9) NOT NULL,
  `t` int(14) NOT NULL,
  `erfasser` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
);";

/* $sqlquery['gn4gnuser'] = "DROP TABLE IF EXISTS `gn4gnuser`;
DROP VIEW IF EXISTS `gn4gnuser`;
CREATE VIEW `gn4gnuser` AS SELECT
 1 AS `erfasst`,
 1 AS `gala`,
 1 AS `planet`,
 1 AS `kommentar`,
 1 AS `ticid`,
 1 AS `name`,
 1 AS `id`;
";
 */
$sqlquery['gn4log'] = "DROP TABLE IF EXISTS `gn4log`;
CREATE TABLE `gn4log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `accid` int(11) NOT NULL DEFAULT '0',
  `rang` int(11) NOT NULL DEFAULT '0',
  `allianz` int(11) NOT NULL DEFAULT '0',
  `zeit` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `aktion` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `ip` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);";

$sqlquery['gn4massinc_atter'] = "DROP TABLE IF EXISTS `gn4massinc_atter`;
CREATE TABLE `gn4massinc_atter` (
  `project_fk` int(11) NOT NULL,
  `gal` int(6) NOT NULL,
  `pla` int(4) NOT NULL,
  `off_fleets` int(1) NOT NULL DEFAULT '2',
  `external` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_fk`,`gal`,`pla`)
);";

$sqlquery['gn4massinc_atter_willing'] = "DROP TABLE IF EXISTS `gn4massinc_atter_willing`;
CREATE TABLE `gn4massinc_atter_willing` (
  `project_fk` int(11) NOT NULL,
  `welle` int(11) NOT NULL,
  `atter_gal` int(11) NOT NULL,
  `atter_pla` int(11) NOT NULL,
  `willing` int(11) DEFAULT '0',
  PRIMARY KEY (`project_fk`,`welle`,`atter_gal`,`atter_pla`),
  KEY `atter_willing_welle` (`welle`)
);";

$sqlquery['gn4massinc_fleets'] = "DROP TABLE IF EXISTS `gn4massinc_fleets`;
CREATE TABLE `gn4massinc_fleets` (
  `project_fk` int(11) NOT NULL,
  `atter_gal` int(6) NOT NULL,
  `atter_pla` int(4) NOT NULL,
  `fleet` int(1) NOT NULL,
  `ja` int(11) NOT NULL DEFAULT '0',
  `bo` int(11) NOT NULL DEFAULT '0',
  `fr` int(11) NOT NULL DEFAULT '0',
  `ze` int(11) NOT NULL DEFAULT '0',
  `kr` int(11) NOT NULL DEFAULT '0',
  `sc` int(11) NOT NULL DEFAULT '0',
  `tr` int(11) NOT NULL DEFAULT '0',
  `cl` int(11) NOT NULL DEFAULT '0',
  `ca` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_fk`,`atter_gal`,`atter_pla`,`fleet`),
  KEY `fleet` (`fleet`)
);";

$sqlquery['gn4massinc_projects'] = "DROP TABLE IF EXISTS `gn4massinc_projects`;
CREATE TABLE `gn4massinc_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `erstellt_am` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `erstellt_von` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `freigegeben` int(10) DEFAULT '0',
  `freie_zielwahl` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`project_id`)
);";

$sqlquery['gn4massinc_wellen'] = "DROP TABLE IF EXISTS `gn4massinc_wellen`;
CREATE TABLE `gn4massinc_wellen` (
  `project_fk` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t` int(15) NOT NULL,
  `kommentar` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_fk` (`project_fk`)
);";

$sqlquery['gn4massinc_ziele'] = "DROP TABLE IF EXISTS `gn4massinc_ziele`;
CREATE TABLE `gn4massinc_ziele` (
  `project_fk` int(11) NOT NULL,
  `gal` int(6) NOT NULL,
  `pla` int(4) NOT NULL,
  PRIMARY KEY (`project_fk`,`gal`,`pla`)
);";

$sqlquery['gn4massinc_ziele_welle'] = "DROP TABLE IF EXISTS `gn4massinc_ziele_welle`;
CREATE TABLE `gn4massinc_ziele_welle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_fk` int(11) NOT NULL,
  `ziel_gal` int(11) NOT NULL,
  `ziel_pla` int(11) NOT NULL,
  `welle` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_fk` (`project_fk`),
  KEY `welle` (`welle`),
  KEY `ziele_welle_X` (`project_fk`,`ziel_gal`,`ziel_pla`),
  KEY `ziele_zuweisung_X` (`project_fk`,`welle`,`ziel_gal`,`ziel_pla`)
);";

$sqlquery['gn4massinc_zuweisung'] = "DROP TABLE IF EXISTS `gn4massinc_zuweisung`;
CREATE TABLE `gn4massinc_zuweisung` (
  `project_fk` int(11) NOT NULL,
  `welle` int(11) NOT NULL,
  `dest_gal` int(11) NOT NULL,
  `dest_pla` int(11) NOT NULL,
  `atter_gal` int(11) NOT NULL,
  `atter_pla` int(11) NOT NULL,
  `fleet_id` int(11) NOT NULL,
  `kommentar` text COLLATE utf8_bin,
  `relative_starttick` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_fk`,`welle`,`dest_gal`,`dest_pla`,`atter_gal`,`atter_pla`,`fleet_id`),
  KEY `fleet` (`fleet_id`),
  KEY `zuweisung_welle` (`welle`),
  KEY `zuweisung_X` (`project_fk`,`dest_gal`,`dest_pla`)
);";

$sqlquery['gn4meta'] = "DROP TABLE IF EXISTS `gn4meta`;
CREATE TABLE `gn4meta` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `sysmsg` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bnds` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `naps` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `wars` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `duell` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`,`name`)
);";

$sqlquery['gn4nachrichten'] = "DROP TABLE IF EXISTS `gn4nachrichten`;
CREATE TABLE `gn4nachrichten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `titel` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `zeit` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
);";

$sqlquery['gn4nachtwache'] = "DROP TABLE IF EXISTS `gn4nachtwache`;
CREATE TABLE `gn4nachtwache` (
  `time` int(11) NOT NULL DEFAULT '0',
  `ticid` tinyint(4) NOT NULL DEFAULT '0',
  `gala` int(11) NOT NULL DEFAULT '0',
  `planet1` tinyint(2) NOT NULL DEFAULT '0',
  `done1` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet2` tinyint(2) NOT NULL DEFAULT '0',
  `done2` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet3` tinyint(2) NOT NULL DEFAULT '0',
  `done3` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet4` tinyint(2) NOT NULL DEFAULT '0',
  `done4` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet5` tinyint(2) NOT NULL DEFAULT '0',
  `done5` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet6` tinyint(2) NOT NULL DEFAULT '0',
  `done6` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `planet7` tinyint(2) NOT NULL DEFAULT '0',
  `done7` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`time`,`gala`)
);";

$sqlquery['gn4nachtwache_config'] = "DROP TABLE IF EXISTS `gn4nachtwache_config`;
CREATE TABLE `gn4nachtwache_config` (
  `ticid` int(11) NOT NULL DEFAULT '0',
  `galaxie` int(11) DEFAULT NULL,
  `start_min` int(11) NOT NULL DEFAULT '0',
  `ende_min` int(11) NOT NULL DEFAULT '360',
  `sampling_per_h` decimal(4,2) NOT NULL DEFAULT '1.00'
);";

$sqlquery['gn4scanblock'] = "DROP TABLE IF EXISTS `gn4scanblock`;
CREATE TABLE `gn4scanblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g` int(5) DEFAULT NULL,
  `p` int(5) DEFAULT NULL,
  `t` int(11) DEFAULT NULL,
  `svs` int(6) DEFAULT NULL,
  `sg` int(5) DEFAULT NULL,
  `sp` int(5) DEFAULT NULL,
  `sname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `typ` int(2) DEFAULT NULL,
  `suspicious` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suspicious` (`suspicious`,`g`,`p`,`sg`,`sp`),
  KEY `g` (`g`,`p`)
);";

$sqlquery['gn4scanrequests'] = "DROP TABLE IF EXISTS `gn4scanrequests`;
CREATE TABLE `gn4scanrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requester_g` int(6) DEFAULT NULL,
  `requester_p` int(4) DEFAULT NULL,
  `ziel_g` int(6) DEFAULT NULL,
  `ziel_p` int(4) DEFAULT NULL,
  `t` int(14) DEFAULT NULL,
  `scantyp` int(2) NOT NULL,
  `bezahlt` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);";

$sqlquery['gn4scans'] = "DROP TABLE IF EXISTS `gn4scans`;
CREATE TABLE `gn4scans` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `zeit` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `type` int(2) NOT NULL DEFAULT '0',
  `g` int(5) NOT NULL DEFAULT '0',
  `p` int(5) NOT NULL DEFAULT '0',
  `rg` int(5) NOT NULL DEFAULT '0',
  `rp` int(5) NOT NULL DEFAULT '0',
  `gen` int(3) NOT NULL DEFAULT '0',
  `pts` decimal(10,0) NOT NULL DEFAULT '0',
  `s` int(11) NOT NULL DEFAULT '0',
  `d` int(11) NOT NULL DEFAULT '0',
  `me` int(11) NOT NULL DEFAULT '0',
  `ke` int(11) NOT NULL DEFAULT '0',
  `a` int(11) NOT NULL DEFAULT '0',
  `sf0j` bigint(20) NOT NULL DEFAULT '0',
  `sf0b` bigint(20) NOT NULL DEFAULT '0',
  `sf0f` bigint(20) NOT NULL DEFAULT '0',
  `sf0z` bigint(20) NOT NULL DEFAULT '0',
  `sf0kr` bigint(20) NOT NULL DEFAULT '0',
  `sf0sa` bigint(20) NOT NULL DEFAULT '0',
  `sf0t` bigint(20) NOT NULL DEFAULT '0',
  `sf0ko` bigint(20) NOT NULL DEFAULT '0',
  `sf0ka` bigint(20) NOT NULL DEFAULT '0',
  `sf0su` bigint(20) NOT NULL DEFAULT '0',
  `sf1j` bigint(20) NOT NULL DEFAULT '0',
  `sf1b` bigint(20) NOT NULL DEFAULT '0',
  `sf1f` bigint(20) NOT NULL DEFAULT '0',
  `sf1z` bigint(20) NOT NULL DEFAULT '0',
  `sf1kr` bigint(20) NOT NULL DEFAULT '0',
  `sf1sa` bigint(20) NOT NULL DEFAULT '0',
  `sf1t` bigint(20) NOT NULL DEFAULT '0',
  `sf1ko` bigint(20) NOT NULL DEFAULT '0',
  `sf1ka` bigint(20) NOT NULL DEFAULT '0',
  `sf1su` bigint(20) NOT NULL DEFAULT '0',
  `status1` int(11) NOT NULL DEFAULT '0',
  `ziel1` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `sf2j` bigint(20) DEFAULT '0',
  `sf2b` bigint(20) DEFAULT '0',
  `sf2f` bigint(20) DEFAULT '0',
  `sf2z` bigint(20) DEFAULT '0',
  `sf2kr` bigint(20) DEFAULT '0',
  `sf2sa` bigint(20) DEFAULT '0',
  `sf2t` bigint(20) DEFAULT '0',
  `sf2ko` bigint(20) DEFAULT '0',
  `sf2ka` bigint(20) DEFAULT '0',
  `sf2su` bigint(20) DEFAULT '0',
  `status2` int(11) DEFAULT '0',
  `ziel2` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '',
  `sfj` bigint(20) NOT NULL DEFAULT '0',
  `sfb` bigint(20) NOT NULL DEFAULT '0',
  `sff` bigint(20) NOT NULL DEFAULT '0',
  `sfz` bigint(20) NOT NULL DEFAULT '0',
  `sfkr` bigint(20) NOT NULL DEFAULT '0',
  `sfsa` bigint(20) NOT NULL DEFAULT '0',
  `sft` bigint(20) NOT NULL DEFAULT '0',
  `sfko` bigint(20) NOT NULL DEFAULT '0',
  `sfka` bigint(20) NOT NULL DEFAULT '0',
  `sfsu` bigint(20) NOT NULL DEFAULT '0',
  `glo` bigint(20) NOT NULL DEFAULT '0',
  `glr` bigint(20) NOT NULL DEFAULT '0',
  `gmr` bigint(20) NOT NULL DEFAULT '0',
  `gsr` bigint(20) NOT NULL DEFAULT '0',
  `ga` bigint(20) NOT NULL DEFAULT '0',
  `gr` bigint(20) NOT NULL DEFAULT '0',
  `erfasser_svs` int(11) DEFAULT NULL,
  `erfasser` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`type`,`zeit`),
  KEY `scan_koords` (`rg`,`rp`,`type`)
);
CREATE TRIGGER `scans_svs_i` BEFORE INSERT ON `gn4scans`
 FOR EACH ROW SET NEW.erfasser_svs = IF(NEW.erfasser_svs IS NULL, (SELECT svs FROM gn4accounts WHERE galaxie = NEW.g AND planet = NEW.p), NEW.erfasser_svs);
 CREATE TRIGGER `history_i` AFTER INSERT ON `gn4scans`
 FOR EACH ROW insert ignore into gn4scans_history (
	ticid,
	t,
	type,
	g,
	p,
	rg,
	rp,
	gen,
	pts,
	s,
	d,
	me,
	ke,
	a,
	sf0j,
	sf0b,
	sf0f,
	sf0z,
	sf0kr,
	sf0sa,
	sf0t,
	sf0ko,
	sf0ka,
	sf0su,
	sf1j,
	sf1b,
	sf1f,
	sf1z,
	sf1kr,
	sf1sa,
	sf1t,
	sf1ko,
	sf1ka,
	sf1su,
	status1,
	ziel1,
	sf2j,
	sf2b,
	sf2f,
	sf2z,
	sf2kr,
	sf2sa,
	sf2t,
	sf2ko,
	sf2ka,
	sf2su,
	status2,
	ziel2,
	sfj,
	sfb,
	sff,
	sfz,
	sfkr,
	sfsa,
	sft,
	sfko,
	sfka,
	sfsu,
	glo,
	glr,
	gmr,
	gsr,
	ga,
	gr,
	erfasser_svs,
	erfasser)
VALUES(
	NEW.ticid,
	floor(unix_timestamp(STR_TO_DATE(NEW.zeit,  '%H:%i %d.%m.%Y' )) / 15 / 60) * 15 * 60,
	NEW.type,
	NEW.g,
	NEW.p,
	NEW.rg,
	NEW.rp,
	NEW.gen,
	NEW.pts,
	NEW.s,
	NEW.d,
	NEW.me,
	NEW.ke,
	NEW.a,
	NEW.sf0j,
	NEW.sf0b,
	NEW.sf0f,
	NEW.sf0z,
	NEW.sf0kr,
	NEW.sf0sa,
	NEW.sf0t,
	NEW.sf0ko,
	NEW.sf0ka,
	NEW.sf0su,
	NEW.sf1j,
	NEW.sf1b,
	NEW.sf1f,
	NEW.sf1z,
	NEW.sf1kr,
	NEW.sf1sa,
	NEW.sf1t,
	NEW.sf1ko,
	NEW.sf1ka,
	NEW.sf1su,
	NEW.status1,
	NEW.ziel1,
	NEW.sf2j,
	NEW.sf2b,
	NEW.sf2f,
	NEW.sf2z,
	NEW.sf2kr,
	NEW.sf2sa,
	NEW.sf2t,
	NEW.sf2ko,
	NEW.sf2ka,
	NEW.sf2su,
	NEW.status2,
	NEW.ziel2,
	NEW.sfj,
	NEW.sfb,
	NEW.sff,
	NEW.sfz,
	NEW.sfkr,
	NEW.sfsa,
	NEW.sft,
	NEW.sfko,
	NEW.sfka,
	NEW.sfsu,
	NEW.glo,
	NEW.glr,
	NEW.gmr,
	NEW.gsr,
	NEW.ga,
	NEW.gr,
	NEW.erfasser_svs,
	NEW.erfasser
);
CREATE TRIGGER `scans_svs_u` BEFORE UPDATE ON `gn4scans`
 FOR EACH ROW SET NEW.erfasser_svs = IF(NEW.erfasser_svs IS NULL, (SELECT svs FROM gn4accounts WHERE galaxie = NEW.g AND planet = NEW.p), NEW.erfasser_svs);
 CREATE TRIGGER `history_u` AFTER UPDATE ON `gn4scans`
 FOR EACH ROW insert ignore into gn4scans_history (
	ticid,
	t,
	type,
	g,
	p,
	rg,
	rp,
	gen,
	pts,
	s,
	d,
	me,
	ke,
	a,
	sf0j,
	sf0b,
	sf0f,
	sf0z,
	sf0kr,
	sf0sa,
	sf0t,
	sf0ko,
	sf0ka,
	sf0su,
	sf1j,
	sf1b,
	sf1f,
	sf1z,
	sf1kr,
	sf1sa,
	sf1t,
	sf1ko,
	sf1ka,
	sf1su,
	status1,
	ziel1,
	sf2j,
	sf2b,
	sf2f,
	sf2z,
	sf2kr,
	sf2sa,
	sf2t,
	sf2ko,
	sf2ka,
	sf2su,
	status2,
	ziel2,
	sfj,
	sfb,
	sff,
	sfz,
	sfkr,
	sfsa,
	sft,
	sfko,
	sfka,
	sfsu,
	glo,
	glr,
	gmr,
	gsr,
	ga,
	gr,
	erfasser_svs,
	erfasser)
VALUES(
	NEW.ticid,
	floor(unix_timestamp(STR_TO_DATE(NEW.zeit, '%H:%i %d.%m.%Y' )) / 15 / 60) * 15 * 60,
	NEW.type,
	NEW.g,
	NEW.p,
	NEW.rg,
	NEW.rp,
	NEW.gen,
	NEW.pts,
	NEW.s,
	NEW.d,
	NEW.me,
	NEW.ke,
	NEW.a,
	NEW.sf0j,
	NEW.sf0b,
	NEW.sf0f,
	NEW.sf0z,
	NEW.sf0kr,
	NEW.sf0sa,
	NEW.sf0t,
	NEW.sf0ko,
	NEW.sf0ka,
	NEW.sf0su,
	NEW.sf1j,
	NEW.sf1b,
	NEW.sf1f,
	NEW.sf1z,
	NEW.sf1kr,
	NEW.sf1sa,
	NEW.sf1t,
	NEW.sf1ko,
	NEW.sf1ka,
	NEW.sf1su,
	NEW.status1,
	NEW.ziel1,
	NEW.sf2j,
	NEW.sf2b,
	NEW.sf2f,
	NEW.sf2z,
	NEW.sf2kr,
	NEW.sf2sa,
	NEW.sf2t,
	NEW.sf2ko,
	NEW.sf2ka,
	NEW.sf2su,
	NEW.status2,
	NEW.ziel2,
	NEW.sfj,
	NEW.sfb,
	NEW.sff,
	NEW.sfz,
	NEW.sfkr,
	NEW.sfsa,
	NEW.sft,
	NEW.sfko,
	NEW.sfka,
	NEW.sfsu,
	NEW.glo,
	NEW.glr,
	NEW.gmr,
	NEW.gsr,
	NEW.ga,
	NEW.gr,
	NEW.erfasser_svs,
	NEW.erfasser
);
";

$sqlquery['gn4scans_history'] = "DROP TABLE IF EXISTS `gn4scans_history`;
CREATE TABLE `gn4scans_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `t` int(14) NOT NULL DEFAULT '0',
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `g` int(5) NOT NULL DEFAULT '0',
  `p` int(5) NOT NULL DEFAULT '0',
  `rg` int(5) NOT NULL DEFAULT '0',
  `rp` int(5) NOT NULL DEFAULT '0',
  `gen` int(3) NOT NULL DEFAULT '0',
  `pts` int(15) NOT NULL DEFAULT '0',
  `s` int(11) NOT NULL DEFAULT '0',
  `d` int(11) NOT NULL DEFAULT '0',
  `me` int(11) NOT NULL DEFAULT '0',
  `ke` int(11) NOT NULL DEFAULT '0',
  `a` int(11) NOT NULL DEFAULT '0',
  `sf0j` bigint(10) NOT NULL DEFAULT '0',
  `sf0b` bigint(10) NOT NULL DEFAULT '0',
  `sf0f` bigint(10) NOT NULL DEFAULT '0',
  `sf0z` bigint(10) NOT NULL DEFAULT '0',
  `sf0kr` bigint(10) NOT NULL DEFAULT '0',
  `sf0sa` bigint(10) NOT NULL DEFAULT '0',
  `sf0t` bigint(10) NOT NULL DEFAULT '0',
  `sf0ko` bigint(10) NOT NULL DEFAULT '0',
  `sf0ka` bigint(10) NOT NULL DEFAULT '0',
  `sf0su` bigint(10) NOT NULL DEFAULT '0',
  `sf1j` bigint(10) NOT NULL DEFAULT '0',
  `sf1b` bigint(10) NOT NULL DEFAULT '0',
  `sf1f` bigint(10) NOT NULL DEFAULT '0',
  `sf1z` bigint(10) NOT NULL DEFAULT '0',
  `sf1kr` bigint(10) NOT NULL DEFAULT '0',
  `sf1sa` bigint(10) NOT NULL DEFAULT '0',
  `sf1t` bigint(10) NOT NULL DEFAULT '0',
  `sf1ko` bigint(10) NOT NULL DEFAULT '0',
  `sf1ka` bigint(10) NOT NULL DEFAULT '0',
  `sf1su` bigint(10) NOT NULL DEFAULT '0',
  `status1` int(11) NOT NULL DEFAULT '0',
  `ziel1` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `sf2j` bigint(10) NOT NULL DEFAULT '0',
  `sf2b` bigint(10) NOT NULL DEFAULT '0',
  `sf2f` bigint(10) NOT NULL DEFAULT '0',
  `sf2z` bigint(10) NOT NULL DEFAULT '0',
  `sf2kr` bigint(10) NOT NULL DEFAULT '0',
  `sf2sa` bigint(10) NOT NULL DEFAULT '0',
  `sf2t` bigint(10) NOT NULL DEFAULT '0',
  `sf2ko` bigint(10) NOT NULL DEFAULT '0',
  `sf2ka` bigint(10) NOT NULL DEFAULT '0',
  `sf2su` bigint(10) NOT NULL DEFAULT '0',
  `status2` int(11) NOT NULL DEFAULT '0',
  `ziel2` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `sfj` bigint(10) NOT NULL DEFAULT '0',
  `sfb` bigint(10) NOT NULL DEFAULT '0',
  `sff` bigint(10) NOT NULL DEFAULT '0',
  `sfz` bigint(10) NOT NULL DEFAULT '0',
  `sfkr` bigint(10) NOT NULL DEFAULT '0',
  `sfsa` bigint(10) NOT NULL DEFAULT '0',
  `sft` bigint(10) NOT NULL DEFAULT '0',
  `sfko` bigint(10) NOT NULL DEFAULT '0',
  `sfka` bigint(10) NOT NULL DEFAULT '0',
  `sfsu` bigint(10) NOT NULL DEFAULT '0',
  `glo` bigint(10) NOT NULL DEFAULT '0',
  `glr` bigint(10) NOT NULL DEFAULT '0',
  `gmr` bigint(10) NOT NULL DEFAULT '0',
  `gsr` bigint(10) NOT NULL DEFAULT '0',
  `ga` bigint(10) NOT NULL DEFAULT '0',
  `gr` bigint(10) NOT NULL DEFAULT '0',
  `erfasser_svs` int(11) DEFAULT NULL,
  `erfasser` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`,`type`,`t`),
  UNIQUE KEY `peter` (`type`,`t`,`rg`,`rp`)
);";

$sqlquery['gn4scans_news'] = "DROP TABLE IF EXISTS `gn4scans_news`;
CREATE TABLE `gn4scans_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t` int(14) NOT NULL,
  `genauigkeit` int(3) NOT NULL,
  `ziel_g` int(5) NOT NULL,
  `ziel_p` int(3) NOT NULL,
  `erfasser_g` int(5) NOT NULL,
  `erfasser_p` int(3) NOT NULL,
  `erfasser_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `erfasser_svs` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t` (`t`),
  KEY `galplani` (`ziel_g`,`ziel_p`)
);";

$sqlquery['gn4scans_news_entries'] = "DROP TABLE IF EXISTS `gn4scans_news_entries`;
CREATE TABLE `gn4scans_news_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `t` int(13) DEFAULT NULL,
  `typ` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `inhalt` text CHARACTER SET utf8 COLLATE utf8_bin,
  `inaccurate` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
);";

$sqlquery['gn4shorturls'] = "DROP TABLE IF EXISTS `gn4shorturls`;
CREATE TABLE `gn4shorturls` (
  `uuid` char(23) COLLATE utf8_bin NOT NULL,
  `url` text COLLATE utf8_bin NOT NULL,
  `t` int(14) NOT NULL,
  PRIMARY KEY (`uuid`)
);";

$sqlquery['gn4vars'] = "DROP TABLE IF EXISTS `gn4vars`;
CREATE TABLE `gn4vars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ticid` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`ticid`)
);";

$sqlquery['gn_allianzen'] = "DROP TABLE IF EXISTS `gn_allianzen`;
CREATE TABLE `gn_allianzen` (
  `allianz_id` int(11) NOT NULL AUTO_INCREMENT,
  `t` datetime NOT NULL,
  `allianz_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `allianz_is_meta` int(1) NOT NULL,
  `allianz_meta` int(11) DEFAULT NULL,
  PRIMARY KEY (`allianz_id`),
  UNIQUE KEY `allianz_name` (`allianz_name`),
  UNIQUE KEY `t` (`t`,`allianz_name`),
  KEY `allianz_meta` (`allianz_meta`)
);";

$sqlquery['gn_galaxien'] = "DROP TABLE IF EXISTS `gn_galaxien`;
CREATE TABLE `gn_galaxien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galaxy_id` int(11) NOT NULL,
  `t` datetime NOT NULL,
  `galaxy_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `galaxy_allianz` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `galaxy_id` (`galaxy_id`,`t`),
  KEY `galaxy_allianz` (`galaxy_allianz`)
);";

$sqlquery['gn_politik'] = "DROP TABLE IF EXISTS `gn_politik`;
CREATE TABLE `gn_politik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t1` datetime NOT NULL,
  `t2` datetime NOT NULL,
  `allianz1` int(11) NOT NULL,
  `allianz2` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `allianz1` (`allianz1`,`allianz2`)
);";

$sqlquery['gn_politik_types'] = "DROP TABLE IF EXISTS `gn_politik_types`;
CREATE TABLE `gn_politik_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beschreibung` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
);";

$sqlquery['gn_spieler'] = "DROP TABLE IF EXISTS `gn_spieler`;
CREATE TABLE `gn_spieler` (
  `spieler_id` int(11) NOT NULL AUTO_INCREMENT,
  `t` datetime NOT NULL,
  `spieler_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `spieler_galaxie` int(6) NOT NULL,
  `spieler_planet` int(6) NOT NULL,
  `spieler_punkte` bigint(11) NOT NULL,
  `spieler_asteroiden` int(6) NOT NULL,
  `spieler_urlaub` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`spieler_id`),
  UNIQUE KEY `spieler_name` (`spieler_name`,`t`),
  KEY `spieler_galaxie` (`spieler_galaxie`)
);
DELIMITER ;;
CREATE TRIGGER `update_spieler_aggregate` BEFORE INSERT ON `gn_spieler`
 FOR EACH ROW BEGIN
		IF NOT EXISTS (SELECT 1 FROM gn_spieler2 WHERE spieler_name = NEW.spieler_name) THEN
			INSERT INTO gn_spieler2
				(spieler_asteroiden, spieler_galaxie, spieler_name, spieler_planet, spieler_punkte, spieler_urlaub, t)
				VALUES (NEW.spieler_asteroiden, NEW.spieler_galaxie, NEW.spieler_name, NEW.spieler_planet, NEW.spieler_punkte, NEW.spieler_urlaub, NEW.t);
		ELSE
			SELECT g.t, g.spieler_punkte, COALESCE(x.galaxy_name, ''), COALESCE(y.allianz_name, ''), COALESCE(z.allianz_name, '')
			INTO @t, @pkt, @galaxyname, @xally, @xmeta
			FROM `gn_spieler` g
			left join gn_galaxien x on x.galaxy_id = g.spieler_galaxie and x.t = g.t
			left join gn_allianzen y on x.galaxy_allianz = y.allianz_id
			left join gn_allianzen z on y.allianz_meta = z.allianz_id
			WHERE g.spieler_name = NEW.spieler_name and g.t = (select max(t) from gn_spieler where spieler_name = NEW.spieler_name);


			SET @xpktdiff 	:= NEW.spieler_punkte - @pkt;
			SET @xtickdiff 	:= ROUND((UNIX_TIMESTAMP(NEW.t) - UNIX_TIMESTAMP(@t))/15/60, 0);
			SET @xexen		:= ROUND((@xpktdiff/@xtickdiff*10-20000)/50, 0);
			SET @xexenpkt	:= @xexen * 15000;
			SET @xfleetpkt 	:= NEW.spieler_punkte - @xexenpkt;
			UPDATE gn_spieler2 SET
				spieler_asteroiden 		= NEW.spieler_asteroiden,
				spieler_galaxie 		= NEW.spieler_galaxie,
				spieler_planet 			= NEW.spieler_planet,
				spieler_punkte 			= NEW.spieler_punkte,
				spieler_urlaub 			= NEW.spieler_urlaub,
				t 						= NEW.t,
				pktdiff 				= @xpktdiff,
				tickdiff 				= @xtickdiff,
				exen 					= @xexen,
				exenpkt 				= @xexenpkt,
				fleetpkt 				= @xfleetpkt,
				fleetpktPerEx 			= @xfleetpkt / @xexen,
				allianz_name			= @xally,
				meta					= @xmeta,
				galaxy_name				= @galaxyname,
				valid					= (@xfleetpkt > 0) AND (@xexen >= 0) AND (@xexen <= 20*NEW.spieler_asteroiden)
				WHERE spieler_name = NEW.spieler_name and t <> NEW.t LIMIT 1;
		END IF;
	END ;;
DELIMITER ;";

$sqlquery['gn_spieler2'] = "DROP TABLE IF EXISTS `gn_spieler2`;
CREATE TABLE `gn_spieler2` (
  `t` datetime NOT NULL,
  `spieler_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `spieler_galaxie` int(6) NOT NULL,
  `spieler_planet` int(6) NOT NULL,
  `spieler_punkte` bigint(11) NOT NULL,
  `spieler_asteroiden` int(6) NOT NULL,
  `spieler_urlaub` int(1) NOT NULL DEFAULT '0',
  `pktdiff` int(11) NOT NULL,
  `tickdiff` int(6) NOT NULL,
  `exen` int(6) NOT NULL,
  `exenpkt` int(11) NOT NULL,
  `fleetpkt` int(11) NOT NULL,
  `fleetpktPerEx` decimal(11,1) NOT NULL,
  `allianz_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta` varchar(255) COLLATE utf8_bin NOT NULL,
  `galaxy_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `valid` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`spieler_name`),
  UNIQUE KEY `galplani` (`spieler_galaxie`,`spieler_planet`)
);";

$sqlquery['gn4gnuser'] = "DROP TABLE IF EXISTS `gn4gnuser`; DROP VIEW IF EXISTS `gn4gnuser`; CREATE VIEW `gn4gnuser` AS select `s`.`t` AS `erfasst`,`s`.`spieler_galaxie` AS `gala`,`s`.`spieler_planet` AS `planet`,'' AS `kommentar`,'' AS `ticid`,`s`.`spieler_name` AS `name`,0 AS `id` from `gn_spieler2` `s`;";

?>
