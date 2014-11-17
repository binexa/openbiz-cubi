<?php /* Smarty version 2.6.10, created on 2014-11-17 11:41:33
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/system/template/view.tpl.html */ ?>
<?php 
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$includedScripts = Openbiz\Openbiz::$app->getClientProxy()->getAppendedScripts();
$includedScripts.="\n"."
<script src=\"".OPENBIZ_JS_URL."/cookies.js\"></script>
<script src=\"".OPENBIZ_JS_URL."/grouping.js\"></script>
<script src=\"".OPENBIZ_JS_URL."/general_ui.js\"></script>
<script type=\"text/javascript\" src=\"".OPENBIZ_JS_URL."/DateRangePicker/daterangepicker.jQuery.js\"></script>
<link rel=\"stylesheet\" href=\"".OPENBIZ_JS_URL."/DateRangePicker/css/ui.daterangepicker.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".OPENBIZ_JS_URL."/DateRangePicker/css/redmond/jquery-ui-1.7.1.custom.css\" type=\"text/css\" />
";
if (OPENBIZ_JSLIB_BASE!='JQUERY') {
	$includedScripts .= "
	<script src=\"".OPENBIZ_JS_URL."/jquery.js\"></script>
	<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
	<script src=\"".OPENBIZ_JS_URL."/jquery-ui-1.8.12.custom.min.js\"></script>
	";
}
$this->_tpl_vars['scripts'] = $includedScripts; 

$css_url = $this->_tpl_vars['css_url'];
$appendStyle = Openbiz\Openbiz::$app->getClientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;


$this->assign('template_file', 'system_view.tpl.html');
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['template_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>