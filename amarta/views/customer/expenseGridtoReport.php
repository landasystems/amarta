<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      customer_category_id		</th>
 		<th width="80px">
		      name		</th>
 		<th width="80px">
		      address		</th>
 		<th width="80px">
		      city_id		</th>
 		<th width="80px">
		      phone		</th>
 		<th width="80px">
		      fax		</th>
 		<th width="80px">
		      email		</th>
 		<th width="80px">
		      description		</th>
 		<th width="80px">
		      acc_number		</th>
 		<th width="80px">
		      acc_number_name		</th>
 		<th width="80px">
		      acc_bank		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->customer_category_id; ?>
		</td>
       		<td>
			<?php echo $row->name; ?>
		</td>
       		<td>
			<?php echo $row->address; ?>
		</td>
       		<td>
			<?php echo $row->city_id; ?>
		</td>
       		<td>
			<?php echo $row->phone; ?>
		</td>
       		<td>
			<?php echo $row->fax; ?>
		</td>
       		<td>
			<?php echo $row->email; ?>
		</td>
       		<td>
			<?php echo $row->description; ?>
		</td>
       		<td>
			<?php echo $row->acc_number; ?>
		</td>
       		<td>
			<?php echo $row->acc_number_name; ?>
		</td>
       		<td>
			<?php echo $row->acc_bank; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
