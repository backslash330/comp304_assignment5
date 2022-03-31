<!--
Nicholas Almeida
CMPT304 - Assignment 5 
March 30, 2020
-->
<header>
    <title> Music Depot: Search</title>
    <!-- add jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</header>
<body>
<h1>Music Depot Catalog Search</h1>
<!-- create a text input that should folow two drop down menus-->
<!-- the first menu has options for name, artist, year and price-->
<!-- the second menu has options for =, <, <=, >, >=  -->
<!-- these should be in a form so php can get them-->
<h2>Search for:</h2>
<form action="index.php" method="post">
    <div>
        <label for="search_type">Search Type:</label>
        <select name="search_type" id="search_type">
            <option value="name">Name</option>
            <option value="artist">Artist</option>
            <option value="year">Year</option>
            <option value="price">Price</option>
        </select>
        <label for="search_type">Search Operator:</label>
        <select name="search_operator" id="search_operator">
            <option value="=">=</option>
        </select>
        <label for="search_value">Search Value:</label>
        <input type="text" name="search_value">
    </div>


<!-- create a second line to the form that has the following-->
<!-- A droptown that has the options name, artist, year and price-->
<!-- radio buttons for ascending or decsending-->
    <div>
        <h2>Sort By:</h2>
        <select name="sort_type">
            <option value="name">Name</option>
            <option value="artist">Artist</option>
            <option value="year">Year</option>
            <option value="price">Price</option>
        </select>
        <label for="sort_order">Sort Order:</label>
        <input type="radio" name="sort_order" value="ASC" checked="checked">Ascending
        <input type="radio" name="sort_order" value="DESC">Descending
    </div>
    <div>
    <!-- submit button -->
        <h2>Submit</h2>
        <input type="submit" value="Search">
    </div>
    <script src=indexscripts.js type="text/javascript"></script>
</form>
    <?php
    // if submit is pressed, then we reload the page with the search parameters in the url
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $search_type_parameter = htmlspecialchars($_POST['search_type']);
        $search_operator_parameter = ($_POST['search_operator']);  /// issue here
        $search_value_parameter = htmlspecialchars($_POST['search_value']);
        $sort_type_parameter = htmlspecialchars($_POST['sort_type']);
        $sort_order_parameter = htmlspecialchars($_POST['sort_order']);
        header("Location: index.php?search_type=$search_type_parameter&search_operator=$search_operator_parameter&search_value=$search_value_parameter&sort_type=$sort_type_parameter&sort_order=$sort_order_parameter");
    }

    // if the url has search parameters, then we use echo them 
    if(isset($_GET['search_type'])){
        $search_type = htmlspecialchars($_GET['search_type']);
        // decode the html entites back into their original characters for the search operator  
        $search_operator = htmlspecialchars_decode($_GET['search_operator']);
        $search_value = htmlspecialchars($_GET['search_value']);
        $sort_type = htmlspecialchars($_GET['sort_type']);
        $sort_order = htmlspecialchars($_GET['sort_order']);

        
        // create option for if the user does not enter a search value it is not the intitial page load
        if(empty($search_value)) {
            echo "Showing Music Depot's entire catalogue";

            $db = new mysqli('localhost', 'root', 'root', 'musicdepot');
            if ($db->connect_error) {
                die('Connect Error (' . $db->connect_errno . ') '
                    . $db->connect_error);
            }
            $query = "SELECT * FROM RECORDS ORDER BY $sort_type $sort_order";
            // create a table to display the data
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Artist</th>";
            echo "<th>Year</th>";
            echo "<th>Price</th>";
            echo "</tr>";
        
            // excute the query
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($name, $artist, $year, $price);
            // loop through the results
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$artist</td>";
                echo "<td>$year</td>";
                echo "<td>$price</td>";
                echo "</tr>";
            }    
        }
        else{
            // if the user is not on the initial page load, then we display the search results
            echo "Showing all results from the entire Music Depot Catalogue where $search_type $search_operator $search_value <br>";

            $db = new mysqli('localhost', 'root', 'root', 'musicdepot');
            if ($db->connect_error) {
                die('Connect Error (' . $db->connect_errno . ') '
                    . $db->connect_error);
            }
            $query = "SELECT * FROM RECORDS WHERE $search_type $search_operator \"$search_value\" ORDER BY $sort_type $sort_order";
            
            // excute the query
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($name, $artist, $year, $price);
            
            // count the number of results in $stmt 
            $count = 0;


            // create a table to display the data
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Artist</th>";
            echo "<th>Year</th>";
            echo "<th>Price</th>";
            echo "</tr>";

            // loop through the results
            while ($stmt->fetch()) {
                $count ++;
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$artist</td>";
                echo "<td>$year</td>";
                echo "<td>$price</td>";
                echo "</tr>";
            }

            if($count === 0){
                echo "No results found";
            }
            else{
                echo "Number of results found: $count";
            }

        }


    }

    ?>
</body>