<?php

    $name    = '';
    $email   = '';
    $phone   = '';
    $address = '';
    $update = false;
    $id = 0;
    $success = '';

    if(isset($_POST['Save']))
    {
        $name    = $_POST["Uname"];
        $email   = $_POST["Email"];
        $phone   = $_POST["Phone"];
        $address = $_POST["Address"];

        try {
            //code...

            $db = new SQLite3('../LustrousJewelers.db');

            $query = "INSERT INTO Customer(c_name, c_email, c_address, c_phoneNumber) values('".$name."', '".$email."', '".$address."', '".$phone."')";
            $db->exec($query);

            $name    = '';
            $email   = '';
            $phone   = '';
            $address = '';
            $success = 'Customer details saved.';

        }catch (Exception $e) {
            echo $e->getMessage();
        }
        finally
        {
            $db = null;
        }
    }

    if(isset($_POST['Update']))
    {
        $id      = $_POST["Id"];
        $name    = $_POST["Uname"];
        $email   = $_POST["Email"];
        $phone   = $_POST["Phone"];
        $address = $_POST["Address"];
        $success = 'Customer details Updated.';

        try {
        
            $db = new SQLite3('../LustrousJewelers.db');

            $query = "Update Customer set c_name = '".$name."',
            c_email  = '".$email."' ,
            c_address= '".$address."' , 
            c_phoneNumber ='".$phone."' where c_customerID = ".$id ;
            $db->exec($query);

            $name    = '';
            $email   = '';
            $phone   = '';
            $address = '';

        }catch (Exception $e) {
            echo $e->getMessage();
        }
        finally
        {
            $db = null;
        }
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $update = true;
		try {
            $db = new PDO('sqlite:../LustrousJewelers.db');

			$result = $db->query('select * from Customer where c_customerID = '.$id);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $name    = $row["c_name"];
            $email   = $row["c_email"];
            $phone   = $row["c_phoneNumber"];
            $address = $row["c_address"];
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
    <title>Customer details</title>    
    <link rel="stylesheet" type="text/css" href="addCustomer.css">    
</head>    
<body>    
    <h2 style="font-size: 50px;">Customer details</h2><br>    
    <div class="login">    
    <form id="login" method="POST" action="addCustomer.php">    
        <input type="hidden"
            style="margin-left: 26px;"		name="Id" id="Id" 
            value = <?php echo $id ?> >
        
        <label id="SuccessMessage"><b><?php echo $success; ?>     
        </b>    
        </label><br><br>
        
        <label><b>Name     
        </b>    
        </label>    
        <input type="text"
            style="margin-left: 26px;"		name="Uname" id="Uname" placeholder="Name"
            value = <?php echo $name ?> >    
        <br><br>  
		<label><b>Email     
        </b>    
        </label>    
        <input type="text" 
            style="margin-left: 26px;" name="Email" id="Email" placeholder="Email"
            value = <?php echo $email ?> >
        <br><br>  	
		<label><b>Phone     
        </b>    
        </label>    
        <input type="text"
            style="margin-left: 20px;" name="Phone" id="Phone" placeholder="Phone"
            value = <?php echo $phone ?> >    
        <br><br>     
        <label><b>Address     
        </b>    
        </label>    
        <textarea type="text"
            style="margin-left: 7px;"		cols="4" name="Address" id="Address" 
            placeholder="Address" ><?php echo $address ?>
        </textarea>
        <br><br><br><br> 
        <?php 
        if ($update == true) :
        ?>
            <input type='submit' name='Update' id='Update'
            style='margin-left: 47px;' value= 'Update'>
        <?php
        else:
        ?>
            <input type='submit' name='Save' id='Save'
            style='margin-left: 47px;' value= 'Save'>
        <?php endif; ?>
        <br><br>    
        <a id='back' href='../menu/menu.php'><-Back</a>
        <a id='viewAll' href='../viewData/viewData.php'>View All-></a>    
    </form>     
</div>    
</body>    
</html>  