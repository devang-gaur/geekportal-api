<?php
/*
require_once('../config.php');
require_once('../connect.php');
*/
require_once('Model.php');
/**
*
*/
class Reply extends Model
{

    function __construct( $config ) {
        parent::__construct($config, 'replys');
    }

}

?>