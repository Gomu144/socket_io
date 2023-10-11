<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Side Chat</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .chat-section {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-top: 20px;
        }

        .input-group {
            display: flex;
        }

        #chatInput {
            flex: 1;
            border: none;
            border-radius: 4px 0 0 4px;
            padding: 10px;
            font-size: 16px;
        }

        #sendButton {
            border: none;
            border-radius: 0 4px 4px 0;
            background-color: royalblue;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
        }

        #messages {
            list-style: none;
            padding: 0;
        }

        ul li {
            background-color: #f0f0f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container">
        <div class="chat-section">
            <ul id="messages"></ul>
            <div class="input-group">
                <input type="text" id="chatInput" placeholder="Type your message">
                <button id="sendButton">Send</button>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(function() {
        let ip_address = "127.0.0.1";
        let socket_port = "3000";
        let socket = io(ip_address + ':' + socket_port);

        var messages = document.getElementById('messages');
        let chatInput = $('#chatInput');
        let sendButton = $('#sendButton');

        function sendMessage() {
            let message = chatInput.val();
            if (message.trim() !== "") {
                socket.emit('chat', message);
                chatInput.val("");
            }
        }

        chatInput.keypress(function(e) {
            if (e.which == 13) {
                sendMessage();
            }
        });

        sendButton.click(function() {
            sendMessage();
        });

        socket.on("user-connect", () => {
            const newItem = document.createElement("li");
            newItem.innerText = "============================New User Contected.===========================";
            newItem.style.color = "green"; // Set the text color to green
            newItem.style.fontWeight = "bold"; // Set the font weight to bold
            messages.appendChild(newItem);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on("user-disconnect", () => {
            const newItem = document.createElement("li");
            newItem.innerText = "============================User Disconnected.=============================";
            newItem.style.color = "red"; // Set the text color to green
            newItem.style.fontWeight = "bold"; // Set the font weight to bold
            messages.appendChild(newItem);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on('chat-message', function(msg) {
            var item = document.createElement('li');
            item.textContent = msg;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });
    });
</script>
</html>
