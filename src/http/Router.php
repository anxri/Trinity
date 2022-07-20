<?php

namespace Trinity\http;

use Trinity\exception\HttpException;
use function Trinity\util\functions\dump;

class Router
{
    private static bool $silent_shutdown;
    private string|null $middleware_class_name = NULL;
    private string $requested_uri;
    private array $aviable_methods = [ 'GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'CONNECT', 'PATCH' ];
    private array $enabled_methods = [];

    /**
     * @param $enabled_methods
     * @param $middleware_class_name
     */
    public function __construct( $enabled_methods = NULL, $middleware_class_name = NULL )
    {
        self::$silent_shutdown = FALSE;
        // parse requested uri
        $this->requested_uri = parse_url( $_SERVER['REQUEST_URI'] )['path'];

        $this->enabled_methods = $enabled_methods;

        // checks if router get called by middlewares, if so, safe the class name of middlewares
        // at excecution can middlewares be called by its class name
        $key = array_search( 'Trinity\HTTP\Middleware', array_column( debug_backtrace(), 'class' ) );
        if ( debug_backtrace()[$key]['class'] === 'Trinity\HTTP\Middleware' )
        {
            $this->middleware_class_name = $middleware_class_name;
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        if ( !self::$silent_shutdown )
        {
            global $response, $config;
            $response->set_status_code( 404 );

            if ( $config['DEFAULT_CONTENT_TYPE'] === 'json' )
            {
                echo '"Not found"';
            }
            else
            {
                echo 'Not found';
            }
        }
    }

    /**
     * @return void
     */
    public static function silent_shutdown()
    {
        self::$silent_shutdown = TRUE;
    }

    /**
     * @param string $registered_route
     * @param string $requested_route
     * @param array|NULL $vars
     *
     * @return bool
     * @throws HttpException
     */
    private function compare_uri( string $registered_route, string $requested_route, array &$vars = NULL ): bool
    {
        if ( $vars === NULL )
        {
            throw new HttpException( 'Error - Provide Variables in Router::compare_uri().', 500 );
        }
        else
        {
            $vars = [];
        }

        $registered_route_arr = explode( '/', $registered_route );
        $requested_route_arr = explode( '/', $requested_route );

        array_shift( $registered_route_arr );
        array_shift( $requested_route_arr );

        if ( sizeof( $registered_route_arr ) === sizeof( $requested_route_arr ) )
        {
            for( $i = 0; $i < sizeof( $registered_route_arr ); $i++ )
            {
                if (
                    !empty( $registered_route_arr[$i] ) &&
                    $registered_route_arr[$i][0] === '{' &&
                    $registered_route_arr[$i][strlen( $registered_route_arr[$i] ) - 1] === '}'
                )
                {
                    $search = array( '{', '}' );
                    $var_name = str_replace( $search, '', $registered_route_arr[$i] );
                    $vars[$var_name] = $requested_route_arr[$i];
                }
                elseif ( $registered_route_arr[$i] === $requested_route_arr[$i] )
                {
                    continue; // character matches
                }
                else
                {
                    return FALSE; // no matching character
                }
            }
        }
        else
        {
            return FALSE; // no matching path length
        }

        return TRUE; // root path
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return void
     * @throws HttpException
     */
    public function __call( $name, $arguments )
    {
        $this->call_internal( $name, $arguments );
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return void
     * @throws HttpException
     */
    private function call_internal( $name, $arguments )
    {
        $method = strtoupper( $name );

        if ( !in_array( $method, $this->enabled_methods ) )
        {
            return;
        }

        $vars = [];

        if ( $_SERVER["REQUEST_METHOD"] === $method )
        {
            if ( $this->compare_uri( $arguments[0], $this->requested_uri, $vars ) )
            {
                // call middlewares::handle()
                if ( $this->middleware_class_name !== NULL )
                {
                    $this->print_result(
                        call_user_func( array( $this->middleware_class_name, 'handle' ) )
                    );
                }

                // call router provided func
                if ( $arguments[1] instanceof \Closure )
                {
                    $this->print_result(
                        call_user_func_array( $arguments[1], $vars )
                    );
                }
                elseif ( str_contains( $arguments[1], '@' ) !== FALSE )
                {
                    try
                    {
                        $controller_func = explode( '@', $arguments[1] );
                        $controller_name = '\Trinity\\' . $controller_func[0];

                        $this->print_result(
                            call_user_func_array( array( new $controller_name(), $controller_func[1] ), $vars )
                        );
                    }
                    catch ( Throwable $e )
                    {
                        // TODO
                        echo $e->getFile() . ' ';
                        echo $e->getLine() . ' ';
                        echo $e->getMessage() . ' ';
                        echo $e->getCode() . ' ';
                    }
                }
                else
                {
                    $this->print_result(
                        call_user_func_array( $arguments[1], $vars )
                    );
                }
            }
        }

        $this->middleware_class_name = NULL;
    }

    /**
     * prints objects and arrays as json string
     *
     * @param $result
     *
     * @return void
     */
    private function print_result( $result )
    {
        if ( ( gettype( $result ) === 'array' || gettype( $result ) === 'object' ) )
        {
            echo json_encode( $result );
        }
        else
        {
            echo $result;
        }
    }
}
