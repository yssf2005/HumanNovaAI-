(function(){
    const chatbotIcon = document.getElementById('chatbot-icon');
    const chatbotWindow = document.getElementById('chatbot-window');
    const closeChat = document.getElementById('close-chat');
    const chatMessages = document.getElementById('chatbot-messages');
    const chatInput = document.getElementById('chat-msg');
    const widget = document.getElementById('chatbot-widget');

    if (!chatbotIcon || !chatbotWindow || !chatMessages || !chatInput || !widget) return;

    let isChatOpen = false;

    // Restore saved position
    const saved = localStorage.getItem('chatbot-pos');
    if (saved) {
        try {
            const pos = JSON.parse(saved);
            if (pos.left !== undefined) widget.style.left = pos.left + 'px';
            if (pos.top !== undefined) widget.style.top = pos.top + 'px';
            widget.style.right = 'auto';
        } catch(e){}
    }

    function openChat(){
        isChatOpen = true;
        chatbotWindow.classList.add('open');
        // welcome message
        if (chatMessages.children.length === 0) addMessage('bot', "Hello! I'm your AI assistant. How can I help you today?");
    }
    function closeChatFn(){ isChatOpen = false; chatbotWindow.classList.remove('open'); }

    chatbotIcon.addEventListener('click', ()=>{ isChatOpen ? closeChatFn() : openChat(); });
    closeChat.addEventListener('click', closeChatFn);

    chatInput.addEventListener('keypress', (e)=>{ if (e.key === 'Enter') sendMessage(); });

    async function sendMessage(){
        const message = chatInput.value.trim(); if (!message) return;
        addMessage('user', message); chatInput.value = '';
        const typingId = addMessage('bot', 'Typing...');
        try{
            // Prefer global BASE_URL if set (handles hosted in subfolder). Fallback to script location or relative.
            const scriptBase = document.querySelector('script[src*="chatbot.js"]')?.src.split('/js/')[0] || '';
            const baseUrl = (window && window.BASE_URL) ? window.BASE_URL : scriptBase || '';
            try {
                const response = await fetch(baseUrl + '/api/chat', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ message }), credentials: 'same-origin' });
                const typingMsg = document.getElementById(typingId); if (typingMsg) typingMsg.remove();
                let data;
                try { data = await response.json(); } catch(e){ data = null; }
                if (response.ok && data && data.success) {
                    addMessage('bot', data.message);
                } else {
                    // show helpful server-side message when available
                    const serverMsg = data && (data.message || data.error) ? (data.message || data.error) : (response.statusText || 'Server error');
                    addMessage('bot', serverMsg || 'Sorry, I encountered an error.');
                }
            } catch(err){
                const typingMsg = document.getElementById(typingId); if (typingMsg) typingMsg.remove();
                addMessage('bot', "Sorry, I'm having trouble connecting.");
                console.error('Chat request failed', err);
            }
        }catch(err){ const typingMsg = document.getElementById(typingId); if (typingMsg) typingMsg.remove(); addMessage('bot', "Sorry, I'm having trouble connecting."); }
    }

    function addMessage(sender, text){
        const messageId = 'msg-' + Date.now();
        const messageDiv = document.createElement('div');
        messageDiv.id = messageId;
        messageDiv.className = 'chat-msg ' + sender;
        messageDiv.style.maxWidth = '80%';
        messageDiv.style.marginBottom = '12px';
        messageDiv.style.padding = '10px 14px';
        messageDiv.style.borderRadius = '14px';
        messageDiv.style.wordWrap = 'break-word';
        if (sender === 'user'){
            messageDiv.style.background = 'linear-gradient(135deg,#e63946,#c1121f)';
            messageDiv.style.color = '#fff'; messageDiv.style.marginLeft = 'auto'; messageDiv.style.textAlign = 'right';
        } else {
            messageDiv.style.background = '#f1f1f1'; messageDiv.style.color = '#222';
        }
        messageDiv.textContent = text;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return messageId;
    }

    // Simple drag-to-move behavior
    let dragging = false, dragOffset = {x:0,y:0};
    chatbotIcon.addEventListener('pointerdown', (e)=>{
        dragging = true; widget.classList.add('moving');
        const rect = widget.getBoundingClientRect();
        dragOffset.x = e.clientX - rect.left; dragOffset.y = e.clientY - rect.top;
        chatbotIcon.setPointerCapture(e.pointerId);
    });
    document.addEventListener('pointermove', (e)=>{
        if (!dragging) return;
        e.preventDefault();
        const left = e.clientX - dragOffset.x; const top = e.clientY - dragOffset.y;
        widget.style.left = Math.max(8, Math.min(window.innerWidth - widget.offsetWidth - 8, left)) + 'px';
        widget.style.top = Math.max(8, Math.min(window.innerHeight - widget.offsetHeight - 8, top)) + 'px';
        widget.style.right = 'auto'; widget.style.bottom = 'auto';
        chatbotWindow.style.right = 'auto'; chatbotWindow.style.bottom = 'auto';
    });
    document.addEventListener('pointerup', (e)=>{
        if (!dragging) return; dragging = false; widget.classList.remove('moving');
        // persist position
        const rect = widget.getBoundingClientRect();
        localStorage.setItem('chatbot-pos', JSON.stringify({ left: Math.round(rect.left), top: Math.round(rect.top) }));
        try{ chatbotIcon.releasePointerCapture && chatbotIcon.releasePointerCapture(e.pointerId); }catch(e){}
    });
})();
