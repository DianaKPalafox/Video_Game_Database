<html>
<head><title> Current Cart </title></head>

<body>

<form action = "search.php" method = "post">
Search for items!<input name = "input" type="text" placeholder="Search..">
<input type = "submit" value = "Search">
</form>

<?php
    
    $newID = $_POST["buy"];
    $decrement = $_POST["button"];
    $empty = $_POST["empty"];
    
    try {
        session_start();
        $db = new PDO('sqlite:games.sqlite');
        
        $currArray = $_SESSION['CART'];
        
        if (!is_null($newID)){
            $rs = $db->query('select * from items, sells where i_itemid = se_itemid AND se_siteid = ' . $newID);
            
            foreach ($rs as $row) {
                if (is_null($currArray[$row[se_siteid]]))
                {
                    $currArray[$row[se_siteid]] = array(id => $row[se_siteid], val => 1);
                }
                else{
                    $currArray[$row[se_siteid]][val] += 1;
                }
            }
        }
        else if (!is_null($decrement))
        {
            $currArray[$decrement][val] -= 1;
            if ($currArray[$decrement][val] <= 0)
            {
                unset($currArray[$decrement]);
            }
        }
        else if (!is_null($empty)){
            unset($currArray);
        }
        
        $totalPrice = 0;
        
        foreach ($currArray as $entry){
            $rs = $db->query('select * from items, sells, storefront where i_itemid = se_itemid AND se_storeid = s_storeid AND se_siteid = ' . $entry[id]);
            
            foreach($rs as $row){
                $displayString = "<p>" . $row[i_name] . " | " . $row[i_platform] . " | x" . $entry[val] . " | " . ($row[se_price] * $entry[val]) . " | " . $row[s_name] . " ";
                echo "<form action = \"cart.php\" method = \"post\">" . $displayString . "<input type = \"submit\" value = \"". $row[se_siteid] ."\" name = \"button\"> </form>";
                $totalPrice += ($row[se_price] * $entry[val]);
            }
        }
        
        $_SESSION['CART'] = $currArray;
        
        echo "<p>Current Cart Total is: $" . $totalPrice . "</p>";
        echo "<form action = \"order.php\" method = \"post\"><input type = \"submit\" value = \"Finalize Order\" name = \"order\"> </form>";
        echo "<form action = \"cart.php\" method = \"post\"><input type = \"submit\" value = \"Empty Cart\" name = \"empty\"> </form>";
        
        $error = 'Incorrect Username/Email or Password';
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    finally{
        $db = null;
    }
    ?>

</body>
</html>
