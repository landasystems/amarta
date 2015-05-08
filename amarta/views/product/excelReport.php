<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      code		</th>
 		<th width="80px">
		      name		</th>
 		<th width="80px">
		      product_brand_id		</th>
 		<th width="80px">
		      product_category_id		</th>
 		<th width="80px">
		      product_measure_id		</th>
 		<th width="80px">
		      product_supplier_id		</th>
 		<th width="80px">
		      departement_id		</th>
 		<th width="80px">
		      type		</th>
 		<th width="80px">
		      description		</th>
 		<th width="80px">
		      price_sell		</th>
 		<th width="80px">
		      discount		</th>
 		<th width="80px">
		      stock		</th>
 		<th width="80px">
		      product_photo_id		</th>
 		<th width="80px">
		      weight		</th>
 		<th width="80px">
		      width		</th>
 		<th width="80px">
		      height		</th>
 		<th width="80px">
		      length		</th>
 	</tr>
	<?php foreach($model as $row): ?>
	<tr>
        		<td>
			<?php echo $row->id; ?>
		</td>
       		<td>
			<?php echo $row->code; ?>
		</td>
       		<td>
			<?php echo $row->name; ?>
		</td>
       		<td>
			<?php echo $row->product_brand_id; ?>
		</td>
       		<td>
			<?php echo $row->product_category_id; ?>
		</td>
       		<td>
			<?php echo $row->product_measure_id; ?>
		</td>
       		<td>
			<?php echo $row->product_supplier_id; ?>
		</td>
       		<td>
			<?php echo $row->departement_id; ?>
		</td>
       		<td>
			<?php echo $row->type; ?>
		</td>
       		<td>
			<?php echo $row->description; ?>
		</td>
       		<td>
			<?php echo $row->price_sell; ?>
		</td>
       		<td>
			<?php echo $row->discount; ?>
		</td>
       		<td>
			<?php echo $row->stock; ?>
		</td>
       		<td>
			<?php echo $row->product_photo_id; ?>
		</td>
       		<td>
			<?php echo $row->weight; ?>
		</td>
       		<td>
			<?php echo $row->width; ?>
		</td>
       		<td>
			<?php echo $row->height; ?>
		</td>
       		<td>
			<?php echo $row->length; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
