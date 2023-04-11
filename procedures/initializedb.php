<?php

require ("dbconnect.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$tables = array("review", "item", "itemCategory", "user");
foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table;";
    if ($conn->query($sql) === false) {
        exit("Error dropping $table table: " . $conn->error);
    }
}


$userTable = "CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(32) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    firstName VARCHAR (64) NOT NULL,
    lastName VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE);";

if ($conn->query($userTable) === false) {
    exit("Error creating user table: " . $conn->error);
}

$itemCategoryTable = "CREATE TABLE itemCategory (
    category VARCHAR(64) NOT NULL PRIMARY KEY);";
    

if ($conn->query($itemCategoryTable) === false) {
    exit("Error creating itemCategory table: " . $conn->error);
}



$itemTable = "CREATE TABLE IF NOT EXISTS item (
    itemId INT(10) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(64) NOT NULL,
    description TEXT(255),
    category VARCHAR(64) NOT NULL,
    FOREIGN KEY (category) REFERENCES itemCategory(category),
    price DECIMAL(10,2),
    postDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    postedBy VARCHAR(32) NOT NULL,
    FOREIGN KEY (postedBy) REFERENCES user(username));";

if ($conn->query($itemTable) === false) {
    exit("Error creating item table: " . $conn->error);
}



$reviewTable = "CREATE TABLE review (
    reviewId INT(10) AUTO_INCREMENT PRIMARY KEY,
    remark TEXT (255),
    score VARCHAR(10),
    reviewDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    writtenBy VARCHAR(32) NOT NULL,
    FOREIGN KEY (writtenBy) REFERENCES user(username),
    forItem INT(10) NOT NULL,
    FOREIGN KEY (forItem) REFERENCES item(itemId));";

if ($conn->query($reviewTable) === false) {
    exit("Error creating review table: " . $conn->error);
}



$queries = array(
    "INSERT INTO user(username, password, firstName, lastName, email) VALUES
        ('john1', 'p@ssword1', 'John', 'Smith', 'john.smith@example.com'),
        ('jane2', 'p@ssword2', 'Jane', 'Doe', 'jane.doe@example.com'),
        ('matt3', 'p@ssword3', 'Matt', 'Garcia', 'jason.garcia@example.com'),
        ('lisa4', 'p@ssword4', 'Lisa', 'Kim', 'lisa.kim@example.com'),
        ('alice5', 'p@ssword5', 'Alice', 'Williams', 'alice.williams@example.com')",

    "INSERT INTO itemCategory(category) VALUES
        ('Art & Collectibles'),
        ('Baby & Kids'),
        ('Clothing & Accessories'),
        ('Electronics'),
        ('Furniture'),
        ('Home & Garden'),
        ('Pet Supplies'),
        ('Sporting Goods'),
        ('Toys'),
        ('Other')",
    
    "INSERT INTO item(title, description, category, price, postDate, postedBy) VALUES
        ('Smartphone 14 Pro', 'Newest phone with improved camera and battery life', 'Electronics', '800.00', '2023-03-03 10:00:00', 'john1'),
        ('Wireless headphones', 'World-class combination of noise cancelling performance and premium comfort', 'Electronics', '275.00', '2023-03-30 12:00:00', 'jane2'),
        ('Artisan Stand Mixer', 'Mix ingredients with ease using this powerful and stylish stand mixer', 'Home & Garden', '250.00', '2023-03-17 13:15:00', 'jane2'),
        ('Mountain Bike', 'Full suspension mountain bike with 29-inch wheels', 'Sporting Goods', '1000.00', '2023-03-28 16:00:00', 'matt3'),
        ('Vintage Watch', 'Mechanical wristwatch from the 1950s', 'Clothing & Accessories', '300.00', '2023-03-27 14:20:00', 'matt3'),
        ('Leather Shoulder Bag', 'Womens crossbody bag with adjustable strap', 'Clothing & Accessories', '400.00', '2023-03-13 10:30:00', 'lisa4'),
        ('Coffee Maker', 'Programmable coffee machine with thermal carafe', 'Home & Garden', '50.00', '2023-03-07 08:15:00', 'lisa4')",

    "INSERT INTO review(remark, score, reviewDate, writtenBy, forItem) VALUES
        ('Great phone. The battery lasts all day!', 'excellent', '2023-04-03 10:02:00', 'jane2', '1'),
        ('These headphones are fantastic! The noise cancelling is top notch!', 'excellent', '2023-04-02 18:34:00', 'john1', '2'),
        ('Amazing sound, however, not comfortable to wear for long periods of time.', 'good', '2023-04-04 16:00:00', 'alice5', '2'),
        ('I love my new mixer! I wish the bowl was larger.', 'good', '2023-04-01 11:45:00', 'lisa4', '3'),
        ('Too loud and too heavy. Cookies turned out great though.', 'fair', '2023-04-01 20:25:00', 'matt3', '3'),
        ('The suspension is terrible! Would not recommend it.', 'poor', '2023-04-02 18:58:00', 'john1', '4'),
        ('Very cute, I got so many compliments.', 'excellent', '2023-04-03 08:24:00', 'jane2', '6'),
        ('Broke after 2 months and difficult to clean. Avoid!', 'poor', '2023-04-04 16:30:00', 'alice5', '7')"

);

foreach ($queries as $query) {
    if ($conn->query($query) === TRUE) {
        header("Location: ../index.php?error=initsuccess");
    } else {
        echo "Error inserting into database: " . $conn->error;
    }
}
    


$conn->close();
?>



