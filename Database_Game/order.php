<html>
<head><title> Current Cart </title></head>

<body>

<form action = "search.php" method = "post">
Search for items!<input name = "input" type="text" placeholder="Search..">
<input type = "submit" value = "Search">
</form>

<?php
    $new = $_POST["order"];
    
    try {
        session_start();
        $db = new PDO('sqlite:games.sqlite');
        if (!is_null($new)){
            session_start();
            $tempCart = $_SESSION['CART'];
            $_SESSIONS['usertype'] = array(type => 'c', id => 1);
            $rs = $db->query('select MAX(o_orderid) AS max FROM orders');
            
            foreach($rs as $row){
                $o_id = $row[max] + 1;
            }
            
            foreach($tempCart as $cartEntry){
                $rs = $db->query("select DISTINCT * from sells, storefront where se_storeid = s_storeid AND se_siteid = " . $cartEntry[id]);
                
                foreach($rs as $row){
                    if (is_null($uniqueStores[$row[s_storeid]])){
                        //echo $o_id;
                        $uniqueStores[$row[s_storeid]] = array(sid => $row[s_storeid], oid => $o_id);
                        $o_id += 1;
                    }
                }
            }
            
            foreach ($uniqueStores as $entry){
                $rs = $db->query("insert into orders values(" . $entry[oid] . ", " . $_SESSIONS['usertype'][id] . ", " . $entry[sid] . ", '" . date("m-d-Y") . "', 'N')");
            }
            
            foreach ($tempCart as $cartEntry){
                $rs = $db->query("select * from sells, storefront where se_storeid = s_storeid AND se_siteid = " . $cartEntry[id]);
                
                foreach($rs as $row){
                    $currEntry = $uniqueStores[$row[s_storeid]];
                    //echo $row[s_name];
                }
                
                $rs = $db->query("insert into contains values(" . $currEntry[oid] . ", " . $currEntry[sid] . ", " . $cartEntry[id] . ", " . $cartEntry[val] . ")");
            }
            
            foreach($uniqueStores as $entry){
                $rs = $db->query("select DISTINCT * from items, sells, storefront, contains, orders where s_storeid = o_storeid AND se_siteid = co_stockid AND i_itemid = se_itemid AND co_storeid = s_storeid AND o_orderid = co_orderid AND s_storeid = " . $entry[sid] . " AND co_orderid = " . $entry[oid]);
                
                foreach($rs as $row){
                    echo "<p>Ordered " . $row[i_name] . " - " . $row[i_platform] . " x" . $row[co_quantity] . " from " . $row[s_name] . " X " . $row[co_orderid] .  "</p>";
                }
            }
            
            unset($uniqueStores);
            unset($tempCart);
            $_SESSION['CART'] = $tempCart;
            //session_destroy();
        }
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    finally{
        $db = null;
    }
    
    
    ?>

</body>
</html>
