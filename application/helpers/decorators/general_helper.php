<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * General Decorator Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	decorator
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class general_helper {
    
    /**
     * Retrun table html code
     * 
     * @param string $content content to have table
     * @return string content with table bundle
     */
    public static function table_sheet($content) {
        
        $table = '<table cellpadding="2" cellspacing="1" border="0" class="sheet task_sheet" width="100%">' . $content . '</table>';

        return $table;
        
    }
    
}

/* End of file general_helper.php */
/* Location: ./application/helpers/decorators/general_helper.php */