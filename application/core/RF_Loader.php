<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Extender Loader for tenplate use
 *
 * @package	Refreak
 * @subpackage	base
 * @category	class
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 * 
 */
class RF_Loader extends CI_Loader {
    
    public function __construct()
    {
        parent::__construct();
    }  
    
    /**------------------------------------------------------------
    |
    | viewLayout($template, $data = array(), $layoutData = array(), $layout = 'default') 
    |
    | Renders output with a layout, rather than using
    | two statements in the code, this will do the same
    | in one. Layouts are stored in the views/layouts 
    | directory.
    |
    | Required: 
    | $view -     the tempalte to render as normally would
    |                with $this->load->view('template');
    |
    | Optional:
    | $data -        the data to be rendered with the template
    |
    | $layout -     the template to render, defaults to default
    |
    | $layoutData -    data to be included in the layout, DO NOT
    |                USE content_for_layout in the $layoutData
    |                array
    |
    +------------------------------------------------------------*/
    public function layout($view, $vars = array(), $layoutData = array()){
        
        $CI =& get_instance();
        $CI->config->load('layout', true);
        
        //load default config
        $defaults_layout = $CI->config->item('layout');
        
        //join default and data from parameter function obtaining unique config
        $data = array_merge($defaults_layout, $layoutData);
        
        $data['content_layout'] = $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => true));

        $this->_ci_load(array('_ci_view' => $data['layout_dir']."/".$data['layout_default'], '_ci_vars' => $this->_ci_object_to_array($data), '_ci_return' => false));
        
    }  
    
    /**
     * Load View - MODIFIED VERSION
     *
     * This function is used to load a "view" file.  It has three parameters:
     *
     * 1. The name of the "view" file to be included.
     * 2. An associative array of data to be extracted for use in the view.
     * 3. TRUE/FALSE - whether to return the data or load it.  In
     * some cases it's advantageous to be able to return data so that
     * a developer can process it in some way.
     *
     * @param	string
     * @param	array
     * @param	bool
     * @return	void
     * @access public
     */
    public function view($view, $vars = array(), $return = FALSE)
    {        
        $CI =& get_instance();
        $CI->config->load('layout', true);
        $data_layout = $CI->config->item('layout');
        
        if (empty($vars) || !isset($vars['layout']))
            $data = $data_layout;
        else
            $data = $this->parse_arguments($data_layout, $vars['layout']);
        
        unset($data_layout);

        $CI->javascript->external();
        $CI->javascript->output('');
        $CI->javascript->compile();
        
        $CI->css->compile();

        if ($data['layout_use'] === true) {
                        
            $this->layout($view, $vars);
            
        }
        else 
            return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }
    
    
    /**
     * Join args
     * 
     * @param array $args
     * @param array $defaults
     * @return array 
     * @access private
     */
    private function parse_arguments($args, $defaults) {    
        //join default and data from parameter function obtaining unique config
        $data = array_merge($args, $defaults);
        return $data;
    }
	
	/**
	 * Add paths to model array to load from outsiude
	 * 
	 * @param string $path Path to model
	 * @return void
	 * @access public
	 */
	public function add_model_path($path) {
		
		array_unshift($this->_ci_model_paths, $path);
		
	}

	/**
	 * Add paths to helper array to load from outsiude
	 * 
	 * @param string $path Path to helper
	 * @return void
	 * @access public
	 */
	public function add_helper_path($path) {
		
		array_unshift($this->_ci_helper_paths, $path);
		
	}
    
}

/* End of file RF_Loader.php */
/* Location: ./application/core/RF_Loader.php */