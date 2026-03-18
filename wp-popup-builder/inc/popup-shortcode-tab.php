<?php 
if ( ! defined( 'ABSPATH' )) exit;
	$OldUser_options = ['all','home_page'];
	$check_option_prev = [];
	foreach ($OldUser_options as $options_value) {
		if ( isset($addon_option[$options_value]) && $addon_option[$options_value] ) {
			$check_option_prev[$options_value] = true;
		}
	}

// =========placement 

$popupPlaceMent = isset($addon_option['placement']) ? $addon_option['placement'] : '';

// =========device 

$device = isset( $addon_option['device'] ) ? $addon_option['device'] : 'all';

// =========page load  

$triggerV = ['class-id'=>'','minute'=>'00','second'=>'3','pageload'=>true]; 

if ( isset( $addon_option['trigger'] ) && is_array( $addon_option['trigger'] ) ) {
	
	foreach ($addon_option['trigger'] as $trigger_key => $trigger_value) {
			
			if ($trigger_key == 'page-load') {
				$triggerV['pageload'] = false;
				if ( $trigger_value == 'true' ) $triggerV['page-load'] = true;
			}else if( $trigger_key == 'time' && !empty($trigger_value) ){
				foreach ($trigger_value as $time_key => $Time_value) {
					if ($Time_value != '') {
						$triggerV[ $time_key ] = $Time_value; 
					}
				}
			}elseif( $trigger_key == 'click' && !empty($trigger_value) ){
				$triggerV['class-id'] = join( ',',$trigger_value );
			}else if( $trigger_key == 'page-scroll' ){
				$triggerV['page-scroll'] = $trigger_value;
			}else if( $trigger_key == 'exit' ){
				$triggerV['exit'] = true;
			}
		}	
}
$frequency = isset($addon_option['frequency']) ? [ $addon_option['frequency']=>true ] : false;
$popup_is_active = isset($popup_is_active) ? $popup_is_active : '';
?>


<section class="setting-submit-wrap wppb-title_">
	<div class="title__">
		<span><?php esc_html_e('Title : ','wppb');?></span>
		<span class="wppb-popup-title-name"><?php esc_html_e('Box Modal Name','wppb');?> </span>
	</div>
	<div class="status__">
		<?php  
		$wp_builder_obj->checkbox("business-idd-",__("Status : ",'wppb'),'class="wppb_popup_setting_active" data-bid="'.esc_attr($wppb_popup_id).'" '.esc_attr($popup_is_active)); 
		?>
	</div>
	<div class="save__">
		<button class="wppb-popup-setting-save business_disabled" data-bid="<?php echo esc_attr($wppb_popup_id); ?>" ><?php esc_html_e('Save','wppb');?></button>
	</div>
</section>
<div class="wppb-popup-editor-divider"></div>

<!-- popup display -->
<section class="wppb-display-popup">
		<span class="popup-display-sub-heading"><?php esc_html_e('Popup Display Option','wppb');?></span>
		<span class="popup-display-sub-heading-2"><?php esc_html_e('Choose option to display popup at Whole Website (Includes all page, post, product etc), At Homepage only or at some selected page and post. You can also use a shortcode to display popup in the area which supports the shortcode.','wppb');?></span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--placement-all' type="radio" name="popup-placement" value="all" <?php if (isset($check_option_prev['all']) || $popupPlaceMent == "all" ) echo esc_attr('checked'); ?> >
					<label for='popup--placement-all'><span class="dashicons dashicons-admin-site-alt3"></span><span><?php esc_html_e('Whole Site','wppb');?></span></label>
				</li>
				<li>
					<input id='popup--placement-home_page' type="radio" name="popup-placement" value="home_page" <?php if (isset($check_option_prev['home_page']) || $popupPlaceMent == "home_page" ) echo esc_attr('checked'); ?> >
					<label for='popup--placement-home_page'><span class="dashicons dashicons-admin-home"></span><span><?php esc_html_e('Home Page','wppb');?></span></label>
				</li>
				<li>
					<input type="radio" name="popup-placement" value="pages" class="lock">
					<label><span class="dashicons dashicons-list-view"></span><span><?php esc_html_e('Selected Pages','wppb');?></span></label>
				</li>
			</ul>
			<div class="wppb-perticular-page">
				<div class="wppb-perticular-page-shortcode">
		          <span class="wppb-popup-title"><?php esc_html_e('Shortcode','wppb') ?></span>
		          <span><?php esc_html_e('[wppb popup="'.esc_attr($wppb_popup_id).'"]','wppb') ?></span>
		      </div>
		    </div>
		</div>
</section>
<div class="wppb-popup-editor-divider"></div>
<!-- popup display device -->
<section class="wppb-display-device">
<span class="popup-display-sub-heading"><?php esc_html_e('Choose Popup Display Device','wppb');?></span>
		<span class="popup-display-sub-heading-2"><?php esc_html_e('Here you can choose the device at which you want to display popup. Choose "All devices" to display popup at PC, Laptop and all small devices. And choose "Desktop" If you don\'t want to display popup at small mobile devices.','wppb');?>
			
		</span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--device-all' type="radio" name="popup-device" value="all" <?php if( $device == "all" ) echo esc_attr("checked"); ?> >
					<label for='popup--device-all'><span class="dashicons dashicons-desktop"></span><span><?php esc_html_e('All Device','wppb');?></span></label>
				</li>
				<li>
					<input id="popup--device-desktop" type="radio" name="popup-device" value="desktop" <?php if( $device == "desktop" )echo esc_attr("checked"); ?>>
					<label for="popup--device-desktop"><span class="dashicons dashicons-desktop"></span><span><?php esc_html_e('Desktop','wppb');?></span></label>
				</li>
				<li>
					<input id="popup--device-mobile" type="radio" name="popup-device" value="mobile" <?php if( $device == "mobile" )echo esc_attr("checked"); ?>>
					<label for="popup--device-mobile"><span class="dashicons dashicons-smartphone"></span><span><?php esc_html_e('Mobile','wppb');?></span></label>
				</li>
			</ul>
		</div>
</section>
<!-- popup trigger -->
<div class="wppb-popup-editor-divider"></div>

<section class="wppb-display-trigger">
		<span class="popup-display-sub-heading"><?php esc_html_e('Popup Trigger','wppb');?></span>
		<span class="popup-display-sub-heading-2"><?php esc_html_e('This option allows you to choose when you want to trigger popup.','wppb');?></span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--trigger-page-load' type="checkbox" name="popup-trigger" value="page-load" <?php if( isset($triggerV['page-load']) || $triggerV['pageload'] ) echo esc_attr('checked'); ?> >
					<label for='popup--trigger-page-load'><span class="dashicons dashicons-update-alt"></span><span><?php esc_html_e('Page Load','wppb');?></span></label>
				</li>
				<li>
					<input class="lock" type="checkbox" name="popup-trigger" value="click">
					<label><span class="dashicons dashicons-external"></span><span><?php esc_html_e('On Click','wppb');?></span></label>
				</li>
				<li>
					<input class="lock" type="checkbox" name="popup-trigger" value="page-scroll">
					<label><span class="dashicons dashicons-arrow-up-alt"></span><span><?php esc_html_e('Page Scroll','wppb');?></span></label>
				</li>
				<li>
					<input class="lock" type="checkbox" name="popup-trigger" value="exit">
					<label><span class="dashicons dashicons-dismiss"></span><span><?php esc_html_e('Exit Window','wppb');?></span></label>
				</li>
			</ul>
		</div>
		<div class="trigger-time <?php if( !(isset($triggerV['page-load']) || $triggerV['pageload']) ) echo esc_attr('rl-display-none'); ?>">
		<div class="wppb-popup-editor-divider"></div>
			<div class="description_">

				<span><?php esc_html_e('Page Load : Set Popup Trigger Time.','wppb');?></span>

				<span><?php esc_html_e('Select "Page Load" to trigger popup at each time page load. You can also set a popup trigger delay.','wppb');?>
				</span>

			</div>

			<div class="field_">

				<span class="popup-display-sub-heading-2"><?php esc_html_e('Time Spent After Appear Popup In Second','wppb');?> </span>

				<input type="number" max="60" name="second" value="<?php echo esc_attr($triggerV['second']); ?>">

			</div>
		</div>

</section>
<div class="wppb-popup-editor-divider"></div>
<section class="wppb-popup-frequency">
		<span class="popup-display-sub-heading"><?php esc_html_e('Frequency','wppb');?></span>
		<div class="wrap-frequency">
			<div>
				<input <?php if(isset($frequency['every-page']) ) esc_attr('checked'); ?> id="checkbox--frequency-every-page" type="radio" name="frequency" value="every-page">
				<label for="checkbox--frequency-every-page">
				<span class="dashicons dashicons-yes-alt"></span><?php esc_html_e('Every Time Site Reload.','wppb');?>
			    </label>
			</div>

			<div>
				<input <?php if(isset($frequency['one-time']) )  esc_attr('checked'); ?> id="checkbox--frequency-show-time" type="radio" name="frequency" value="one-time">
				<label for="checkbox--frequency-show-time">
					<span class="dashicons dashicons-yes-alt"></span><?php esc_html_e('One Time Show On Visit Page.','wppb');?>
				</label>
			</div>
			<div class="frequency-day-hour">
				<input type="radio" name="frequency" value="after-time">
				<label><span class="dashicons dashicons-lock"></span><?php esc_html_e('How Much Time After Show Popup.','wppb');?></label>
			</div>

		</div>
</section>

<div class="wppb-popup-editor-divider"></div>

<section class="setting-submit-wrap">
	<button class="wppb-popup-setting-save business_disabled" data-bid="<?php echo esc_attr($wppb_popup_id); ?>" ><?php esc_html_e('Save','wppb');?>
	</button>
</section>