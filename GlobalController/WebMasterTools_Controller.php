<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 13.02.2014
 * Time: 11:13
 */

class WebMasterTools_Controller {

    private $webmastertools_model;
    const WMT_NONCE_NAME        = "wmt_nonce_name";
    const WMT_NONCE_ACTION      = "wmt_nonce_action";
    const ANALYTICS_FORM_NAME   = "analytics_form_name";
    const GOOGLE_WMT_FORM_NAME  = "google_webmastertools_form_name";

    function __construct( WebMasterTools_Model $webmastertools_model ) {
        $this->webmastertools_model = $webmastertools_model;
        add_action("wp_head",array($this,"wmt_tools_add_func"));
    }

    public function process_analytics_code(){

        if( isset( $_POST[self::WMT_NONCE_NAME] ) ) {
            if( wp_verify_nonce( $_POST[self::WMT_NONCE_NAME],self::WMT_NONCE_ACTION ) ) {
                $get_analytics_code     = $this->security_sql_inj( $_POST[self::ANALYTICS_FORM_NAME] );
                $this->webmastertools_model->register_analytics_code( $get_analytics_code );
                return $get_analytics_code;
            }
        }
        else {
            return $this->webmastertools_model->send_analyitcs_code();
        }

    }

    public function process_wmtools_code(){

        if( isset( $_POST[self::WMT_NONCE_NAME] ) ) {
            if( wp_verify_nonce( $_POST[self::WMT_NONCE_NAME],self::WMT_NONCE_ACTION ) ) {
                $get_wm_tools_code     = $this->security_sql_inj( $_POST[self::GOOGLE_WMT_FORM_NAME] );
                $this->webmastertools_model->register_wmtools_code( $get_wm_tools_code );
                return $get_wm_tools_code;
            }
        }
        else {
            return $this->webmastertools_model->send_wmtools_code();
        }

    }

    private function security_sql_inj( $post_value ) {
        return htmlspecialchars(trim( $post_value ));
    }

    public function wmt_tools_add_func(){

        echo stripslashes(get_option("google_analytics_code"));
//        $get_analytics_code     = get_option( self::ANALYTICS_FORM_NAME );
//        if( !empty( $get_analytics_code ) ) echo stripslashes( $get_analytics_code );
//
//        $get_wm_tools_code      = get_option( self::GOOGLE_WMT_FORM_NAME );
//        if( !empty( $get_wm_tools_code ) ) echo stripslashes( $get_wm_tools_code );
    }

}

?>