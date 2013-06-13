<?php if (!empty($message)) : ?>
<div id="infoMessage"><?php echo $message;?></div>
<?php endif; ?>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                <th width="25%"><?php echo $this->lang->line('pluginstable_name'); ?></th>                
                <th width="50%"><?php echo $this->lang->line('pluginstable_directory'); ?></th>
                <th width="10%" style="text-align:center">
                    <?php echo $this->lang->line('pluginstable_action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plugins as $table_plugin) : 
                        $plugin_status  = $table_plugin->active ? 'enay' : 'disy';
                        $url_active     = $table_plugin->active ? 'deactivate' : 'activate';
                        $tr_class       = $table_plugin->active ? '' : 'class = "disabled"';
            ?>
            <tr <?php echo $tr_class; ?>>
                <td><a href="<?php echo site_url();?>plugin/config/<?php echo $table_plugin->id;?>"><?php echo $table_plugin->name ?></a></td>
                <td><?php echo $table_plugin->directory; ?></td>
                <td align="center">
                        <?php if ($this->ion_auth->is_admin()) : ?>
                            <a href="<?php echo site_url();?>plugin/<?php echo $url_active;?>/<?php echo $table_plugin->id;?>">
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $plugin_status; ?>.png" />
                            </a>
                        <?php else : ?>
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $plugin_status; ?>.png" />
                        <?php endif; 
                        
                        if ($this->ion_auth->is_admin()) :                                                    
                        ?>
                            <a href="<?php echo site_url();?>plugin/config/<?php echo $table_plugin->id;?>"><img src="<?php echo base_url() . $theme;?>/images/b_edit.png" width="20" height="16" border="0" /></a>
                        <?php else : ?>
                            <img src="<?php echo base_url() . $theme;?>/images/b_edin.png" width="20" height="16" border="0" />
                        <?php endif; ?>
                            
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>        