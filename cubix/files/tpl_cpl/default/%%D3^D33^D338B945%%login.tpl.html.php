<?php /* Smarty version 2.6.10, created on 2014-11-17 10:37:39
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/user/template/login.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/user/template/login.tpl.html', 207, false),)), $this); ?>
<form id="<?php echo $this->_tpl_vars['form']['name']; ?>
" name="<?php echo $this->_tpl_vars['form']['name']; ?>
">
<style>
<?php echo '
.oauth_bar{
float:left;
width:170px;
height:24px;
padding-left:8px;
background-image:url(';  echo $this->_tpl_vars['resource_url'];  echo '/oauth/images/social_provider_spacer.png);
background-repeat:no-repeat;
background-position:0px 3px;
}
.oauth_bar a{
	background-image:url(';  echo $this->_tpl_vars['resource_url'];  echo '/oauth/images/social_provider_icons.png);
	background-repeat:no-repeat;
	margin-right:0px;
	display:block;
	float:left;
}
a#oauth_sina{
	background-position:0px 0px;
	width:24px;
	height:24px;
}
a#oauth_sina:hover{
	background-position:0px -24px;
}
a#oauth_sina:active{
	background-position:0px -48px;
}

a#oauth_qq{
	background-position:-24px 0px;
	width:24px;
	height:24px;
}
a#oauth_qq:hover{
	background-position:-24px -24px;
}
a#oauth_qq:active{
	background-position:-24px -48px;
}

a#oauth_facebook{
	background-position:-48px 0px;
	width:24px;
	height:24px;
}
a#oauth_facebook:hover{
	background-position:-48px -24px;
}
a#oauth_facebook:active{
	background-position:-48px -48px;
}

a#oauth_google{
	background-position:-72px 0px;
	width:24px;
	height:24px;
}
a#oauth_google:hover{
	background-position:-72px -24px;
}
a#oauth_google:active{
	background-position:-72px -48px;
}

a#oauth_alipay{
	background-position:-96px 0px;
	width:24px;
	height:24px;
}
a#oauth_alipay:hover{
	background-position:-96px -24px;
}
a#oauth_alipay:active{
	background-position:-96px -48px;
}
a#oauth_qzone{
	background-position:-120px 0px;
	width:24px;
	height:24px;
}
a#oauth_qzone:hover{
	background-position:-120px -24px;
}
a#oauth_qzone:active{
	background-position:-120px -48px;
}
a#oauth_twitter{
	background-position:-144px 0px;
	width:24px;
	height:24px;
}
a#oauth_twitter:hover{
	background-position:-144px -24px;
}
a#oauth_twitter:active{
	background-position:-144px -48px;
}
.button_highlight{
margin-top:2px;
}
'; ?>

</style>
<!-- 	
<div class="cubi_logo_large" style="background-image:url(<?php echo $this->_tpl_vars['app_url']; ?>
/images/cubi_logo_large.png?rnd=<?php echo rand(); ?>)"></div>
 -->
 <table>
 	<tr>
 	<td>
 	
		<div class="cubi_logo_large" ></div>	
	</td>
	<td class="v_line">
	<div class="login_form " >
		<table><tr><td class="login-top-padding" valign="top">
		<div class="cubi_login_banner">
		<h1 id="welcome-message">
			<?php echo @OPENBIZ_DEFAULT_SYSTEM_NAME;  echo $this->_tpl_vars['use_login_welcome_message']; ?>

		</h1>
		</div>

		
		<?php if ($this->_tpl_vars['dataPanel']['username']['label']): ?>
		<p class="input_row">
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['username']['label']; ?>
</label>
			<span style="width:200px; display:block;float:left;"><?php echo $this->_tpl_vars['dataPanel']['username']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['username']): ?>
			<!-- <span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['username']; ?>
</span> -->
			<?php endif; ?>			
		</p>
		
		<p class="input_row">
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['password']['label']; ?>
</label>
			<span style="width:200px; display:block;float:left;"><?php echo $this->_tpl_vars['dataPanel']['password']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['password']): ?>
			<!-- <span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['password']; ?>
</span> -->
			<?php endif; ?>		
		</p>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['dataPanel']['antispam']['label']): ?>
		<p class="input_row">
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['antispam']['label']; ?>
</label>
			<span style="width:200px; display:block;float:left;"><?php echo $this->_tpl_vars['dataPanel']['antispam']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['antispam']): ?>
			<span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['antispam']; ?>
</span>
			<?php endif; ?>		
		</p>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['dataPanel']['smartcard']['label']): ?>
		<div class="input_row" style="height:140px;">
			<div style="height:30px;">
			<label style="width:120px;"><?php echo $this->_tpl_vars['dataPanel']['smartcard']['label']; ?>
</label>
			</div>
			<div style="height:120px;">
			<span style="width:400px; display:block;float:left;"><?php echo $this->_tpl_vars['dataPanel']['smartcard']['element']; ?>
</span>
			</div>			
		</div>
		<?php endif; ?>		
		
		<?php if ($this->_tpl_vars['dataPanel']['session_timeout']['label']): ?>
		<div class="input_row"  style="width:400px;display:block;height:35px;overflow:hidden;">
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['session_timeout']['label']; ?>
</label>
			<span style="width:200px; display:block;height:35px;float:left;"><?php echo $this->_tpl_vars['dataPanel']['session_timeout']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['session_timeout']): ?>
			<span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['session_timeout']; ?>
</span>
			<?php endif; ?>		
		</div>	
		<?php endif; ?>	
		<?php if ($this->_tpl_vars['dataPanel']['current_language']['label']): ?>
		<div class="input_row" style="width:400px;display:block;height:35px;overflow:hidden;" >
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['current_language']['label']; ?>
</label>
			<span style="width:200px; display:block;height:35px;float:left;"><?php echo $this->_tpl_vars['dataPanel']['current_language']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['current_language']): ?>
			<span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['current_language']; ?>
</span>
			<?php endif; ?>		
		</div>	
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dataPanel']['current_theme']['label']): ?>
		<div class="input_row" style="width:400px;display:block;height:35px;overflow:hidden;">
			<label style="width:60px;"><?php echo $this->_tpl_vars['dataPanel']['current_theme']['label']; ?>
</label>
			<span style="width:200px; display:block;height:35px;float:left;"><?php echo $this->_tpl_vars['dataPanel']['current_theme']['element']; ?>
</span>
			<?php if ($this->_tpl_vars['errors']['current_theme']): ?>
			<span class="input_error_msg"><?php echo $this->_tpl_vars['errors']['current_theme']; ?>
</span>
			<?php endif; ?>		
		</div>
		<?php endif; ?>
						
		<p class="input_row" style="height:38px;padding-top:5px;padding-left:0px;" >
			<!-- onclick="document.getElementById('login_indicator').className='show'"  -->
			<span style="height:30px;display:block;">
			<?php $_from = $this->_tpl_vars['actionPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
			<?php echo $this->_tpl_vars['elem']['element']; ?>

			<?php endforeach; endif; unset($_from); ?>
			</span>
		</p>
			<!-- 
			<?php if ($this->_tpl_vars['errors']['login_status']): ?>
				<span id="login_indicator" class="show" style="float:none;text-indent:0px;">
				<?php echo $this->_tpl_vars['errors']['login_status']; ?>

				</span>
			<?php else: ?>
				<span id="login_indicator" class="hidden" style="float:none;text-indent:0px;">
				<?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Processing login...<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
				</span>
			<?php endif; ?>
			 -->	
		
	<?php if ($this->_tpl_vars['notices']): ?>
	    <div >
	    <?php $_from = $this->_tpl_vars['notices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['noticeMsg']):
?>
	        <div><?php echo $this->_tpl_vars['noticeMsg']; ?>
</div>
	    <?php endforeach; endif; unset($_from); ?>
	    </div>	   
	<?php endif; ?>		
		<p class="input_row">
	    <span style="margin-right:10px;"> <?php echo $this->_tpl_vars['dataPanel']['register_new']['element']; ?>
  </span> <?php echo $this->_tpl_vars['dataPanel']['forget_pass']['element']; ?>

		</p>

		</td></tr></table>
		</div>
		
	</td></tr></table>


</form>

