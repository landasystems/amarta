<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      workorder_det_id		</th>
 		<th width="80px">
		      code		</th>
 		<th width="80px">
		      qty		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->workorder_det_id; ?>
		</td>
       		<td>
			<?php echo $row->code; ?>
		</td>
       		<td>
			<?php echo $row->qty; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
