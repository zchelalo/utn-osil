import React, { useState } from 'react';
import ChatbotBubble from './components/Chatbot';
import ChatInterface from './components/ChatInterface';

function App() {
  const [chatbotOpen, setChatbotOpen] = useState(false);

  const handleChatbotClick = () => {
    setChatbotOpen(!chatbotOpen);
  }

  return (
    <div className="App">
      {chatbotOpen ?  (
        <ChatInterface onClick={handleChatbotClick} />
      ) : (
        <ChatbotBubble image=" https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQgtUmkNbo-ZEwCC2_4LaVMkVS-AzWEPhcXvDs3eoc9VOm4ekVw" onClick={handleChatbotClick} />
      )}
    </div>
  );
}

export default App;