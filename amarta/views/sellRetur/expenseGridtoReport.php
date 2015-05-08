<?php if ($model !== null):?>
<table border="1">

	<tr>
		<th width="80px">
		      id		</th>
 		<th width="80px">
		      code		</th>
 		<th width="80px">
		      sell_id		</th>
 		<th width="80px">
		      departement_id		</th>
 		<th width="80px">
		      customer_user_id		</th>
 		<th width="80px">
		      created		</th>
 		<th width="80px">
		      created_user_id		</th>
 		<th width="80px">
		      modified		</th>
 		<th width="80px">
		      description		</th>
 		<th width="80px">
		      subtotal		</th>
 		<th width="80px">
		      discount		</th>
 		<th width="80px">
		      ppn		</th>
 		<th width="80px">
		      other		</th>
 		<th width="80px">
		      term		</th>
 		<th width="80px">
		      dp		</th>
 		<th width="80px">
		      credit		</th>
 		<th width="80px">
		      payment		</th>
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
			<?php echo $row->sell_id; ?>
		</td>
       		<td>
			<?php echo $row->departement_id; ?>
		</td>
       		<td>
			<?php echo $row->customer_user_id; ?>
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
       		<td>
			<?php echo $row->description; ?>
		</td>
       		<td>
			<?php echo $row->subtotal; ?>
		</td>
       		<td>
			<?php echo $row->discount; ?>
		</td>
       		<td>
			<?php echo $row->ppn; ?>
		</td>
       		<td>
			<?php echo $row->other; ?>
		</td>
       		<td>
			<?php echo $row->term; ?>
		</td>
       		<td>
			<?php echo $row->dp; ?>
		</td>
       		<td>
			<?php echo $row->credit; ?>
		</td>
       		<td>
			<?php echo $row->payment; ?>
		</td>
       	</tr>
     <?php endforeach; ?>
</table>
<?php endif; ?>
