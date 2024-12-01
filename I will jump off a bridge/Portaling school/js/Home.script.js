function toggleComments(postId) {
    console.log("Toggling comments for post ID:", postId); // Debugging line
    var commentForm = document.getElementById('comment-form-' + postId);
    var commentsSection = document.getElementById('comments-' + postId);

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