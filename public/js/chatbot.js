const chatbotIcon = document.getElementById('chatbot-icon');
const chatbotWindow = document.getElementById('chatbot-window');
const closeChat = document.getElementById('close-chat');
const chatMessages = document.getElementById('chatbot-messages');
const chatInput = document.getElementById('chat-msg');

let isChatOpen = false;

// Toggle chatbot window
chatbotIcon.addEventListener('click', () => {
    isChatOpen = !isChatOpen;
    chatbotWindow.style.display = isChatOpen ? 'block' : 'none';

    // Show welcome message on first open
    if (isChatOpen && chatMessages.children.length === 0) {
        addMessage('bot', 'Hello! I\'m your AI assistant. How can I help you today?');
    }
});

closeChat.addEventListener('click', () => {
    isChatOpen = false;
    chatbotWindow.style.display = 'none';
});

// Send message on Enter key
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

async function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;

    // Add user message to chat
    addMessage('user', message);
    chatInput.value = '';

    // Show typing indicator
    const typingId = addMessage('bot', 'Typing...');

    try {
        // Call backend API - get BASE_URL from page
        const baseUrl = document.querySelector('script[src*="chatbot.js"]')?.src.split('/js/')[0] || '';
        const response = await fetch(baseUrl + '/api/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();

        // Remove typing indicator
        const typingMsg = document.getElementById(typingId);
        if (typingMsg) typingMsg.remove();

        // Add bot response
        if (data.success) {
            addMessage('bot', data.message);
        } else {
            addMessage('bot', data.message || 'Sorry, I encountered an error. Please try again.');
        }
    } catch (error) {
        // Remove typing indicator
        const typingMsg = document.getElementById(typingId);
        if (typingMsg) typingMsg.remove();

        addMessage('bot', 'Sorry, I\'m having trouble connecting. Please try again later.');
    }
}

function addMessage(sender, text) {
    const messageId = 'msg-' + Date.now();
    const messageDiv = document.createElement('div');
    messageDiv.id = messageId;
    messageDiv.style.cssText = `
        margin-bottom: 12px;
        padding: 10px 15px;
        border-radius: 15px;
        max-width: 80%;
        word-wrap: break-word;
        ${sender === 'user'
            ? 'background: linear-gradient(135deg, #e63946, #c1121f); color: white; margin-left: auto; text-align: right;'
            : 'background: #f1f1f1; color: #333;'}
    `;
    messageDiv.textContent = text;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    return messageId;
}
