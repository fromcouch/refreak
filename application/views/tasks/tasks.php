<div class="task_panel">
    <img border="0" src="<?php echo base_url();?>theme/default/images/load.gif" class="loader">    
</div>
    <table class="task_sheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
            <thead>
                <tr>
                    <th width="2%">&nbsp;</th>
                    <th width="2%">&nbsp;</th>
                    <th width="15%"><?php echo $this->lang->line('task_list_project'); ?></th>
                    <th width="41%"><?php echo $this->lang->line('task_list_title'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('task_list_user'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('task_list_deadline'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('task_list_comments'); ?></th>
                    <th width="10%" colspan="5"><?php echo $this->lang->line('task_list_status'); ?></th>
                    <th width="5%" class="act">
                        <?php if ($this->ion_auth->in_group(array(1,2))) : ?>
                                <a href="#" class="btn_task_new">
                                        <img src="<?php echo base_url();?>theme/default/images/b_new.png" width="39" height="16" border="0" hspace="3" alt="<?php echo $this->lang->line('task_list_new'); ?>" />
                                </a>
                        <?php endif; ?>
                    </th>
                </tr>
            </thead>
            <tbody class="taskSheetData">
                <?php 
                    if (count($tasks)>0) :
                        $context    = $this->lang->line('task_context');
                        foreach ($tasks as $tf) : 
                        //preparing some data
                            $context_letter     = substr($context[$tf->context], 0, 1);
                ?>
                            <tr data-id="<?php echo $tf->task_id; ?>">
                                <td class="task_prio">
                                    <span class="task_pr<?php echo $tf->priority; ?>"><?php echo $tf->priority; ?></span>
                                </td>
                                <td class="task_ctsh">
                                    <span class="task_ctx<?php echo $context_letter; ?>"><?php echo $context_letter; ?></span>
                                </td>
                                <td><?php echo $tf->project_name; ?></td>
                                <td>
                                    <?php 
                                            echo $tf->title; 
                                            if (!empty($tf->description)) : ?>
                                                <img src="<?php echo base_url();?>theme/default/images/desc.png" width="16" height="16" align="absmiddle" border="0" alt="" />
                                            <?php endif;
                                            if ($tf->private > 0) : ?>
                                                <img src="<?php echo base_url();?>theme/default/images/priv<?php echo $tf->private; ?>.png" width="12" height="16" align="absmiddle" border="0" alt="" />
                                            <?php endif; ?>
                                </td>
                                <td><?php echo $tf->first_name; ?></td>
                                <td><?php echo RFK_Task_Helper::calculate_deadline($tf->deadline_date, $tf->status_key); ?></td>
                                <td>
                                    <div class="comment_count">
                                        <?php echo $tf->comment_count; ?>
                                    </div>
                                    <a href="#" class="comment_link">
                                        <img src="<?php echo base_url();?>theme/default/images/b_disc.png" width="14" height="16" alt="" border="0" />
                                    </a>
                                </td>
                                <?php for ($cont = 0; $cont < 5; $cont++) : 
                                            $sts = ($cont < $tf->status_key) ? (5 - $cont) : 0; ?>
                                <td class="sts<?php echo $sts; ?>" style="cursor:pointer">&nbsp;</td>
                                <?php endfor; ?>
                                <td class="act">
                                    <?php if ($this->ion_auth->in_group(array(1,2)) || $tf->position > 3) : //falta checkear permiso de proyecto ?>
                                        <a href="#" class="btn_task_edit">
                                            <img src="<?php echo base_url();?>theme/default/images/b_edit.png" width="20" height="16" alt="edit" border="0" />
                                        </a>
                                    <?php else : ?>
                                        <img src="<?php echo base_url();?>theme/default/images/b_edin.png" width="20" height="16" alt="del" border="0" />
                                    <?php endif;
                                    // DELETE
                                    if ($this->ion_auth->in_group(array(1,2))  || $tf->position > 3) : //falta checkear permiso de proyecto ?>
                                        <a href="#">
                                            <img src="<?php echo base_url();?>theme/default/images/b_dele.png" width="20" height="16" alt="del" border="0" />
                                        </a>
                                    <?php else : ?>
                                        <img src="<?php echo base_url();?>theme/default/images/b_deln.png" width="20" height="16" alt="del" border="0" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                <?php endforeach; 
                else : ?>
                            <tr class="nothanks">
                                <td colspan="14">
                                    <p>&nbsp;</p>
                                    <p align="center">- <?php echo $this->lang->line('task_list_comments'); ?> -</p>
                                    <?php
                                        if ($this->ion_auth->in_group(array(1,2))) :
                                            ?>
                                            <p align="center">
                                                <a href="#" class="btn_task_new">
                                                    <img src="<?php echo base_url();?>theme/default/images/b_new.png" width="39" height="16" border="0" hspace="3" alt="<?php echo $this->lang->line('task_list_new'); ?>" />
                                                </a>                                            
                                            </p>
                                            <?php
                                        endif;
                                    ?>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                </td>
                            </tr>
                <?php endif; ?>
            </tbody>
    </table>
<script type="text/javascript">

    (function($) {
        
        $(".task_sheet").tablesorter({
                0: { 
                    sorter: false 
                }, 
                1: { 
                    sorter: false 
                }, 
                7: { 
                    sorter: false 
                }, 
                8: { 
                    sorter: false 
                },
                cssHeader: "table_headers"
        });
        
        $('.btn_task_new').on('click', function(event) {
                
                //prevent call tr event
                event.stopPropagation();
                // 0 means new task
                edittask(0);
           
        });
        
        $('.btn_task_edit').on('click', function(event) {

                //prevent call tr event
                event.stopPropagation();

                var task_id = $(this).parents("tr").attr("data-id");
                edittask(task_id);
           
        });
        
        $(".task_sheet tbody").on("click", "tr", function () {
                
                var task_id = $(this).attr("data-id");
                
                $('.task_panel').showTask({ task_id: task_id });
           
                
                
        });
        
        function edittask(task_id) {
                
                $(".task_panel").newTask({ task_id: task_id });
                
        }
    })(jQuery);

</script>