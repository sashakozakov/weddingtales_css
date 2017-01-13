<?php

class WeddingTalesTheme {
    
    public function __construct() {
        
        $this->init_config();
        
        $this->init_custom();
       
        
    }
    
    private function init_config() {
        
        require_once 'theme-config.php';

        
    }
    
      /**
         * Init Custom Functions & fields
         */
    public function init_custom() {
        
        require_once 'custom-functions.php';
        
    }

}

new WeddingTalesTheme();

///////////
// polylang or not? ex_pll__
function ex_pll__($string, $extra = NULL) {
        if ( function_exists('pll__') ) {
                return pll__($string);
        } else {
                return __($string,$extra);
        }
}

