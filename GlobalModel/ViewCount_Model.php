<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 14.02.2014
 * Time: 11:50
 */

class ViewCount_Model {

    public static $view_increase    = "post_view_count";

    function __construct(){

        add_action("save_post",array($this,"save_view_count"));
        add_action("wp_head",array($this,"blog_view_increase"));

    }

    /*
     * Yeni bir yazı eklendiği veya güncellendiği zaman devreye girer.
     * Veritabanında o posta ait post_view_count adında bir meta etiketi arar.
     * Eğer yoksa 0 değerinde bir giriş yapar.
     */
    public function save_view_count( $post_id ){
        global $wpdb;
        $get_post_view_count    =   $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE post_id = {$post_id} and meta_key  = '" . self::$view_increase . "'");
        if( $get_post_view_count == null ) {
            update_post_meta($post_id,self::$view_increase,0);
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

}