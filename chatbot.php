<!-- Float Button Wrapper -->
<div id="chatbot-wrapper" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; display: flex; align-items: center; gap: 15px;">
    <!-- The prompt text -->
    <div id="chatbot-prompt" style="background-color: white; color: #333; padding: 10px 15px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-family: 'Inter', sans-serif, Arial; font-size: 14px; font-weight: 500; cursor: pointer; animation: float 3s ease-in-out infinite; transition: transform 0.2s;">
        If you need any help... click me! 🏥
    </div>
    <!-- Float Button -->
    <div id="chatbot-button" style="cursor: pointer; background-color: #dc3545; color: white; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.2s; animation: shake 2.5s infinite ease-in-out;">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </div>
</div>

<!-- Chat Window -->
<div id="chatbot-window" style="display: none; position: fixed; bottom: 100px; right: 20px; z-index: 1000; width: 380px; height: 500px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); flex-direction: column; overflow: hidden; font-family: 'Inter', sans-serif, Arial; border: 1px solid #eaeaea; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease; transform-origin: bottom right; transform: scale(0.9); opacity: 0;">
    <!-- Header -->
    <div style="background-color: #007bff; color: white; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 17px; font-weight: 600; display: flex; align-items: center; gap: 10px; letter-spacing: 0.2px;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            Healthcare Assistant
        </h3>
        <button id="chatbot-close" style="background: none; border: none; color: white; cursor: pointer; font-size: 24px; padding: 0; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; opacity: 0.8; transition: opacity 0.2s; line-height: 1;">&times;</button>
    </div>
    
    <!-- Chat Body -->
    <div id="chatbot-messages" style="flex: 1; padding: 20px; overflow-y: auto; background-color: #ffffff; display: flex; flex-direction: column; gap: 16px;">
        <div style="align-self: flex-start; background-color: #f0f2f5; color: #1c1e21; padding: 12px 16px; border-radius: 18px 18px 18px 4px; max-width: 85%; font-size: 15px; line-height: 1.5; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            Hello! I am your NSBM Healthcare Assistant. How can I help you today?
        </div>
    </div>
    
    <!-- Input Area -->
    <div style="padding: 16px 20px; background-color: #ffffff; border-top: none; display: flex; gap: 12px; align-items: center;">
        <input type="text" id="chatbot-input" placeholder="Type your message..." style="flex: 1; padding: 12px 20px; border: 1px solid #e4e6eb; background-color: #f0f2f5; border-radius: 24px; outline: none; font-size: 15px; color: #1c1e21; transition: border-color 0.2s, background-color 0.2s;">
        <button id="chatbot-send" style="background-color: #007bff; color: white; border: none; padding: 0; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; box-shadow: 0 2px 6px rgba(0,123,255,0.3); transition: transform 0.2s, background-color 0.2s;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: -2px;">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple styles for hover states
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: rotate(0deg); }
                10%, 30%, 50%, 70%, 90% { transform: rotate(-8deg); }
                20%, 40%, 60%, 80% { transform: rotate(8deg); }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }
            @keyframes pulse {
                0%, 100% { opacity: 0.3; }
                50% { opacity: 1; }
            }
            #chatbot-button:hover { transform: scale(1.05); animation: none !important; }
            #chatbot-prompt:hover { transform: scale(1.02); }
            #chatbot-close:hover { opacity: 1; }
            #chatbot-send:hover { background-color: #0069d9; transform: scale(1.05); }
            #chatbot-input:focus { border-color: #007bff; background-color: #ffffff; }
            
            /* Custom Scrollbar for messages */
            #chatbot-messages::-webkit-scrollbar { width: 6px; }
            #chatbot-messages::-webkit-scrollbar-track { background: transparent; }
            #chatbot-messages::-webkit-scrollbar-thumb { background: #dcdcdc; border-radius: 10px; }
            #chatbot-messages::-webkit-scrollbar-thumb:hover { background: #c0c0c0; }
        `;
        document.head.appendChild(style);

        const chatButton = document.getElementById('chatbot-button');
        const chatPrompt = document.getElementById('chatbot-prompt');
        const chatWindow = document.getElementById('chatbot-window');
        const closeBtn = document.getElementById('chatbot-close');
        const sendBtn = document.getElementById('chatbot-send');
        const inputField = document.getElementById('chatbot-input');
        const messagesDiv = document.getElementById('chatbot-messages');

        // Toggle chat window
        chatButton.addEventListener('click', () => {
            if (chatWindow.style.display === 'none' || chatWindow.style.opacity === '0') {
                chatWindow.style.display = 'flex';
                // Trigger reflow for animation
                void chatWindow.offsetWidth; 
                chatWindow.style.transform = 'scale(1)';
                chatWindow.style.opacity = '1';
                inputField.focus();
                if (chatPrompt) chatPrompt.style.display = 'none';
            } else {
                closeChat();
            }
        });

        if (chatPrompt) {
            chatPrompt.addEventListener('click', () => {
                chatWindow.style.display = 'flex';
                // Trigger reflow for animation
                void chatWindow.offsetWidth; 
                chatWindow.style.transform = 'scale(1)';
                chatWindow.style.opacity = '1';
                inputField.focus();
                chatPrompt.style.display = 'none';
            });
        }

        function closeChat() {
            chatWindow.style.transform = 'scale(0.9)';
            chatWindow.style.opacity = '0';
            setTimeout(() => {
                chatWindow.style.display = 'none';
            }, 300); // Wait for transition to finish
        }

        closeBtn.addEventListener('click', closeChat);

        function appendMessage(text, sender) {
            const msgDiv = document.createElement('div');
            msgDiv.style.padding = '12px 16px';
            msgDiv.style.maxWidth = '85%';
            msgDiv.style.fontSize = '15px';
            msgDiv.style.lineHeight = '1.5';
            msgDiv.style.wordWrap = 'break-word';
            msgDiv.style.boxShadow = '0 1px 2px rgba(0,0,0,0.02)';

            if (sender === 'user') {
                msgDiv.style.alignSelf = 'flex-end';
                msgDiv.style.backgroundColor = '#007bff';
                msgDiv.style.color = 'white';
                msgDiv.style.borderRadius = '18px 18px 4px 18px';
                msgDiv.textContent = text;
            } else {
                msgDiv.style.alignSelf = 'flex-start';
                msgDiv.style.backgroundColor = '#f0f2f5';
                msgDiv.style.color = '#1c1e21';
                msgDiv.style.borderRadius = '18px 18px 18px 4px';
                // Convert line breaks and markdown links logic if needed, but innerHTML allows injected HTML links 
                msgDiv.innerHTML = text.replace(/\n/g, '<br>');
            }

            messagesDiv.appendChild(msgDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        async function sendMessage() {
            const text = inputField.value.trim();
            if (!text) return;

            // Add user message
            appendMessage(text, 'user');
            inputField.value = '';

            // Loading state
            const loadingId = 'loading-' + Date.now();
            const loadingDiv = document.createElement('div');
            loadingDiv.id = loadingId;
            loadingDiv.style.alignSelf = 'flex-start';
            loadingDiv.style.backgroundColor = '#f0f2f5';
            loadingDiv.style.color = '#65676b';
            loadingDiv.style.padding = '12px 16px';
            loadingDiv.style.borderRadius = '18px 18px 18px 4px';
            loadingDiv.style.fontSize = '14px';
            loadingDiv.innerHTML = '<span style="display:inline-block;animation:pulse 1.5s infinite;">●</span><span style="display:inline-block;animation:pulse 1.5s infinite 0.2s;">●</span><span style="display:inline-block;animation:pulse 1.5s infinite 0.4s;">●</span>';
            messagesDiv.appendChild(loadingDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

            try {
                // We use relative path or full domain relative. Assuming we are in the same folder structure.
                const apiUrl = '/VIVA-Group-O-NSBM-WEB/chatbot_api.php';
                
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                document.getElementById(loadingId).remove();

                if (data.response) {
                    appendMessage(data.response, 'bot');
                } else if (data.error) {
                    console.error("Chatbot Error:", data.error, data.details);
                    appendMessage("Sorry, I am having trouble connecting to the service. Please try again later.", 'bot');
                } else {
                    appendMessage("Sorry, I could not understand the response.", 'bot');
                }
            } catch (error) {
                const loader = document.getElementById(loadingId);
                if(loader) loader.remove();
                appendMessage("Error communicating with the chatbot service.", 'bot');
                console.error('Chat API Error:', error);
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    });
</script>
