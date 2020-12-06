<?php
    $error='';
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["Uname"];
        $password = $_POST["Pass"];
        try {
            
            $db = new PDO('sqlite:games.sqlite');

            $result = $db->query('select * from customer');

            foreach ($result as $row ) {
                if (($username == $row['c_email']) &&
                    $password == $row['c_pass'] ) {
                    
                    header('Location: menu/menu.php');
                    break;
                }                
            }
            $error = 'Incorrect Username/Email or Password';
        } catch (PDOException $e) {
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
    <title>Login</title>    
    <link rel="stylesheet" type="text/css" href="login.css">    
</head>    
<body>    
    <h2 style="font-size: 50px;">Database_Game</h2><br>    
    <div class="login">    
    <form id="login" method="POST" action="login.php">    
        <label><b>Email address     
        </b>    
        </label>    
        <input type="text" name="Uname" id="Uname" placeholder="Email address">    
        <br><br>    
        <label><b>Password     
        </b>    
        </label>    
        <input type="Password" name="Pass" id="Pass" placeholder="Password">    
        <br>
        <label id="errorText"><b><?php echo $error; ?>     
        </b>    
        </label><br>    
            
        <input type="submit" name="log" id="log" value="Log In">       
        <br><br>        
    </form>     
</div>    
</body>    
</html>  