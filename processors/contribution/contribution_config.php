<?php

$financial_types = civicrm_api3( 'Contribution', 'getoptions', array(
	'sequential' => 1,
	'field' => 'financial_type_id',
));

$contribution_fields_result = civicrm_api3( 'Contribution', 'getfields', array(
  'sequential' => 1,
  'api_action' => 'create',
));

$contribution_fields = array();
foreach ( $contribution_fields_result['values'] as $key => $value ) {
	if (in_array( $value['name'], CiviCRM_Caldera_Forms_Helper::$contribution_fields ) ) {
		$contribution_fields[$value['name']] = $value['title'];
	}
}

?>

<h2><?php _e( 'Contact Link', 'caldera-forms-civicrm' ); ?></h2>
<div id="contact_link" class="caldera-config-group">
	<label><?php _e( 'Link to', 'caldera-forms-civicrm' ); ?></label>
	<div class="caldera-config-field">
		<?php CiviCRM_Caldera_Forms_Helper::contact_link_field(); ?>
		<p><?php _e( 'Select which contact you want to link this processor to.', 'caldera-forms-civicrm' ); ?></p>
	</div>
</div>

<hr style="clear: both;" />

<!-- Contact ID -->
<h2><?php _e( 'Contribution Fields', 'caldera-forms-civicrm' ); ?></h2>

<?php
	foreach ( $contribution_fields as $key => $value ) { ?>
	<div id="<?php echo esc_attr( $key ); ?>" class="caldera-config-group">
		<label><?php echo esc_html( $value ); ?> </label>
		<div class="caldera-config-field">
			<?php
				if($key != 'financial_type_id') {
					echo '{{{_field ';
					if ( $key == 'currency_code' || $key == 'total_amount' || $key == 'financial_type_id') echo 'required="true" ';
					echo 'slug="' . $key . '"}}}';
				} else {
					?>
							<select class="block-input field-config" name="{{_name}}[<?php echo $key ?>]" required>
								<?php foreach ( $financial_types['values'] as $key => $value ) { ?>
									<option value="<?php echo esc_attr( $value['value'] ); ?>" {{#is financial_type value="<?php echo $value['value']; ?>"}}selected="selected"{{/is}}><?php echo esc_html( $value['value'] ); ?></option>
								<?php } ?>
							</select>
					<?php
				}
			?>
		</div>
	</div>
<?php } ?>
