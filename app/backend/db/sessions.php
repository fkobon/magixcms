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
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name sessions
 *
 */
class backend_db_sessions{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $admindbsession;
	/**
	 * instance backend_db_config with singleton
	 */
	public static function adminDbSession(){
        if (!isset(self::$admindbsession)){
         	self::$admindbsession = new backend_db_sessions();
        }
    	return self::$admindbsession;
    }
	/**
	 * deletes the current session id
	 * @param $userid
	 * @return void
	 */
	function delCurrent($userid){
		$sql = 'DELETE FROM mc_admin_session WHERE userid = :userid';
		magixglobal_model_db::layerDB()->delete($sql,
			array(
				':userid'=> $userid
				
		)); 
	}
	/**
	 * inserts a new session identifier
	 * @param $userid (ID)
	 * @param $ip (IP)
	 * @return void
	 */
	function insertNewSessionId($userid,$ip,$browser){
		$sql = 'INSERT INTO mc_admin_session (sid, userid, ip, browser) VALUE (:sid,:userid, :ip, :browser)';
		magixglobal_model_db::layerDB()->insert($sql,
			array(
			':sid'=> session_id(),
			':userid'=> $userid,
			':ip'=> $ip,
			':browser' => $browser
		)); 
	}
	/**
	 * delete lastest modified max 2 days
	 * @param $limit
	 * @return void
	 */
	function delLast_modified($limit){
		$sql = 'DELETE FROM mc_admin_session WHERE last_modified < :limit';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':limit'=>$limit));
	}
	/**
	 * delete session where sid
	 * @param $sid
	 * @return void
	 */
	function delete_session_sid($sid){
		$sql = 'DELETE FROM mc_admin_session WHERE sid = :sid';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':sid'=>$sid));
	}
	/**
	 * récupère la session utilisateur via la session actuelle
	 * @return void
	 */
	function getsid(){
		$sql = 'SELECT sid,userid FROM mc_admin_session WHERE sid = :sid';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(':sid'=>session_id()));
	}
}
?>