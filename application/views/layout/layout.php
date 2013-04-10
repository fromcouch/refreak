<!doctype html>
<html lang="en">
<head>
	<title>Refreak</title>
        <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
        <?php   //render css links
                if (isset($css_link_src)) echo $css_link_src;         
                //render script tags
                if (isset($library_src)) echo $library_src;
        ?>
        <script type="text/javascript">
            <?php   //render search vars
                    if (isset($js_vars)) echo $js_vars 
            ?>
        </script>
</head>
<body>
    <header class="head">
        <header class="header">
            <div class="userlogout">
                <a href="<?php echo site_url();?>/auth/logout" title="<?php echo $this->lang->line('header_logout'); ?>">
                    <img class="header-logout" src="<?php echo base_url();?>theme/default/images/logout-off.png" width="13" height="13" border="0" onmouseover="this.src='<?php echo base_url();?>theme/default/images/logout-on.png'" onmouseout="this.src='<?php echo base_url();?>theme/default/images/logout-off.png'" />
                </a>
            </div>
            <div class="user">
                <div class="username"><a href="<?php echo site_url();?>/users/edit_user/<?php echo $actual_user->id; ?>"><?php echo $actual_user->first_name.' '.$actual_user->last_name; ?></a></div>
                <div class="userdate"><?php echo actual_text_date(); ?></div>
            </div>
        </header>
        <nav>
            <?php echo ul($menu_left,   array('class' => 'nav')); 
                  echo ul($menu_right,  array('class' => 'navright')); ?>
        </nav>
    </header>
    <div class="content">
        <?php

            echo $content_layout;

        ?>
    </div>
    <footer class="footer">
        ReFreak! v0.1 Beta - Released on 2013-04-15
    </footer>
    <?php if (isset($script_foot)) echo $script_foot;?>
    <script type="text/javascript">
        (function($){
            
            $('.list_users').on('change', function() {
                var local_url = s_url + '/tasks/s/' + project_id + "/" + 
                                        $(this).val() + "/" + 
                                        time_concept + "/" + 
                                        context_id + "/";
                document.location = local_url;                    
            });
            
            $('.list_contexts').on('change', function() {
                var local_url = s_url + '/tasks/s/' + project_id + "/" + 
                                        user_id + "/" + 
                                        time_concept + "/" + 
                                        $(this).val() + "/";
                document.location = local_url;                    
            });
            
            $(".menu_new_task").on('click', function( event ) {
                
                $(".task_panel").newTask({ task_id: 0 });
                
            });
            
        })(jQuery);
    </script>
</body>
</html>