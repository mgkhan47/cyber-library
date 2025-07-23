<?php
// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cyber_library";  // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to search for the book based on exact title
function searchBook($title) {
    global $conn;  // Ensure the global connection is used

    // Sanitize user input to prevent SQL injection
    $title = $conn->real_escape_string($title);

    // SQL query to search for the book by exact title
    $sql = "SELECT * FROM finalbook WHERE title = '$title'"; // Exact match
    $result = $conn->query($sql);

    // Check if any results are found
    if ($result->num_rows > 0) {
        // Loop through and output each book's details
        while ($row = $result->fetch_assoc()) {
            echo "<div class='details-container'>";
            echo "<h2>Book Details</h2>";
            echo "<p><strong>Title:</strong> <span style='color: #e1daed;'>" . htmlspecialchars($row['title']) . "</span></p>";
            echo "<p><strong>Author:</strong> <span style='color: #e1daed;'>" . htmlspecialchars($row['author']) . "</span></p>";
            echo "<p><strong>Description:</strong> <span style='color: #e1daed;'>" . nl2br(htmlspecialchars($row['description'])) . "</span></p>";
            echo "<p><strong>ISBN:</strong> <span style='color: #e1daed;'>" . htmlspecialchars($row['isbn']) . "</span></p>";
            echo "<p><strong></strong> <span style='color: #e1daed;'> <a href='" . htmlspecialchars($row['url']) . "' target='_blank' style='color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-decoration: none;'>Read More</a></span></p>";
            echo "</div>";
        }
    } else {
        echo "<div class='details-container'>";
        echo "<p style='color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 18px; text-align: center;'><strong>No Book Found with the Exact Title '" . htmlspecialchars($title) . "'</strong></p>";
        echo "</div>";
    }

    // Always call the suggestBooks function to show keyword-based suggestions
    suggestBooks($title);
}

// Function to suggest books based on a keyword in the title
function suggestBooks($keyword) {
    global $conn;  // Ensure the global connection is used

    // Sanitize user input to prevent SQL injection
    $keyword = $conn->real_escape_string($keyword);

    // SQL query to search for books with the keyword in the title
    $sql = "SELECT title FROM finalbook WHERE title LIKE '%$keyword%'";
    $result = $conn->query($sql);

    // Check if any results are found
    if ($result->num_rows > 0) {
        echo "<div class='suggestions-box'>"; // Begin box
        echo "<h3 style='color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;'><strong>Other Books with '$keyword' in the Title:</strong></h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li style='color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;'><u><a href='?title=" . urlencode($row['title']) . "'>" . htmlspecialchars($row['title']) . "</a></u></li>";
        }
        echo "</ul>";
        echo "</div>"; // End box
    } else {
        echo "<div class='suggestions-box'>"; // Begin box
        echo "<p style='color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;'><strong>NO BOOK FOUND !</strong></p>";
        echo "</div>"; // End box
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Library</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('https://wallpapercat.com/w/full/d/b/9/914052-2560x1600-desktop-hd-library-background-image.jpg') no-repeat center center/cover;
            color: #eaeaea;
            background-attachment: fixed; /* Ensures background stays static */
        }

        u {
            text-decoration-color: #9e861c;
            text-decoration-thickness: 2px; /* optional: controls the thickness of the underline */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 4rem;
            color: #f4fc03;
            text-transform: uppercase;
            font-weight: bold;
            text-shadow: 0 0 50px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .header p {
            font-size: 1.5rem;
            color: #f4fc03;
            margin-top: 10px;
            text-shadow: 0 0 30px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .form-container, .details-container {
            background: rgba(33, 34, 68, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(50, 255, 126, 0.4), 0 0 25px rgba(176, 131, 255, 0.4);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
        }

        .form-container h2, .details-container h2 {
            margin-bottom: 20px;
            color: #f4fc03;text-shadow: 0 0 20px black;background: linear-gradient(45deg, #f4fc03, #f4fc03); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-size: 1rem;
            color: #eaeaea;
        }

        .form-container input {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #2a2b3c;
            border-radius: 5px;
            background: #121530;
            color: #eaeaea;
            box-shadow: inset 0 0 5px rgba(50, 255, 126, 0.4), inset 0 0 5px rgba(176, 131, 255, 0.4);
        }

        .form-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(45deg, #c4c404,#c4c404); /* Brighter yellowish-brown gradient */
            color: #121530; /* Dark text for readability */
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease; /* Add a slight transform effect on hover */
        }

        .form-container button:hover {
            background: linear-gradient(45deg, #c4c404,#c4c404); /* Slightly lighter and brighter on hover */
            transform: scale(1.05); /* Slight button size increase on hover */
        }

        .details-container p {
            margin: 10px 0;
            color: #eaeaea;
        }

        .details-container ul {
            list-style-type: none;
            padding: 0;
        }

        .details-container ul li {
            margin: 10px 0;
            color: #eaeaea;
        }

        .suggestions-box {
            background: rgba(40, 44, 60, 0.9); /* Slightly transparent dark background */
            padding: 15px;
            margin-top: 20px; /* Space above the box */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 25px rgba(50, 255, 126, 0.4), 0 0 25px rgba(176, 131, 255, 0.4); /* Glow effect */
            color: #eaeaea; /* Text color */
        }

        .suggestions-box h3 {
            margin-bottom: 15px;
            color: #b083ff; /* Header color */
            font-size: 1.2rem;
        }

        .suggestions-box ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        .suggestions-box ul li {
            margin: 5px 0;
        }

        .suggestions-box ul li a {
            color: #32ff7e; /* Link color */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s ease;
        }

        .suggestions-box ul li a:hover {
            color: #28e673; /* Hover color for links */
        }

        footer {
            margin-top: 20px;
            text-align: center;
            color: #6c6c91;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cyber Library</h1>
            <p><i><strong>Your Trusted Book Repository</strong></i></p>
        </div>

        <!-- Form container -->
        <div class="form-container">
            <h2>Search for a Book</h2>
            <form method="POST" action="books.php">
                <label for="title">Enter Book Title:</label>
                <input type="text" name="title" id="title" required style="width: 80%; height: 20px; font-size: 1rem;">
                <button type="submit" name="search">Search</button>
            </form>
        </div>

        <!-- Display search results -->
        <?php
        if (isset($_POST['search'])) {
            $title = $_POST['title'];
            searchBook($title);
        }

        // If the user clicked on a suggested title, show the book's details
        if (isset($_GET['title'])) {
            $title = $_GET['title'];
            searchBook($title);
        }
        ?>
    </div>
</body>
</html>