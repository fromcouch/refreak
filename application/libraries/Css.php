<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak CSS Library
 *
 * @package	Refreak
 * @subpackage	base
 * @category	library
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Css {
    
    protected   $_style_load        = array();
    private     $_open_style        = '<link type="text/css" rel="stylesheet" media="all" href="';
    private     $_close_style       = "\" />\n";
    
    public function __construct() {
        
        $this->CI = &get_instance();
        
    }
    
    /**
     * Add style to class
     * 
     * @param string $style Css Url
     * @param string|null $key if you want a key for remove or search css url
     * @return void
     * @access public
     */
    public function add_style($style, $key = null) {
        
        $link               = $this->_open_style . $style . $this->_close_style;
        
        if (!is_null($key)) {
            $this->_style_load    [$key]= $link;
        }
        else {
            $this->_style_load    []= $link;
        }

    }
    
    /**
     * Remove style from class
     * 
     * @param string $key 
     * @return void
     * @access public
     */
    public function remove_style($key) {
        
        if (isset($this->_style_load[$key])) {
            unset($this->_style_load[$key]);
        }
        
    }
    
    /**
     * Create string code to draw HTML
     * 
     * @return void
     * @access public
     */
    public function compile() {
        
        if ( count($this->_style_load) > 0) {
            
            $external_css = implode('', $this->_style_load);
            $this->CI->load->vars(array('css_link_src' => $external_css));
            
        }              
        
    }
    
}
// END Css Class

/* End of file Css.php */
/* Location: ./application/libraries/Css.php */