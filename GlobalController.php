<?php
include_once (__DIR__ . "/ViewCount.php");
class GlobalController implements ViewCount {

    private $globalmodel;

    function __construct(GlobalModel $globalmodel)
    {
        $this->globalmodel = $globalmodel;
    }

    /*
     * Tüm formlardan gelen değerler burada toplanacak.
     * Her birinin kontrolü Controller dosyasında yapılacak.
     */
    public function forms_save_settings(){
        $tab_page = (isset($_GET["tab"])) ? $_GET["tab"]  : "homepage";
        switch($tab_page){
            case "homepage":
                return $this->home_page_save();
                break;
            case "social":
                return $this->social_page_save();
                break;
            case "footer":
                break;
            case("googleanalytics"):
                return $this->google_analytics_save();
                break;
        }
    }

    /*
     * Anasayfa ayarlar bölümünün kontrol alanı.
     * Burada gerekli kontrol ve güvenlik işlemlerini tamamlayıp Model dosyasmıza gönderip kayıt işlemini gerçekleştireceğiz.
     * Burada gelen verileri bir diziye atayıp geri dönderdik çünkü bu veriyi daha sonra
     * FormUi nesnesinde kullancağız.
     */
    private function home_page_save(){
        if(isset($_POST[FormUi::home_page_nonce_name])){
            if(wp_verify_nonce($_POST[FormUi::home_page_nonce_name],FormUi::home_page_nonce_action)) {

                //Gerekli kontrolleri yapıyoruz.
                $customer_name_surname          = $this->form_security($_POST[FormUi::doctor_name_surname]);
                $customer_title                 = $this->form_security($_POST[FormUi::doctor_title]);
                $customer_email                 = $this->form_security($_POST[FormUi::doctor_email]);
                $doctor_telephone_number_one    = $this->form_security($_POST[FormUi::doctor_telephone_number_one]);
                $doctor_telephone_number_two    = $this->form_security($_POST[FormUi::doctor_telephone_number_two]);
                $doctor_telephone_number_three  = $this->form_security($_POST[FormUi::doctor_telephone_number_three]);
                $doctor_address                 = $this->form_security($_POST[FormUi::doctor_address]);

                $home_page_settings             = array(
                    FormUi::doctor_name_surname             => $customer_name_surname,
                    FormUi::doctor_title                    => $customer_title,
                    FormUi::doctor_email                    => $customer_email,
                    FormUi::doctor_telephone_number_one     => $doctor_telephone_number_one,
                    FormUi::doctor_telephone_number_two     => $doctor_telephone_number_two,
                    FormUi::doctor_telephone_number_three   => $doctor_telephone_number_three,
                    FormUi::doctor_address                  => $doctor_address

                );

                $this->globalmodel->home_page_save_model($home_page_settings);
                return $home_page_settings;
            }
        }
        else {
            $get_home_page_option = get_option("home_page_settings");
            if(!empty($get_home_page_option)){
                return $get_home_page_option;
            }
            else {
                return array();
            }
        }
    }

    /*
     * Sosyal Ağ linklerinin kaydedilmesi için kullanılır.
     * O an post edilmiş sayfa linki varsa, veritabanında sayfa linkleri güncellenir ve geriye o an post edilmiş linkler return edilir.
     * Burada dikkat etmek gereken sayfa kaydı yapıldıktan sonra, tekrar sayfadan kayıt çekilip sayfaya bastırılmaya çalışılmaz,
     * Post edilen bilgi dönderilir.
     */
    private function social_page_save(){
        if(isset($_POST[FormUi::home_page_nonce_name])){
            if(wp_verify_nonce($_POST[FormUi::home_page_nonce_name],FormUi::home_page_nonce_action)) {
                $social_arrays = array();
                foreach(FormUi::$social_array as $key => $val) {
                     $social_arrays[$key] = $this->form_security($_POST[$key]);
                }
                update_option(SOCIAL_THEME_SETTINGS,$social_arrays);
                return $social_arrays;
            }
        }
        else {
            $social_arrays      = get_option(SOCIAL_THEME_SETTINGS);
            if(empty($social_arrays)){
                $social_arrays      = array();
                foreach(FormUi::$social_array as $key => $val) {
                    $social_arrays[$key]    = "";
                }
            }
            return $social_arrays;
        }
    }
    /*
     * Google Analytics Kodunun Save Edilmesi için kullanılır.
     * @return $string -  o an kaydedilen Analytics kodunu döner.
     */
    private function google_analytics_save(){
        $google_analytics_code =  null;
        if(isset($_POST[FormUi::home_page_nonce_name])){
            if(wp_verify_nonce($_POST[FormUi::home_page_nonce_name],FormUi::home_page_nonce_action)) {
                $google_analytics_code  = $_POST[FormUi::google_analytics];
                update_option(GOOGLE_ANALYTICS_CODE,$google_analytics_code);
            }
        }
        else {
                $google_analytics_code  = get_option(GOOGLE_ANALYTICS_CODE);
        }
        if(empty($google_analytics_code)){
            return "";
        }
        else {
            return $google_analytics_code;
        }

    }

    private function form_security($val){
        return trim(htmlspecialchars($val));
    }

    /*
     * Model dosyasına gönderilen post_id değerinden
     */
    public function get_date_from_pass_time($post_id){
        global $post;
        $one_minute     = 60;
        $one_hour       = $one_minute * 60;
        $one_day        = $one_hour * 24;
        $one_month      = $one_day * 30;
        $one_year       = $one_month * 12;

        /*
         * Unix tarih biçiminde geri dönen değer get_date değişkenine atanır.
         * @return String, günlük kullanılan zaman biçiminde geri değer return edilir.
         * Single ve Category sayfalarında aktif olarak kullanılır.
         */
        $get_date         = $this->globalmodel->get_date_from_pass_time($post_id);

        $pass_time = (time() + ($one_hour * 2)) - $get_date;

        if( $pass_time >= $one_year ) {
            return floor($pass_time / $one_year) . " Yıl Önce";
        }
        else if( $pass_time >= $one_month ) {
            return floor($pass_time / $one_month) . " Ay Önce";
        }
        else if( $pass_time >= $one_day ) {
            return floor($pass_time / $one_day) . " Gün Önce";
        }
        else if( $pass_time >= $one_hour ) {
            return floor($pass_time / $one_hour) . " Saat Önce";
        }
        else if( $pass_time >= $one_minute ) {
            return floor($pass_time / $one_minute) . " Dakika Önce";
        }
        else {
            return $pass_time .  " saniye önce";
        }
    }

    /*
     * Views eklentisine ihtiyaç duymadan, kendi views yardımcı fonkyionlarımı yazdığımız yerden,
     * O an single veya page sayfasının görüntülenmes sayısını alır.
     * @param $post_id girilen içeriğin post numarası
     * @return $get_view_count[0] girilen post numarasına ait görüntülenme sayısı.
     */
    public function get_view_count($post_id) {
        $get_view_count     = get_post_meta($post_id,GlobalModel::$view_increase);
        return $get_view_count[0];
    }

    public function order_view_count()
    {
        // TODO: Implement order_view_count() method.
    }
}