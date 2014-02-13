<?php
/**
 * Created by PhpStorm.
 * User: olkunmustafa
 * Date: 13.02.2014
 * Time: 11:13
 */

class WebMasterTools_Controller {

    private $webmastertools_model;

    function __construct( WebMasterTools_Model $webmastertools_model )
    {
        $this->webmastertools_model = $webmastertools_model;
    }


} 