<?php /* Smarty version 2.6.10, created on 2014-11-17 11:38:01
         compiled from system_appbuilder_btn.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'system_appbuilder_btn.tpl.html', 3, false),)), $this); ?>
<?php if (@CUBI_APPBUILDER && $this->_tpl_vars['hidden_appbuilder'] != 1): ?>
	<?php if ($this->_tpl_vars['view']['name']): ?>	
		<a class="appbuilder_btn_view_edit appbuilder_btn" title="<?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Edit Application View<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" href="<?php echo $this->_tpl_vars['app_url']; ?>
/bin/metaedit.php?metaobj=<?php echo $this->_tpl_vars['view']['name']; ?>
" target="_blank"  style="float:right;margin-left:5px; margin-top:6px;" ></a>
		<a class="appbuilder_btn_app_wizard appbuilder_btn" title="<?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Launch Appbuilder<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" href="<?php echo $this->_tpl_vars['app_url']; ?>
/bin/metaedit.php?action=launch" target="_blank"  style="float:right;margin-left:5px; margin-top:6px;" ></a>
	<?php else: ?>
		<a class="appbuilder_btn_form_edit appbuilder_btn" title="<?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Edit Application Form<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"  href="<?php echo $this->_tpl_vars['app_url']; ?>
/bin/metaedit.php?metaobj=<?php echo $this->_tpl_vars['form']['name']; ?>
" target="_blank" style="float:right;" ></a>
	<?php endif; ?>
<?php endif; ?>