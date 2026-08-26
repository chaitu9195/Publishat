<?php
$paymentdata = $this->session->userdata();
$path = $paymentdata['url'];
$color = $paymentdata['colorselection'];
$papersize = $paymentdata['papersize'];
$pagescount = $paymentdata['pagescount'];
$copies = $paymentdata['copies'];
$user_id = trim($this->session->userdata('user_id'));
$orderid = $user_id."-".date('YmdHis')."_P";
$id = $paymentdata["id"];
$code = $paymentdata["code"];
$user_name = $paymentdata["name"];
$address = $paymentdata["address"];

$m = new MongoClient();
$db = $m->jobs;
$collection = $db->printers;
$data = $collection->findOne(array("code"=>$code));
$latitude = $data['latitude'];
$longitude = $data['longitude'];
setcookie("OrderID", $orderid, time() + (86400 * 30), "/");
setcookie("TotalAmount", $cost, time() + (86400 * 30), "/");
?>
<body>
<div class="container">
<div class="col-md-8 col-md-offset-2">
<form class="form-horizontal" method="post" action = "../../../paytmgateway/pgRedirect.php">
		<input type="hidden" class="form-control" id="path" value="<?=$path;?>">
		
		<table class="table table-striped table-bordered">
            <tr>
				<td>OrderId</td>
				<td><?=$orderid;?></td>
		    </tr>
			<tr>
				<td>Color</td>
				<td><?=$color;?></td>
		    </tr>
			<tr>
				<td>Paper Size</td>
				<td><?=$papersize;?></td>
		    </tr>
			<tr>
				<td>Copies</td>
				<td><?=$copies;?></td>
		    </tr>
			<tr>
				<td>No.Of Pages</td>
				<td><?=$pagescount;?></td>
		    </tr>
			<?php if($print_type == "Project"){ ?>
			<tr>
				<td>Color Pages</td>
				<td><?php echo count($ProjectPageNos ?? array());?></td>
			</tr>
			<?php } ?>
			<tr>
				<td>Total Cost</td>
				<td><?=$cost;?></td>
		    </tr>

        </table>
		
					<input type="hidden" name ="ORDER_ID"  value="<?=$orderid;?>">
                    <input type="hidden" name ="CUST_ID" value="<?=$user_id;?>">
					<input type="hidden" name ="INDUSTRY_TYPE_ID" value="Retail120">
                    <input type="hidden" name ="CHANNEL_ID" value="WEB">
					<input type="hidden" name ="TXN_AMOUNT" value="<?=$cost;?>">
                    <input type="hidden" name="code" value="<?=$code;?>">
					<input type="hidden" name="url" value="<?=$path;?>">
					<input type="hidden" name="pages" value="<?=$pagescount;?>">
					<input type="hidden" name="copies" value="<?=$copies;?>">
					<input type="hidden" name="color" value="<?=$color;?>">
					<input type="hidden" name="username" value="<?=$user_name;?>">
					<input type="hidden" name="address" value="<?=$address;?>">
					<input type="hidden" name="latitude" value="<?=$latitude;?>">
					<input type="hidden" name="longitude" value="<?=$longitude;?>">
					<input type="hidden" name="filename" value="<?=$filename;?>">
					<input type="hidden" name="description" value="<?=$description;?>">
					<input type="hidden" name="idUser" value="<?=$this->session->userdata('user_id');?>">
					<input type="hidden" name="PaymentFrom" value="Print">
					<input type="hidden" name="print_type" value="<?php echo $print_type;?>">
					<button type="submit" class="btn btn-success pull-right">CheckOut</button>
				
		
	</form>
	</div>
</div>
</body>