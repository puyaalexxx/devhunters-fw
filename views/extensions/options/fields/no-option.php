<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

?>

<?php do_action( 'dht_options_view_fields_nooption_before_area' ); ?>

    <div class="dht-field-wrapper">

        <div class="dht-title">
			<?php echo apply_filters( 'dht_options_no_such_field_type', _x( 'No such field type', 'options', DHT_PREFIX ) ); ?>
        </div>

    </div>

<?php do_action( 'dht_options_view_fields_nooption_after_area' ); ?>