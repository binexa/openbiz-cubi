<?php /* Smarty version 2.6.10, created on 2014-11-19 10:03:50
         compiled from system_view.tpl.html */ ?>
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
<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
"/>
<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
"/>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/ckeditor/ckeditor.js"></script>
<?php echo $this->_tpl_vars['style_sheets']; ?>

<?php echo $this->_tpl_vars['scripts']; ?>

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
<div align="center" id="body_warp">
	<div id="header_warp">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_header.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<!--main warp-->
	<div id="main_warp">	
		<!--main-->
		<div id="main" >
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_loader.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<table id="main_content" border="0" cellpadding="0" cellspacing="0">
				<tr><td><img src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" style="height:15px;" /></td></tr>
				<tr>
					<td valign="top" style="width:18px;"><img src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" style="width:18px;" /></td>
					<td valign="top" id="left_panel">
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_left_panel.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</td>
					<td valign="top" id="right_panel">
						<!-- notification block start -->
						<div id="notification">
						<?php echo Openbiz\Openbiz::getObject('notification.widget.NotificationWidgetForm')->render(); ?>
						</div>
						<!-- notification block start -->
					
						<!-- right block start -->
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_right_panel.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<!-- right block end -->
					</td>
				</tr>
			  </table>		  
			</div>
			<!--main-->
		
		</div>		
		<!--main wrap end-->
		<!--footer-->
		<div  id="footer_warp">			
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_footer.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
		<!-- footer end -->
	
	</div>
</div>

<script>
<?php  if (OPENBIZ_JSLIB_BASE=='JQUERY') :  ?>

<?php  else :  ?>
<?php echo '
$(\'main_loader_bg\').style.height = $(\'main_content\').offsetHeight+\'px\';
'; ?>

<?php  endif;  ?>
</script>
<?php if(preg_match('/iPad/si',$_SERVER['HTTP_USER_AGENT']) || preg_match('/iPhone/si',$_SERVER['HTTP_USER_AGENT'])){  ?>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/ios_webapp.js"></script>
<?php } ?>
</body>
</html>