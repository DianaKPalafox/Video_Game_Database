<html>
<head><title> Search </title></head>

<body>

<form action = "search.php" method = "post">
    Search for items!<input name = "input" type="text" placeholder="Search..">
    <input type = "submit" value = "Search">
</form>

<?php
    
    $input = $_POST["input"];
    try {
        $db = new PDO('sqlite:games.sqlite');

        $rs = $db->query('select * from items, sells, storefront where i_itemid = se_itemid AND s_storeid = se_storeid AND (i_name like \'%' . $input . '%\' OR i_platform like \'%' . $input . '%\' OR s_name like \'%' . $input . '%\')');
        
        $doc = new DomDocument("1.0", "iso-8859-1");
        echo "Press the button on the side to view the item";
        //use a table?
        foreach ($rs as $row ) {
            $displayString = $row[i_name] . ", " . $row[i_platform] . ", $" . $row[se_price] . ", Sold by " . $row[s_name];
            echo "<form action = \"item.php\" method = \"post\">" . $displayString . "<input type = \"submit\" value = \"". $row[se_siteid] ."\" name = \"button\"> </form>";
        }
        
        $error = 'Incorrect Username/Email or Password';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    finally
    {
        $db = null;
    }
    
?>

</body>
</html>
