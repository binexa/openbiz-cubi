{php}
$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

Openbiz\Openbiz::$app->getClientProxy()->includeColorPickerScripts();
Openbiz\Openbiz::$app->getClientProxy()->includeCalendarScripts();
Openbiz\Openbiz::$app->getClientProxy()->includeCKEditorScripts();
$includedScripts = Openbiz\Openbiz::$app->getClientProxy()->getAppendedScripts();
$includedScripts.="
<script type='text/javascript' src='//maps.googleapis.com/maps/api/js?sensor=false'></script>
<script type='text/javascript' src='$js_url/cookies.js'></script>
<script type='text/javascript' src='$js_url/grouping.js'></script>
<script type='text/javascript' src='$theme_js_url/general_ui.js'></script>
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
<script type='text/javascript' src='$js_url/uploadify/swfobject.js'></script>
<script type='text/javascript' src='$js_url/uploadify/jquery.uploadify.v2.1.4.js'></script>
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
";
$this->_tpl_vars['scripts'] = $includedScripts;

$appendStyle = Openbiz\Openbiz::$app->getClientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/@@MENU_ICON_CSS@@\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

$left_menu = "@@LEFT_MENU_WIDGET@@";
$this->assign('left_menu', $left_menu);

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}