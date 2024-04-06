<?php
declare(strict_types=1);

namespace DHT\Helpers;

use DHT\Core\Helpers\Classes\Dumper;

/**
 *
 * print_r alternative with styling
 *
 * @param mixed $value the value to be printed
 * @return void
 */
function dht_print_r(mixed $value) : void{
    static $first_time = true;
    
    if ( $first_time ) {
        ob_start();
        echo '<style type="text/css">
		div.dht_print_r {
			max-height: 500px;
			overflow-y: scroll;
			background: #23282d;
			margin: 10px 30px;
			padding: 0;
			border: 1px solid #F5F5F5;
			border-radius: 3px;
			position: relative;
			z-index: 11111;
		}

		div.dht_print_r pre {
			color: #78FF5B;
			background: #23282d;
			text-shadow: 1px 1px 0 #000;
			font-family: Consolas, monospace;
			font-size: 12px;
			margin: 0;
			padding: 5px;
			display: block;
			line-height: 16px;
			text-align: left;
		}

		div.dht_print_r_group {
			background: #f1f1f1;
			margin: 10px 30px;
			padding: 1px;
			border-radius: 5px;
			position: relative;
			z-index: 11110;
		}
		div.dht_print_r_group div.dht_print_r {
			margin: 9px;
			border-width: 0;
		}
		</style>';
        echo str_replace( array( '  ', "\n" ), '', ob_get_clean() );
        
        $first_time = false;
    }
    
    if ( func_num_args() == 1 ) {
        echo '<div class="dht_print_r"><pre>';
        echo htmlspecialchars( Dumper::dump( $value ), ENT_QUOTES, 'UTF-8' );
        echo '</pre></div>';
    } else {
        echo '<div class="dht_print_r_group">';
        foreach ( func_get_args() as $param ) {
            fw_print( $param );
        }
        echo '</div>';
    }
}

/**
 *
 * check if array key exist and if it is empty
 *
 * @param array $array - array to be checked
 * @param string $array_key - array key
 * @return void
 */
function dht_is_array_empty(array $array, string $array_key) : bool{
    if(array_key_exists($array_key, $array) && !empty($array[$array_key]))
    {
        return false;
    }
    
    return true;
}

/**
 *
 * Convert to Unix style directory separators
 *
 * @param string $path - dir path
 * @return string
 */
function dht_fix_path( string $path ) : string {
    $windows_network_path = isset( $_SERVER['windir'] ) && in_array( substr( $path, 0, 2 ),
            array( '//', '\\\\' ),
            true );
    $fixed_path           = untrailingslashit( str_replace( array( '//', '\\' ), array( '/', '/' ), $path ) );
    
    if ( empty( $fixed_path ) && ! empty( $path ) ) {
        $fixed_path = '/';
    }
    
    if ( $windows_network_path ) {
        $fixed_path = '//' . ltrim( $fixed_path, '/' );
    }
    
    return $fixed_path;
}


/**
 *
 * load file with arguments and display it or return its content
 *
 * @param string $path - dir path]
 * @param string $file - file name
 * @param array $args - arguments to be passed into the view
 * @param bool $return - return the file content or display it
 * @return string
 */
function dht_load_view(string $path, string $file, array $args = [], bool $return = true) : string {
    
    if ( ! is_file( $path . $file) ) {
        return '';
    }
    
    extract( $args, EXTR_REFS );
    unset( $args );
    
    if ( $return ) {
        ob_start();
        require $file_path;
        
        return ob_get_clean();
    } else {
        require $file_path;
    }
    
    return '';
}

/**
 * Safe load variables from a file
 * Use this function to not include files directly and to not give access to current context variables (like $this)
 *
 * @param string $file_path
 * @param array $_extract_variables Extract these from file array('variable_name' => 'default_value')
 * @param array $_set_variables Set these to be available in file (like variables in view)
 *
 * @return array
 */
function dht_get_variables_from_file( string $file_path, string $extract_variable, array $set_variables = [] ) : array {
    extract( $set_variables, EXTR_REFS );
    unset( $set_variables );
    
    require $file_path;
    
    foreach ( $$extract_variable as $variable_name => $default_value ) {
        if ( isset( $$variable_name ) ) {
            $$extract_variable[ $variable_name ] = $$variable_name;
        }
    }
    
    return (array)$$extract_variable;
}