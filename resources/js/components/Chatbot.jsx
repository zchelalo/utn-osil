import React from 'react';
import "../../css/estilos_chatbot/burbuja.css"

const ChatbotBubble = ({ image, onClick }) => {
  return (
    <div className="chatbot-bubble" onClick={onClick} >
      <img src={image} alt="Chatbot" />
    </div>
  );
};

export default ChatbotBubble;