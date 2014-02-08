<?php

if( !defined( "GENERAL_SETTINGS_GC" ) ){
    define( "GENERAL_SETTINGS_GC","global_class_settings" );
}

include_once ( GLOBAL_CLASS_PATH . "/GlobalController/GeneralSettings_Controller.php" );
include_once ( GLOBAL_CLASS_PATH . "/GlobalModel/GeneralSettings_Model.php" );

$general_settings_model     = new GeneralSettings_Model();
$general_settings_cont      = new GeneralSettings_Controller( $general_settings_model );
?>
<?php function general_settings_ui(){
    global $general_settings_cont;
    $gs_set_defaults     = GeneralSettings_Model::$general_settings_defaults;
    $general_settings_cont->register_general_function();
    ?>
    <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

        <?php foreach( $general_settings_cont->intent_general_settings() as $gs_key => $gs_val ) { ?>
            <fieldset>
                <label for="<?php echo $gs_key; ?>"><?php echo $gs_set_defaults[$gs_key] ?></label>
                <input type="text" name="<?php echo $gs_key; ?>" id="<?php echo $gs_key; ?>" value="<?php echo $gs_val; ?>" />
            </fieldset>
        <?php } ?>
        <?php wp_nonce_field(GeneralSettings_Controller::GS_NONCE_ACTION,GeneralSettings_Controller::GS_NONCE_NAME);  ?>
        <input type="submit" value="Ayarları Kaydet" />
    </form>
<?php } ?>
