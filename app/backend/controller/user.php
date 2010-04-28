<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name USER
 * @version 4.0
 *
 */

class backend_controller_user extends statesUserAdmin{
	/**
	 * Pseudo
	 * @var string
	 */
	public $pseudo;
	/**
	 * Email
	 * @var string
	 */
	public $email;
	/**
	 * Cryptpass
	 * @var string
	 */
	public $cryptpass;
	/**
	 * perms (permission)
	 * @var string
	 */
	public $perms;
	/**
	 * deluser
	 * @var string
	 */
	public $deluser;
	/**
	 * edit
	 * @var string
	 */
	public $edit;
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_POST['pseudo'])){
			$this->pseudo = magixcjquery_form_helpersforms::inputClean($_POST['pseudo']);
		}
		if(isset($_POST['email'])){
			$this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
		}
		if(isset($_POST['cryptpass'])){
			$this->cryptpass = magixcjquery_form_helpersforms::inputClean(sha1($_POST['cryptpass']));
		}
		if(isset($_POST['perms'])){
			$this->perms = magixcjquery_form_helpersforms::inputClean(magixcjquery_filter_isVar::isPostNumeric($_POST['perms']));
		}
		if(isset($_GET['deluser'])){
			$this->deluser = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['deluser']);
		}
		if(isset($_GET['edit'])){
			$this->edit = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
	}
	/**
	 * Insert un nouvel utilisateur
	 */
	protected function insert_members(){
		if(isset($this->pseudo) AND isset($this->cryptpass)){
			backend_db_admin::adminDbMember()->i_n_members($this->pseudo,$this->email,$this->cryptpass,$this->perms);
			backend_config_smarty::getInstance()->display('user/request/success.phtml');
		}
	}
	/**
	 * Update un utilisateur
	 */
	protected function update_members(){
		if(isset($this->edit)){
			if(isset($this->pseudo) AND isset($this->cryptpass)){
				try{
					backend_db_admin::adminDbMember()->u_n_members($this->pseudo,$this->email,$this->cryptpass,$this->perms,$this->edit);
					$fetch = backend_config_smarty::getInstance()->fetch('user/request/update.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
				}catch(Exception $e) {
		         	magixcjquery_debug_magixfire::magixFireError($e);
				} 
			}
		}
	}
	/**
	 * Block pour afficher le nombre total de membres
	 */
	function block_states_members(){
		$states = null;
		$states .=  parent::count_maximum_members();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de membres suivant les permissions
	 */
	function block_members_perms(){
		$states = null;
		$states .=  parent::count_members_in_perms();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de news par membres
	 */
	function block_news_members(){
		$states = null;
		$states .=  parent::count_news_by_members();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de page CMS par membres
	 */
	function block_cms_members(){
		$states = null;
		$states .=  parent::count_cms_by_members();
		return $states;
	}
	/**
	 * Requête POST pour l'insertion des membres
	 */
	function post(){
		self::insert_members();
	}
	/**
	 * Requête POST pour la mise à jour des membres
	 */
	function update_post(){
		self::update_members();
	}
	/**
	 * Suppression d'utilisateur
	 */
	function delete_user(){
		if(isset($this->deluser)){
			backend_db_admin::adminDbMember()->d_members_user($this->deluser);
		}
	}
	/**
	 * Affiche la page des utilisateurs
	 */
	function display(){
		backend_config_smarty::getInstance()->assign('block_states_users',self::block_states_members());
		backend_config_smarty::getInstance()->assign('block_members_perms',self::block_members_perms());
		backend_config_smarty::getInstance()->assign('block_news_members',self::block_news_members());
		backend_config_smarty::getInstance()->assign('block_cms_members',self::block_cms_members());
		backend_config_smarty::getInstance()->display('user/index.phtml');
	}
	/**
	 * Affiche la page des utilisateurs
	 */
	function display_edit(){
		self::update_post();
		parent::load_param_form($this->edit);
		backend_config_smarty::getInstance()->assign('current_perm',backend_model_member::s_perms_current_admin());
		backend_config_smarty::getInstance()->display('user/edit.phtml');
	}
}
/**
 * Class pour les statistiques utilisateurs
 * @author Gérits Aurelien
 *
 */
class statesUserAdmin{
	/**
	 * Compte le nombre de membres
	 */
	protected static function count_maximum_members(){
		$dbmembers = backend_db_admin::adminDbMember()->c_max_members();
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-bookmark"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							</tr>
						</thead>
						<tbody>';
		$states .= '<tr class="line">';
		$states .=	'<td class="maximal">Total</td>';
		$states .=	'<td class="nowrap">'.$dbmembers['countadmin'].'</td>';
		$states .= '</tr>';
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Compte 
	 */
	protected static function count_members_in_perms(){
		$perms = null;
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-key"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_admin::adminDbMember()->c_members_by_perms() as $members){
			switch($members['perms']){
					case 1:
						$perms = 'Seo Agency';
						break;
					case 2:
						$perms = 'Web Agency';
						break;
					case 3:
						$perms = 'User admin';
						break;
					case 4:
						$perms = 'User';
						break;
			}
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$perms.'</td>';
			$states .=	'<td class="nowrap">'.$members['countadmin'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Compte le nombre de news inserer par membre
	 */
	protected static function count_news_by_members(){
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-calendar"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_news::adminDbNews()->c_news_user() as $members){
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$members['pseudo'].'</td>';
			$states .=	'<td class="nowrap">'.$members['usernews'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Compte le nombre de page par membre
	 */
	protected static function count_cms_by_members(){
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-document-b"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_cms::adminDbCms()->c_cms_user() as $members){
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$members['pseudo'].'</td>';
			$states .=	'<td class="nowrap">'.$members['usercms'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Charge les donnée du formulaire de mise à jour
	 */
	protected static function load_param_form($edit){
		$userperm = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		$info = backend_db_admin::adminDbMember()->view_info_members($edit);
		backend_config_smarty::getInstance()->assign('user_perms',$info['perms']);
		backend_config_smarty::getInstance()->assign('pseudo',$info['pseudo']);
		backend_config_smarty::getInstance()->assign('email',$info['email']);
	}
}