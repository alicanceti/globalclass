<?php

if( !defined( "SOCIAL_SETTINGS_GC" ) )
    define( "SOCIAL_SETTINGS_BT","social_button_settings" );

if( !defined( "SOCIAL_THEME_SETTINGS" ) )
    define("SOCIAL_THEME_SETTINGS","social_theme_settings");

include_once ( GLOBAL_CLASS_PATH . "/GlobalController/SocialButtons_Controller.php" );
include_once ( GLOBAL_CLASS_PATH . "/GlobalModel/SocialButtons_Model.php" );

$social_buttons_model           = new SocialButtons_Model();
$social_buttons_controller      = new SocialButtons_Controller( $social_buttons_model );

?>
<?php function social_settings_ui(){
    global $social_buttons_controller;
    $sb_set_defaults     = SocialButtons_Model::$social_array;
    $social_buttons_controller->register_social_function();
    ?>
    <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

        <?php foreach( $social_buttons_controller->intent_social_settings() as $sb_key => $sb_val ) { ?>
            <fieldset>
                <p><?php echo "\"" . $sb_key . "\""; ?></p>
                <label for="<?php echo $sb_key; ?>"><?php echo $sb_set_defaults[$sb_key] ?></label>
                <input type="text" name="<?php echo $sb_key; ?>" id="<?php echo $sb_key; ?>" value="<?php echo stripslashes($sb_val); ?>" class="gs_input_class" />
            </fieldset>
        <?php } ?>
        <?php wp_nonce_field(SocialButtons_Controller::SB_NONCE_ACTION,SocialButtons_Controller::SB_NONCE_NAME);  ?>
        <input type="submit" value="Ayarları Kaydet" />
    </form>
<?php } ?>
<?php

/*
 * Sosyal Ağ butonlarının çıkması için kullanılır.
 */
function social_settings_site(){
    echo "<ul class='ul-table social_links'>";
    foreach( SocialButtons_Model::$social_array as $network => $url ) :
        $url    = get_option( $network );
        if(!empty( $url )) :
            echo "<li><a id='" . $network . "' href='" . $url . "'></a></li>";
        endif;
    endforeach;
    echo "</ul>";
}

?>