<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Projects refreak - English
*
* Created:  10-10-2012
*
* Description:  English language file for refreak layout
*
*/
/**
 * Projects language
 *
 * @package	Refreak
 * @subpackage	project
 * @category	language
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */

//Projects table
$lang['projectstable_project']         = 'Project';
$lang['projectstable_position']        = 'Position';
$lang['projectstable_members']         = 'Members';
$lang['projectstable_status']          = 'Status';
$lang['projectstable_tasks']           = 'Tasks';
$lang['projectstable_action']          = 'Action';
$lang['projectstable_confirmdelete']   = 'really delete this user?';
$lang['projectstable_new']             = 'New';
$lang['projectstable_nofound']         = '- no project found -';


//Create and edit Project
$lang['projectscrud_info']             = 'Project Info';
$lang['projectscrud_name']             = 'Name:';
$lang['projectscrud_description']      = 'Description:';
$lang['projectscrud_status']           = 'Status:';
$lang['projectscrud_create']           = 'Create Project';
$lang['projectscrud_edit']             = 'Edit Project';

$lang['projectscrud_members']          = 'Project Members';
$lang['projectscrud_add_members']      = 'Add a user to this project';
$lang['projectscrud_select_user']      = '- select user -';
$lang['projectscrud_user']             = 'User';
$lang['projectscrud_position']         = 'Position';
$lang['projectscrud_action']           = 'Action';
$lang['projectscrud_hidden_change']    = 'Change';
$lang['projectscrud_save']             = 'Save Project';
$lang['projectscrud_compulsory']       = 'Fields in <span class="compulsory">red</span> are compulsory.';

//messages
$lang['projectsmessage_created']       = 'Project Created';
$lang['projectsmessage_deleted']       = 'Project Deleted';
$lang['projectsmessage_saved']         = 'Project Saved';
$lang['projectsmessage_remove_user']   = 'really remove this user from the team?';
$lang['projectsmessage_useradded']     = 'User added to project';
$lang['projectsmessage_userremoved']   = 'User removed from project';
$lang['projectsmessage_userchanged']   = 'User position changed';


/*
 *  projects arrays
 */
//project position
$lang['project_position']              = array(	
                                                1	=> 'visitor',	// no action
                                                2	=> 'official',	// add comments
                                                3	=> 'member',	// add tasks, comments and task status
                                                4	=> 'moderator', // add/edit all tasks, comments, project members and status
                                                5	=> 'leader'     // everything
                                        );

// project status
$lang['project_status']                = array(
                                                1 	=> 'New',
                                                2	=> 'Proposal',       
                                                3 	=> 'In Progress',   
                                                4	=> 'Completed',     
                                                5	=> 'Cancelled'      
                                        );