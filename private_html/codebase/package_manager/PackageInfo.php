<?php

namespace Tres\package_manager {
    
    /**
     * Information about this package.
     */
    class PackageInfo {
        
        /**
         * The package information.
         * 
         * @var array
         */
        protected static $_info = [
            'version' => '0.2',
            
            'contributors' => [
                'pedzed' => [
                    'profile' => 'https://github.com/pedzed/'
                ]
            ]
        ];
        
        /**
         * Gets the info.
         * 
         * @return array
         */
        public static function get(){
            return self::$_info;
        }
        
    }
    
}
