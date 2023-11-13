import React, { useState, useEffect, useRef } from 'react';
import "../../css/estilos_chatbot/estilos_bot.css"; //Importamos los estilos CSS
import { RViewerTrigger,RViewer  } from "react-viewerjs"

const urlHost = document.getElementById('urlHost').value

let options = {
  toolbar: {//Since there is only one picture, let's hide "prev" and "next"
    prev: false,
    next: false
  }
}

const isImageURL = (url) => {
  // Expresión regular para validar si es una URL de imagen
  const imageRegex = /\.(jpeg|jpg|gif|png|svg)$/;
  return imageRegex.test(url);
};

const isPdfURL = (url) => {
  // Expresión regular para validar si es una URL de imagen
  const pdfRegex = /\.(pdf)$/;
  return pdfRegex.test(url);
};

const ChatInterface = ({ onClick }) => {
  //Definimos estados usando useState
  const [newMessage, setNewMessage] = useState(''); // Almacena el mensaje actual del usuario
  const [chatbotImage, setChatbotImage] = useState(`${urlHost}/storage/img/chatbot/grajillo.png`); // Inicializa con la imagen abierta
  const [messages, setMensajes] = useState([]);

  // useEffect(() => {
  //   // Cada 5 segundos, cambia la imagen del chatbot
  //   const imageRotationInterval = setInterval(() => {
  //     setChatbotImage((prevImage) =>
  //       prevImage === `${urlHost}/storage/img/chatbot/grajoBurbuja.webp` ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTf1v1PjnhFSTU4KKxIIHFLzipEm7evIcG6x6kOyU2UDzBW7ALOWCfQFC5ze85YnVOsOf4&usqp=CAU' : 'https://anchaesmicasa.files.wordpress.com/2022/07/ancha-es-castilla.jpg'
  //     );
  //   }, 5000); // Cambia cada 5 segundos

  //   return () => {
  //     clearInterval(imageRotationInterval); // Limpia el intervalo cuando el componente se desmonta
  //   };
  // }, []); // El segundo argumento [] asegura que el efecto se ejecute solo una vez al montar

  // Función para enviar un mensaje
  const handleSendMessage = async () => {
    if (newMessage == ' ') {
      return;
    }

    const data = {
      message: newMessage,
    };

    // Hacer la solicitud a la API para obtener la respuesta del chatbot
    const opciones = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    };
    const response = await fetch(`${urlHost}/fastapi/chatbot`, opciones)
    try {
      if (response.ok) {
        const data = await response.json();

        if (!data.error) {
          const info = data.custom.json;
          setMensajes((prevMensajes) => [
            ...prevMensajes,
            { text: newMessage, isUser: true },
            ...info.map((message) => ({ text: message, isUser: false })),
          ]);
        }
      }
    } catch (error) {
      console.error('Error:', error);
    }
    setNewMessage(''); // Limpia el mensaje actual del usuario
  };
  const handleKeyPress = (event) => {
    if (event.key === 'Enter') {
      handleSendMessage();
    }
  };
    const messagesEndRef = useRef(null);
  useEffect(() => {
    messagesEndRef.current.scrollIntoView({ behavior: "smooth" });
  }, [messages]);

  return (
    <div className="chat-interface">

      <div className='header'>
        <div className='contenedor-header-chatBot'>
          <div className='row'>
            <div className='d-flex justify-content-center align-items-center col-md-4 contenedor-titulo-chatbot p-2'><h3 className='text-color'>Grajillo</h3></div> 
            <div className='contenedor-ImagenChatBot col-md-6 contenedor-img-chatbot'>
                <img
                  src={chatbotImage}
                  alt="Chatbot"
                  className="chatbot-image"
                />
            </div>
            <div className='d-flex justify-content-center align-items-center  col-md-2 contenedor-close-chatbot p-2'>
              <button className="w-100 close-button"  onClick={onClick}>
                <i className="fa-solid fa-xmark"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div className="chat-messages">
        {messages.map((message, index) => (
          <div key={index} className={`message ${message.isUser ? 'user' : 'bot'}`}>
            <span>
              {isImageURL(message.text) ? (
                <RViewer options={options} imageUrls={message.text}>
                  <RViewerTrigger>
                    <img className="img-chatBot-respuesta" src={message.text}/>
                  </RViewerTrigger>
                </RViewer>
              ) : (
                isPdfURL(message.text) ? (
                  <a href={message.text} download>Descargar PDF</a>
                ) : (
                  message.text
                )
              )}
            </span>
          </div>
        ))}
        
        <div ref={messagesEndRef} />
      </div>

      <div className='input-container'>
        <input
          className='input-chatBot'
          type="text"
          value={newMessage}
          onChange={(e) => setNewMessage(e.target.value)}
          onKeyPress={handleKeyPress} // Agregar el evento onKeyPress
          placeholder="Escribe un mensaje..."
        />
        <button className="button-chatBot" onClick={handleSendMessage}>Enviar</button>
      </div>

    </div>
  );

};

export default ChatInterface;