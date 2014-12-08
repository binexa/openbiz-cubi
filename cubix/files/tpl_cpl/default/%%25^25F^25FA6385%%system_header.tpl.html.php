<?php /* Smarty version 2.6.10, created on 2014-12-08 06:42:34
         compiled from system_header.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 't', 'system_header.tpl.html', 47, false),)), $this); ?>
<?php 

/*
$widget = Openbiz\Openbiz::getObject('menu.widget.MainTabMenu');
if($widget->globalSearchRule && $widget->searchRule){
	$searchRule = $widget->globalSearchRule ." and ". $widget->searchRule;
}else{
	$searchRule = $widget->searchRule;
}
$menu_count = $widget->getDataObj()->recordCount($searchRule);
*/

$menu_count = 5;
$menu_item_width = 115;
$menu_width = ($menu_count * $menu_item_width)."px";
$this->assign('menu_count', $menu_count);

$header_background_image = $this->_tpl_vars['header_background_image'];
$custom_header_background_image = OPENBIZ_APP_PATH.'/images/cubi_top_header.png';
if(file_exists($custom_header_background_image))
{
    $header_background_image_url = OPENBIZ_APP_URL.'/images/cubi_top_header.png';
    $this->assign('header_background_image_url', $header_background_image_url);
} elseif ($header_background_image) {
    $header_background_image_url = OPENBIZ_RESOURCE_URL.$header_background_image;
    $this->assign('header_background_image_url', $header_background_image_url);
}
 ?>
<script>
var top_menu_item_width='<?php echo $menu_item_width; ?>';
var top_menu_width='<?php ($menu_count * $menu_item_width); ?>';
var top_menu_count='<?php echo $menu_count; ?>';
var top_menu_first=0;
var top_menu_play=false;
var top_menu_move_direction='';
var top_menu_play_speed=1000;
</script>
<div id="header_bg">
	<div id="header" <?php if ($this->_tpl_vars['header_background_image_url'] != ''): ?> style="background-image:url(<?php echo $this->_tpl_vars['header_background_image_url']; ?>
);" <?php endif; ?>>
		<div id="header_left"></div>
		<div id="header_right">
			<div id="user_actions">
				<div style="height:10px;"></div>
				<!-- user actions start -->
				<ul>
					<?php if ($this->_tpl_vars['view']['module'] == 'mystore' || $this->_tpl_vars['view']['module'] == 'cart' || $this->_tpl_vars['view']['module'] == 'common'): ?>
					<li><a class="icon_myaccount" href="<?php echo $this->_tpl_vars['app_index']; ?>
/mystore/profile" ><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>My Account<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></li>
					<?php else: ?>
					<li><a class="icon_myaccount" href="<?php echo $this->_tpl_vars['app_index']; ?>
/myaccount/dashboard" ><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>My Account<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></li>
					<?php endif; ?>										
					<li><a class="icon_help" href="http://www.openbiz.me/web/product_cubi" target="_blank" ><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Help<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></li>
					<li><a class="icon_logout" href="<?php echo $this->_tpl_vars['app_index']; ?>
/user/logout" ><?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Logout<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a></li>												
				</ul>
				<!-- user actions end -->					
			</div>
			<div class="arrow_left">
				<?php if ($this->_tpl_vars['menu_count'] > 5): ?>
				<a  onmouseover="top_menu_move_direction='left';top_menu_move();top_menu_play=true;" 
					onmouseout="top_menu_play=false;"
					href="javascript:;"><img height="29" width="10" src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" ></a>
				<?php endif; ?>
			</div>
			<div id="menu">	
				<div id="top_menu_list" style="width:<?php echo $menu_width; ?>;">
				<!-- top menu start -->
				<?php 
				//$temp = Openbiz\Openbiz::getObject('menu.widget.MainTabMenu')->render();
				//unset($temp);
				//echo Openbiz\Openbiz::getObject('menu.widget.MainTabMenu')->render();
				 ?>
				<!-- top menu end -->	
				</div>
			</div>
			<div  class="arrow_right">
				<?php if ($this->_tpl_vars['menu_count'] > 5): ?>
				<a onmouseover="top_menu_move_direction='right';top_menu_move();top_menu_play=true;" 
					onmouseout="top_menu_play=false;"				
				 href="javascript:;"><img height="29" width="10" src="<?php echo $this->_tpl_vars['image_url']; ?>
/spacer.gif" ></a>
				<?php endif; ?>
			</div>
			
		</div>
	</div>	
</div>	
	<div id="header_navi">
		<div id="navi">
		<?php  // echo Openbiz\Openbiz::getObject('menu.widget.BreadcrumbMenu')->render(); ?>
		</div>
		<div id="current_user_info">
		<a class="screen_switch_max_btn" title="<?php $this->_tag_stack[] = array('t', array()); smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Switch Theme<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"  href="javascript:;" onclick="Openbiz.switchTheme('fullwidth')" style="float:right;margin-left:5px; margin-top:4px;  " ></a>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "system_appbuilder_btn.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
			<div>
			<?php   //echo Openbiz\Openbiz::getObject('system.widget.SwitchUserWidget')->render(); ?>
			</div>
		</div>			
	</div>
<?php if ($this->_tpl_vars['menu_count'] > 5): ?>
<script>init_top_menu_pos();</script>
<?php endif; ?>	