<html>
<head><title> Search </title></head>

<body>

<form action = "search.php" method = "post">
Search for items!<input name = "input" type="text" placeholder="Search..">
<input type = "submit" value = "Search">
</form>

<?php
    
    $input = $_POST["button"];
    
    try {
        
        $db = new PDO('sqlite:games.sqlite');
        
        $rs = $db->query('select * from items, sells where i_itemid = se_itemid AND se_siteid = ' . $input);
        
        foreach ($rs as $row ) {
            $type = $row[i_type];
        }
        
        $error = 'Incorrect Username/Email or Password';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    finally
    {
        $db = null;
    }

</body>
</html>
