
<pre>
<?php
print_r($plg);
?>
</pre>
<?php
        echo validation_errors(); 
        echo form_open("plugin/xxx/".$pid);

        echo $form;
        
        echo form_close();