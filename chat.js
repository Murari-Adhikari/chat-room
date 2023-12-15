function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value;

    // Create a FormData object and append the message
    const formData = new FormData();
    formData.append('message', message);

    // Send the message to the PHP script using a POST request
    fetch('chatroom.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Log a success message
    })
    .catch(error => console.error('Error:', error));

    // Clear the input field after sending the message
    messageInput.value = '';
}
