<table class="border-table" width=90% align=center style="font-size: 12;">
	<th align=left>
	Comment:
	</th>
	<th></th>
	<th></th>
	<?php
		
		function num_to_month($month_number){
			$month_name = date("F", mktime(0, 0, 0, $month_number, 10));
		return $month_name;
		}
	
		for ($i=1; $i <= 12; $i++){
	?>
		<tr>
			<td width="auto"><?php echo num_to_month($i); ?></td>
			<td width="auto">Grade A </td> <!-- get grade -->
			<td width="auto">Pertahankan </td> <!-- get month -->
		</tr>
	
	<?php
		}
	?>
	
</table>