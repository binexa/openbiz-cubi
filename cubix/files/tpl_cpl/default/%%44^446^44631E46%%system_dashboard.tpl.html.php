<?php /* Smarty version 2.6.10, created on 2014-11-17 11:38:01
         compiled from C:%5Cxampp%5Chtdocs%5Copenbizx-cubix%5Ccubix%5Cmodules/menu/template/system_dashboard.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'C:\\xampp\\htdocs\\openbizx-cubix\\cubix\\modules/menu/template/system_dashboard.tpl.html', 5, false),)), $this); ?>
<form id="<?php echo $this->_tpl_vars['form']['name']; ?>
" name="<?php echo $this->_tpl_vars['form']['name']; ?>
">
<div style="padding-left:25px; padding-right:20px;" class="dashboard_panel">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "system_appbuilder_btn.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="dashboard_bg_light_header">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>User & Group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('User.Administer_Users')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/user_list" class="icon_user">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>User<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Role.Administer_Roles')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/role_list" class="icon_role">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Role<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
				
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Group.Administer_Groups')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/group_list" class="icon_group">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
				
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Group.Administer_Groups')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/group_data_sharing" class="icon_datasharing" >
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Sharing<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
		</div>
	</div>
	<div class="dashboard_bg_dark">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Application<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Market.Manage')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/market/applications" class="icon_appstore">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Market<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
				
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Module.Administer_Modules')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/module_list" class="icon_module">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Module<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>	
						
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Menu.Administer_Menu')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/menu/menu_list" class="icon_menu_list">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Menu list<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Menu.Administer_Menu')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/menu/menu_tree" class="icon_menu_tree" >
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Menu tree<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Module.Administer_Modules')){  ?>							
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/module_change_log" class="icon_changelog" >
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>ChangeLog<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
		</div>
	</div>
	<div class="dashboard_bg_light">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Email<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('EmailQueue.Administer_Email_Queue')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/email/email_queue_list" class="icon_mail_queue">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Queue<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('EmailLog.Administer_Email_Log')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/email/email_log_list" class="icon_mail_sentlog">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Sent Log<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('EmailSetting.Administer_Email_Setting')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/email/email_setting_list" class="icon_mail_account">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Account<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('EmailTemplate.Administer_Email_Template')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/email/email_template_list" class="icon_mail_template" >
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Template<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>			
		</div>
	</div>
	<div class="dashboard_bg_dark">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>System<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">		
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('System.Administer_System')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/user_preference" class="icon_preference">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Preference<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('System.Administer_System')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/database_list" class="icon_database">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Database<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('backup.Access_Backup')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/backup/backup_device_list" class="icon_backup_device">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Devices<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('backup.Access_Backup')){  ?>	
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/backup/backup_list" class="icon_backup">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Backup<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Market.Manage')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/market/app_updates" class="icon_update">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Update<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('websvc.websvc.Access')){  ?>		
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/websvc/websvc_list" class="icon_webservice">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>WebService<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
		</div>
	</div>
	<div class="dashboard_bg_light">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Advanced Feature<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">		
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('cache.Administer_Cache')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/cache/manage" class="icon_cache">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Cache<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('cronjob.Administer_Cron')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/cronjob/cronjob_list" class="icon_cronjob">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Cronjob<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Security.Administer_Security')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/security/security_rule" class="icon_security">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Security<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('EventLog.Access_EventLog')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/eventlog/event_log_list" class="icon_eventlog">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Event Log<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('location.setting')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/location/location_setting" class="icon_location">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Location<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Session.Administer_Session')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/system/session_manage" class="icon_session">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Session<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>					
			<?php  }  ?>		
		</div>
	</div>	
	<div class="dashboard_bg_dark">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Misc<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">		
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Help.Administer_Help')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/help/help_category" class="icon_helpcategory">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>HelpCategory<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/help/help_list" class="icon_helptips">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Help Tips<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Theme.Administer_Theme')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/theme/manage_theme" class="icon_theme">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Theme<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('Translation.Administer_Transation')){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/translation/manage_translation" class="icon_translation">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Translation<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>	
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/translation/manage_language" class="icon_language">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Language<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
		</div>
	</div>
	<?php  if(Openbiz\Openbiz::$app->allowUserAccess('oauth.Administer') || Openbiz\Openbiz::$app->allowUserAccess('payment.Manage') || Openbiz\Openbiz::$app->allowUserAccess('sms.Manage')  ){  ?>
	<div class="dashboard_bg_light">
		<div class="title"><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Extension<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></div>
		<div class="icons">		
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('oauth.Administer') ){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/oauth/provider_setting" class="icon_oauth">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>OAuth<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('payment.Manage')  ){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/payment/intergration_setting" class="icon_payment">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif" /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Payment<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
			
			<?php  if(Openbiz\Openbiz::$app->allowUserAccess('sms.Manage') ){  ?>
			<a href="<?php echo $this->_tpl_vars['app_index']; ?>
/sms/intergration_setting" class="icon_sms">
				<img border="0" src="<?php echo $this->_tpl_vars['theme_url']; ?>
/images/spacer.gif"  /><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>SMS<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
			<?php  }  ?>
				
		</div>	
	</div>		
	<?php  }  ?>
</div>
</form>		