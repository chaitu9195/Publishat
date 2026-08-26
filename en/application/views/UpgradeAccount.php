<?php
   if($Upgraded != 'Y'){ ?>
	<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog dialog_box">
			<div class="modal-content">
			  <div class="modal-body main_content">
					<form class="form-horizontal" method="post" action = "https://www.publishat.com/paytmgateway/pgRedirect.php">
						<?php
						$user_id = trim($this->session->userdata('user_id'));
						$orderid = $user_id . '-' . date('YmdHis') . '_U';
						setcookie('TotalAmount', AccountUpgradeAmonut, time() + (86400 * 30), '/');
						?>
						<input type="hidden" name ="ORDER_ID"  value="<?=$orderid;?>">
						<input type="hidden" name ="CUST_ID" value="<?=$user_id . '-' . date('YmdHis');?>">
						<input type="hidden" name ="INDUSTRY_TYPE_ID" value="Retail120">
						<input type="hidden" name ="CHANNEL_ID" value="WEB">
						<span><h6>Please Upgrade the account to upload More Then 5MB File<h6></span>
						<button type="submit" class="btn btn-primary" id="upgrade">Upgrade</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>