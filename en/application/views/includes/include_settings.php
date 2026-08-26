     		        <table  cellpadding="4" cellspacing="0" class="col-xs-12 col-md-8 col-md-offset-2 "> 
     		        <tr align="center"> <td colspan="2">Show / Hide your <?=ucfirst($module)?> Records Settings you do like to update/upload.</td></tr>
       		        <tr align="center"> <td colspan="2"><input type="hidden" name="module" id="set_mod" value="<?=$module?>" ></td></tr>
			 <?php  foreach($settings as $row){ 
			 $checked = ($row["SettingValue"] == "Y") ? 'checked="checked"' : ""; ?>
	                <tr>
                          <td width="33%" align="right">
                        <input name="account_setting_id[]"  id="account_setting_id_arr" type="checkbox" value="<?=$row["AccountSettingId"] ?>"  <?= $checked ?> >
                    </td>
                    <td width="67%" align="left"><div class=""><?= $row["Setting"] ?></div></td>
                </tr>
		<?php } ?>
		     <tr>
                          <td width="67%" align="right">
                          </td>
                          <td width="67%" align="left">
                            <input name="save"  id="setting_save" type="submit" value="Save" class="btn btn-primary">
                         </td>
                     </tr>
		</table>
