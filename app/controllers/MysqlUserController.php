<?php

namespace Trinity;

use Trinity\http\Controller;
use Noxx\Trinity\database\Pdo;
use function Trinity\util\functions\uuid4;
use function Trinity\util\functions\dump;

use PDO as PDO_Class;



class MysqlUserController extends Controller
{
    use Pdo;

    /**
     *
     */
    public function __construct()
    {
        $this->init_pdo();

        $create_table_stmt = "CREATE TABLE IF NOT EXISTS USER (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        $this->pdo->exec( $create_table_stmt );
    }

    /**
     * @param string|NULL $email
     *
     * @return string
     */
    public function get( string $email = NULL ): string
    {
        if ( $email !== NULL )
        {
            $stmt = $this->pdo->query( "SELECT * FROM USER WHERE email='$email'" );
        }
        else
        {
            $stmt = $this->pdo->query( "SELECT * FROM USER" );
        }

        return json_encode( $stmt->fetchAll( PDO_Class::FETCH_CLASS ), JSON_PRETTY_PRINT );
    }

    /**
     * @param $data
     *
     * @return void
     */
    public function post()
    {

        global $request;
        $data = json_decode( $request->get_body(), TRUE );
        $data['user_id'] = uuid4();

        $stmt = $this->pdo->prepare( "INSERT INTO USER (user_id, username, email, password) VALUES (:user_id, :username, :email, :password )" );
        return $stmt->execute( $data );

    }

    /**
     * @param $data
     *
     * @return void
     */
    public function put( $user_id )

    {
        global $request;
        $data = json_decode( $request->get_body() );
        $data['user_id'] = $user_id;

        $stmt = $this->pdo->prepare( "UPDATE USER SET name=?, email=?, password=? WHERE user_id=?" );
        return $stmt->execute( $data );
    }

    /**
     * @param $user_id
     *
     * @return void
     */
    public function delete( $user_id )
    {
        $stmt = $this->pdo->prepare( "DELETE FROM users WHERE user_id=?" );
        return $stmt->execute( $user_id );
    }
}