<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      workorder_intruction_id		</th>
 		<th width="80px">
		      code		</th>
 		<th width="80px">
		      nomark		</th>
 		<th width="80px">
		      amount		</th>
 		<th width="80px">
		      material_total_used		</th>
 		<th width="80px">
		      material_used		</th>
 		<th width="80px">
		      size_qty		</th>
 		<th width="80px">
		      ordering		</th>
 		<th width="80px">
		      description		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->workorder_intruction_id; ?>
		</td>
       		<td>
			<?php echo $row->code; ?>
		</td>
       		<td>
			<?php echo $row->nomark; ?>
		</td>
       		<td>
			<?php echo $row->amount; ?>
		</td>
       		<td>
			<?php echo $row->material_total_used; ?>
		</td>
       		<td>
			<?php echo $row->material_used; ?>
		</td>
       		<td>
			<?php echo $row->size_qty; ?>
		</td>
       		<td>
			<?php echo $row->ordering; ?>
		</td>
       		<td>
			<?php echo $row->description; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
