<?php

namespace Trinity\util\functions;

/**
 * @param $var
 */
function dump( $var ): void
{
    echo "<pre>";
    var_dump( $var );
    echo "</pre>";
}

/**
 * @param int $num_ch
 * @param string $charset
 *
 * @return string
 */
function rand_str( int $num_ch, string $charset = "abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ1234567890" ): string
{
    $char_arr = str_split( $charset, 1 );
    $rand_str = "";
    for( $i = 0; $i < $num_ch; $i++ )
    {
        $rand_str .= $char_arr[rand( 0, $num_ch - 1 )];
    }
    return $rand_str;
}

/**
 * @return string
 */
function uuid3($name_space, $string)
{
    $n_hex = str_replace(array('-','{','}'), '', $name_space);
    $binary_str = '';

    for($i = 0; $i < strlen($n_hex); $i+=2)
    {
        $binary_str .= chr(hexdec($n_hex[$i].$n_hex[$i+1]));
    }

    $hashing = md5($binary_str . $string);

    return sprintf('%08s-%04s-%04x-%04x-%12s',
        substr($hashing, 0, 8),
        substr($hashing, 8, 4),
        (hexdec(substr($hashing, 12, 4)) & 0x0fff) | 0x3000,
        (hexdec(substr($hashing, 16, 4)) & 0x3fff) | 0x8000,
        substr($hashing, 20, 12)
    );
}

/**
 * @return string
 */
function uuid4()
{
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,

        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

/**
 * isset && !empty
 *
 * @param $var
 *
 * @return bool
 */
function isset_not_empty( $var ): bool
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
function get_files_in_dir( $path ): array
{
    $files[$path] = scandir( $path );

    array_shift( $files[$path] );
    array_shift( $files[$path] );

    foreach( $files as $path => &$arr )
    {
        foreach( $files[$path] as $key => $file )
        {
            if ( is_dir( "$path/$file" ) )
            {
                $files["$path/$file"] = scandir( "$path/$file" );
                array_shift( $files["$path/$file"] );
                array_shift( $files["$path/$file"] );
            }
        }
    }
    return $files;
}
