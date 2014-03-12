<!doctype html>
<html lang="en">
<head>
	<title>Refreak</title>
        <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . $theme;?>/css/login.css" />
</head>
<body>
    
    <div class="container">
        <div class="horiz">
            <img src="../theme/default/images/freak-logo.png" border="0" alt="Refreak" />
            <p>Please enter your email address so we can<br/> send you an email to reset your password.</p>

            <div class="info_message"><?php echo $message;?></div>

            <?php echo form_open("auth/forgot_password/");?>

                  <p>
                        <label>Email Address:</label>
                        <?php echo form_input($email);?>
                  </p>

                  <p class="button"><?php echo form_submit('submit', 'Send');?></p>

            <?php echo form_close();?>

        </div>
    </div>
    <footer class="footer">
            Refreak! <?php echo $this->lang->line('version'); ?> - <?php echo $this->lang->line('release_date'); ?> - <a href="https://github.com/fromcouch/refreak/" target="_blank">Visit on Github</a>
    </footer>
</body>
</html>