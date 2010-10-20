<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name home
 *
 */
class backend_db_home{
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $admindbhome;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbHome(){
        if (!isset(self::$admindbhome)){
         	self::$admindbhome = new backend_db_home();
        }
    	return self::$admindbhome;
    }
	/**
	 * selection du titre et du contenu de la page home ou index public 
	 *
	 */
	function s_home_page_plugin(){
		$sql = 'SELECT h.idhome,h.subject,h.content,h.metatitle,h.metadescription,lang.codelang,h.idlang,m.pseudo
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
				LEFT JOIN mc_admin_member AS m ON(h.idadmin = m.idadmin)';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Affiche les données (dans les champs) pour une modification
	 * @param $gethome
	 */
	function s_home_page_record($gethome){
		$sql = 'SELECT h.subject,h.content,h.metatitle,h.metadescription,lang.codelang,lang.idlang
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang) 
				WHERE idhome = :gethome';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		':gethome'=>$gethome
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	function s_home_page_b_lang($idlang){
		$sql ='SELECT h.idhome,h.idlang
				FROM mc_page_home AS h
				WHERE h.idlang =:idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		':idlang'=>$idlang
		));
	}
	/**
	 * insertion d'un nouvel enregistrement pour une page d'accueil
	 * @param $subject
	 * @param $content
	 * @param $metatitle
	 * @param $metadescription
	 * @param $idlang
	 * @param $idadmin
	 */
	function i_new_home_page($subject,$content,$metatitle,$metadescription,$idlang,$idadmin){
		$sql = 'INSERT INTO mc_page_home (subject,content,metatitle,metadescription,idlang,idadmin) 
				VALUE(:subject,:content,:metatitle,:metadescription,:idlang,:idadmin)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':subject'			=>	$subject,
			':content'			=>	$content,
			':metatitle'		=>	$metatitle,
			':metadescription'  =>	$metadescription,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin
		));
	}
	/**
	 * Mise à jour d'un enregistrement d'une page d'accueil
	 * @param $subject
	 * @param $content
	 * @param $metatitle
	 * @param $metadescription
	 * @param $idlang
	 * @param $idadmin
	 * @param $idhome
	 */
	function u_home_page($subject,$content,$metatitle,$metadescription,$idlang,$idadmin,$idhome){
		$sql = 'UPDATE mc_page_home 
		SET subject=:subject,content=:content,metatitle=:metatitle,metadescription=:metadescription,idlang=:idlang,idadmin=:idadmin,date_home=NOW()
		WHERE idhome = :idhome';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':subject'			=>	$subject,
			':content'			=>	$content,
			':metatitle'		=>	$metatitle,
			':metadescription'  =>	$metadescription,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':idhome'			=>	$idhome
		));
	}
	/**
	 * Suppression d'une page d'accueil
	 * @param $delhome
	 */
	function d_home($delhome){
		$sql = 'DELETE FROM mc_page_home WHERE idhome = :delhome';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delhome'	=>	$delhome
			)); 
	}
}