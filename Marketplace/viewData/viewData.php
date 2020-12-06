<?php
	if (isset($_GET['deleteId'])) {
		$id = $_GET['deleteId'];
		try {
            $db = new SQLite3('../games.sqlite');

			$query = "Delete from Customer where c_customerID = ". $id;
			$db->exec($query);

        }catch (Exception $e) {
            echo $e->getMessage();
        }
        finally
        {
            $db = null;
        }
	}
?>

<!DOCTYPE html>    
<html>    
<head>    
    <title>Customers</title>    
    <link rel="stylesheet" type="text/css" href="viewData.css">    
</head>    
<body>    
    <h2 style="margin-left:-90px;font-size: 50px;">Customers</h2><br> 
	<table style="width: 60%;
    margin-left: 250px;">
	  <tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Actions</th>
	  </tr>
	  
	<?php
		try {
			//code...

			$db = new PDO('sqlite:../games.sqlite');

			$result = $db->query('select * from Customer');

			foreach ($result as $row ) {
				# code...
				echo "<tr><td>".$row['c_customerID']."</td>".
				"<td>".$row['c_name']."</td>".
				"<td>".$row['c_email']."</td>".
				"<td>".$row['c_phoneNumber']."</td>".
				"<td>".$row['c_address']."</td>".
				"<td><a href='viewData.php?deleteId=".$row['c_customerID'] ."'>Delete</a> ".
				"<a href='../addCustomer/addCustomer.php?id=".$row['c_customerID'] ."'>Edit</a></td></tr>";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		finally{
			$db = null;
		}
	?>

	</table>
</div>    
</body>    
</html>  