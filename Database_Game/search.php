<html>
<head><title> Search </title></head>

<body>

<form action = "search.php" method = "post">
    Search for items!<input name = "input" type="text" placeholder="Search..">
    <input type = "submit" value = "Search">
</form>

<?php
    
    $input = $_POST["input"];
    //echo "You searched: " . $input;
    
    try {
        //code...
        $db = new PDO('sqlite:games.sqlite');

        $rs = $db->query('select * from items, sells, storefront where i_itemid = se_itemid AND s_storeid = se_storeid AND i_name like \'%' . $input . '%\'');
        
        $doc = new DomDocument("1.0", "iso-8859-1");
        echo "Name, Platform, Price, Sold By, Pre-owned?";
        foreach ($rs as $row ) {
            $displayString = $row[i_name] . ", " . $row[i_platform] . ", $" . $row[se_price] . ", Sold by " . $row[s_name];
            echo "<form action = \"../item.php\" method = \"post\">" . $displayString . "<input type = \"submit\" value = \"View Item\" name = \"" . $row[se_siteid] . "\"> </form>";
            //echo "Checking ". $row[i_name] . "";
            //$docElement = $doc->createElement('body', $row[i_name]);
            //$doc->appendChild($docElement);
        }
        
        //echo $domDocument->saveHTML();
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
