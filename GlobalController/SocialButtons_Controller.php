<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 12.02.2014
 * Time: 17:49
 */

class SocialButtons_Controller {

    private $social_buttons_model;
    const SB_NONCE_NAME         = "sb_nonce_name";
    const SB_NONCE_ACTION       = "sb_nonce_action";

    function __construct(SocialButtons_Model $social_buttons_model)
    {
        $this->social_buttons_model = $social_buttons_model;
    }

    /*
     * Veritabanına genel ayarlar sekmesinden yapılmış son kayıtları çeker.
     * Burada ki yaklaşım diğer yerlerinden farksızdır.
     * SocialButtons_Model dosyamızda ki diziden yönetilmeye başlanan tüm ayarlar burada
     * Bir dizi değişkene tekrar atılır ve SocialButtons dosyamıza bu dizi değer okunmak üzere gönderilir.
     */
    public function intent_social_settings(){
        $get_settings   = get_option( SOCIAL_SETTINGS_BT );
        if( !empty( $get_settings ) ) {
            $sb_settings     = array();

            foreach( SocialButtons_Model::$social_array as $item_key => $item_val ) {
                $get_option_key                     = get_option( $item_key );
                $sb_settings[ $item_key ]        = $get_option_key;
            }
            return $sb_settings;
        }
        return null;
    }

    /*
     * Admin panelden yapılan tüm kayıtları çeker,
     * Sql injection ataklarına karşı korur GeneralSettings_Model dosyamıza kaydedilmek üzere gönderilir.
     */
    public function register_social_function(){

        if( isset( $_POST[self::SB_NONCE_NAME] ) ) {
            if( wp_verify_nonce( $_POST[self::SB_NONCE_NAME],self::SB_NONCE_ACTION ) ) {
                $register_sb_array   = array();


                foreach( SocialButtons_Model::$social_array as $key => $val ) {
                    $register_sb_array[$key] = $this->security_sql_inj( $_POST[$key] );
                }
                $this->social_buttons_model->register_social_settings( $register_sb_array );
            }
        }

    }

    private function security_sql_inj( $post_value ) {
        return htmlspecialchars(trim( $post_value ));
    }


} 