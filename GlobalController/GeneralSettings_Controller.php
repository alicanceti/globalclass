<?php
class GeneralSettings_Controller {

    private $general_settings_model;
    const GS_NONCE_NAME     = "gs_nonce_name";
    const GS_NONCE_ACTION   = "gs_nonce_action";

    function __construct(GeneralSettings_Model $general_settings_model)
    {
        $this->general_settings_model = $general_settings_model;
    }

    /*
     * Veritabanına genel ayarlar sekmesinden yapılmış son kayıtları çeker.
     * Burada ki yaklaşım diğer yerlerinden farksızdır.
     * GeneralSettings_Model dosyamızda ki diziden yönetilmeye başlanan tüm ayarlar burada
     * Bir dizi değişkene tekrar atılır ve GeneralSettings_View dosyamızdan bu dizi değer okunmak üzere gönderilir.
     */
    public function intent_general_settings(){
        $get_settings   = get_option( GENERAL_SETTINGS_GC );
        if( !empty( $get_settings ) ) {
            $gs_settings_df     = array();

            foreach( GeneralSettings_Model::$general_settings_defaults as $key => $val ) {
                $get_option_key             = get_option( $key );
                $gs_settings_df[$key]       = $get_option_key;
            }
            return $gs_settings_df;
        }
        return null;
    }

    /*
     * Admin panelden yapılan tüm kayıtları çeker,
     * Sql injection ataklarına karşı korur GeneralSettings_Model dosyamıza kaydedilmek üzere gönderilir.
     */
    public function register_general_function(){

        if( isset( $_POST[self::GS_NONCE_NAME] ) ) {
            if( wp_verify_nonce( $_POST[self::GS_NONCE_NAME],self::GS_NONCE_ACTION ) ) {
                $register_gs_array   = array();

                foreach( GeneralSettings_Model::$general_settings_defaults as $key => $val ) {
                    $register_gs_array[$key] = $this->security_sql_inj( $_POST[$key] );
                }
                $this->general_settings_model->register_general_settings( $register_gs_array );
            }
        }

    }

    private function security_sql_inj( $post_value ) {
        return htmlspecialchars(trim( $post_value ));
    }


} 