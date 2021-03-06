<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @contributor Salvatore Di Salvo <disalvo.infographiste@gmail.com>
 * @copyright  MAGIX CMS Copyright (c) 2010 -2014 Gerits Aurelien,
 * @version  Release: 1.0
 * Date: 20/08/2014
 * @license Dual licensed under the MIT or GPL Version 3 licenses.
 */
class backend_model_message{
    /**
     * @var backend_controller_template
     */
    protected $template,$plugins;
	protected $default = array(
		'template'		=>'message.tpl',
		'method'		=>'display',
		'assignFetch'	=>'',
		'plugin'		=>'false'
	);

    /**
     *
     */
    public function __construct(){
        $this->template = new backend_controller_template();
        $this->plugins = new backend_controller_plugins();
    }

    /**
     * Retourne le message de notification
     * @param $type
     * @param array $options
	 * @return string html compiled
     */
    public function getNotify($type,$options = array()){
		$options = $options + $this->default;
		$model = $options['plugin'] ? $this->plugins : $this->template;

		switch($options['method']) {
			case 'display':
				$model->assign('message',$type);
				$model->display($options['template']);
				break;

			case 'fetch':
			case 'return':
				$model->assign('message',$type);
                $fetch = $model->fetch($options['template']);
				if($options['method'] == 'fetch')
					$model->assign($options['assignFetch'],$fetch);
				else
					return $fetch;
				break;

			default:
				$model->assign('message',$type);
				$model->display($options['template']);
		}
    }
	
	/**
	 * Return a json object with the statut of the post action, the notification and the eventual result of the post
	 * @param bool $statut
	 * @param string $notify
	 * @param bool $result
	 */
	public function json_post_response($statut=true,$notify='save',$options = null,$result = null)
	{
		if (is_array($options))
			$options = $options + $this->default;
		elseif ($options === null || !is_array($options))
			$options = $this->default;
		$options['method'] = 'return';

		$notify = $this->getNotify($notify,$options);
		print '{"statut":'.json_encode($statut).',"notify":'.json_encode($notify).',"result":'.json_encode($result).'}';
	}
}
?>