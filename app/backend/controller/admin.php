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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ADMIN
 *
 */
class backend_controller_admin{
	/**
	 *
	 *
	 * @var string
	 */
	public $acmail;
	/**
	 *
	 *
	 * @var string
	 */
	public $acsclose;
	/**
	 *
	 *
	 * @var param
	 */
	public $smarty;
	/**
	 * instance lang setting conf
	 *
	 * @var string
	 */
	public $lang;
	/**
	 * input type hidden 
	 * @access protected
	 *
	 * @var string
	 */
	protected $achpass;
	/**
	 * 
	 * @var hash
	 */
	static protected $hash;
	/**
	 * private var password re-genere
	 *
	 * @var string
	 * @access private
	 */
	protected $acpass;
	/**
	 * protected var for dbLayer
	 *
	 * @var void
	 */
	function __construct(){
		if(isset($_POST['acpass']) && isset($_POST['achpass'])){
			$this->achpass = $_POST['achpass'];
		    $this->acpass = (string) sha1(magixcjquery_filter_var::escapeHTML($_POST['acpass']));
          }
          if (isset($_GET['acsclose'])) {
          	$this->acsclose = magixcjquery_filter_isVar::isPostAlpha($_GET['acsclose']);
          }
          if(isset($_POST['acmail'])){
         	 $this->acmail = (string) magixcjquery_filter_var::escapeHTML($_POST['acmail']); 
          }
          self::$hash = uniqid('',true);
	}
	/**
	 * Crypt md5
	 * @param string $hash
	 * @static
	 * @access protected
	 */
	static protected function hashPassCreate($hash){
		return md5($hash);
	}
	/**
	 * function Send session and redirect page
	 *
	 */
	function authSession(){
		$token = self::hashPassCreate(self::$hash);
		backend_config_smarty::getInstance()->assign('hashpass',$token);
		if (isset($this->acpass) AND isset($this->acmail) AND isset($this->achpass)) {
			if(strcasecmp($this->achpass,$token) == true){
				if(count(backend_db_admin::adminDbMember()->s_auth_exist($this->acmail,$this->acpass)) == true){
					$session = new backend_model_sessions();
					$string = $_SERVER['HTTP_USER_AGENT'];
					$string .= 'SHIFLETT';
					/* Add any other data that is consistent */
					$fingerprint = md5($string);
					session_name('adminlang');
					ini_set('session.hash_function',1);
					session_start();
					$const_url = backend_db_admin::adminDbMember()->s_t_profil_url($this->acmail);
					if (!isset($_SESSION['useradmin'])) {
						$session->openSession($const_url['idadmin'],session_regenerate_id(true));
						//session_regenerate_id(true);
		    			$_SESSION['useradmin'] = $this->acmail;
		    			header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard.php');	
					}else{
						$session->openSession($const_url['idadmin'],null);
						$_SESSION['useradmin'] = $this->acmail;
						header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard.php');	
					}
				}else{
					backend_config_smarty::getInstance()->assign('msg',
					'<div style="margin:5px;padding:5px;" class="ui-state-error ui-corner-all"> 
						<strong>Alert:</strong> Login failed
					</div>');
				}
			}else{
					backend_config_smarty::getInstance()->assign('msg',
					'<div style="margin:5px;padding:5px;" class="ui-state-error ui-corner-all"> 
						<strong>Alert:</strong> Error hashed conflict
					</div>');
			}
		}
	}
	/**
	 * function secure page with session verif
	 * @return header
	 */
	function securePage(){
		//ini_set("session.cookie_lifetime",1800);
		session_name('adminlang');
		ini_set('session.hash_function',1);
		session_start();
		if (!isset($_SESSION["useradmin"]) || empty($_SESSION['useradmin'])){
			if (!isset($this->acmail)) {
				header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/login.php');	
			}
		}elseif(!backend_model_sessions::compareSessionId()){
			header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/login.php');	
		}
	}
	/**
	* function close Session in erase cookies
	* @return header
	*/
	function closeSession(){
		if (isset($this->acsclose)) {
			if (isset($_SESSION['useradmin'])){	
				$session = new backend_model_sessions();
				$session->closeSession();
				session_unset();
				$_SESSION = array();
				session_destroy();
				session_start();
				header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/login.php');	
			}
		}
	}
	/**
	 * Affiche le formulaire d'identification
	 * @return void
	 */
	function login(){
		self::authSession();
		backend_config_smarty::getInstance()->display('login/index.phtml');
	}
}