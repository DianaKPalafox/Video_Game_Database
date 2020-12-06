<html>    
<head>    
    <title>Dashboard</title>    
    <link rel="stylesheet" type="text/css" href="menu.css">    
</head>    
<body>    
    <h2 style="margin-left:-90px;font-size: 50px;"> Videogame Marketplace </h2><br>
	<div class="col-sm-12" style="margin-left: 380px;">
        <input type="button" onClick="window.location='../addCustomer/addCustomer.php';" name="log" id="log" value="Add Customers">
		<input type="button" onClick="window.location='../viewData/viewData.php';" name="log1" id="log1" value="All Customers">
	</div>
    
    <form action = "../search.php" method = "post">
        Search for items!<input name = "input" type="text" placeholder="Search..">
        <input type = "submit" value = "Search">
    </form>
</div>    
</body>    
</html>
