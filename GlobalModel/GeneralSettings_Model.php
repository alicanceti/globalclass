<?php
class GeneralSettings_Model {

    /*
     * Temanın ayar sayfasında sitenin genel olarak müşteri ayarlarını yapabileceğiniz kısımdır.
     * Burada ki amaç sitenin görünen yerlerinde bu değişkenleri kullanabilmektir.
     * Mesela user_name_surname keyine sahip alanı bir logo veya tarayıcının title kısmında kullanabilirsiniz.
     */

    public static  $general_settings_defaults    = array(
        "customer_name_surname"             => "Müşteri Adı Soyadı",
        "customer_title"                    => "Müşteri Unvanı",
        "customer_email_address"            => "Müşteri E-mail adresi",
        "customer_telephone_number_one"     => "Telefon Numarası 1",
        "customer_telephone_number_two"     => "Telefon Numarası 2",
        "customer_telephone_number_thr"     => "Telefon Numarası 3",
        "customer_address"                  => "Müşteri Adresi",
    );

    /*
     * Genel ayarlar Database versiyon numarası.
     * Eğer forma yeni alanlar eklenmek $general_settings_defaults dizisine yeni alan eklendikten sonra,
     * Versiyon numarası yükseltilmelidir.
     */
    private $gs_version_number = "1.3";

    function __construct() {

        /*
         * Sayfa açılış anında Genel ayarların yapılıp yapılmadığı kontrol edilir.
         * Eğer herhangi Db kaydı yoksa wp_option tablosunda $general_settings_defaults dizisi kullanılarak boş kayıtlar oluşturulur.
         *
         * Bunun amacı Genel Ayarlar formunun tek bir alandan yönetilmesidir.
         * Diziye eklenecek her alan formun name ve key alanlarına etki edecektir.
         *
         * Diziye ekleme yapıldıktan sonra versiyon numrasının değiştirilmesi gerektiği unutulmamalıdır.
         */
        $get_settings   = get_option( GENERAL_SETTINGS_GC );
        if( empty( $get_settings ) ) {
            foreach( self::$general_settings_defaults as $key => $val ){
                add_option( $key,"" );
            }
            add_option( GENERAL_SETTINGS_GC, $this->gs_version_number );
        }
        else {
            $get_settings   = get_option( GENERAL_SETTINGS_GC );
            if( $get_settings != $this->gs_version_number ) {
                foreach( self::$general_settings_defaults as $item_key => $item_val ){
                    $get_item       = get_option($item_key);
                    if( empty( $get_item ) ) {
                        add_option( $item_key,"" );
                    }
                }
                update_option( GENERAL_SETTINGS_GC, $this->gs_version_number );
            }
        }
    }

    /*
     * Formdan gelen bilgileri alır ve kaydını yapar.
     */
    public function register_general_settings( array $gs_settings_post ){
        if( !empty( $gs_settings_post ) ) {

            foreach( self::$general_settings_defaults as $item_key => $val ){
               update_option( $item_key,$gs_settings_post[$item_key] );
            }

        }
    }

}