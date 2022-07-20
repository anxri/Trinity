<?php

namespace Trinity\util;

class Autoloader
{
    private array $files_to_include;

    /**
     *
     */
    public function __construct()
    {
        $this->files_to_include = [];
    }

    /**
     * @param string $path
     *
     * @return void
     */
    public function add_directory( string $path )
    {
        if ( is_dir( $path ) )
        {
            $this->get_files_in_dir( $path );
        }
    }

    /**
     *
     */
    public function autoload()
    {
        foreach( $this->files_to_include as $file_to_include )
            require_once $file_to_include;
    }

    /**
     * @param $path
     *
     * @return void
     */
    public function get_files_in_dir( $path )
    {
        $current_dir = scandir( $path );

        unset( $current_dir[0] );
        unset( $current_dir[1] );

        foreach( $current_dir as $file )
        {
            $real_path = realpath( $path . "/" . $file );
            $file_info = explode( '.', $file );

            if ( $file_info[sizeof( $file_info ) - 1] === "php" )
            {
                $this->files_to_include[] = $real_path;
            }

            if ( is_dir( $real_path ) )
            {
                $this->get_files_in_dir( $real_path );
            }
        }
    }
}