<?php /* Smarty version 2.6.10, created on 2014-11-17 11:41:33
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cthemes/default/template/system_right_listform_grouping.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\themes/default/template/system_right_listform_grouping.tpl.html', 63, false),array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\themes/default/template/system_right_listform_grouping.tpl.html', 67, false),)), $this); ?>
<form id='<?php echo $this->_tpl_vars['form']['name']; ?>
' name='<?php echo $this->_tpl_vars['form']['name']; ?>
'>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/cookies.js"></script>
<script src="<?php echo $this->_tpl_vars['js_url']; ?>
/grouping.js"></script>
<div style="padding-left:25px;padding-right:20px;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "system_appbuilder_btn.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<table><tr><td>
		<?php if ($this->_tpl_vars['form']['icon'] != ''): ?>
		<div class="form_icon"><img  src="<?php echo $this->_tpl_vars['form']['icon']; ?>
" border="0" /></div>
		<?php endif; ?>
		<div style="float:left; width:600px;">
		<h2>
		<?php echo $this->_tpl_vars['form']['title']; ?>

		</h2> 
		<p class="form_desc"><?php echo $this->_tpl_vars['form']['description']; ?>
</p>
		</div>
	</td></tr></table>
<?php if ($this->_tpl_vars['actionPanel'] || $this->_tpl_vars['searchPanel']): ?>	
	<div class="form_header_panel">	
		<div class="action_panel" >
			<?php $_from = $this->_tpl_vars['searchPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
				<?php if ($this->_tpl_vars['elem']['type'] == 'InputDateRangePicker'): ?> <?php echo $this->_tpl_vars['elem']['element'];  endif; ?> 
			<?php endforeach; endif; unset($_from); ?>
		
			<?php $_from = $this->_tpl_vars['actionPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
			    	<?php echo $this->_tpl_vars['elem']['element']; ?>

			<?php endforeach; endif; unset($_from); ?>
		</div>
		<div class="search_panel" >		
			<?php $_from = $this->_tpl_vars['searchPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
				<?php if ($this->_tpl_vars['elem']['type'] != 'InputDateRangePicker'): ?>
					<?php if ($this->_tpl_vars['elem']['label']): ?> <?php echo $this->_tpl_vars['elem']['label']; ?>
 <?php endif; ?> <?php echo $this->_tpl_vars['elem']['element']; ?>

				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>	
<?php endif; ?>	
<div class="from_table_container">
<!-- table start -->
<table border="0" cellpadding="0" cellspacing="0" class="form_table" id="<?php echo $this->_tpl_vars['form']['name']; ?>
_data_table">
	<thead>		
     <?php $_from = $this->_tpl_vars['dataPanel']['elems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elems_name'] => $this->_tpl_vars['cell']):
?>	
     	<?php if ($this->_tpl_vars['cell']['type'] == 'ColumnStyle'): ?>
     		<?php $this->assign('row_style_name', $this->_tpl_vars['elems_name']); ?>
     	<?php else: ?>
			<?php if ($this->_tpl_vars['cell']['type'] == 'RowCheckbox'): ?>
				<?php $this->assign('th_style', "text-align:left;padding-left:10px;"); ?>
			<?php else: ?>
				<?php $this->assign('th_style', ""); ?>
			<?php endif; ?>
         <th onmouseover="this.className='hover'" 
			onmouseout="this.className=''"
				nowrap="nowrap" style="<?php echo $this->_tpl_vars['th_style']; ?>
"
			><?php echo $this->_tpl_vars['cell']['label']; ?>
</th>	 
		<?php endif; ?>
     <?php endforeach; endif; unset($_from); ?>
	</thead>				


<?php $this->assign('group_counter', 0); ?>    
<?php $_from = $this->_tpl_vars['form']['dataGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_name'] => $this->_tpl_vars['row']):
?>
	<tbody >
		<tr class="group_selector">
		<td colspan="<?php echo count($this->_tpl_vars['dataPanel']['elems']); ?>
" >
			<a href="javascript:;" id="<?php echo $this->_tpl_vars['form']['name']; ?>
_group_<?php echo $this->_tpl_vars['group_name']; ?>
_switcher"
			onclick="switch_datasheet('<?php echo $this->_tpl_vars['form']['name']; ?>
_group_<?php echo $this->_tpl_vars['group_name']; ?>
')"
				class="shrink"		 		
			><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group: <?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo $this->_tpl_vars['group_name']; ?>
</a>
		</td>
		</tr>
	</tbody>
	<tbody id="<?php echo $this->_tpl_vars['form']['name']; ?>
_group_<?php echo $this->_tpl_vars['group_name']; ?>
">
	<!--  Group: <?php echo $this->_tpl_vars['group_name']; ?>
 -->
 		<?php $this->assign('row_counter', 0); ?>    
     	<?php $_from = $this->_tpl_vars['form']['dataGroup'][$this->_tpl_vars['group_name']]['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>

     	 <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['row_style_name']] != ''): ?>
     	 	<?php $this->assign('row_style', $this->_tpl_vars['dataPanel']['data'][$this->_tpl_vars['row_counter']][$this->_tpl_vars['row_style_name']]); ?>
     	 <?php else: ?>
     	 	<?php $this->assign('row_style', ''); ?>
     	 <?php endif; ?>
         
          <?php if ((1 & $this->_tpl_vars['row_counter'])): ?>
		   <tr id="<?php echo $this->_tpl_vars['form']['name']; ?>
-<?php echo $this->_tpl_vars['form']['dataGroup'][$this->_tpl_vars['group_name']]['ids'][$this->_tpl_vars['row_counter']]; ?>
" 
		   			style="<?php echo $this->_tpl_vars['row_style']; ?>
"
		   			class="odd"  normal="odd" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='odd'"  
					onclick="Openbiz.CallFunction('<?php echo $this->_tpl_vars['form']['name']; ?>
.SelectRecord(<?php echo $this->_tpl_vars['form']['dataGroup'][$this->_tpl_vars['group_name']]['ids'][$this->_tpl_vars['row_counter']]; ?>
)');">
          <?php else: ?>
			<tr id="<?php echo $this->_tpl_vars['form']['name']; ?>
-<?php echo $this->_tpl_vars['form']['dataGroup'][$this->_tpl_vars['group_name']]['ids'][$this->_tpl_vars['row_counter']]; ?>
"
					style="<?php echo $this->_tpl_vars['row_style']; ?>
" 
					class="even"  normal="even" select="selected"
					onmouseover="if(this.className!='selected')this.className='hover'" 
					onmouseout="if(this.className!='selected')this.className='even'" 
					onclick="Openbiz.CallFunction('<?php echo $this->_tpl_vars['form']['name']; ?>
.SelectRecord(<?php echo $this->_tpl_vars['form']['dataGroup'][$this->_tpl_vars['group_name']]['ids'][$this->_tpl_vars['row_counter']]; ?>
)');">
         <?php endif; ?>
		         <?php $this->assign('col_counter', 0); ?>    
         		<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cell_name'] => $this->_tpl_vars['cell']):
?>
		         	<?php if ($this->_tpl_vars['col_counter'] == 0): ?>
		         		<?php $this->assign('col_class', ' class="row_header" '); ?>    
		         	<?php else: ?>
		         		<?php $this->assign('col_class', ' '); ?>
		         	<?php endif; ?>
		         	<?php if ($this->_tpl_vars['cell_name'] != $this->_tpl_vars['row_style_name']): ?>
			            <?php if ($this->_tpl_vars['cell'] != ''): ?>            	
			              <td <?php echo $this->_tpl_vars['col_class']; ?>
 nowrap="nowrap" ><?php echo $this->_tpl_vars['cell']; ?>
</td>
			            <?php else: ?>
			              <td <?php echo $this->_tpl_vars['col_class']; ?>
 nowrap="nowrap" >&nbsp;</td>
			            <?php endif; ?>
		            <?php endif; ?>
		            <?php $this->assign('col_counter', $this->_tpl_vars['col_counter']+1); ?>
		         <?php endforeach; endif; unset($_from); ?>         
		<?php $this->assign('row_counter', $this->_tpl_vars['row_counter']+1); ?>
		</tr>
     	<?php endforeach; endif; unset($_from); ?>			
	</tbody>
	<script>load_default_status('<?php echo $this->_tpl_vars['form']['name']; ?>
_group_<?php echo $this->_tpl_vars['group_name']; ?>
');</script>
	<?php $this->assign('group_counter', $this->_tpl_vars['group_counter']+1); ?>
<?php endforeach; endif; unset($_from); ?>
</table>
<!-- table end -->
</div>	

<!-- status switch  -->
<script>
<?php if ($this->_tpl_vars['form']['status'] == 'Enabled'): ?>
<?php elseif ($this->_tpl_vars['form']['status'] == 'Disabled'): ?>
$('<?php echo $this->_tpl_vars['form']['name']; ?>
_data_table').fade(<?php echo '{ duration: 0.5, from: 1, to: 0.35 }'; ?>
);
<?php endif; ?>
</script>
	<div class="form_footer_panel">
		<div class="ajax_indicator">
			<div id='<?php echo $this->_tpl_vars['form']['name']; ?>
.load_disp' style="display:none" >
				<img src="<?php echo $this->_tpl_vars['image_url']; ?>
/form_ajax_loader.gif"/>
			</div>
		</div>
		<div class="navi_panel">

<?php if ($this->_tpl_vars['navPanel']): ?>
   <?php $_from = $this->_tpl_vars['navPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
   		<?php if ($this->_tpl_vars['elem']['label']): ?> <label style="width:68px;"><?php echo $this->_tpl_vars['elem']['label']; ?>
</label><?php endif; ?>
    	<?php echo $this->_tpl_vars['elem']['element']; ?>

   <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>			
		
		</div>		
	</div>
	<div class="v_spacer"></div>
</div>
</form>