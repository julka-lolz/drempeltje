<?php
include 'database.php';

//initialize session
session_start();

$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');

if (isset($_GET['jongerecode'])) {
	$jongerecode = $_GET['jongerecode'];

	$db->deleteJongere($jongerecode);
	// redirect to overview
	header("location: welcome.php");
	exit;
}

?>

<html>
	<head>
		<title>Welcome!</title>        
	</head>
	<body>		

		<?php
			$db = new database('localhost', 'root', '', 'drempeltoets', 'utf8');			
			$results = $db->get_jongere_information(NULL);
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
					<th colspan="2">action</th>
				</tr>
			</thead>
			<?php foreach($results as $rows => $row){ ?>

				<?php $row_id = $row['jongerecode']; ?>
				<tr>
					<?php   foreach($row as $row_data){?>

					
						<td>
							<?php echo $row_data ?>
						</td>
					<?php } ?>

					<td>
						<a href="updateJonger.php?jongerecode=<?php echo $row_id; ?>&jongerecode=<?php echo $row['jongerecode']?>" class="edit_btn" >Edit</a>
					</td>
					<td>
						<a href="edit_delete_jongere.php?jongerecode=<?php echo $row_id; ?>&jongerecode=<?php echo $row['jongerecode']?>" class="del_btn">Delete</a>
					</td>
				</tr>
			<?php } ?>
		</table>		
	</body>
</html>