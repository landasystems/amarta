<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      workorder_id		</th>
 		<th width="80px">
		      code		</th>
 		<th width="80px">
		      material_img		</th>
 		<th width="80px">
		      material_wide		</th>
 		<th width="80px">
		      material_used		</th>
 		<th width="80px">
		      material_total_used		</th>
 		<th width="80px">
		      description		</th>
 		<th width="80px">
		      is_payment		</th>
 		<th width="80px">
		      created		</th>
 		<th width="80px">
		      created_user_id		</th>
 		<th width="80px">
		      modified		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->workorder_id; ?>
		</td>
       		<td>
			<?php echo $row->code; ?>
		</td>
       		<td>
			<?php echo $row->material_img; ?>
		</td>
       		<td>
			<?php echo $row->material_wide; ?>
		</td>
       		<td>
			<?php echo $row->material_used; ?>
		</td>
       		<td>
			<?php echo $row->material_total_used; ?>
		</td>
       		<td>
			<?php echo $row->description; ?>
		</td>
       		<td>
			<?php echo $row->is_payment; ?>
		</td>
       		<td>
			<?php echo $row->created; ?>
		</td>
       		<td>
			<?php echo $row->created_user_id; ?>
		</td>
       		<td>
			<?php echo $row->modified; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
