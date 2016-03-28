<?php

class User
{

    private $config 

    function __construct( $config ) {
        parent::__construct($config, 'posts');
        $this->config = $config;
    }

        /**
        * Adds a new user record.
        * args : array (
        *   'name' => '' ,
        *   'pass' => '' ,
        *   'email' => '' ,
        *   'dp' => 'res/default_dp.jpg' ,
        *   'level' => 0 ,
        *   'signup' => 0 ,
        *   'clef' => '' 
        * )
        */

    function insert_user ( $user = array() ) {

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

            $statement->bindparam(':level' , $user['level'] );

            $statement->execute();

            $this->conn->commit();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            $this->conn->rollBack();
            redirect("../signup.php?err=1");
        }

    }




        function delete_user ( $params = array() , $param_op = 'AND' ){
            $sql = "DELETE FROM users WHERE ";

            foreach ($params as $key => $value) {
                $sql .= "$key = '$value' $param_op ";
            }

            $sql = chop( $sql , "$param_op " );

            try{
                $this->conn->beginTransaction();
                $this->conn->quote( $sql );
                $this->conn->exec( $sql );
                $this->conn->commit();

            } catch ( PDOException $e ) {
                echo $e->getMessage();
                $this->conn->rollBack();
            }
        }

}
