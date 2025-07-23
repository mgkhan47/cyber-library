<?php
// Create a database connection
$connection = new mysqli("localhost", "root", "", "cyber_library");

// Check if connection is successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the JSON data
$json_data = file_get_contents("finalbook.json");
$books = json_decode($json_data, true); // Convert to an associative array

// Check if the JSON data was decoded successfully
if ($books !== null) {
    // Prepare the SQL query
    $stmt = $connection->prepare("INSERT INTO finalbook (title, author, description, isbn, url) VALUES (?, ?, ?, ?, ?)");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . $connection->error);
    }

    // Loop through each book and insert into the database
    foreach ($books as $book) { // Changed from $finalbooks to $books
        // Make sure the index exists and is not empty
        $title = isset($book['Title']) ? $book['Title'] : '';
        $author = isset($book['Authors']) ? $book['Authors'] : '';
        $description = isset($book['Description']) ? $book['Description'] : '';
        $isbn = isset($book['ISBN']) ? $book['ISBN'] : '';
        $url = isset($book['URL']) ? $book['URL'] : '';

        // Bind parameters to the prepared statement
        $stmt->bind_param("sssss", $title, $author, $description, $isbn, $url);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Record inserted successfully.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error decoding JSON data.";
}

// Close the connection
$connection->close();
?>
