<?php
class GlobalModel {

    public static $view_increase    = "post_view_count";

    function __construct()
    {
        add_action("save_post",array($this,"save_view_count"));
        add_action("wp_head",array($this,"blog_view_increase"));
    }

    /*
     * Yeni bir yazı eklendiği veya güncellendiği zaman devreye girer.
     * Veritabanında o posta ait post_view_count adında bir meta etiketi arar.
     * Eğer yoksa 0 değerinde bir giriş yapar.
     */
    public function save_view_count($post_id){
        global $wpdb;
        $get_post_view_count    =   $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE post_id = {$post_id} and meta_key  = '" . self::$view_increase . "'");
        if( $get_post_view_count == null ) {
            update_post_meta($post_id,self::$view_increase,0);
        }
    }

    public function home_page_save_model(array $val_array){
        if(is_array($val_array)){
            update_option(HOME_PAGE_SETTINGS,$val_array);
        }
    }

    /*
     * Single veya page sayfalarına ziyaretci arayüzünde bir giriş yapıldığı zaman,
     * Sayfanın o an ki ziyaret sayısını alır ve bir arttırıp tekrar veritabanına kaydeder.
     * @return null;
     */
    public function blog_view_increase(){
        global $post;

        if(!wp_is_post_revision($post->ID)) {
            if(is_single() || is_page()) {

                $id                 = intval($post->ID);
                $views_count      = get_post_meta($id,self::$view_increase);
                $views_count      = intval($views_count[0]) + 1;
                update_post_meta($id,self::$view_increase ,$views_count);

            }
        }

    }

    /*
     * Verilen post numarasını veritabanına arar ve posta ait giriş tarihini Unix zaman tarihi biçiminde geri dönderir.
     */
    public function get_date_from_pass_time($post_id){
        global $wpdb;
        $entry_time     = $wpdb->get_row( "SELECT * FROM $wpdb->posts where ID = " . $post_id );
        if( !empty($entry_time) ) {
            return strtotime($entry_time->post_date);
        }
        else  {
            return null;
        }
    }

} 