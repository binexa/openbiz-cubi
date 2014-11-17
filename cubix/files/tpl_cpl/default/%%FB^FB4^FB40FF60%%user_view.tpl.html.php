<?php /* Smarty version 2.6.10, created on 2014-11-17 10:37:39
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cthemes/default/template/user_view.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\themes/default/template/user_view.tpl.html', 52, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if(preg_match('/iPad/si',$_SERVER['HTTP_USER_AGENT']) || preg_match('/iPhone/si',$_SERVER['HTTP_USER_AGENT'])){  ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ios_webapp.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php echo $this->_tpl_vars['style_sheets']; ?>

<?php echo $this->_tpl_vars['scripts']; ?>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_url']; ?>
/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_url']; ?>
/login.css" type="text/css" />
<?php  if (OPENBIZ_JSLIB_BASE=='JQUERY') :  ?>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/jquery.textbox.hinter.js"></script>
<?php  else :  ?>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/jquery.js"></script>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/jquery-ui-1.8.12.custom.min.js"></script>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/jquery.textbox.hinter.js"></script>
<script><?php echo 'try{var $j=jQuery.noConflict();}catch(e){}'; ?>
</script>
<?php  endif;  ?>

<?php if(preg_match('/iPad/si',$_SERVER['HTTP_USER_AGENT']) || preg_match('/iPhone/si',$_SERVER['HTTP_USER_AGENT'])){  ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_url']; ?>
/ipad.css" type="text/css" />
<?php } ?>
<?php if(preg_match('/Android/si',$_SERVER['HTTP_USER_AGENT'])){  ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css_url']; ?>
/andriod.css" type="text/css" />
<?php } ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['app_url']; ?>
/languages/<?php echo $this->_tpl_vars['lang_name']; ?>
/localization.css" type="text/css" />
</head>

<body>
<div align="center">
<?php if(preg_match('/iPad/si',$_SERVER['HTTP_USER_AGENT']) ){  ?>
<div id="wrap_header_padding" style="height:80px;"></div>
<?php } ?>
	<div id="wrap">
		<div id="login_box">
				<div id="forms" >
					<div style="height:25px;"></div>
					<?php $_from = $this->_tpl_vars['forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['form']):
?>
					   <div><?php echo $this->_tpl_vars['form']; ?>
</div>
					<?php endforeach; endif; unset($_from); ?>
				</div>
				<div id="loader_bg" ></div>
				<div id="loader">
					<div style="height:185px;"></div>
					<div style="padding-left:300px; text-align:left">
					<div class="loader_box">
						<img src="<?php echo $this->_tpl_vars['image_url']; ?>
/ajax_loader.gif" style="float:left; margin-top:8px;" />
						<p style="float:left;margin-left:10px; padding-top:5px;" >
						<img src="<?php echo $this->_tpl_vars['image_url']; ?>
/loading.gif" />
						<br/><span style="padding-left:3px;color:#aaaaaa "><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Please wait a while ...<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></span></p>
					</div>
					</div>			
				</div>
				<?php echo '
				<script>
					//$(\'loader_bg\').fade( {from: 1, to: 0.7});
					//$(\'loader\').fade( {from: 0, to: 1});
				</script>
				'; ?>

		</div>
	</div>
</div>
<?php echo '
<!--[if gte IE 6]>
<style type="text/css">
#loader .loader_box
{
background-image:url(';  echo $this->_tpl_vars['theme_url'];  echo '/images/loading_bg.gif);
}
</style>
<![endif]-->
'; ?>

<script>
window.onload=fade_loader;
window.onunload=fadeout_loader;
<?php  if (OPENBIZ_JSLIB_BASE=='JQUERY') :  ?>
<?php echo '
function fade_loader(){
	$(\'#loader\').fadeOut(\'slow\');
	$(\'#loader_bg\').fadeOut(\'slow\');	
}
function fadeout_loader(){	
	$(\'#loader_bg\').fadeIn(\'slow\');
}
'; ?>

<?php  else :  ?>
<?php echo '
function fade_loader(){
	window.setTimeout("$(\'loader\').fade( {from: 0.7, to: 0});",800);
	window.setTimeout("$(\'loader_bg\').fade( {from: 0.7, to: 0});",800);	
	window.setTimeout("$(\'loader\').hide();",2000);
	window.setTimeout("$(\'loader_bg\').hide();",2000);	
}
function fadeout_loader(){	
	$(\'loader_bg\').fade( {from: 0.5, to: 1});
}
'; ?>

<?php  endif;  ?>
</script>

<?php if(preg_match('/iPad/si',$_SERVER['HTTP_USER_AGENT']) || preg_match('/iPhone/si',$_SERVER['HTTP_USER_AGENT'])){  ?>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/ios_webapp.js"></script>
<?php } ?>
</body>
</html>