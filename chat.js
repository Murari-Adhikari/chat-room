
let userId  = prompt("user id please");
function sendMessage(){
    const messageInput = document.getElementById('message-input');
    const message =messageInput.value;

    if(message.trim()=== ' '){
        console.log("please enter the message");
        return;
    }
    const formData = new FormData();
    formData.append('message', message);
    formData.append('userId', userId);

    fetch('http://localhost/day_35/chatroom/chatroom.php' , {
        method:'POST',
        body:formData
    })

    .then(response => response.json())
    .then(data =>{
        console.log(data.message);
        const chatmessage= document.getElementById('chat-messages');
        const messageElement = document.createElement('p');
    

        messageElement.innerHTML = `${data.date} &nbsp  &nbsp${userId} &nbsp  &nbsp${data.message}`;
        chatmessage.appendChild(messageElement)
    })
.catch(error => console.error('error',error));

messageInput.value = '';
}