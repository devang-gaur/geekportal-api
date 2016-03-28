<?php
/*
require_once('../config.php');
require_once('../utility.php');
*/

class Post extends Model
{
    private $config 

    function __construct( $config ) {
        parent::__construct($config, 'posts');
        $this->config = $config;
    }

    function delete_post( $params = array() , $param_op = 'AND' ) {

        $posts = $this->select_record($params, array( 'id' ), $param_op );

        $reply = new Reply($this->config);

        foreach ($posts as $post) {
            $reply->delete_record( array( 'post' => $post['id'] ));
        }

        $this->delete_record($params);

    }

}

?>