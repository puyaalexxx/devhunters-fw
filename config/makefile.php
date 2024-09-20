<?php
declare( strict_types = 1 );

/*
 * Code used for the make file to check for the DHT_IS_DEV_ENVIRONMENT
 * to compile the ts and pcss files via Vite also
 */
$filename = "constants.php"; // Adjust the path
if ( $handle = fopen( $filename, "r" ) ) {
	while( ( $line = fgets( $handle ) ) !== false ) {
		if ( str_contains( $line, "DHT_IS_DEV_ENVIRONMENT" ) ) {
			preg_match( "/define\(\s*'DHT_IS_DEV_ENVIRONMENT'\s*,\s*(.+?)\s*\);/", $line, $matches );
			echo isset( $matches[ 1 ] ) ? trim( $matches[ 1 ] ) : "true";
			break;
		}
	}
	fclose( $handle );
} else {
	echo( "Could not open the file." );
}