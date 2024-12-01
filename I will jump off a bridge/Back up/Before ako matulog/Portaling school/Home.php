<?php
// Start output buffering
ob_start();
?>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['account_type'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}
$posts = []; // Renamed from announcements to posts

// Fetch posts
if (($handle = fopen("assets/Database/Posts.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $visibility = $data[4]; // Assuming visibility is the 5th column
        if ($visibility == 'public' || 
            ($visibility == 'teachers only' && $_SESSION['account_type'] == 'teacher') || 
            ($visibility == 'admin only' && $_SESSION['account_type'] == 'admin')) {
            $posts[] = $data; // Add to posts array
        }
    }
    fclose($handle);
}

// Handle posting new posts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postContent = trim($_POST['post']); // Renamed from announcement to post
    $visibility = $_POST['visibility'];
    $author =$_SESSION['username']; // Use the logged-in username as the author
    $accountType = $_SESSION['account_type'];
    $timestamp = date('Y-m-d H:i:s');

    // Append to Posts.csv
    $file = fopen("assets/Database/Posts.csv", "a");
    fputcsv($file, [count($posts) + 1, $postContent, $author, $accountType, $visibility, $timestamp]);
    fclose($file);

    // Redirect to avoid resubmission
    header("Location: Home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Posts</title> <!-- Title updated to reflect posts -->
    <link rel="stylesheet" href="styles.css"> <!-- Optional CSS file -->
</head>
<body>
    <?php include 'header/header.html'; ?>
    
    <div id="post-feed"> <!-- Updated ID to reflect posts -->
        <h1>Posts</h1> <!-- Updated header to reflect posts -->
        <form method="POST" action="Home.php">
            <textarea name="post" required placeholder="Write your post..."></textarea> <!-- Updated name and placeholder -->
            <select name="visibility" required>
                <option value="public">Public</option>
                <option value="teachers only">Teachers Only</option>
                <option value="admin only">Admin Only</option>
            </select>
            <button type="submit">Post</button> <!-- Updated button text -->
        </form>
        <div id="posts-list"> <!-- Display the list of posts -->
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p><strong><?php echo htmlspecialchars($post[2]); ?></strong> (<?php echo htmlspecialchars($post[4]); ?>) - <?php echo htmlspecialchars($post[5]); ?></p>
                    <p><?php echo htmlspecialchars($post[1]); ?></p> <!-- Display the post content -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <h2><a href="logout.php">Logout</a></h2>
</body>
</html>
<?php
// Flush the output buffer
ob_end_flush();
?>