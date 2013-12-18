<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -------------------------------------------------------------------
|  Locale
| -------------------------------------------------------------------
*/
//deprecated
//$config['rfk_locale'] = 'es_ES';

/*
| -------------------------------------------------------------------
|  theme directory
| -------------------------------------------------------------------
*/
$config['rfk_theme_dir'] = 'theme';

/*
| -------------------------------------------------------------------
|  actual theme
| -------------------------------------------------------------------
*/
$config['rfk_theme_selected'] = 'default';

/*
| -------------------------------------------------------------------
|  Short Date
|    
| TZN_DATE_SHT %d %b %y         -- by default on TF
| TZN_DATE_SHX %a %d %b %y
|
| -------------------------------------------------------------------
*/
$config['rfk_short_date'] = '%d %b %y';

/*
| -------------------------------------------------------------------
|  Long Date
| 
| TZN_DATE_LNG %d %B %Y
| TZN_DATE_LNX %A %d %B %Y
| TZN_DATETIME_EUR %d/%m/%y %H:%M
| TZN_DATETIME_USA %m/%d/%y %I:%M%p
| TZN_DATETIME_SHT %d %b %y %H:%M
| TZN_DATETIME_SHX %a %d %b %y %H:%M  -- by default on TF
| TZN_DATETIME_LNG %d %B %Y, %H:%M
| TZN_DATETIME_LNX %A %d %B %Y, %H:%M   
| -------------------------------------------------------------------
*/
$config['rfk_long_date'] = '%a %d %b %y %H:%M';

/*
| -------------------------------------------------------------------
|  Datediff mode for tasks
|  deadline: displays day of the week (or tomorrow) or '1 day'
|  
|  posible values: day, diff, date 
| -------------------------------------------------------------------
*/
$config['rfk_datediff_mode'] = 'day';

/*
| -------------------------------------------------------------------
|  Datediff mode for tasks
|  deadline: displays 'tomorrow' for next day 
|  
|  posible values: day, diff, date 
| -------------------------------------------------------------------
*/
$config['rfk_datediff_tomorrow'] = TRUE;

/*
| -------------------------------------------------------------------
|  Default task Visibility
|  
|  
|  posible values:  0 - public
|                   1 - internal (default)
|                   2 - private
| -------------------------------------------------------------------
*/
$config['rfk_task_visibility'] = 1;

/*
| -------------------------------------------------------------------
|  Update deadline on complete task
|  
|  
|  posible values:  TRUE, FALSE
| -------------------------------------------------------------------
*/
$config['rfk_complete_deadline'] = TRUE;

/*
| -------------------------------------------------------------------
|  Status levels
|  
|  
|  posible values:  1 to 5
| -------------------------------------------------------------------
*/
$config['rfk_status_levels'] = 5;

/*
| -------------------------------------------------------------------
|  Subtasks
|  
|  
|  posible values:  TRUE, FALSE
| -------------------------------------------------------------------
*/
$config['rfk_subtasks'] = FALSE;

/* End of file refreak.php */
/* Location: ./application/config/refreak.php */
