<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 12.02.2014
 * Time: 17:49
 */

class SocialButtons_Model {

    public static $social_array = array(
        "facebook"      => "Facebook Sayfa Linki",
        "twitter"       => "Twitter Sayfa Linki",
        "googleplus"    => "Google+ Sayfa Linki",
        "linkedin"      => "Linkedin Sayfa Linki",
        "youtube"       => "Youtube Sayfa Linki",
        "instagram"     => "İnstagram Sayfa Linki",
        "pinterest"     => "Pinterest Sayfa Linki"
    );
    private $sb_version_number = "1.1";

    function __construct() {

        $social_arrays      = get_option( SOCIAL_THEME_SETTINGS );
        $get_settings       = get_option( SOCIAL_SETTINGS_BT );
        if( empty( $get_settings ) || $get_settings != $this->sb_version_number ){

            if( !empty( $social_arrays ) ){
                foreach( self::$social_array as $item_key => $item_val ){
                    $get_item       = get_option( $item_key );
                    if( empty( $get_item ) ) {
                        update_option( $item_key,$social_arrays[ $item_key ] );
                    }
                }
                delete_option( SOCIAL_THEME_SETTINGS );
            }
            else {
                foreach( self::$social_array as $item_key => $item_val ){
                    $get_item       = get_option( $item_key );
                    if( empty( $get_item ) ) {
                        update_option( $item_key,"" );
                    }
                }
            }

            update_option( SOCIAL_SETTINGS_BT, $this->sb_version_number );
        }
    }

    /*
     * Formdan gelen bilgileri alır ve kaydını yapar.
     */
    public function register_social_settings( array $sb_settings ){
        if( !empty( $sb_settings ) ) {

            foreach( self::$social_array as $item_key => $val ){
                update_option( $item_key,$sb_settings[$item_key] );
            }

        }
    }
}