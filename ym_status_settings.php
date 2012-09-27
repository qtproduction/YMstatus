<form method="post" action="options.php">
	<?php settings_fields( 'ym_options' ); ?>
	
    <h1>Yahoo! Messenger Status Settings</h1>
	
    <h3>Choose your status icon:</h3>
    <p>Select from the list your desired Online/Offline badge. The default Y!M badges available from the webservice are displayed here but if you want your own images displayed, enter the URLs of your online and offline images in the areas provided under 'Custom Image'.</p>
    <table style="width:50%;">
        <thead>
            <tr>
                <th style="width:10%;"></th>
                <th style="width:45%; text-align:center;">Online</th>
                <th style="width:45%; text-align:center;">Offline</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i <= 24; $i++) { ?>      
                <tr>
                    <td style="text-align: center;"><input type="radio" name="ym_status[image]" value="<?php echo $i ?>" title="choice_<?php echo $i ?>" <?php echo ($opts['image'] == $i) ? 'checked="checked" ' : ''; ?>/></td>
                    <td style="text-align: center;"><img src="<?php echo plugins_url("/status_images/".$i."_online.gif", __FILE__) ?>" /></td>
                    <td style="text-align: center;"><img src="<?php echo plugins_url("/status_images/".$i."_offline.gif", __FILE__) ?>" /></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center;"><h4>Custom Image</h4></td>
            </tr>           
        </tbody>
    </table>
</p>

<h3>Default action:</h3>
<p>Choose what clicking the badge does.</p>
<ul>
    <li><input type="radio" name="ym_status[action]" value="sendIM" title="sendIM" <?php echo ($opts['action'] == 'sendIM') ? 'checked="checked" ' : '0'; ?>/> Sends a Message <small>(Opens a Yahoo Messenger chat window with you as the recipient.)</small></li>
    <li><input type="radio" name="ym_status[action]" value="sendweb" title="sendweb" <?php echo ($opts['action'] == 'sendweb') ? 'checked="checked" ' : '0'; ?>/> Sends a Web Message <small>(Opens Yahoo Web Messenger and starts a chat with you.)</small></li>
    <li><input type="radio" name="ym_status[action]" value="addfriend" title="addfriend" <?php echo ($opts['action'] == 'addfriend') ? 'checked="checked" ' : '0'; ?>/> Adds as a Contact <small>(Adds you as a contact on their Yahoo Messenger contact list.)</small></li> 
    <li><input type="radio" name="ym_status[action]" value="call" title="call" <?php echo ($opts['action'] == 'call') ? 'checked="checked" ' : '0'; ?>/> Calls <small>(Starts a voice call with you on Yahoo Messenger.)</small></li>
</ul>

<p class="submit"><input type="submit" name="ym_status_settings_submit" value="<?php _e('Update Options &raquo;', 'ym_status'); ?>" /></p>
</form>