<?php

define( 'YES' , 1 );

define( 'NO' , 0 );

define( 'ADMIN_USER' , 1 );

define( 'USER' , 0 );

if( isset($config['root']))
    define( 'ROOT', $config['root'] );

function redirect($url) {
    header('location:'.$url);
    exit();
}


function log_that( $message ) {
    $current_date = date('d/m/Y  h:i:s');
    $log_file = fopen(ROOT.'log.txt', 'a');
    fwrite($log_file, $current_date."\t".$_SERVER['PHP_SELF']."\t\t\"".$message."\"".PHP_EOL);
    fclose($log_file);
}

