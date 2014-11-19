<?php /* Smarty version 2.6.10, created on 2014-11-19 10:03:51
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/menu/template/tab_menu.tpl */ ?>
<ul>
	<?php $_from = $this->_tpl_vars['widget']['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<?php $this->assign('current', '0'); ?>
		<?php $_from = $this->_tpl_vars['widget']['breadcrumb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bc']):
?>
			<?php if ($this->_tpl_vars['item']->recordId == $this->_tpl_vars['bc']->recordId): ?>
	    		<?php $this->assign('current', '1'); ?>
			<?php endif; ?>
	    <?php endforeach; endif; unset($_from); ?>
	    <?php if ($this->_tpl_vars['current'] == 1): ?>
	    	<li><a class="current"  href="<?php echo $this->_tpl_vars['item']->url; ?>
" ><?php echo $this->_tpl_vars['item']->objectName; ?>
</a></li>
	    <?php else: ?>
	    	<li><a href="<?php echo $this->_tpl_vars['item']->url; ?>
" ><?php echo $this->_tpl_vars['item']->objectName; ?>
</a></li>
	    <?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
</ul>