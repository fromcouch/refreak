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
            
            <?php 
                  echo layout_helper::header(site_url() . 'auth/logout',
                                             $this->lang->line('header_logout'), 
                                             base_url() . $theme, 
                                             site_url() . 'users/edit_user/',
                                             $actual_user);
            ?>                        
            <div>
                <a href="<?php echo site_url();?>"><img width="166" height="30" border="0" alt="Refreak" src="<?php echo base_url() . $theme;?>/images/logo.png"></a>
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
        <?php
            if (is_dir('install')) {
                echo '<p class="footer_error">' . $this->lang->line('footer_install_dir') . '</p>';
            }
        ?>
            Refreak! v0.1.1 Beta - 2013-07-31 - <a href="https://github.com/fromcouch/refreak/issues/" target="_blank">Visit on Github</a>
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
            <?php if($this->ion_auth->in_group(array(1,2))) : ?>
            $(".menu_new_task").on('click', function( event ) {
                
                $(".task_panel").newTask({ task_id: 0 });
                
            });
            <?php endif; ?>
        })(jQuery);
    </script>
</body>
</html>