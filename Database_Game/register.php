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
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
</style>
</head>
<body>

<form action="/action_page.php">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>

</body>
</html>