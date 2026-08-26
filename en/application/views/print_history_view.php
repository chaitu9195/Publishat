<small>Open - Payment success but Printing is not done.</small><br />
<small>Unpaid - Payment Failed or not paid.</small><br />
<table class="table table-striped table-bordered">
    <thead>
        <tr class="bg-primary">
            <th>Date</th>
            <th>Job Id</th>
            <th>Number of pages</th>
            <th>Price Per Page</th>
            <th>Total Amount</th>
            <th>Mode of Payment</th>
            <th>Status</th>
            <th>Delivery Type</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($PrintHistory) {
      foreach ($PrintHistory as $rowData) { ?>
        <tr>
            <td><?php echo $rowData['datetime']; ?></td>
            <td><?php echo $rowData['jobid']; ?></td>
            <td><?php echo $rowData['Nos']; ?></td>
            <td><?php echo $rowData['EachCopyPrice']; ?></td>
            <td><?php echo $rowData['amount']; ?></td>
            <td><?php echo $rowData['Mode']; ?></td>
            <td><?php echo $rowData['status']; ?></td>
            <td><?php echo $rowData['DelType']; ?></td>
        </tr>
        <?php }
  } else {
       ?>
        <tr>
            <td colspan="8">No Data Found!</td>
        </tr>
        <?php
  } ?>
    </tbody>
</table>