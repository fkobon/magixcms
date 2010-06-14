<?php
/**
 * @see groupsConfig
 * minify dans public
 */
return array(
	'publiccss' => array('//framework/css/colorbox-white/colorbox.css','//framework/css/ui.selectmenu.css','//framework/css/ui/ui.checkbox.css','//framework/css/notification.css'),
	'publicjs'=> array('//framework/js/jquery-1.4.2.min.js','//framework/js/jquery-ui-1.7.3.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.43.js','//framework/js/ui.selectmenu.js',
	'//framework/js/jquery.validate-1.7.js','//framework/js/additional-methods-1.7.js','//framework/js/ui.checkbox.js','//framework/js/jquery.colorbox-min-1.6.js',
	'//framework/js/jquery.meerkat.1.3.js','//framework/js/jquery.cookie.js','//framework/js/jquery.jfirebug.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>