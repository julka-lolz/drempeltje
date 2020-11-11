<html>
	<head>
		<title>Welcome!</title>        
	</head>
	<body>		

		<?php
		include 'database.php';
			$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');			
			$results = $db->get_overzicht_information(NULL);
			$columns = array_keys($results[0]);
			
		?>

		<table>
			<thead>
				<tr>
					<?php foreach($columns as $column){ ?>
						<th>
							<strong> <?php echo $column ?> </strong>
						</th>
					<?php } ?>					
				</tr>
			</thead>
			<?php foreach($results as $rows => $row){ ?>

				<?php $row_id = $row; ?>
				<tr>
					<?php   foreach($row as $row_data){?>					
						<td>
							<?php echo $row_data ?>
						</td>
					<?php } ?>				
				</tr>
			<?php } ?>
		</table>
		<a href="welcome.php"> Back home</a><br>
	</body>
</html>