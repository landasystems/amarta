<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      work_process_id		</th>
 		<th width="80px">
		      workorder_det_split_id		</th>
 		<th width="80px">
		      time_start		</th>
 		<th width="80px">
		      time_end		</th>
 		<th width="80px">
		      start_user_id		</th>
 		<th width="80px">
		      end_user_id		</th>
 		<th width="80px">
		      qty		</th>
 		<th width="80px">
		      charge		</th>
 		<th width="80px">
		      charge_total		</th>
 		<th width="80px">
		      is_payment		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->work_process_id; ?>
		</td>
       		<td>
			<?php echo $row->workorder_det_split_id; ?>
		</td>
       		<td>
			<?php echo $row->time_start; ?>
		</td>
       		<td>
			<?php echo $row->time_end; ?>
		</td>
       		<td>
			<?php echo $row->start_user_id; ?>
		</td>
       		<td>
			<?php echo $row->end_user_id; ?>
		</td>
       		<td>
			<?php echo $row->qty; ?>
		</td>
       		<td>
			<?php echo $row->charge; ?>
		</td>
       		<td>
			<?php echo $row->charge_total; ?>
		</td>
       		<td>
			<?php echo $row->is_payment; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
