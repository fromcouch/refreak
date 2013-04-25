<!doctype html>
<html lang="en">
<head>
	<title>Refreak</title>
        <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
        <link rel="stylesheet" type="text/css" href="../theme/default/css/login.css" />
</head>
<body>
    
    <div class="container">
        <div class="horiz">
            <img src="../theme/default/images/freak-logo.png" border="0" alt="Refreak" />
            <h1>Change Password</h1>

            <div id="infoMessage"><?php echo $message;?></div>

            <?php echo form_open("auth/change_password");?>

                  <p>Old Password:<br />
                  <?php echo form_input($old_password);?>
                  </p>

                  <p>New Password (at least <?php echo $min_password_length;?> characters long):<br />
                  <?php echo form_input($new_password);?>
                  </p>

                  <p>Confirm New Password:<br />
                  <?php echo form_input($new_password_confirm);?>
                  </p>

                  <?php echo form_input($user_id);?>
                  <p><?php echo form_submit('submit', 'Change');?></p>

            <?php echo form_close();?>
        </div>
    </div>
    <footer class="footer">
            Refreak! <?php echo $this->lang->line('version'); ?> - <?php echo $this->lang->line('release_date'); ?> - <a href="https://github.com/fromcouch/refreak/" target="_blank">Visit on Github</a>
    </footer>
</body>
</html>