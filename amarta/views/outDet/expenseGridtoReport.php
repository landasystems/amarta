<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      out_id		</th>
 		<th width="80px">
		      product_id		</th>
 		<th width="80px">
		      qty		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->out_id; ?>
		</td>
       		<td>
			<?php echo $row->product_id; ?>
		</td>
       		<td>
			<?php echo $row->qty; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
