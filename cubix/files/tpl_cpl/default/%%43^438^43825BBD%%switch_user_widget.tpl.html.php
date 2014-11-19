<?php /* Smarty version 2.6.10, created on 2014-11-19 10:03:51
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/system/template/switch_user_widget.tpl.html */ ?>
<form id='<?php echo $this->_tpl_vars['form']['name']; ?>
' name='<?php echo $this->_tpl_vars['form']['name']; ?>
'>
<span style="display:block;float:right;padding-top:2px;text-align:left;"><?php 
		$profile_display = Openbiz\Openbiz::$app->getProfile()->getProfileName(Openbiz\Openbiz::$app->getUserProfile("Id"));
		$this->assign('profile', $profile_display);
		 ?>
		<?php if ($this->_tpl_vars['form']['show_widget']): ?>
		<?php $_from = $this->_tpl_vars['dataPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
			<?php if ($this->_tpl_vars['elem']['label']): ?> 
				<span style="display:block;float:left;padding-right:5px;padding-top:2px;"><?php echo $this->_tpl_vars['elem']['label']; ?>
</span> 
			<?php endif; ?> 
			<?php echo $this->_tpl_vars['elem']['element']; ?>

		<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
			<span style="display:block;float:left;padding-right:5px;padding-top:2px;">
			<?php echo $this->_tpl_vars['profile']; ?>

			</span>
		<?php endif; ?>
</span>
</form>