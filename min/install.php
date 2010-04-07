<?php
/**
 * @see groupsConfig
 * minify install
 */
return array(
	'installcss' => array('//framework/css/ui/vader-1-7-2/jquery-ui-1.7.2.custom.css','//framework/css/ui/ui.checkbox.css',
	'//framework/css/globalcss.css','//framework/css/colorbox-simple/colorbox.css','//framework/css/ui.selectmenu.css',
	'//framework/css/globalforms.css','//framework/css/install.css'),
	'installjs'=> array('//framework/js/jquery-1.4.2.min.js','//framework/js/jquery-ui-1.7.2.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.43.js','//framework/js/ui.selectmenu.js',
	'//framework/js/jquery.validate-1.7.js','//framework/js/additional-methods-1.7.js','//framework/js/ui.checkbox.js','//framework/js/jquery.colorbox-min-1.6.js',
	'//framework/js/jquery.cookie.js','//framework/js/install.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>