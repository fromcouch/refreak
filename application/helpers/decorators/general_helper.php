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
    
    public static function table_sheet($content) {
        
        $table = '<table cellpadding="2" cellspacing="1" border="0" class="sheet task_sheet" width="100%">' . $content . '</table>';

        return $table;
        
    }
    
}

?>
