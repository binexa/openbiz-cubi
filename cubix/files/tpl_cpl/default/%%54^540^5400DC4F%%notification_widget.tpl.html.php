<?php /* Smarty version 2.6.10, created on 2014-11-19 10:03:52
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/notification/template/notification_widget.tpl.html */ ?>
<form id="<?php echo $this->_tpl_vars['form']['name']; ?>
" name="<?php echo $this->_tpl_vars['form']['name']; ?>
">
<style>
<?php echo '
.notification_block
{
width:750px;
height:50px;
background-color:#e7f7ff;
border:1px solid #00AAFF;
border-radius:10px;
}
.notification_block_hover
{
width:750px;
height:50px;
background-color:#edf8fe;
border:1px solid #018fd6;
border-radius:10px;
}
'; ?>

</style>

	<div class="notification_block" 
		onmouseover="this.className='notification_block_hover'"
		onmouseout="this.className='notification_block'"
	>
		<table style="padding:2px;padding-left:10px; padding-right:5px;">
			<tr>
				<td style="padding-top:0px;padding-right:5px;">
					<img style="border:none" width="40" border="0" src="<?php echo $this->_tpl_vars['resource_url']; ?>
/notification/images/<?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_type']; ?>
.png" />
				</td>
				<td style="padding-left:5px;padding-right:10px;width:580px;">
					<span style="color: #149BC8; font-size:14px; font-weight:normal;" >
					<?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_subject']; ?>

					</span>
					<p style="height:18px; overflow:hidden;">
					<?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_message']; ?>

					</p>
				</td>
				<td style="padding-top:2px;">					
					<div style="height:22px;">
						<?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_goto_url']; ?>

						<?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_dismiss']; ?>

					</div>
					<span style="display:block;color:#999999;padding-left:5px;"><?php echo $this->_tpl_vars['dataPanel']['data']['0']['fld_create_time']; ?>
</span>
				</td>
			</tr>
		</table>		
	</div>
	<div style="height:10px;"></div>
</form>