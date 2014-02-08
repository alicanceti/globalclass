<?php
class GeneralSettings_Model {

    /*
     * Temanın ayar sayfasında sitenin genel olarak müşteri ayarlarını yapabileceğiniz kısımdır.
     * Burada ki amaç sitenin görünen yerlerinde bu değişkenleri kullanabilmektir.
     * Mesela user_name_surname keyine sahip alanı bir logo veya tarayıcının title kısmında kullanabilirsiniz.
     */
    public static  $general_settings_defaults    = array(
        "customer_name_surname"         => "Müşteri Adı Soyadı",
        "customer_title"                => "Müşteri Unvanı",
        "customer_email_address"        => "Müşteri E-mail adresi",
        "customer_telephone_number_one" => "Telefon Numarası 1",
        "customer_telephone_number_two" => "Telefon Numarası 2",
        "customer_telephone_number_thr" => "Telefon Numarası 3",
        "customer_address"              => "Müşteri Adresi",
    );

    function __construct() {

        $get_settings   = get_option( GENERAL_SETTINGS_GC );
        if( empty( $get_settings ) ) {
            foreach( $this->general_settings_defaults as $key => $val ){
                add_option( $key,"" );
            }
            add_option( GENERAL_SETTINGS_GC, true );
        }

    }

    /*
     * Formdan gelen bilgileri alır ve gerekli olanları kaydeder.
     */
    public function register_general_settings(){



    }

}