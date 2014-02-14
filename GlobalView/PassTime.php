<?php

    if( !defined( "PASS_TIME_GC" ) )
        define( "PASS_TIME_GC","pass_time_gc" );

include_once ( GLOBAL_CLASS_PATH . "/GlobalController/PassTime_Controller.php" );
include_once ( GLOBAL_CLASS_PATH . "/GlobalModel/PassTime_Model.php" );

$passtime_model         = new PassTime_Model();
$passtime_controller    = new PassTime_Controller( $passtime_model );



?>