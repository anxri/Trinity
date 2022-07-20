<?php
/*
 *
 * Logger class that supports custom dates string representation, custom log types and enableable log printing
 *
 *  Looger ( [, string $log_path , string $date_format , string $head_format , string $print ] )
 *
 *      $log_path       default: "./"                               specifies the path to current log file
 *      $date_format    default: "Y-m-d H:i:s (T)"                  specifies the date string format
 *      $head_format    default: "%%date%% - %%type%% - %%msg%%"    specifies how log message will be build
 *      $print          default: false                              specifies if printig is enabled by default
 *
 */

namespace Trinity\util;

class Log
{
    private string $log_path;
    private bool $global_print_mode;
    private string $global_date_format;
    private string $global_log_format;

    private static $needles = [
        "%%date%%",
        "%%type%%",
        "%%msg%%"
    ];

    const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s (T)';
    const DEFAULT_MSG_FORMAT = '%%date%% [%%type%%] - %%msg%%';
    private array $log_types;

    /**
     * @param string|NULL $log_path
     * @param int|null $global_print
     * @param string $date_format
     * @param string $log_format
     *
     * @throws \Exception
     */
    public function __construct(
        string $log_path = '/tmp/trinity_default.log',
        int    $global_print = NULL,
        string $date_format = self::DEFAULT_DATE_FORMAT,
        string $log_format = self::DEFAULT_MSG_FORMAT
    )
    {
        $this->log_path = $log_path;
        $this->global_date_format = $date_format;
        $this->global_print_mode = $global_print;
        $this->log_types = [];

        $this->set_log_format( $log_format );

        if ( !file_exists( $this->log_path ) )
        {
            mkdir( dirname( $this->log_path ), $recursive = TRUE );
        }
    }

    /**
     * @param int $type
     * @param string $msg
     * @param int|NULL $print
     *
     * @return void
     */
    private function log_internal( string $type, string $msg, int $print = NULL )
    {
        $msg = str_replace( "\n", "", $msg );
        $log_msg = $this->construct_msg( $type, $msg );

        if ( $this->global_print_mode )
        {
            if ( $print )
            {
                echo $log_msg . "\n";
            }
        }

        file_put_contents( $this->log_path, $log_msg . "\n", FILE_APPEND );
    }

    /**
     * @param string $log_format
     *
     * @return void
     * @throws \Exception
     */
    private function set_log_format( string $log_format ): void
    {
        // check if all variables set
        foreach( self::$needles as $needle )
        {
            strpos( $log_format, $needle );
        }

        $this->global_log_format = $log_format;
    }

    /**
     * @param string $type
     * @param string $msg
     *
     * @return string
     */
    private function construct_msg( string $type, string $msg ): string
    {
        $log = str_replace( self::$needles[0], $this->get_date_str(), $this->global_log_format );      // date
        $log = str_replace( self::$needles[1], $type, $log );                                           // type
        return str_replace( self::$needles[2], $msg, $log );                                            // msg
    }

    /**
     * @return string
     */
    private function get_date_str(): string
    {
        if ( $this->global_date_format == NULL )
        {
            return date();
        }
        else
        {
            return date( $this->global_date_format );
        }
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function fatal( string $msg, int $print = 1 )
    {
        $this->log_internal( 'FATAL', $msg, $print );
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function error( string $msg, int $print = 1 )
    {
        $this->log_internal( 'ERROR', $msg, $print );
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function warn( string $msg, int $print = 1 )
    {
        $this->log_internal( 'WARN', $msg, $print );
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function info( string $msg, int $print = 1 )
    {
        $this->log_internal( 'INFO', $msg, $print );
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function debug( string $msg, int $print = 1 )
    {
        $this->log_internal( 'DEBUG', $msg, $print );
    }

    /**
     * @param string $msg
     * @param int $print
     *
     * @return void
     */
    public function trace( string $msg, int $print = 1 )
    {
        $this->log_internal( 'TRACE', $msg, $print );
    }
}
