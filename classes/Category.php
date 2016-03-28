<?php

require_once('../config.php');
require_once('../utility.php');

/**
*
*/
class Category
{
    protected $conn = null ;
    
    function __construct( $config )
    {
        try{

            $conn = new PDO("mysql:host=".$config['server'].";dbname=".$config['db']."", $config['user'], $config['pass']);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    *   'description' => '' ,
    *   'last_update' => '' ,
    * )
    */
    function insert_category ( $category = array() ) {

        $sql = "INSERT INTO categories ( name , description , last_update ) VALUES ( :name , :description , CURRENT_TIMESTAMP() )";

        try {

            $this->conn->beginTransaction();

            $statement = $this->conn->prepare( $sql );

            $statement->bindparam(':name' , $user['name'] );

            $statement->bindparam(':description' , $user['description'] );

            $statement->execute();

            $this->conn->commit();

        } catch ( PDOException $e ) {
            echo $e->getMessage();
            $this->conn->rollBack();
            redirect("../signup.php?err=1");
        }

    }

    /*
    * Deletes a category
    *   array() params : parameters to delete the category

    *
    */
    function delete_category( $params = array() , $param_op = 'AND' ) {

        $categories = $this->select_record($params, array( 'id' ), $param_op );

        $topic = new Topic( $this->config );

        foreach ($categories as $category) {
            $topic->delete_record( array( 'category' => $category['id'] ));
        }

        $this->delete_record($params);

    }








}
