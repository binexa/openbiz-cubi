<?php /* Smarty version 2.6.10, created on 2014-11-19 10:03:52
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/help/template/widget_list.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/help/template/widget_list.tpl.html', 14, false),array('modifier', 'count', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/help/template/widget_list.tpl.html', 20, false),)), $this); ?>
<div id="<?php echo $this->_tpl_vars['form']['name']; ?>
" name="<?php echo $this->_tpl_vars['form']['name']; ?>
">
	<div class="content_block_dark">

		<div class="header">								
		</div>
		<div class="content" >
<table></table>
<div class="title">
	<h2 style="width:65px;"><?php echo $this->_tpl_vars['form']['title']; ?>
</h2>
	<p style="float:right">
	<?php if ($this->_tpl_vars['actionPanel']['btn_show_tutorial']['element']): ?> 
		<?php echo $this->_tpl_vars['actionPanel']['btn_show_tutorial']['element']; ?>
 		
 	<?php else: ?>
		<span><a href="javascript:"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Help Center<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></span>
	<?php endif; ?> 
	<a onclick="switch_help_content()" href="javascript:"><img id="switch_help_content_btn" class="btn_max"  src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" border="0" /></a>	</p>
</div>
<div id="help_content" style="display:none">
<ul>
	<?php if (count($this->_tpl_vars['dataPanel']['data']) > 0): ?>
	    <?php $_from = $this->_tpl_vars['dataPanel']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
	    	<li><?php echo $this->_tpl_vars['row']['fld_title']; ?>
</li>
	    <?php endforeach; endif; unset($_from); ?>	
    <?php else: ?>
    	<li><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No help tips for this module.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></li>    
    <?php endif; ?>	
</ul>
</div>
<div style="padding-left:10px; padding-top:10px; height:30px;">
		<?php $_from = $this->_tpl_vars['searchPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
			<?php if ($this->_tpl_vars['elem']['label']): ?> <?php echo $this->_tpl_vars['elem']['label']; ?>
 <?php endif; ?> <?php echo $this->_tpl_vars['elem']['element']; ?>

		<?php endforeach; endif; unset($_from); ?>
</div>
<script>init_help_content()</script>
		</div>
		<div class="footer"></div>	
	</div>
</div>