<?php 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=DataReceivedGPS.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<table>
	<caption><center><b><h3>Data GPS Received</h3></b></center></caption>
	<thead>
		<tr>
			<th>No</th>
			<th>Purchase Date</th>
            <th>IMEI</th>
            <th>Serial Number</th>
			<th>Vendor</th>
			<th>Type</th>
			<th>Condition</th>
            <th>Status Gps</th>
			<th>Receive By</th>
			<th>Receive Date</th>
			<th>Receive Status</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$no = 1;
		foreach ($sql1 as $v):
	?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $v->gps_purchase_order; ?></td>
			<td><?php echo $v->gps_imei_number; ?> </td>
			<td><?php echo $v->gps_sn; ?></td>
			<td><?php echo $v->vendor_name; ?> </td>
			<td><?php echo $v->gps_type_name; ?> </td>
			<td><?php echo $v->gps_cond_name; ?> </td>
			<td><?php echo $v->gps_stat_name; ?> </td>
			<td><?php echo $v->gps_received_by; ?> </td>
			<td><?php echo $v->gps_received_date; ?> </td>
			<td><?php echo $v->status; ?> </td>
		</tr>
	<?php 
		$no++; 
		endforeach;
    ?>
	</tbody>
</table>