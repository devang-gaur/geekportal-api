<?php

require_once('../config.php');
require_once('../connect.php');

/**
*
*/
class Topic extends Model
{

    private $config 

    function __construct( $config )
    {
        parent::__construct( $config, 'topics' );
        $this->config = $config;
    }


    function delete_topic( $params = array() , $param_op = 'AND' ) {

        $topics = $this->select_record($params, array( 'id' ), $param_op );

        $post = new Post( $this->config );

        foreach ($topics as $topic) {
            $post->delete_record( array( 'topic' => $topic['id'] ));
        }

        $this->delete_record($params);

    }



}

/*
var_dump($config);
$user = new Topic( $config );
echo "yay";
*/
?>