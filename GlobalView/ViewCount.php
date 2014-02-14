<?php

if( !defined( "VIEW_COUNT_GLOBAL" ) )
    define( "VIEW_COUNT_GLOBAL","view_count_global" );

include_once( GLOBAL_CLASS_PATH .  "/GlobalController/ViewCount_Controller.php" );
include_once( GLOBAL_CLASS_PATH .  "/GlobalModel/ViewCount_Model.php" );

$view_count_model       = new ViewCount_Model();
$view_count_controller  = new ViewCount_Controller( $view_count_model );




?>