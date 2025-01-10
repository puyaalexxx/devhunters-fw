<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

?>

<?php do_action( 'dht:options:view:fields:nooption_before_area' ); ?>

    <div class="dht-field-wrapper">

        <div class="dht-title">
			<?php echo apply_filters( 'dht:options:fields:no_such_field_type', _x( 'No such field type', 'options', 'dht' ) ); ?>
        </div>

    </div>

<?php do_action( 'dht:options:view:fields:nooption_after_area' ); ?>