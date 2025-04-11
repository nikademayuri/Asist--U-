<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <link rel="stylesheet" href="recommend.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100..700,0..1,-50..200" />

    <style>
       .star {
    color: #ccc; /* Default color for empty stars */
    font-size: 40px;
}

.star.filled {
    color: #ffc107; /* Color for full stars */
}

.star.half {
    color: #ffc107; /* Color for half stars, if you're using them */
    position: relative;
}

.star.half::after {
    content: "\2605"; /* Unicode for a half star */
    position: absolute;
    width: 50%;
    overflow: hidden;
    color: #ffc107; /* Ensure the half star is the correct color */
}


        </style>
</head>
<body>
<header>
        <nav class="nav">
            <ul class="list">
                <li><div class="logo">
                    <img id="logo" src="l1.png" alt="logo">
                    <img id="lname" src="name.png" alt="name">
                </div></li>
                <div id="search">
                    
                    <input readonly class="search-input1" type="search" placeholder="Services">
                    <div id="dropdown-menu1" class="dropdown-content1">
                        <!-- Dropdown content goes here -->
                        <a onclick="redirectToCategory('mess')"> <img width="20px" src="laundry.png" alt="laundry"> Mess</a>
                        <a onclick="redirectToCategory('pg')"><img width="20px" src="laundry.png" alt="laundry">PG</a>
                        <a onclick="redirectToCategory('laundry')"><img width="20px" src="laundry.png" alt="laundry">Laundry</a>
                        <a onclick="redirectToCategory('hospital')"><img width="20px" src="laundry.png" alt="laundry">Medical</a>
                    </div>
                    <span></span>
                    <input readonly class="search-input2" type="search" placeholder="Location">
                    <div id="dropdown-menu2" class="dropdown-content2">
                        <!-- Dropdown content goes here -->
                        <a href="#">Dr. D. Y. Patil Institute of Technology</a>
                        <a href="#">Dr. D. Y. Patil Medical College</a>
                    </div>
                    <div class="icon">
                        <span class="search-icon"><img width="60px" src="search.png" alt=""></span>
                    </div>
                </div>
                <li id="contactus" class="links"><a href="#">Contact US</a></li>
                <li class="links"><a href="/review_page/review.html">Write a Review</a></li>
                <li><a id="loglink" href="/login/Login.html"><button id="logbt">Log In</button></li></a>
                <li><a id="reglink" href="/registration/register.html"><button id="regbt">Sign Up</button></a></li>
            </ul>
        </nav>
    </header>
    <h1> Recommended Mess Near DY Patil Medical and Engineering, Pimpri</h1>
    <div class="list-container">
        <?php

        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "id21975537_navigate_db";

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT list_table.*, AVG(mess_ratings.overall_rating) AS avg_rating 
        FROM list_table 
        LEFT JOIN mess_ratings ON list_table.title = mess_ratings.mess_name 
        WHERE type='mess' 
        GROUP BY list_table.id 
        ORDER BY avg_rating DESC 
        LIMIT 5";

        $result = $conn->query($sql);
        echo '<div class="main">';
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="items">';
                echo '<div class="item" id="div_'.$row['id'].'">';
                echo "<img src='".trim($row["img"])."' alt='Image' width='200px' height='200px'>";
                echo "<div class='info'>";
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>Price: ₹" . $row["price"] . "</p>";


                $conn = new mysqli($host, $username, $password, $database);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
              
                $sql = "SELECT * FROM list_table WHERE type=? AND title=?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $type = "mess"; // Assign the value to a variable
                    $title = $row['title']; // Assign the value to a variable
                    $stmt->bind_param("ss", $type, $title); // Bind the variables
                    $stmt->execute();
                    $res = $stmt->get_result();
                    // Rest of your code
                } else {
                    echo "Error in preparing SQL statement: " . $conn->error;
                }
                
                   if ($res->num_rows > 0) {
                       while($row1 = $res->fetch_assoc()) {
                           $mess_name=$row1["title"];
       
                           $avgRatingSql = "SELECT AVG(overall_rating) as average_rating FROM mess_ratings WHERE mess_name='$mess_name'";
       
                       $avgRatingResult = $conn->query($avgRatingSql);
                       if ($avgRatingResult->num_rows > 0) {
                           $avgRatingRow = $avgRatingResult->fetch_assoc();
                           $averageRating = $avgRatingRow['average_rating'];
                           // Display the mess name and its average rating
                           echo "<div class='mess-info'>";
                           displayStars($averageRating);
                           echo "</div>";
                   }
                }
               }
           
            
  
             
                echo '<div class="loca"><span class="material-symbols-outlined">
                location_on
                </span> ' . $row["location"] . "</div>";
                echo '<span class="service">'.explode(',',$row["services"])[0].'</span><span class="service">'.explode(',',$row["services"])[1].'</span><span class="service">'.explode(',',$row["services"])[2].'</span>';
                echo '<span class="phone">'.$row['phone'].'</span>';
                echo "</div>";
                echo "</div>";
                echo "</div>";

                
            }
        } else {
            echo "No items found.";
        }

        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
echo '<hr>';

echo ' <h1> Recommended Mess Near DY Patil Medical and Engineering, Pimpri</h1>';


        $sql = "SELECT list_table.*, AVG(pg_ratings.overall_rating) AS avg_rating 
        FROM list_table 
        LEFT JOIN pg_ratings ON list_table.title = pg_ratings.pg_name 
        WHERE type='pg' 
        GROUP BY list_table.id 
        ORDER BY avg_rating DESC 
        LIMIT 5";

        $result = $conn->query($sql);
        echo '<div class="main">';
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="items">';
                echo '<div class="item" id="div_'.$row['id'].'">';
                echo "<img src='".trim($row["img"])."' alt='Image' width='200px' height='200px'>";
                echo "<div class='info'>";
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>Price: ₹" . $row["price"] . "</p>";


                $conn = new mysqli($host, $username, $password, $database);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
              
                $sql = "SELECT * FROM list_table WHERE type=? AND title=?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $type = "pg"; // Assign the value to a variable
                    $title = $row['title']; // Assign the value to a variable
                    $stmt->bind_param("ss", $type, $title); // Bind the variables
                    $stmt->execute();
                    $res = $stmt->get_result();
                    // Rest of your code
                } else {
                    echo "Error in preparing SQL statement: " . $conn->error;
                }
                
                   if ($res->num_rows > 0) {
                       while($row1 = $res->fetch_assoc()) {
                           $pg_name=$row1["title"];
       
                           $avgRatingSql = "SELECT AVG(overall_rating) as average_rating FROM pg_ratings WHERE pg_name='$pg_name'";
    
                       $avgRatingResult = $conn->query($avgRatingSql);
                       if ($avgRatingResult->num_rows > 0) {
                           $avgRatingRow = $avgRatingResult->fetch_assoc();
                           $averageRating = $avgRatingRow['average_rating'];
                           // Display the mess name and its average rating
                           echo "<div class='mess-info'>";
                           displayStars($averageRating);
                           echo "</div>";
                   }
                }
               }
           
            
  
             
                echo '<div class="loca"><span class="material-symbols-outlined">
                location_on
                </span> ' . $row["location"] . "</div>";
                echo '<span class="service">'.explode(',',$row["services"])[0].'</span><span class="service">'.explode(',',$row["services"])[1].'</span><span class="service">'.explode(',',$row["services"])[2].'</span>';
                echo '<span class="phone">'.$row['phone'].'</span>';
                echo "</div>";
                echo "</div>";
                echo "</div>";

               
                
            }
        } else {
            echo "No items found.";
        }
        echo '</div>';
        $conn->close();
        ?>

        <!-------------- Rating fetch ----------------------------->
        <?php
         $host = "localhost";
         $username = "root";
         $password = "";
         $database = "id21975537_navigate_db";
 
       

    function displayStars($rating) {
        $fullStars = (int)$rating;
        $halfStar = $rating - $fullStars > 0 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;
    
        echo '<div class="star-rating">';
        for ($i = 0; $i < $fullStars; $i++) {
            echo '<span class="star filled">&#9733;</span>'; // Full star
        }
        if ($halfStar) {
            echo '<span class="star half">&#9733;</span>'; // Half star
        }
        for ($i = 0; $i < $emptyStars; $i++) {
            echo '<span class="star">&#9733;</span>'; // Empty star
        }
        echo '</div>';
    }
        ?>



    </div>
    <script src="recommend.js">
        document.addEventListener('DOMContentLoaded', function() {
    // Select all .item divs
    const itemDivs = document.querySelectorAll('.item');
    const category = "<?php echo $_GET['category']; ?>";

    // Loop through each .item div
    itemDivs.forEach(function(itemDiv) {
        // Add a click event listener to the .item div
        itemDiv.addEventListener('click', function() {
            const itemId = itemDiv.id;

            // Redirect to details.php with the item ID as a query parameter
            window.location.href = 'details.php?categoryId=' + encodeURIComponent(itemId)+'&category='+encodeURIComponent(category)  ;
        });
    });
});
        </script>
</body>
</html>
