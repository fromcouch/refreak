<?php //copied from tf ?>
        <div class="task_show_menu">
            <div id="task_show_close">
                <a href="#">
                    <?php echo $this->lang->line('task_show_close'); ?>
                    <img src="<?php echo base_url();?>theme/default/images/b_disn.png" width="20" height="16" border="0" alt="close" />
                </a>
            </div>
            <div id="task_show_edit">
                <a href="#"><?php echo $this->lang->line('task_show_edit'); ?>
                    <img src="<?php echo base_url();?>theme/default/images/b_edin.png" width="20" height="16" border="0" alt="edit" />
                </a>
            </div>
            <div id="task_show_delete">
                <a href="#" onClick="return confirm('<?php echo $this->lang->line('task_show_delete_confirm');  ?>')">
                    <?php echo $this->lang->line('task_show_delete');  ?>
                    <img src="<?php echo base_url();?>theme/default/images/b_deln.png" width="20" height="16" border="0" alt="delete" />
                </a>
            </div>
        </div>
        <div class="task_show_priority">
            <div class="label"><?php echo $this->lang->line('task_show_priority'); ?></div>
            <div class="vprio">
                <span class="task_pr<?php echo $tf['priority']; ?>"><?php echo $tf['priority']; ?></span>
            </div>
        </div>
        <div class="task_show_content">
    	    <div class="label"><?php echo $this->lang->line('task_show_deadline'); ?></div>
            <div id="vdead"><?php echo RFK_Task_Helper::calculate_deadline($tf['deadline_date'], $tf['status']); ?></div>
        </div>
        <div class="task_show_content">
            <div class="label"><?php echo $this->lang->line('task_show_context'); ?></div>
            <div class="task_ctx<?php echo $context_letter; ?>">
                <?php echo $context[$tf['context']]; ?>
            </div>
        </div>
        <div class="task_show_project">
            <div class="label"><?php echo $this->lang->line('task_show_project'); ?></div>
            <div class="vproj"><?php echo $project_name; ?></div>
        </div>        
        <div class="task_show_title">
    	    <div class="label"><?php echo $this->lang->line('task_show_title'); ?></div>
            <div class="vtitl"><?php echo $tf['title']; ?></div>
        </div>
    	<div class="task_show_user">
            <div class="label"><?php echo $this->lang->line('task_show_user'); ?></div>
            <div class="vuser"><?php echo $username ?></div>
        </div>
        <div class="task_show_visibility">
            <div class="label"><?php echo $this->lang->line('task_show_visibility'); ?></div>
            <div class="vvisi">
                    <?php                         
                        echo $visibility[$tf['private']];
                        
                        if ($tf['private'] > 0) : ?>
                            <img src="<?php echo base_url();?>theme/default/images/priv<?php echo $tf['private']; ?>.png" width="12" height="16" align="absmiddle" border="0" alt="" />
                    <?php endif; ?>
            </div>
        </div>
        <div class="tabmenu">
            <ul>
		<li id="tdesc" class="active"><a href="javascript:freak_more('desc')"><?php echo $this->lang->line('task_show_tab_description'); ?></a></li>
                <li id="tcomm"><a href="javascript:freak_more('comm')"><?php echo $this->lang->line('task_show_tab_comment'); ?></a></li>
                <li id="thist"><a href="javascript:freak_more('hist')"><?php echo $this->lang->line('task_show_tab_history'); ?></a></li>
            </ul>
	</div>
	<div class="tabcontent">
                <div class="tabcontent_content">
                    <div class="tabcontent_edit">
                            <div>
                                    <input type="hidden" name="veditid" value="" />
                                    <textarea id="veditbody" name="veditbody"></textarea>
                            </div>
                            <div>
                                    <input type="submit" name="veditsubmit" value="<?php echo $this->lang->line('task_show_tab_save'); ?>"> &nbsp;
                                    <input type="button" name="veditcancel" value="<?php echo $this->lang->line('task_show_tab_cancel'); ?>">
                            </div>
                    </div>
                    <div id="vmore"></div>
                </div>
	</div>
        <div class="task_show_status">
            <div class="label2"><?php echo $this->lang->line('task_show_status'); ?></div>
            <div class="task_show_status_inside">
                <?php                
                        $st = $tf['status'];
                        if (empty($st)) $st = 0; //i have problems passing zero vales to views :/
                        echo $status[$st];
                ?>
            </div>
        </div>
