<?php 
/*
require_once("..\utility.php");
*/
class Model{

    protected $table;

    protected $conn;

    function __construct( $config, $table )
    {
        try{
            $this->conn = new PDO("mysql:host=".$config['server'].";dbname=".$config['db']."", $config['user'], $config['pass']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->table = $table;

        } catch ( PDOException $e ) {
            log_that("Failed to connect to the specified DB: $e->getMessage()");
        }

    }

    function __destruct(){
        $conn = null ;
    }


    function insert_record ( $params = array(), $defaults = array() ) {

        $sql = "INSERT INTO $this->table ( ";

        foreach ($params as $key => $value) {
            $sql .= "$key, ";
        }

        $sql = chop( $sql, ", ");

        $sql .= " ) VALUES ( ";

        foreach ($params as $key => $value) {
            $sql .= "'$value', ";
        }

        $sql = chop( $sql, ", ");

        $sql .= " )"; 

        try {
            print_r($sql);
            $this->conn->beginTransaction();
            $this->conn->quote( $sql );
            $this->conn->exec( $sql );
            $this->conn->commit();
            return true;
        } catch ( PDOException $e ) {
            log_that("failed to insert your record: $e->getMessage()");
            $this->conn->rollBack();
            return false;
        }

    }




    /*
    * Returns an associative array
    */
    function select_record ( $params = array(), $fields= array(), $param_op = 'AND' ) {
        $sql = "SELECT ";

        if( count($fields) == 0 ){
            $sql .= "*";
        }

        foreach ($fields as $field) {
            $sql .=" $field, ";
        }
        $sql = chop( $sql, ", ");

        $sql .= " FROM ".$this->table." WHERE ";

        foreach ($params as $key => $value) {
            $sql .= "$key = '$value' $param_op ";
        }

        $sql = chop( $sql, "$param_op ");

        try{
            $this->conn->quote( $sql );
            $statement = $this->conn->query( $sql );
            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            return $result;

        } catch ( PDOException $e ){
            log_that("Couldn't fetch the records: $e->getMessage()");
            return false;
        }
    }



    /*
    * Updates a category an associative array
    */

    function update_record ( $params = array(), $fields = array(), $param_op = 'AND' ) {

        $sql = "UPDATE ".$this->table." SET ";

        foreach ($fields as $key => $value) {
            $sql .= "$key = '$value', ";
        }

        $sql = chop( $sql, ", ");

        $sql .= " WHERE ";

        foreach ($params as $key => $value) {
            $sql .= "$key = '$value' $param_op ";
        }
        $sql = chop( $sql, "$param_op ");
        try {
            $this->conn->beginTransaction();
            $this->conn->quote( $sql );
            $this->conn->exec( $sql );
            $this->conn->commit();
            return true;
        } catch ( PDOException $e ) {
            echo $e->getMessage();
            $this->conn->rollBack();
            return false;
        }

    }




    /*
    * Deletes a category
    *   array() params : parameters to delete the category
    */
    function delete_record ( $params = array() , $param_op = 'AND' ){
        $sql = "DELETE FROM ".$this->table." WHERE ";

        foreach ($params as $key => $value) {
            $sql .= "$key = '$value' $param_op ";
        }

        $sql = chop( $sql , "$param_op " );

        try{
            $this->conn->beginTransaction();
            $this->conn->quote( $sql );
            $this->conn->exec( $sql );
            $this->conn->commit();
            return true;
        } catch ( PDOException $e ) {
            log_that("failed to delete record: $e->getMessage()");
            $this->conn->rollBack();
            return false;
        }
    }


}

 ?>