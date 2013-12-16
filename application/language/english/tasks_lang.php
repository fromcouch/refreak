<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Tasks refreak - English
*
* Created:  10-10-2012
*
* Description:  English language file for refreak layout
*
*/
/**
 * Tasks language
 *
 * @package	Refreak
 * @subpackage	tasks
 * @category	language
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */

//Users table
$lang['task_edit_priority']             = 'Priority';
$lang['task_edit_context']              = 'Context';
$lang['task_edit_deadline']             = 'Deadline';
$lang['task_edit_project']              = 'Project';
$lang['task_edit_project_new']          = 'new project?';
$lang['task_edit_project_list']         = 'show list';
$lang['task_edit_title']                = 'Title';
$lang['task_edit_description']          = 'Description';
$lang['task_edit_user']                 = 'User';
$lang['task_edit_public']               = 'public';
$lang['task_edit_internal']             = 'internal';
$lang['task_edit_private']              = 'private';
$lang['task_edit_status']               = 'Status';
$lang['task_edit_save']                 = 'Save';
$lang['task_edit_cancel']               = 'Cancel';
$lang['task_edit_project_none']         = '- - - - - - - - -';


//tasks list
$lang['task_list_project']              = 'Project';
$lang['task_list_title']                = 'Title';
$lang['task_list_user']                 = 'User';
$lang['task_list_deadline']             = 'Deadline';
$lang['task_list_comments']             = 'Comments';
$lang['task_list_status']               = 'Status';
$lang['task_list_new']                  = 'New Task';
$lang['task_list_no_task']              = 'no task match your criterions';
$lang['task_list_create_task']          = 'Click here to make an attempt to create one';
$lang['task_list_close_task']           = 'Really close this task?';

//messages
$lang['tasksmessage_created']                = 'task created!';
$lang['tasksmessage_updated']                = 'task updated!';
$lang['tasksmessage_deleted']                = 'task deleted!';


//info panel
$lang['task_show_close']                = 'close';
$lang['task_show_edit']                 = 'edit';
$lang['task_show_delete']               = 'delete';
$lang['task_show_delete_confirm']       = 'Really delete this task?';
$lang['task_show_priority']             = 'Priority';
$lang['task_show_deadline']             = 'Deadline';
$lang['task_show_context']              = 'Context';
$lang['task_show_project']              = 'Project';
$lang['task_show_title']                = 'Title';
$lang['task_show_user']                 = 'User';
$lang['task_show_visibility']           = 'Visibility';
$lang['task_show_tab_description']      = 'description';
$lang['task_show_tab_comment']          = 'comment';
$lang['task_show_tab_history']          = 'history';
$lang['task_show_tab_save']             = 'save';
$lang['task_show_tab_cancel']           = 'cancel';
$lang['task_show_status']               = 'status';
$lang['task_show_delete_comment_confirm']       = 'Really delete this comment?';
$lang['task_show_parent']               = 'Parent';
$lang['task_show_subtasks']             = 'Subtasks';

/*
 *  projects arrays
 */
// task status
$lang['task_status']                    = array(
                                                0	=> '0%',
                                                1	=> '20%',
                                                2	=> '40%',
                                                3	=> '60%',
                                                4	=> '80%',
                                                5	=> '100%'
);

// contexts
$lang['task_context']                   = array(
                                                1       => 'Work',
                                                2       => 'Meeting',
                                                3       => 'Document',
                                                4       => 'Internet',	
                                                5       => 'Phone',
                                                6       => 'Email',
                                                7       => 'Home',
                                                8       => 'Other'
);

//priority
$lang['task_priority']                  = array(
                                                1       => 'Urgent!',
                                                2       => 'High priority',
                                                3       => 'Medium priority',
                                                4       => 'Normal priority',	
                                                5       => 'Low priority',
                                                6       => 'Low priority',
                                                7       => 'Very Low priority',
                                                8       => 'Very Low priority',
                                                9       => 'Whatever'
);

//task visivility
$lang['task_visibility']                = array(
                                                0       => 'public',
                                                1       => 'internal',
                                                2       => 'private'
);

//date
$lang['task_date'] = array (
	'today'				=> 'today',
	'tomorrow'			=> 'tomorrow',
	'days'				=> 'days',
	'day'				=> 'day',
	'weeks'				=> 'weeks',
	'week'				=> 'week',
	'months'			=> 'months',
	'month'				=> 'month',
	'years'				=> 'years',
	'year'				=> 'year',
	'january'			=> 'january',
	'february'			=> 'february',
	'march'				=> 'march',
	'april'				=> 'april',
	'may'				=> 'may',
	'june'				=> 'june',
	'july'				=> 'july',
	'august'			=> 'august',
	'september'			=> 'september',
	'october'			=> 'october',
	'november'			=> 'november',
	'december'			=> 'december',
	'jan'				=> 'jan',
	'feb'				=> 'feb',
	'mar'				=> 'mar',
	'apr'				=> 'apr',
	'may'				=> 'may',
	'jun'				=> 'jun',
	'jul'				=> 'jul',
	'aug'				=> 'aug',
	'sep'				=> 'sep',
	'oct'				=> 'oct',
	'nov'				=> 'nov',
	'dec'				=> 'dec',
	'monday'			=> 'monday',
	'tuesday'			=> 'tuesday',
	'wednesday'			=> 'wednesday',
	'thursday'			=> 'thursday',
	'friday'			=> 'friday',
	'saturday'			=> 'saturday',
	'sunday'			=> 'sunday',
	'mon'				=> 'mon',
	'tue'				=> 'tue',
	'wed'				=> 'wed',
	'thu'				=> 'thu',
	'fri'				=> 'fri',
	'sat'				=> 'sat',
	'sun'				=> 'sun'
);