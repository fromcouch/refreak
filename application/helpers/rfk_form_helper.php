<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('form_dropdown_users')) {    
        function form_dropdown_users($class = '', $first_option = null, $selected=0,$name = null) {

                $CI =& get_instance();

                $ret = '<select class="' . $class . '"';
                
                if (!is_null($name)) {
                    $ret .= ' name = "' . $name . '"';
                }
                    
                $ret .= '>';
                
                if (!is_null($first_option))
                    $ret .= '<option value="0">' . $first_option . '</option>';

                foreach ($CI->data['users'] as $list_user) {
                    $ret .= '            <option value="' . $list_user->id . '"';
                    
                    if($selected != 0 && $selected == $list_user->id)
                        $ret .= ' selected="selected"';
                    
                    $ret .= '>';
                    $ret .= $list_user->first_name . ' ' . $list_user->last_name . "</option>\n";
                }

                $ret .= '</select>';

                return $ret;
        }
}

/* End of file rfk_form_helper.php */
/* Location: ./application/helpers/rfk_form_helper.php */