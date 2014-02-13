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
<?php function GoogleAnalytics(){ ?>
    <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

        <fieldset>
            <label for="google_analytics">Google Analytics Kodu</label>
            <textarea name="<?php echo self::google_analytics; ?>" id="google_analytics" placeholder="Google Analytics Code"><?php echo stripslashes($google_analytics); ?></textarea>
        </fieldset>

        <input type="submit" value="Ayarları Kaydet" />

        <?php wp_nonce_field(self::home_page_nonce_action,self::home_page_nonce_name); ?>

    </form>
<?php } ?>