<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 14.02.2014
 * Time: 12:40
 */

class PassTime_Controller {

    private $passtime_model;

    function __construct( PassTime_Model $passtime_model )
    {
        $this->passtime_model = $passtime_model;
    }


    /*
     * Model dosyasına gönderilen post_id değerinden
     */
    public function get_date_from_pass_time( $post_id ){
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
        $get_date         = $this->passtime_model->get_date_from_pass_time($post_id);

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

} 