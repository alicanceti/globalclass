<?php

class ViewCount_Controller {

    private $view_count_model;

    function __construct( ViewCount_Model $view_count_model )
    {
        $this->view_count_model = $view_count_model;
    }

    /*
     * Views eklentisine ihtiyaç duymadan, kendi views yardımcı fonkyionlarımı yazdığımız yerden,
     * O an single veya page sayfasının görüntülenmes sayısını alır.
     * @param $post_id girilen içeriğin post numarası
     * @return $get_view_count[0] girilen post numarasına ait görüntülenme sayısı.
     */
    public function get_view_count( $post_id ) {
        $get_view_count     = get_post_meta( $post_id,ViewCount_Model::$view_increase );
        return $get_view_count[0];
    }


} 