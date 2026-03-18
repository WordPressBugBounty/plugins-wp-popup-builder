<?php
if (!defined('ABSPATH')) exit;

$custom_popup_all = wppb_db::getCustomPopup();

?>
<div class="resetConfirmPopup">
	<div class="reserConfirm_inner">
		<div class="resetWrapper">
			<div class="resetHeader">
				<span><?php esc_html_e('Popup Will Delete Permanentally.', 'wppb'); ?></span>
			</div>
			<div class="resetFooter">
				<a class="wppbPopup popup deny" href="#"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e('No', 'wppb') ?></a>
				<a class="wppbPopup popup confirm" href="#"><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e('Yes', 'wppb') ?></a>
			</div>
		</div>
	</div>
</div>

<div id="wppb-popup-demos-container">

	<section id="wppb-custom-popup-section" class="wppb-custom-popup-section">

		<div class="wppb-popup-cmn-nav" id="wppb-custom-popup-nav">

			<div class="wppb-popup-cmn-nav-item">

				<a class="active" data-tab='view-list' data-tab-group='pro-to-free' href="#"> <?php esc_html_e('View Popup List', 'wppb'); ?></a>

				<a data-tab='view-free-to-pro' data-tab-group='pro-to-free' href="#"> <?php esc_html_e('Free To Pro', 'wppb'); ?></a>

				<a data-tab='help' data-tab-group='pro-to-free' href="#"><?php esc_html_e('Help', 'wppb'); ?></a>

			</div>
			
		</div>

		<section class="wppb-front-view-list active" data-tab-active='view-list' data-tab-group="pro-to-free">

			<div class="wppb-custom-popup-heading">

				<h1><?php esc_html_e('WP Builder Popup', 'wppb'); ?></h1>

				<a href="<?php echo esc_url(WPPB_PAGE_URL . '&custom-popup&_pnonce='.esc_attr(wp_create_nonce( 'nonce_pop' )), 'wppb'); ?>"> <span class="dashicons dashicons-edit"></span> <?php esc_html_e('Add New Popup', 'wppb'); ?></a>

			</div>

			<?php if ($custom_popup_all != '') { ?>

				<div class="wppb-custom-popup-head rl-clear">

					<div class="wppb-popup-list-title"><span><?php esc_html_e('Title','wppb');?></span></div>

					<div class="wppb-popup-list-enable"><span><?php esc_html_e('Status','wppb');?></span></div>

					<div class="wppb-popup-list-mobile"><span><?php esc_html_e('Device','wppb');?></span></div>

					<div class="wppb-popup-list-view"><span>
					<?php esc_html_e('View','wppb');?></span></div>

					<div class="wppb-popup-list-action"><span><?php esc_html_e('Action','wppb');?></span></div>

					<div class="wppb-popup-list-setting"><span><?php esc_html_e('Setting','wppb');?></span></div>

				</div>

				<div class="wppb-custom-popup-list">

				<?php if (!empty($custom_popup_all)) {

				foreach ($custom_popup_all as $popupValue) {

					$allSetting = unserialize($popupValue->setting, ['allowed_classes' => false]);

					$business_id 	   		= isset($popupValue->BID) ? $popupValue->BID : "";

					if ($popupValue->boption != '') {

						$bOption = unserialize($popupValue->boption, ['allowed_classes' => false]);
					}
					
					$device = isset($bOption['device']) ? $bOption['device'] : false;

					$wp_builder_obj->wppbPopupList($allSetting, $business_id, $device, $popupValue->is_active);
				     }

                  } ?>

			</div>

			<?php } else { ?>

				<p class="no-popup-found">

					<?php esc_html_e('No Popup Found. Click Add New Popup To Create Popup.','wppb');?> 

				</p>;

			<?php } ?>

		</section>

		<?php

		include_once 'wppb-pro-popup.php';

		include_once 'wppb-help.php';

		?>

	</section>

</div>