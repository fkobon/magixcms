<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2012 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 * @name home
 *
 */
class backend_controller_home extends backend_db_home{
	/**
	 * gethome
	 * @var getedit (get edit)
	 */
	public $edit,$action;
	/**
	 * string
	 * @var subject
	 */
	public $subject;
	/**
	 * string
	 * @var content
	 */
	public $content;
	/**
	 * string
	 * @var metatitle
	 */
	public $metatitle;
	/**
	 * string
	 * @var metadescription
	 */
	public $metadescription;
	/**
	 * integer
	 * @var delhome
	 */
	public $delete_home;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('subject')){
			$this->subject = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
		}
		if(magixcjquery_filter_request::isPost('content')){
			$this->content = magixcjquery_form_helpersforms::inputCleanQuote($_POST['content']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('metatitle')){
			$this->metatitle = magixcjquery_form_helpersforms::inputTagClean($_POST['metatitle']);
		}
		if(magixcjquery_filter_request::isPost('metadescription')){
			$this->metadescription = magixcjquery_form_helpersforms::inputTagClean($_POST['metadescription']);
		}
		if(magixcjquery_filter_request::isPost('delete_home')){
			$this->delete_home = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_home']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
	}
	/**
	 * @access private
	 * Requête JSON pour retourner la liste des langues
	 */
	private function json_list_home(){
		if(parent::s_list_home() != null){
			foreach (parent::s_list_home() as $s){
				if ($s['metatitle'] != null){
					$metatitle = 1;
				}else{
					$metatitle = 0;
				}
				if ($s['metadescription'] != null){
					$metadescription = 1;
				}else{
					$metadescription = 0;
				}
				$uri = magixcjquery_html_helpersHtml::getUrl().'/'.$s['iso'].'/';
				$json[]= '{"idhome":'.json_encode($s['idhome']).',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($s['iso']))
				.',"subject":'.json_encode($s['subject']).',"pseudo":'.json_encode($s['pseudo']).',"uri_home":'.json_encode($uri).',"metatitle":'.json_encode($metatitle).
				',"metadescription":'.json_encode($metadescription).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	private function load_data_forms($create){
		$data = parent::s_edit_home($this->edit);
		$create->assign('subject',$data['subject']);
		$create->assign('content',$data['content']);
		$create->assign('idlang',$data['idlang']);
		$create->assign('iso',$data['iso']);
		$create->assign('metatitle',$data['metatitle']);
		$create->assign('metadescription',$data['metadescription']);
	}
	private function insert_data_forms($create){
		if(isset($this->subject)){
			if(empty($this->subject)){
				$create->display('request/empty.phtml');
			}else{
				if(parent::s_lang_home($this->idlang) == null){
					parent::i_new_home(
						$this->subject,
						$this->content,
						$this->metatitle,
						$this->metadescription,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					$create->display('request/success.phtml');
				}else{
					$create->display('request/element-exist.phtml');
				}
			}
		}
	}
	private function update_data_forms($create){
		if(isset($this->subject)){
			if(empty($this->subject)){
				$create->display('request/empty.phtml');
			}else{
                parent::u_home(
                    $this->subject,
                    $this->content,
                    $this->metatitle,
                    $this->metadescription,
                    $this->idlang,
                    backend_model_member::s_idadmin(),
                    $this->edit
                );
                $create->display('request/success.phtml');
			}
		}
	}
	/**
	 * Supprime une page home
	 * @access private
	 */
	private function remove_home(){
		if(isset($this->delete_home)){
			parent::d_home($this->delete_home);
		}
	}

    /**
     * @access private
     * Requête JSON pour les statistiques des pages d'accueil
     */
    private function json_graph(){
        if(parent::s_count_home() != null){
            foreach (parent::s_count_home() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['counthome']
                );
            }
            print json_encode($stat);
        }
    }
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        if(isset($this->action)){
            if($this->action == 'list'){
                if(magixcjquery_filter_request::isGet('json_list_home')){
                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                    $header->pragma();
                    $header->cache_control("nocache");
                    $header->getStatus('200');
                    $header->json_header("UTF-8");
                    $this->json_list_home();
                }else{
                    $create->display('home/list.phtml');
                }
            }elseif($this->action == 'add'){
                if(isset($this->subject)){
                    $this->insert_data_forms($create);
                }
            }elseif($this->action == 'edit'){
                if(magixcjquery_filter_request::isGet('edit')){
                    if(isset($this->subject)){
                        $this->update_data_forms($create);
                    }else{
                        $this->load_data_forms($create);
                        $create->display('home/edit.phtml');
                    }
                }
            }elseif($this->action == 'remove'){
                if(isset($this->delete_home)){
                    $this->remove_home();
                }
            }
        }else{
            if(magixcjquery_filter_request::isGet('json_graph')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_graph();
            }else{
                $create->assign('selectlang',backend_model_blockDom::select_language());
                $create->display('home/index.phtml');
            }
        }
	}
}
?>