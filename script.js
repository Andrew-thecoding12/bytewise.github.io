// Get a reference to the post button and the form
const postButton = document.getElementById('post-button');
const postForm = document.getElementById('post-form');

// Add an event listener to the post button
postButton.addEventListener('click', (event) => {
  // Prevent the form from submitting normally
  event.preventDefault();

  // Get the form data
  const formData = new FormData(postForm);

  // Send the form data to the PHP script using AJAX
  const request = new XMLHttpRequest();
  request.open('POST', 'post.php');
  request.send(formData);

  // Clear the form
  postForm.reset();
});
