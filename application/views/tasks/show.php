<? php //copied from tf ?>
        <div class="task_show_menu">
            <div id="task_show_close"><a href="#"><?php echo $GLOBALS['langForm']['close']; ?><img src="skins/<?php echo FRK_SKIN_FOLDER; ?>/images/b_disn.png" width="20" height="16" border="0" alt="close" /></a></div>
            <div id="task_show_edit"><a href="#"><?php echo $GLOBALS['langForm']['edit']; ?><img src="skins/<?php echo FRK_SKIN_FOLDER; ?>/images/b_edin.png" width="20" height="16" border="0" alt="edit" /></a></div>
            <div id="task_show_delete"><a href="#" onClick="return confirm('<?php echo $GLOBALS['langMessage']['task_delete_confirm']; ?>')"><?php echo $GLOBALS['langForm']['delete']; ?><img src="skins/<?php echo FRK_SKIN_FOLDER; ?>/images/b_deln.png" width="20" height="16" border="0" alt="delete" /></a></div>
        </div>
        <div class="task_show_priority">
            <div class="flabel"><?php echo $GLOBALS['langForm']['priority']; ?></div>
			<div id="vprio"><span class="pr<?php  echo $objTask->priority; ?>"><?php echo $objTask->priority; ?></span></div>
        </div>
        <div class="task_show_content">
    	    <div class="flabel"><?php echo $GLOBALS['langForm']['deadline']; ?></div>
			<div id="vdead"><?php echo $objTask->getDeadline(); ?></div>
        </div>
		<?php
			if (@constant('FRK_CONTEXT_ENABLE')) {
		?>
        <div class="task_show_content">
			<div class="flabel"><?php echo $GLOBALS['langForm']['context']; ?></div>
			<div id="vctxt"><span style="color:<?php echo $GLOBALS['confContext'][$objTask->context]; ?>"><?php
				echo $GLOBALS['langItemContext'][$objTask->context]; ?></span></div>
        </div>
		<?php
			}
		?>
        <div class="task_show_project">
            <div class="flabel"><?php echo $GLOBALS['langForm']['project']; ?></div>
			<div id="vproj"><?php echo $objTask->project->get('name','-'); ?></div>
        </div>        
        <div class="task_show_title">
    	    <div class="flabel"><?php echo $GLOBALS['langForm']['title']; ?></div>
			<div id="vtitl"><?php
				$objTask->p('title');
			?></div>
        </div>
    	<div class="task_show_user">
            <div class="flabel"><?php echo $GLOBALS['langForm']['user']; ?></div>
			<div id="vuser"><?php echo $objTask->member->getName('-'); ?></div>
        </div>
        <div class="task_show_visibility">
            <div class="flabel"><?php echo $GLOBALS['langForm']['visibility']; ?></div>
			<div id="vvisi"><?php
				$strVisi = $GLOBALS['langForm']['public'];
				switch ($objTask->showPrivate) {
					case 1:
						$strVisi = $GLOBALS['langForm']['internal'];
						$strVisi .= ' <img src="skins/'.FRK_SKIN_FOLDER
							.'/images/priv1.png" width="12" height="16" align="absmiddle" border="0" alt="" />';
						break;
					case 2:
						$strVisi = $GLOBALS['langForm']['private'];
						$strVisi .= ' <img src="skins/'.FRK_SKIN_FOLDER
							.'/images/priv2.png" width="12" height="16" align="absmiddle" border="0" alt="" />';
						break;
				}
				echo $strVisi;
			?></div>
        </div>
        <div class="tabmenu">
            <ul>
		<li id="tdesc" class="active"><a href="javascript:freak_more('desc')"><?php echo $GLOBALS['langTaskDetails']['tab_description']; ?></a></li>
                <li id="tcomm"><a href="javascript:freak_more('comm')"><?php echo $GLOBALS['langTaskDetails']['tab_comments']; ?></a></li>
                <li id="thist"><a href="javascript:freak_more('hist')"><?php echo $GLOBALS['langTaskDetails']['tab_history']; ?></a></li>
            </ul>
	</div>
	<div class="tabcontent">
		<div id="vedit">
			<div><input type="hidden" name="veditid" value="" /><textarea id="veditbody" name="veditbody"></textarea></div>
			<div>
				<input type="submit" name="veditsubmit" value="<?php echo $GLOBALS['langForm']['save']; ?>"> &nbsp;
				<input type="button" name="veditcancel" value="<?php echo $GLOBALS['langForm']['cancel']; ?>" onClick="freak_body_edit()">
			</div>
		</div>
		<div id="vmore"></div>
	</div>
        <div class="task_show_status">
            <div class="flabel2"><?php echo $GLOBALS['langForm']['status']; ?></div>
            <div id="vsts"><?php
				echo $GLOBALS['langItemStatus'][$objTask->itemStatus->statusKey]
            ?></div>
        </div>
