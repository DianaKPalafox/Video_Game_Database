<html>
<head><title> Item Listing </title></head>

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
        
        if ($type == 'G'){
            $rs = $db->query('select * from items, games, sells, storefront where i_itemid = se_itemid AND g_gameid = i_genericid AND se_storeid = s_storeid AND se_siteid = ' . $input);
            
            foreach($rs as $row){
                echo "<p>Item Name: " . $row[g_name] . "</p>";
                echo "<p>Genre: " . $row[g_genre] . "</p>";
                echo "<p>Release Year: " . $row[g_year] . "</p>";
                
                switch($row[g_solo]){
                    case 'Y':
                        echo "<p>Single/Multiplayer : Singleplayer only</p>";
                        break;
                    case 'B':
                        echo "<p>Single/Multiplayer : Both Single and Multiplayer</p>";
                        break;
                    case 'N':
                        echo "<p>Single/Multiplayer : Multiplayer only</p>";
                        break;
                }
                echo "<p>Age Rating: " . $row[g_rating] . "</p>";
                echo "<p>Platform: " . $row[i_platform] . "</p>";
                echo "<p>Price: " . $row[se_price] . "</p>";
                switch($row[se_preowned]){
                    case 'N':
                        echo "<p>Condition: New</p>";
                        break;
                    case 'Y':
                        echo "<p>Condition: Pre-owned</p>";
                        break;
                }
                echo "<p>Seller: " . $row[s_name] . "</p>";
                echo "<p>Location: " . $row[s_addy] . "</p>";
                $se_id = $row[se_siteid];
            }
        }
        else{
            $rs = $db->query('select * from items, accessories, sells, storefront where i_itemid = se_itemid AND se_storeid = s_storeid AND a_accid = i_genericid AND se_siteid = ' . $input);
            foreach($rs as $row){
                echo "<p>Item Name: " . $row[a_name] . "</p>";
                echo "<p>Color/Edition: " . $row[a_color] . "</p>";
                echo "<p>Accessory Type: " . $row[a_type] . "</p>";
                echo "<p>Platform: " . $row[i_platform] . "</p>";
                echo "<p>Price: " . $row[se_price] . "</p>";
                switch($row[se_preowned]){
                    case 'N':
                        echo "<p>Condition: New</p>";
                        break;
                    case 'Y':
                        echo "<p>Condition: Pre-owned</p>";
                        break;
                }
                echo "<p>Seller: " . $row[s_name] . "</p>";
                echo "<p>Location: " . $row[s_addy] . "</p>";
                $se_id = $row[se_siteid];
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
    echo "<form action = \"cart.php\" method = \"post\"> Add to Cart <button name = \"buy\" value = \"" . $se_id . "\"> </button> </form>";
    ?>

</body>
</html>
