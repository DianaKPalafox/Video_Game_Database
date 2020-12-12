<!DOCTYPE html>    
<html>    
<head>    
    <title>Stores details</title>    
</head>    
<body>    
    <h2 style="font-size: 57px;">Register Store</h2><br>    
    <div class="login">    
    <form id="login" method="POST" action="registerStore.php">    
       
        <label id="SuccessMessage"><b><?php echo $success; ?>     
        </b>    
        </label><br><br>
        
        <label><b>Name</b></label>
        <input type="text" style="margin-left: 60px;" name="Zname" id="Zname" placeholder="Full Name"
            value = <?php echo $name ?> >    
        <br><br>  
		
        <label><b>Email</b></label>
        <input type="text" 
            style="margin-left: 60px;" name="Email" id="Email" placeholder="Email "
            value = <?php echo $email ?> >
        <br><br>  	
		
        <label><b>Password</b></label>
        <input type="text" 
            style="margin-left: 30px;" name="Pass" id="Pass" placeholder="Password"
            value = <?php echo $passW ?> >
        <br><br>  	
		
    <label><b>Number</b></label>    
        <input type="text"
            style="margin-left: 46px;" name="Phone" id="Phone" placeholder="number"
            value = <?php echo $phone ?> >    
        <br><br>     
        
        <label><b>Address </b></label>    
        <textarea type="text"
            style="margin-left: 46px;"		cols="5" name="Address" id="Address" 
            placeholder="Address" ><?php echo $address ?>
        </textarea>
        <br><br>
        
        
        
        
        <br><br> 
       
<?php 
        if ($update == true) :
        ?>
            <input type='submit' name='Update' id='Update'
            style='margin-left: 50px;' value= 'Update'>
        <?php
        else:
        ?>
            <input type='submit' name='Save' id='Save'
            style='margin-left: 50px;' value= 'Save'>
        <?php endif; ?>
        <br><br>    
        <a id='back' href='menu.php'><-Back to menu</a>
     
</form>     
</div>    
</body>    
</html>  }

<?php

    $name    = '';
    $email   = '';
    $passW   = '';
    $phone   = '';
    $address = '';
    $update = false;
    $id = 0;
    $success = '';

    if(isset($_POST['Save']))
    {
        $name    = $_POST["Zname"];
        $email   = $_POST["Email"];
        $passW   = $_POST["Pass"];
        $phone   = $_POST["Phone"];
        $address = $_POST["Address"];

        try {
            

            $db = new SQLite3('games.sqlite');

            $query = "INSERT INTO storefront(s_name, s_email, s_pass, s_addy, s_phone) values('".$name."', '".$email."','".$passW."', '".$address."', '".$phone."')";
            $db->exec($query);

            $name    = '';
            $email   = '';
            $passW   = '';
            $phone   = '';
            $address = '';
            $success = 'Store Register saved.';

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
            $db = new PDO('sqlite:games.sqlite');

			$result = $db->query('select * from storefront where s_storeid = '.$id);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);

            $name    = $row["s_name"];
            $email   = $row["s_email"];
            $passW   = $row["s_pass"];
            $phone   = $row["s_phone"];
            $address = $row["s_addy"];
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        finally
        {
            $db = null;
        }
	}

?>


