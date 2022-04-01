<header>
    <title> Music Depot: Insert</title>
    <!-- add jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</header>
<body>
    <h1>Music Depot Catalog Insert</h1>
    <!-- create a form with four text inputs: name, artist, year and price-->
    <h2>Search for:</h2>
    <form action="insert.php" method="post">
        <div">
            <label for="name" >Name:</label>
            <input type="text" id="name" name="name"><br>
            <label for="artist">Artist:</label>
            <input type="text" id="artist" name="artist"><br>
            <label for="year">Year:</label>
            <input type="text" id="year" name="year"><br>
            <label for="price">Price: $</label>
            <input type="text" id="price" name="price"><br>
        </div>
        <div>
            <input type="submit" id="submit" value="Add a New Record" >
        </div>
    </form>
    <?php
    // get the parameters from the form
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = htmlspecialchars($_POST['name']);
        $artist = htmlspecialchars($_POST['artist']);
        $year = htmlspecialchars($_POST['year']);
        $price = htmlspecialchars($_POST['price']);
        // check if the parameters are empty
        if(empty($name) || empty($artist) || empty($year) || empty($price)){
            $error = true;
        }
        // if all the parameters are valid, then we insert the record into the database
        else{
            $db = new PDO('mysql:host=localhost;dbname=musicdepot', 'root', 'mmljar');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO records (name, artist, year, price) VALUES ('$name', '$artist', '$year', '$price')";
            $db->exec($query);
            $success = true;
        }
        header("Location: insert.php?success=$success&error=$error&name=$name&artist=$artist&year=$year&price=$price");
    }


    // if there are parameters in the header we check for success/failure
    if(isset($_GET['success'])){
        $name = ($_GET['name']);
        $artist = ($_GET['artist']);
        $year = ($_GET['year']);
        $price = ($_GET['price']);
        $success = ($_GET['success']);
        $error = ($_GET['error']);
        if($success == 1){
            echo "<p>The record was successfully added to the catalog.</p>";
        }
        if($error == 1){
            echo "<p>An error has occurred. </br> The item was not added. </p>";
        }

    }


    ?>


</body>