<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license  Dual licensed under the MIT or GPL Version 3 licenses.
 * @version  plugin version
 * @author   <samuel@magix-cms.com>, <aurelien@magix-cms.com>
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_lang_prelude} function plugin
 *
 * Type:     function
 * Name:     widget_lang_prelude
 * Date:     25/11/2010
 * Date Update : 10/08/2011
 * Examples: {widget_lang_prelude 
  				config_param=[
  				'display'=>true,
  				'icons'=>true,
  				'separator'=>''
  			  ]}
 * Output:   
 * @link 
 * @version  1.3
 * @param $params
 * @param $template
 * @return string
 */

function smarty_function_widget_lang_prelude($params, $template){
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	$icons = !empty($tabs['icons'])? "true" : "false";
	$separator = !empty($tabs['separator'])? $tabs['separator'] : '';
	if(frontend_db_lang::s_fetch_lang() != null){
		$menu = '<div id="prelude">';
		switch($icons){
			case "true":
				foreach (frontend_db_lang::s_fetch_lang() as $l){
					$menu .= $separator.'<a href="/'.$l['iso'].'/" hreflang="'.$l['iso'].'">';
					$menu .= '<img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/lang/'.$l['iso'].'.png" alt="'.$l['language'].'" />';
					$menu .= '</a>';
				}
			break;
			case "false":
				foreach (frontend_db_lang::s_fetch_lang() as $l){
					$menu .= $separator.'<a href="/'.$l['iso'].'/">'.magixcjquery_string_convert::upTextCase($l['iso']).'</a>';
				}
			break;
		}
		$menu .= "</div>";
	return $menu;
	}
}
?>