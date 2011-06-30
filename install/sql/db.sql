CREATE TABLE IF NOT EXISTS `mc_admin_member` (
  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `cryptpass` varchar(50) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_admin_perms` (
  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
  `perms` tinyint(1) NOT NULL,
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_admin_session` (
  `sid` tinytext NOT NULL,
  `userid` tinyint(2) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(50) DEFAULT NULL,
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog` (
  `idcatalog` int(6) NOT NULL AUTO_INCREMENT,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `idadmin` tinyint(2) NOT NULL,
  `urlcatalog` varchar(125) NOT NULL,
  `titlecatalog` varchar(125) NOT NULL,
  `desccatalog` text,
  `price` decimal(12,2) DEFAULT NULL,
  `ordercatalog` int(6) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '1',
  `date_catalog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcatalog`),
  KEY `idclc` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_c` (
  `idclc` tinyint(3) NOT NULL AUTO_INCREMENT,
  `clibelle` varchar(125) NOT NULL,
  `pathclibelle` varchar(125) NOT NULL,
  `img_c` varchar(125) DEFAULT NULL,
  `c_content` text,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `corder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idclc`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_galery` (
  `idmicro` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idmicro`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_img` (
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_product` (
  `idproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idclc` tinyint(3) NOT NULL,
  `idcls` tinyint(3) NOT NULL DEFAULT '0',
  `orderproduct` int(6) NOT NULL,
  PRIMARY KEY (`idproduct`),
  KEY `idclc` (`idclc`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_rel_product` (
  `idrelproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idproduct` int(6) NOT NULL,
  PRIMARY KEY (`idrelproduct`),
  KEY `idcatalog` (`idcatalog`),
  KEY `idproduct` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_s` (
  `idcls` tinyint(3) NOT NULL AUTO_INCREMENT,
  `slibelle` varchar(125) NOT NULL,
  `pathslibelle` varchar(125) NOT NULL,
  `img_s` varchar(125) DEFAULT NULL,
  `s_content` text,
  `idclc` tinyint(3) NOT NULL,
  `sorder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idcls`),
  KEY `idclc` (`idclc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_cms_category` (
  `idcategory` tinyint(3) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `pathcategory` varchar(100) DEFAULT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `idorder` tinyint(2) NOT NULL,
  PRIMARY KEY (`idcategory`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_cms_page` (
  `idpage` smallint(6) NOT NULL AUTO_INCREMENT,
  `idcategory` tinyint(3) NOT NULL DEFAULT '0',
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `pathpage` varchar(125) NOT NULL,
  `subjectpage` varchar(125) NOT NULL,
  `contentpage` text,
  `idadmin` tinyint(2) NOT NULL,
  `metatitle` varchar(150) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `orderpage` smallint(6) NOT NULL,
  `viewpage` tinyint(1) NOT NULL,
  `date_page` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpage`),
  KEY `idcategory` (`idcategory`,`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_cms_pages` (
  `idpage` int(7) NOT NULL AUTO_INCREMENT,
  `idadmin` tinyint(3) NOT NULL,
  `idlang` tinyint(3) NOT NULL,
  `idcat_p` int(7) NOT NULL,
  `idlang_p` int(7) NOT NULL,
  `title_page` varchar(125) NOT NULL,
  `uri_page` varchar(125) NOT NULL,
  `content_page` text NOT NULL,
  `seo_title_page` tinytext NOT NULL,
  `seo_desc_page` tinytext NOT NULL,
  `order_page` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_page` tinyint(1) NOT NULL DEFAULT '0',
  `date_register` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpage`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_config_limited_module` (
  `idconfig` tinyint(1) NOT NULL,
  `number` tinyint(1) NOT NULL,
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mc_config_limited_module` (`idconfig`, `number`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0);

CREATE TABLE IF NOT EXISTS `mc_config` (
  `idconfig` tinyint(3) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `mc_config` (`idconfig`, `attr_name`, `status`) VALUES
(1, 'lang', 1),
(2, 'cms', 1),
(3, 'news', 1),
(4, 'catalog', 1),
(5, 'metasrewrite', 1),
(6, 'plugins', 1);

CREATE TABLE IF NOT EXISTS `mc_config_size_img` (
  `id_size_img` tinyint(3) NOT NULL AUTO_INCREMENT,
  `idconfig` tinyint(3) NOT NULL,
  `name_size` varchar(40) NOT NULL,
  `num_size` decimal(4,0) NOT NULL,
  PRIMARY KEY (`id_size_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

INSERT INTO `mc_config_size_img` VALUES
(1, 4, 'size_w_cat', 120),
(2, 4, 'size_h_cat', 100),
(3, 4, 'size_w_subcat', 120),
(4, 4, 'size_h_subcat', 100),
(5, 4, 'size_w_small_product', 120),
(6, 4, 'size_h_small_product', 100),
(7, 4, 'size_w_medium_product', 350),
(8, 4, 'size_h_medium_product', 250),
(9, 4, 'size_w_large_product', 700),
(10, 4, 'size_h_large_product', 700),
(11, 4, 'size_w_small_microgalery', 120),
(12, 4, 'size_h_small_microgalery', 100),
(13, 4, 'size_w_large_microgalery', 700),
(14, 4, 'size_h_large_microgalery', 700);

CREATE TABLE IF NOT EXISTS `mc_lang` (
  `idlang` tinyint(4) NOT NULL AUTO_INCREMENT,
  `iso` varchar(3) NOT NULL,
  `language` varchar(30) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `mc_lang` VALUES(1, 'fr', 'francais', 1);

CREATE TABLE IF NOT EXISTS `mc_metas_rewrite` (
  `idrewrite` tinyint(2) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(40) NOT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `strrewrite` tinytext,
  `idmetas` tinyint(1) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrewrite`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_news` (
  `idnews` int(7) NOT NULL AUTO_INCREMENT,
  `keynews` varchar(40) NOT NULL,
  `n_uri` varchar(125) NOT NULL,
  `idadmin` tinyint(1) NOT NULL,
  `idlang` tinyint(3) NOT NULL,
  `n_title` varchar(125) NOT NULL,
  `n_image` varchar(25) DEFAULT NULL,
  `n_content` text NOT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_publish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idnews`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_page_home` (
  `idhome` tinyint(1) NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `metatitle` varchar(150) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `idadmin` tinyint(2) NOT NULL,
  `date_home` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idhome`),
  KEY `idlang` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_setting` (
  `setting_id` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(8) NOT NULL DEFAULT 'string',
  `setting_label` text,
  KEY `setting_id` (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mc_setting` (`setting_id`, `setting_value`, `setting_type`, `setting_label`) VALUES
('theme', 'default', 'string', 'site theme'),
('microgalery', 'default', 'string', 'micro galery'),
('sold', 'sold_product', 'string', 'Produit vendu'),
('webmaster', '', 'string', 'google webmasterTools'),
('analytics', '', 'string', 'google analytics'),
('editor', 'pdw_file_browser', 'string', 'tinymce'),
('magix_version', '2.3.43', 'string', 'Version Magix CMS');

ALTER TABLE `mc_admin_session`
  ADD CONSTRAINT `mc_admin_session_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_catalog_img`
  ADD CONSTRAINT `mc_catalog_img_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`);

ALTER TABLE `mc_catalog_product`
  ADD CONSTRAINT `mc_catalog_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_product_ibfk_2` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);

ALTER TABLE `mc_catalog_rel_product`
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `mc_catalog_product` (`idproduct`) ON DELETE CASCADE;

ALTER TABLE `mc_catalog_s`
  ADD CONSTRAINT `mc_catalog_s_ibfk_1` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);

ALTER TABLE `mc_cms_page`
  ADD CONSTRAINT `mc_cms_page_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_news`
  ADD CONSTRAINT `mc_news_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_page_home_config`
  ADD CONSTRAINT `mc_page_home_config_ibfk_1` FOREIGN KEY (`idhome`) REFERENCES `mc_page_home` (`idhome`);