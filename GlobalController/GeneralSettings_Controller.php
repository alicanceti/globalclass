<?php
class GeneralSettings_Controller {

    private $general_settings_model;

    function __construct(GeneralSettings_Model $general_settings_model)
    {
        $this->general_settings_model = $general_settings_model;
    }

    public function intent_general_settings(){
        $get_settings   = get_option( GENERAL_SETTINGS_GC );
        if( !empty( $get_settings ) && $get_settings ) {
            $gs_settings_df     = array();

            foreach( GeneralSettings_Model::$general_settings_defaults as $key => $val ) {
                $get_option_key             = get_option( $key );
                $gs_settings_df[$key]       = $get_option_key;
            }
            return $gs_settings_df;
        }
        return null;
    }


} 