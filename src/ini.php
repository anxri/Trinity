<?php

const INI_PATH = 'trinity.ini';

/**
 * - check ini file is present
 *
 * @return bool
 */
function ini_present(): bool
{
    if ( is_file( INI_PATH ) )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

/**
 * - set default values when they are not correctl configured
 *
 * @return void
 * @throws Exception
 */
function check_mandartory_settings( $config )
{
    //
    // DB_ENABLED
    //
    if (
        !in_array( 'mariadb', $config['DB_ENABLED'] ) &&
        !in_array( 'mssql', $config['DB_ENABLED'] ) &&
        !in_array( 'mongodb', $config['DB_ENABLED'] )
    )
    {
        throw new Exception( 'provide a valid database in trinity.ini' );
    }

    //
    // DEFAULT_CONTENT_TYPE
    //
    if (
        $config['DEFAULT_CONTENT_TYPE'] !== 'json' &&
        $config['DEFAULT_CONTENT_TYPE'] !== 'html' &&
        $config['DEFAULT_CONTENT_TYPE'] !== 'plain' &&
        $config['DEFAULT_CONTENT_TYPE'] !== 'file'
    )
    {
        throw new Exception( 'provide a valid default content type in trinity.ini' );
    }
}

/**
 * - load ini file if present
 *
 * @return void
 * @throws Exception
 */
function ini_load(): array
{
    if ( ini_present() )
    {
        $config = parse_ini_file( INI_PATH );
    }
    else
    {
        throw new Exception( 'ini file not found at ' . INI_PATH );
    }

    check_mandartory_settings( $config );

    return $config;
}