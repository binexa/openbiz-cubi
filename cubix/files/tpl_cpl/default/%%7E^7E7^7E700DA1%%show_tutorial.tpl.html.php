<?php /* Smarty version 2.6.10, created on 2014-11-17 11:38:13
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/help/tutorial/template/show_tutorial.tpl.html */ ?>
<?php echo '
<style type="text/css">
.fld_help_content {font-size: 14px; padding: 10px;}
.fld_help_content ul { padding-left:20px; }
.fld_help_content p { padding-bottom:10px; }
</style>
'; ?>

<div style="margin:20px;">
<form id="<?php echo $this->_tpl_vars['form']['name']; ?>
" name="<?php echo $this->_tpl_vars['form']['name']; ?>
">

<?php if ($this->_tpl_vars['dataPanel']['fld_type']['element'] == 'content'): ?>
<div style="padding-left:25px; ">
	<div>
		<div style="padding-bottom: 10px"><h2><?php echo $this->_tpl_vars['dataPanel']['fld_subject']['element']; ?>
</h2></div>
		<div class="fld_content">
			<div class="label_text"><?php echo $this->_tpl_vars['dataPanel']['fld_content']['element']; ?>
</div>
		</div>
	</div>
</div>
<?php else: ?>
<div>
<?php echo $this->_tpl_vars['dataPanel']['fld_content_url']['element']; ?>

</div>
<?php endif; ?>
<div style="padding-left:0px; ">		
	<div style="height:10px;"></div>
	<p class="input_row" style="height:20px;">
		<?php $_from = $this->_tpl_vars['searchPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
			<span style="display:block;float:left;padding-right:10px;"><?php echo $this->_tpl_vars['elem']['element'];  echo $this->_tpl_vars['elem']['description']; ?>
</span>
		<?php endforeach; endif; unset($_from); ?>
	</p>
	
</div>

</form>
<?php if ($this->_tpl_vars['dataPanel']['fld_width']['element'] && $this->_tpl_vars['dataPanel']['fld_height']['element']): ?>
<script>Openbiz.Window.centerDialog(<?php echo $this->_tpl_vars['dataPanel']['fld_width']['element']; ?>
+40,<?php echo $this->_tpl_vars['dataPanel']['fld_height']['element']; ?>
+80); </script>
<?php endif; ?>
</div>