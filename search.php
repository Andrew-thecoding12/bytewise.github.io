<?php
$servername = "sql307.epizy.com";
$username = "epiz_33635847";
$password = "pCXJgdofFf";
$dbname = "epiz_33635847_User_Post";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $content = $_POST['content'];

  // Validate input
  if (empty($title)) {
    $errors[] = "Title is required";
  } else if (strlen($title) > 255) {
    $errors[] = "Title must be no more than 255 characters";
  }

  if (empty($content)) {
    $errors[] = "Content is required";
  }

  // Filter input
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $content = filter_var($content, FILTER_SANITIZE_STRING);

  // Check for swear words
  $swear_words = array('badword1', 'badword2', 'badword3');
  foreach ($swear_words as $swear_word) {
    if (stripos($title, $swear_word) !== false || stripos($content, $swear_word) !== false) {
      $errors[] = "Please refrain from using inappropriate language";
      break;
    }
  }

  if (empty($errors)) {
    // Insert post into database
    $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: index.php');
  }
}

?>

<!-- HTML code for post uploader form -->

<h2>Post Uploader</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="title">Title:</label><br>
  <input type="text" id="title" name="title"><br>
  <label for="author">Author:</label><br>
  <input type="text" id="author" name="author"><br>
  <label for="content">Content:</label><br>
  <textarea id="content" name="content"></textarea><br>
  <button type="submit" name="submit">Post</button>
</form>