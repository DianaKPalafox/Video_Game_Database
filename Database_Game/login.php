
<!DOCTYPE html>    
<html>    
<head>    
    <title>Login</title>    
        
    </head>    
    <body>    
        <h2 style="font-size: 55px;">Database_Game</h2><br>    
        <div class="login">    
        <form id="login" method="POST" action="login.php">    
            <label><b>Email address     
            </b>    
            </label>    
            <input type="text" name="Zname" id="Zname" placeholder="Email address">    
            <br><br>    
            <label><b>Password     
            </b>    
            </label>    
            <input type="Password" name="PassW" id="Pass" placeholder="PassWword">    
            <br>
            <label id="errorText"><b><?php echo $error; ?>     
            </b>    
            </label><br>    
                
            <input type="submit" name="log" id="log" value="Log In">       
            <br><br>        
                    
            <input type="button"onClick="window.location='../Database_Game/registerCustomer.php';" name="log" id="log" value="Register">
    
</form>     
</div>    
</body>    
</html>  

<?php
    
        $error='';
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = $_POST["Zname"];
            $password = $_POST["PassW"];
            try {
                
                $db = new PDO('sqlite:games.sqlite');

                $result = $db->query('select * from customer');

                foreach ($result as $row ) {
                    if (($username == $row['c_email']) &&
                        $password == $row['c_pass'] ) {
                        
                        header('Location: menu.php');
                        break;
                    }                
                }
                $error = 'Incorrect Email or Password';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            finally
            {
                $db = null;
            }
        }
        
        $error='';
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = $_POST["Zname"];
            $password = $_POST["PassW"];
            try {
                
                $db = new PDO('sqlite:games.sqlite');

                $result = $db->query('select * from storefront');

                foreach ($result as $row ) {
                    if (($username == $row['s_email']) &&
                        $password == $row['s_pass'] ) {
                        
                        header('Location: menu.php');
                        break;
                    }                
                }
                $error = 'Incorrect Email or Password';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            finally
            {
                $db = null;
            }
        }
?>
