<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 13.02.2014
 * Time: 11:13
 */

class WebMasterTools_Model {


    /*
     * Formdan gelen analytics kodu veritabanına kaydeder.
     * @param String $analytics_code
     * return null
     */
    public function register_analytics_code( $analyitcs_code ){
        update_option( GOOGLE_ANALYTICS_CODE,$analyitcs_code );
    }

    /*
     * Veritabanına kaydedilmiş olan analytics kodunu geri dönderir.
     * @return String $get_analytics_code
     */
    public function send_analyitcs_code(){
        $get_analytics_code     = get_option( GOOGLE_ANALYTICS_CODE );
        if( empty( $get_analytics_code ) ) return null;

        return $get_analytics_code;
    }

    /*
     * Formdan gelen webmastertools kodunu veritabanına kaydeder.
     * @param String $wm_code
     * return null
     */
    public function register_wmtools_code( $wm_code ){
        update_option( WEBMASTER_TOOLS_CODE,$wm_code );
    }

    /*
     * Veritabanına kaydedilmiş olan wm kodunu geri dönderir.
     * @return String $get_wmtools_code
     */
    public function send_wmtools_code(){
        $get_wmtools_code     = get_option( WEBMASTER_TOOLS_CODE );
        if( empty( $get_wmtools_code ) ) return null;

        return $get_wmtools_code;
    }

} 