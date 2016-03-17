<?php

require_once('../config.php');

require_once('../utility.php');

/**
*
*/
class User
{
    protected $conn = null ;
    
    function __construct( $config )
    {
        try{

            $this->conn = new PDO("mysql:host=".$config['server'].";dbname=".$config['db']."", $config['user'], $config['pass']);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Success!";
        } catch ( PDOException $e ) {
            echo $e->getMessage();
        }
    }

    function __destruct(){
        $conn = null ;
    }

        /**
        * Adds a new user record.
        * args : array (
        *   'name' => '' ,
        *   'pass' => '' ,
        *   'email' => '' ,
        *   'dp' => 'res/default_dp.jpg' ,
        *   'level' => 0 ,
        *   'clef' => '' ,
        * )
        */

        function insert_user ( $user = array() , $make_admin = NO ){

            $sql = "INSERT INTO users ( name , pass , email , dp , level , signup , clef ) VALUES ( :name , :pass , :email , :dp , :level , CURRENT_TIMESTAMP() , :clef )";

            try {

                $this->conn->beginTransaction();

                $statement = $this->conn->prepare( $sql );

                $statement->bindparam(':name' , $user['name'] );

                $statement->bindparam(':pass' , $user['pass'] );

                $statement->bindparam(':email' , $user['email'] );

                if( !isset( $user['dp'] ) ){
                    $user['dp'] = 'res/default_dp.jpg';
                }

                $statement->bindparam(':dp' , $user['dp'] );

                if( !isset( $user['clef'] ) ){
                    $user['clef'] = '';
                }

                $statement->bindparam(':clef' , $user['clef'] );

                $statement->bindparam(':level' , $make_admin );

                $statement->execute();

                $this->conn->commit();

            } catch ( PDOException $e ) {
                echo $e->getMessage();
                $this->conn->rollBack();
                redirect("../signup.php?err=1");
            }

        }



        function update_user ( $fields = array() , $params = array() ){

            $sql = "UPDATE users SET ";

            foreach ($fields as $key => $value) {
                $sql .= "$key = '$value' ";
            }

            $sql .= "WHERE ";

            foreach ($params as $key => $value) {
                $sql .= "$key = '$value' ";
            }
            echo $sql;
            try {
                $this->conn->beginTransaction();
                $this->conn->exec( $sql );
                $this->conn->commit();

            } catch ( PDOException $e ) {
                echo $e->getMessage();
                $this->conn->rollBack();
//                redirect("../updatedetails.php?err=1");
            }

        }




}

var_dump($config);

$user = new User( $config );

/*
$u = array (
    'name' => 'bulla',
    'email' => 'bulla@gunda.com' ,
    'pass' => 'aajmaineterimautkidatefixkardi' ,
    'date' => time() ,
    'dp' => '' ,
    'level' => 0 ,
    'clef' => ''
    ); 
*/

$user->update_user(
    array( 'name' => 'bullaji' ), 
    array(    'email' => 'bulla@gunda.com' ) 
    );
    
echo "yay";

?>