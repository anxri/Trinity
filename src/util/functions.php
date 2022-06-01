<?php

/**
 * @param $var
 */
function dump( $var ) : void
{
    echo "<pre>";
    var_dump( $var );
    echo "</pre>";
}

/**
 * @param int    $num_ch
 * @param string $charset
 *
 * @return string
 */
function rand_str( int $num_ch, string $charset="abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ1234567890" ) : string
{
	$char_arr = str_split( $charset, 1 );
	$rand_str = "";
	for( $i = 0; $i < $num_ch; $i++ )
	{
		$rand_str .= $char_arr[rand( 0, $num_ch-1 )];
	}
	return $rand_str;
}

/**
 * @return string
 */
function rand_uuid() : string
{

}

/**
 * isset && !empty
 *
 * @param $var
 *
 * @return bool
 */
function isset_not_empty( $var ) : bool
{
	return isset( $var ) && !empty( $var );
}


/**
 * get files in dir
 *
 * @param $path
 *
 * @return mixed
 */
function get_files_in_dir( $path ) : array
{
	$files[$path] = scandir( $path );

	array_shift( $files[$path] );
	array_shift( $files[$path] );

	foreach ( $files as $path => &$arr )
	{
		foreach ( $files[$path] as $key => $file )
		{
			if( is_dir( "$path/$file" ))
			{
				$files["$path/$file"] = scandir( "$path/$file" );
				array_shift( $files["$path/$file"] );
				array_shift( $files["$path/$file"] );
			}
		}
	}
	return $files;
}
