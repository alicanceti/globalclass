<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 14.02.2014
 * Time: 12:40
 */

class PassTime_Model {

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