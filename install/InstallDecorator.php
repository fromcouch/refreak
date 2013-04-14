<?php

/*14/04/2013
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Install Decorator Class
 *
 * @package	Refreak
 * @subpackage	installer
 * @category	class
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class InstallDecorator {
    
    /**
     * HTML for OK value
     * 
     * @var string
     * @access private
     * @static 
     */
    private static $span_ok = '<span class="ok">OK</span>';
    
    /**
     * HTML for wrong value
     * @var string
     * @access private
     * @static 
     */
    private static $span_fail = '<span class="error">FAIL!</span>';
    
    /**
     * Renders LI HTML element with ok/fail value
     * 
     * @param string $title Text to show inside LI
     * @param boolean $state OK or FAIL
     * @return string HTML string
     */
    public static function show_li_element($title, $state) {
            
            $ret        = '<li>' . $title . ' ';
            
            $ret       .= $state ? self::$span_ok : self::$span_fail;
            
            $ret       .='</li>';
                   
            return $ret;
    }
    
}

?>
