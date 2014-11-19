<?php /* Smarty version 2.6.10, created on 2014-11-19 11:01:30
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/menu/template/vertical_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/menu/template/vertical_menu.tpl', 4, false),array('modifier', 'count', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/menu/template/vertical_menu.tpl', 24, false),)), $this); ?>
<div class="menu_title">
<h2><?php echo $this->_tpl_vars['widget']['title']; ?>
</h2>
<p style="float:right;display:block;padding-top:4px;">
<span style="display: block;float: left;"><a class="menu_index_link" href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/general_default"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Index<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></span>
<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/general_default"><img id="system_dashboard" class="btn_dashboard"  src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" border="0" /></a></p>
</div>
<ul class="toplevel <?php echo $this->_tpl_vars['widget']['css']; ?>
 left_menu">
	<?php $_from = $this->_tpl_vars['widget']['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<li>
	    <?php $this->assign('current', '0'); ?>
	    <?php $_from = $this->_tpl_vars['widget']['breadcrumb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bc']):
?>
			<?php if ($this->_tpl_vars['item']->recordId == $this->_tpl_vars['bc']->recordId): ?>
	    		<?php $this->assign('current', '1'); ?>
			<?php endif; ?>
	    <?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['current'] == 1): ?>
			<?php $this->assign('menu_class', 'current'); ?>
		<?php else: ?>
			<?php $this->assign('menu_class', ""); ?>
	    <?php endif; ?>
		<a onclick="show_submenu(this)" class="<?php echo $this->_tpl_vars['menu_class']; ?>
" href="<?php if ($this->_tpl_vars['item']->url):  echo $this->_tpl_vars['item']->url;  else: ?>javascript:<?php endif; ?>">
			<img class="<?php echo $this->_tpl_vars['item']->iconCSSClass; ?>
" src="<?php echo $this->_tpl_vars['image_url']; ?>
/<?php if ($this->_tpl_vars['item']->iconImage != ''):  echo $this->_tpl_vars['item']->iconImage;  else: ?>spacer.gif<?php endif; ?>" /><?php echo $this->_tpl_vars['item']->objectName; ?>

		</a>
		<?php if (count($this->_tpl_vars['item']->childNodes) > 0): ?>
		<ul class="secondlevel module" <?php if ($this->_tpl_vars['menu_class'] == 'current'): ?>style="display:block;"<?php endif; ?>>
		<?php $_from = $this->_tpl_vars['item']->childNodes; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subitem']):
?>
    		<?php $this->assign('current', '0'); ?>
    	    <?php $_from = $this->_tpl_vars['widget']['breadcrumb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bc']):
?>
    			<?php if ($this->_tpl_vars['subitem']->recordId == $this->_tpl_vars['bc']->recordId): ?>
    	    		<?php $this->assign('current', '1'); ?>
    			<?php endif; ?>
    	    <?php endforeach; endif; unset($_from); ?>
			<?php if ($this->_tpl_vars['current'] == 1): ?>
				<?php $this->assign('submenu_class', 'current'); ?>
			<?php else: ?>
				<?php $this->assign('submenu_class', ""); ?>
		    <?php endif; ?>
				<li><a class="<?php echo $this->_tpl_vars['submenu_class']; ?>
" href="<?php if ($this->_tpl_vars['subitem']->url):  echo $this->_tpl_vars['subitem']->url;  else: ?>javascript:<?php endif; ?>"><?php echo $this->_tpl_vars['subitem']->objectName; ?>
</a></li>
		<?php endforeach; endif; unset($_from); ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; endif; unset($_from); ?>
</ul>
<div class="v_spacer"></div>