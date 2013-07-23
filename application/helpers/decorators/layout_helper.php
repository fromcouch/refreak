<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout Decorator Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	decorator
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */

class layout_helper {
    
    /**
     * Render Header
     * 
     * @param string $logout_url
     * @param string $logout_text
     * @param string $theme_url
     * @param string $edituser_url
     * @param object $actual_user
     * @return string html header
     * @access public
     * @static 
     */
    public static function header($logout_url, $logout_text, $theme_url, $edituser_url, $actual_user) {
        
        $parts = array();
        
        $parts ['userlogout'] = '
                <div class="userlogout">
                    <a href="' . $logout_url . '" title="' . $logout_text . '">
                        <img class="header-logout" src="' . $theme_url . '/images/logout-off.png" 
                            width="13" height="13" border="0" onmouseover="this.src=\'' . $theme_url . '/images/logout-on.png\'" 
                                onmouseout="this.src=\'' . $theme_url . '/images/logout-off.png\'" />
                    </a>
                </div>
        ';
        
        $parts ['user'] = '
            <div class="user">
                <div class="username"><a href="' . $edituser_url . '/' . $actual_user->id . '">' . $actual_user->first_name.' '.$actual_user->last_name . '</a></div>
                <div class="userdate"><?php echo actual_text_date(); ?></div>
            </div>            
        ';
        
        $parts = rfk_plugin_helper::trigger_event('layout_view_header', $parts);
        
        return implode('', $parts);
    }
    
}

?>
