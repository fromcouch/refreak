<?php if (!empty($message)) : ?>
<div class="error_box"><?php echo $message;?></div>
<?php endif; ?>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                <th width="25%"><?php echo $this->lang->line('pluginstable_name'); ?></th>                
                <th width="37%"><?php echo $this->lang->line('pluginstable_directory'); ?></th>
                <th width="15%"><?php echo $this->lang->line('pluginstable_section'); ?></th>
                <th width="15%"><?php echo $this->lang->line('pluginstable_observations'); ?></th>		
                <th width="10%" style="text-align:center">
                    <?php echo $this->lang->line('pluginstable_action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plugins as $table_plugin) : 
                        $plugin_status  = $table_plugin->active ? 'enay' : 'disy';
                        $url_active     = $table_plugin->active ? 'deactivate' : 'activate';
                        $tr_class       = $table_plugin->active ? '' : ' disabled';
			$tr_class	.= $table_plugin->installed ? '' : ' not-installed';
			$tr_class	.= $table_plugin->dir_exists ? '' : ' not-dir';
			
            ?>
            <tr class="<?php echo $tr_class; ?>">
		<?php if ($table_plugin->dir_exists && $table_plugin->installed) : ?>
		    <td><a href="<?php echo site_url();?>plugin/config/<?php echo $table_plugin->id;?>"><?php echo $table_plugin->name ?></a></td>
		<?php else : ?>
		    <td><?php echo $table_plugin->name ?></td>
		<?php endif; ?>		    
                <td><?php echo $table_plugin->directory; ?></td>
                <td><?php echo empty($table_plugin->controller_name) ? $this->lang->line('pluginstable_all') : $table_plugin->controller_name; ?></td>
		<td>
		    <?php 
		    if (!$table_plugin->dir_exists) :
				echo $this->lang->line('pluginsmessage_notexist').'<br/>';
		    endif;
		    if (!$table_plugin->installed) :
				echo $this->lang->line('pluginsmessage_notinstalled');
		    endif;
		    ?>
		</td>
                <td align="center">
                        <?php if ($this->ion_auth->is_admin() && ($table_plugin->dir_exists && $table_plugin->installed)) : ?>
                            <a href="<?php echo site_url();?>plugin/<?php echo $url_active;?>/<?php echo $table_plugin->id;?>">
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $plugin_status; ?>.png" />
                            </a>
			    
			    <a href="<?php echo site_url();?>plugin/config/<?php echo $table_plugin->id;?>">
				<img src="<?php echo base_url() . $theme;?>/images/b_edit.png" width="20" height="16" border="0" />
			    </a>
                        <?php else : ?>
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $plugin_status; ?>.png" />
				<img src="<?php echo base_url() . $theme;?>/images/b_edin.png" width="20" height="16" border="0" />
                        <?php endif; 
                        			    
			if ($this->ion_auth->is_admin()) :                                                    
                        ?>
                            <a href="<?php echo site_url();?>plugin/delete/<?php echo $table_plugin->id;?>"><img src="<?php echo base_url() . $theme;?>/images/b_dele.png" width="20" height="16" border="0" /></a>
                        <?php else : ?>
                            <img src="<?php echo base_url() . $theme;?>/images/b_deln.png" width="20" height="16" border="0" />
                        <?php endif;
			
			if ($this->ion_auth->is_admin() && !$table_plugin->installed) :                                                    
                        ?>
                            <a href="<?php echo site_url();?>plugin/install/<?php echo $table_plugin->directory;?>"><img src="<?php echo base_url() . $theme;?>/images/raz.png" width="20" height="16" border="0" /></a>                        
                        <?php endif; ?>
                            
                </td>
            </tr>
            <?php endforeach; ?>	   
        </tbody>
</table>        