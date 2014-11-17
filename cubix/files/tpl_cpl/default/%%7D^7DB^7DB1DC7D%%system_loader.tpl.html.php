<?php /* Smarty version 2.6.10, created on 2014-11-17 11:38:02
         compiled from system_loader.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'system_loader.tpl.html', 10, false),)), $this); ?>
<div style="position:absolute;">
	<div id="main_loader_bg"></div>
	<div id="main_loader">
			<div style="height:175px;"></div>
			<div style="padding-left:400px; text-align:left" id="main_loader_content">
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
</div>

<?php echo '
<!--[if gte IE 6]>
<style type="text/css">
#main_loader .loader_box
{
background-image:url(';  echo $this->_tpl_vars['theme_url'];  echo '/images/loading_bg.gif);
}
</style>
<![endif]-->
'; ?>


<script>
<?php  if (OPENBIZ_JSLIB_BASE=='JQUERY') :  ?>

<?php  else :  ?>
<?php echo '
$(\'main_loader_bg\').fade( {from: 1, to: 0.7});
$(\'main_loader\').fade( {from: 0, to: 1});
'; ?>

<?php  endif;  ?>
</script>