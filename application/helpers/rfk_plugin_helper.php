<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Plugin Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	plugin
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class rfk_plugin_helper {
    
    /**
     * Trigger plugin event
     * 
     * @param string $event_name Event name
     * @return array processed data
     * @access private
     * @static
     */
    public static function trigger_event($event_name, $data) {
        
        $CI =& get_instance();
        return $CI->plugin_handler->trigger($event_name, $data);
    }
    
}

?>
