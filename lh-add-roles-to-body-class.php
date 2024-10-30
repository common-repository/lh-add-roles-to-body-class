<?php
/**
 * Plugin Name: LH Add Roles to Body Class
 * Plugin URI: https://lhero.org/portfolio/lh-add-roles-to-body-class/
 * Description: Simply adds the currently logged in users roles as classes to the body tag in the front and back end
 * Version: 1.01
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('LH_Add_roles_to_body_class_plugin')) {


class LH_Add_roles_to_body_class_plugin {
    
    private static $instance;

    static function return_plugin_namespace(){

        return 'lh_artbc';

    }
    

    public function class_to_body($classes) {
    
        if ($the_current_user = wp_get_current_user()){
    
            foreach($the_current_user->roles as $user_role) { 
    
                $classes[] = 'role-'.$user_role;
    
            }
    
            $classes[] = 'user_id-'.$the_current_user->ID;
    
        }
    
        return $classes;
    
    
    }




    public function class_to_body_admin($classes) {
    
        if ($the_current_user = wp_get_current_user()){
        
            foreach($the_current_user->roles as $user_role) { 
            
                $classes .= ' role-'.$user_role;
            
            }
        
        $classes .= ' user_id-'.$the_current_user->ID;
        
        return preg_replace('!\s+!', ' ', $classes);
        
        } else {
            
            return $classes;
            
        }
    
    
    }

    public function plugin_init(){
        
        //add classes to the front end body class attribute
        add_filter('body_class', array($this,"class_to_body"), 10, 1);
        
        //add classes to the back end body class attribute
        add_filter('admin_body_class', array($this,"class_to_body_admin"), 10, 1);
        
    }

    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        
        if (null === self::$instance) {
            
            self::$instance = new self();
            
        }
 
        return self::$instance;
        
    }


    public function __construct() {
        
        //run our hooks on plugins loaded to as we may need checks       
        add_action( 'plugins_loaded', array($this,'plugin_init'));
        
    }

}

$lh_add_roles_to_body_class_instance = LH_Add_roles_to_body_class_plugin::get_instance();

}


?>