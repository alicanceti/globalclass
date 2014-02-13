<?php

class FormUi {

//    Bu const değerlerinde ekleme yaparsan mutlaka GlobalController sınıfında ki home_page_save fonksiyonunda da da değişiklik yap.
    const doctor_name_surname               = "doctor_name_surname";
    const doctor_title                      = "doctor_title";
    const doctor_email                      = "doctor_email";
    const doctor_telephone_number_one       = "doctor_telephone_number_one";
    const doctor_telephone_number_two       = "doctor_telephone_number_two";
    const doctor_telephone_number_three     = "doctor_telephone_number_three";
    const doctor_address                    = "doctor_address";
    const home_page_nonce_action            = "home_page_nonce_action";
    const home_page_nonce_name              = "home_page_nonce_name";

    /*
     * Google Analytics Code Kısayol
     */

    const google_analytics                  = "google_analytics";
    private $auto_google_code;

    public static $social_array = array(
        "facebook"      => "Facebook Sayfa Linki",
        "twitter"       => "Twitter Sayfa Linki",
        "googleplus"    => "Google+ Sayfa Linki",
        "linkedin"      => "Linkedin Sayfa Linki",
        "youtube"       => "Youtube Sayfa Linki",
        "instagram"     => "İnstagram Sayfa Linki",
        "pinterest"     => "Pinterest Sayfa Linki"
    );

    public function  SocialPage($social_array){
        print_r( $social_array );
        ?>
        <p><strong>Sayfada çalıştırmak için social_buttons() fonksiyonunu ekleyin.</strong></p>
        <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

            <?php foreach(self::$social_array as $social_key => $social_val): ?>
                <fieldset>
                    <label for="<?php echo $social_key ?>"><?php echo $social_val; ?></label>
                    <input type="text" name="<?php echo $social_key ?>" id="<?php echo $social_key ?>" value="<?php echo $this->empty_array_val_control($social_array,$social_key); ?>" />
                </fieldset>
            <?php endforeach; ?>

            <input type="submit" value="Ayarları Kaydet" />

            <?php wp_nonce_field(self::home_page_nonce_action,self::home_page_nonce_name); ?>

        </form>
    <?php
    }
    public function FooterPage($footer_page){

    }


    public function GoogleAnalytics( $google_analytics ){ ?>

        <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

            <fieldset>
                <label for="google_analytics">Google Analytics Kodu</label>
                <textarea name="<?php echo self::google_analytics; ?>" id="google_analytics" placeholder="Google Analytics Code"><?php echo stripslashes($google_analytics); ?></textarea>
            </fieldset>

            <input type="submit" value="Ayarları Kaydet" />

            <?php wp_nonce_field(self::home_page_nonce_action,self::home_page_nonce_name); ?>

        </form>

    <?php    }

    private function empty_array_val_control($array,$key){
        if(array_key_exists($key,$array)) {
            return $array[$key];
        }
        else {
            return null;
        }
    }
}
?>