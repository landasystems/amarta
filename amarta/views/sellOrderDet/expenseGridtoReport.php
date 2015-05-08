<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      sell_order_id		</th>
 		<th width="80px">
		      product_id		</th>
 		<th width="80px">
		      qty		</th>
 		<th width="80px">
		      price		</th>
 		<th width="80px">
		      discount		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->sell_order_id; ?>
		</td>
       		<td>
			<?php echo $row->product_id; ?>
		</td>
       		<td>
			<?php echo $row->qty; ?>
		</td>
       		<td>
			<?php echo $row->price; ?>
		</td>
       		<td>
			<?php echo $row->discount; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
