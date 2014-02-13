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

    public  function HomePage($post_val){
        /*
         * Sayfa açılış anında HomePage fonksiyonu hata vericektir.
         * Bunun sebebi $post_val değişkeninin boş olmasıdır.
         * Yani henüz database'e hiç bir veri gönderilmemiştir.
         * Controller dosyasından boş değer döner.
         * Bizde bunu kontrol edip hata atmasını engelliyoruz.
         */
        if(empty($post_val)) {
            $post_val             = array(
                self::doctor_name_surname             => "",
                self::doctor_title                    => "",
                self::doctor_email                    => "",
                self::doctor_telephone_number_one     => "",
                self::doctor_telephone_number_two     => "",
                self::doctor_telephone_number_three   => "",
                self::doctor_address                  => ""

            );
        }
        ?>
        <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <p> Şeklinde bütün değişkenli topla $get_main_area_option   = get_option(HOME_PAGE_SETTINGS);</p>
            <fieldset>
                <p>$get_main_area_option["doctor_name_surname"]</p>
                <label for="<?php echo self::doctor_name_surname; ?>">Doktor Adı ve Soyadı : </label>
                <input type="text" name="<?php echo self::doctor_name_surname; ?>" id="<?php echo self::doctor_name_surname; ?>" value="<?php echo $post_val[self::doctor_name_surname] ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_title"]</p>
                <label for="<?php echo self::doctor_title; ?>">Doktor Ünvanı : </label>
                <input type="text" name="<?php echo self::doctor_title; ?>" id="<?php echo self::doctor_title; ?>" value="<?php echo $post_val[self::doctor_title] ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_email"]</p>
                <label for="<?php echo self::doctor_email; ?>">Doktor E-mail Adresi : </label>
                <input type="text" name="<?php echo self::doctor_email; ?>" id="<?php echo self::doctor_email; ?>" value="<?php echo $post_val[self::doctor_email]; ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_telephone_number_one"]</p>
                <label for="<?php echo self::doctor_telephone_number_one; ?>">Telefon Numarası 1 : </label>
                <input type="text" name="<?php echo self::doctor_telephone_number_one; ?>" id="<?php echo self::doctor_telephone_number_one; ?>" value="<?php echo $post_val[self::doctor_telephone_number_one]; ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_telephone_number_two"]</p>
                <label for="<?php echo self::doctor_telephone_number_two; ?>">Telefon Numarası 2 : </label>
                <input type="text" name="<?php echo self::doctor_telephone_number_two; ?>" id="<?php echo self::doctor_telephone_number_two; ?>" value="<?php echo $post_val[self::doctor_telephone_number_two]; ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_telephone_number_three"]</p>
                <label for="<?php echo self::doctor_telephone_number_three; ?>">Telefon Numarası 3 : </label>
                <input type="text" name="<?php echo self::doctor_telephone_number_three; ?>" id="<?php echo self::doctor_telephone_number_three; ?>" value="<?php echo $post_val[self::doctor_telephone_number_three]; ?>" />
            </fieldset>
            <fieldset>
                <p>$get_main_area_option["doctor_address"]</p>
                <label for="<?php echo self::doctor_address; ?>">Hastane veya muayene adresi</label>
                <textarea name="<?php echo self::doctor_address; ?>" id="<?php echo self::doctor_address; ?>"><?php echo $post_val[self::doctor_address]; ?></textarea>
            </fieldset>
            <fieldset>
                <input id="submit_button" type="submit" value="Ayarları Kaydet" />
            </fieldset>
            <?php wp_nonce_field(self::home_page_nonce_action,self::home_page_nonce_name); ?>
        </form>
    <?php
    }
    public static $social_array = array(
        "facebook"      => "Facebook Sayfa Linki",
        "twitter"       => "Twitter Sayfa Linki",
        "googleplus"    => "Google+ Sayfa Linki",
        "linkedin"      => "Linkedin Sayfa Linki",
        "youtube"       => "Youtube Sayfa Linki",
        "instagram"     => "İnstagram Sayfa Linki",
        "pinterest"     => "Pinterest Sayfa Linki"
    );

    public function  SocialPage($social_array){ ?>
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


    public function GoogleAnalytics($google_analytics){ ?>

        <form id="main_page_settings" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

            <fieldset>
                <label for="google_analytics">Google Analytics Kodu</label>
                <textarea
                    name="<?php echo self::google_analytics; ?>"
                    id="google_analytics"
                    placeholder="Google Analytics Code"><?php echo stripslashes($google_analytics); ?></textarea>
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