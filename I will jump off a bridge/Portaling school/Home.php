<?php
// Start output buffering
ob_start();
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['account_type'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$posts = []; // Array to hold posts
$comments = []; // Array to hold comments

// Fetch posts from CSV file
if (($handle = fopen("assets/Database/Posts.csv", "r")) !== FALSE) {
    while (($line = fgetcsv($handle)) !== FALSE) {
        $visibility = $line[4]; // Assuming visibility is the 5th column
        if ($_SESSION['account_type'] == 'admin' || // Allow all for admins
            $visibility == 'public' || 
            ($visibility == 'faculty' && $_SESSION['account_type'] == 'teacher')) {
            $posts[] = $line; // Add to posts array
        }
    }
    fclose($handle);
}

// Fetch comments from CSV file
if (($handle = fopen("assets/Database/Comments.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $comments[] = $data; // Add to comments array
    }
    fclose($handle);
}

// Handle posting new posts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['post'])) {
        $postContent = trim($_POST['post']); // Get post content
        $visibility = $_POST['visibility'];
        $author = $_SESSION['username']; // Use the logged-in username as the author
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

    // Handle comments
    if (isset($_POST['comment'])) {
        $postId = $_POST['post_id']; // Get the post ID to which the comment belongs
        $commentContent = trim($_POST['comment']); // Get comment content
        $author = $_SESSION['username']; // Use the logged-in username as the author
        $timestamp = date('Y-m-d H:i:s');

        // Generate a new comment ID
        $commentId = count($comments) + 1; // Simple incrementing ID based on current count

        // Append new comment to Comments.csv
        $file = fopen("assets/Database/Comments.csv", "a");
        fputcsv($file, [$commentId, $postId, $commentContent, $author, $timestamp]);
        fclose($file);

        // Redirect to avoid resubmission
        header("Location: Home.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Posts</title>
    <link rel="stylesheet" href="header/styles.css"> <!-- Optional CSS file -->
    <style>
        .toggle-comments {
            margin: 10px 0;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .toggle-comments:hover {
            background-color: #0056b3;
        }

        .comment-form, .comments {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header/header.html'; ?>
    <div class="pcontainer">
        <div id="post-feed">
            <h1>Posts</h1>
            <form method="POST" action="Home.php">
                <textarea class="fixed-textarea" name="post" required placeholder="Write your post..."></textarea>
                <select name="visibility" required>
                    <option value="public">Public</option>
                    <option value="faculty">Faculty only</option>
                    <option value="admin">Admin only</option>
                </select>
                <button type="submit">Post</button>
            </form>
            <div id="posts-list">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <p><strong><?php echo htmlspecialchars($post[2]); ?></strong>
                        (<?php echo htmlspecialchars($post[4]); ?>) - <?php echo htmlspecialchars($post[5]); ?></p>
                        <p><?php echo htmlspecialchars($post[1]); ?></p>

                        <!-- Toggle button for comments -->
                        <button class="toggle-comments" onclick="toggleComments(<?php echo htmlspecialchars($post[0]); ?>)">Toggle Comments</button>

                        <!-- Comment form -->
                        <div class="comment-form" id="comment-form-<?php echo htmlspecialchars($post[0]); ?>" style="display: none;">
                            <form method="POST" action="Home.php">
                                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post[0]); ?>">
                                <textarea name="comment" required placeholder="Write your comment..."></textarea>
                                <button type="submit">Comment</button>
                            </form>
                        </div>

                        <!-- Display comments for the post -->
                        <div class="comments" id="comments-<?php echo htmlspecialchars($post[0]); ?>" style="display: none;">
                            <h3>Comments:</h3>
                            <?php foreach ($comments as $comment): ?>
                                <?php if ($comment[1] == $post[0]): // Check if comment belongs to the current post ?>
                                    <p><strong><?php echo htmlspecialchars($comment[3]); ?></strong> - <?php echo htmlspecialchars($comment[4]); ?></p>
                                    <p><?php echo htmlspecialchars($comment[2]); ?></p> <!-- Display the comment content -->
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
    function toggleComments(postId) {
        // Get the comment form and comments section for the specific post
        var commentForm = document.getElementById('comment-form-' + postId);
        var commentsSection = document.getElementById('comments-' + postId);

        // Toggle visibility
        if (commentForm.style.display === "none") {
            commentForm.style.display = "block"; // Show comment form
        } else {
            commentForm.style.display = "none"; // Hide comment form
        }

        if (commentsSection.style.display === "none") {
            commentsSection.style.display = "block"; // Show comments
        } else {
            commentsSection.style.display = "none"; // Hide comments
        }
    }
    </script>
</body>
</html>