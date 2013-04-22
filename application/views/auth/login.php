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
            <h1>Login</h1>
            
            <div class="info_message"><?php echo $message;?></div>

            <?php echo form_open("auth/login");?>

              <p>
                <label for="identity">Email/Username:</label>
                <?php echo form_input($identity);?>
              </p>

              <p>
                <label for="password">Password:</label>
                <?php echo form_input($password);?>
              </p>

              <p>
                <label for="remember">Remember Me:</label>
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
              </p>


              <p class="button"><?php echo form_submit('submit', 'Login');?></p>

            <?php echo form_close();?>

            <p><a href="forgot_password">Forgot your password?</a></p>

        </div>
    </div>
    <footer class="footer">
            Refreak! <?php echo $this->lang->line('version'); ?> - <?php echo $this->lang->line('release_date'); ?> - <a href="https://github.com/fromcouch/refreak/" target="_blank">Visit on Github</a>
    </footer>
</body>
</html>