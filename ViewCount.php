<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 22.01.2014
 * Time: 10:56
 */

interface ViewCount {
    public function get_view_count($post_id);
    public function order_view_count();
}