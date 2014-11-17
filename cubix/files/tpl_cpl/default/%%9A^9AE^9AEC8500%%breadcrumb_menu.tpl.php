<?php /* Smarty version 2.6.10, created on 2014-11-17 11:38:02
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/menu/template/breadcrumb_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/menu/template/breadcrumb_menu.tpl', 2, false),)), $this); ?>
<div style="padding-left:20px;">
<a href="javascript:"><img class="icon_dot_root" style="margin-top:5px;" border="0" src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Cubi System<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
	<?php $_from = $this->_tpl_vars['widget']['breadcrumb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<?php if ($this->_tpl_vars['item']->url != ""): ?>
		<a href="<?php echo $this->_tpl_vars['item']->url; ?>
">
		<?php else: ?>
		<a href="javascript:">
		<?php endif; ?>
		<img class="icon_dot" border="0" src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" /><?php echo $this->_tpl_vars['item']->objectName; ?>
</a>	    
	<?php endforeach; endif; unset($_from); ?>
</div>