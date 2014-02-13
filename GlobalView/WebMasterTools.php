<?php

if( !defined( "GOOGLE_ANALYTICS_CODE" ) ){
    define( "GOOGLE_ANALYTICS_CODE","google_analytics_code" );
}
if( !defined( "WEBMASTER_TOOLS_CODE" ) ){
    define( "WEBMASTER_TOOLS_CODE","webmaster_tools_code" );
}

include_once ( GLOBAL_CLASS_PATH . "/GlobalController/WebMasterTools_Controller.php" );
include_once ( GLOBAL_CLASS_PATH . "/GlobalModel/WebMasterTools_Model.php" );

$webmastertools_model       = new WebMasterTools_Model();
$webmastertools_controller  = new WebMasterTools_Controller( $webmastertools_model );

?>
<?php function wm_tools_func(){
    global $webmastertools_controller;
    $get_analytics_process_respond      = $webmastertools_controller->process_analytics_code();
    $get_wmtools_process_respond        = $webmastertools_controller->process_wmtools_code();
    ?>
    <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

        <fieldset>
            <label for="google_analytics">Google Analytics Kodu</label>
            <textarea
                name="<?php echo $webmastertools_controller::ANALYTICS_FORM_NAME; ?>"
                id="google_analytics"
                placeholder="Google Analytics Code"
                class="gs_textarea_class"><?php echo stripslashes( $get_analytics_process_respond ); ?></textarea>
        </fieldset>

        <fieldset>
            <label for="google_analytics">Web Master Araçları Kodu</label>
            <textarea
                name="<?php echo $webmastertools_controller::GOOGLE_WMT_FORM_NAME; ?>"
                id="wm_tools_code"
                placeholder="Web Master Tools Code"
                class="gs_textarea_class"><?php echo stripslashes( $get_wmtools_process_respond ); ?></textarea>
        </fieldset>
        <input type="submit" value="Ayarları Kaydet" />

        <?php wp_nonce_field($webmastertools_controller::WMT_NONCE_ACTION,$webmastertools_controller::WMT_NONCE_NAME); ?>

    </form>
<?php } ?>