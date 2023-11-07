//importar hel useState y el effect
import React, { useState, useEffect } from 'react';

function Chatbot() {
  
  //mensajeUser: Almacena el mensaje que el usuario está escribiendo en el chat.
  const [mensajeUser, setMensajeUser] = useState('');

  //mensajes: Almacena la lista de mensajes que se mostran en el chat.
  const [mensajes, setMensajes] = useState([]);

 //isLoading: Indica si se está haciendo una solicitud al servidor.
  const [isLoading, setIsLoading] = useState(false);

  //comprueba si el mensaje no esta vacio
  const handleEnviarMensaje = async () => {
    if (mensajeUser === '') {
      return;
    }

    // Crear un JSON 
    const data = {
      message: mensajeUser,
    };

    // Realizar la solicitud POST con fetch
    setIsLoading(true);

    try {
      const response = await fetch('http://localhost/fastapi/chatbot', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });
        // lee la respuesta del JSON de la solicitud y si esta todo gucci se almacena en la variable data.
      if (response.ok) {
        const data = await response.json();

          // Procesa la respuesta JSON
        if (!data.error) {
          const info = data.custom.json;
          //se actualiza el estado mensajes con los mensajes del chat
          setMensajes((prevMensajes) => [
            ...prevMensajes,
            { text: mensajeUser, isUser: true },
            ...info.map((message) => ({ text: message, isUser: false })),
          ]);
        }
      }

     // errores con try catch
    } catch (error) {
      console.error('Error:', error);
    }
    //hace que se deje de esperar respuesta del server como dio exitoso 
    setMensajeUser('');
    setIsLoading(false);
  };

  //ver el estado del mensaje y crea el componente que es como el "form" por asi decirlo
  useEffect(() => {
  }, [mensajes]);
  return (
    <div>
      <h1>Grajillo</h1>

      <Mensajes mensajes={mensajes} />

      <input
        id="mensaje"
        type="text"
        value={mensajeUser}
        onChange={(e) => setMensajeUser(e.target.value)}
      />
      <button onClick={handleEnviarMensaje} disabled={isLoading}>
        Enviar
      </button>
    </div>
  );
}
//estos de aqui muestran laconversacion del usuario con el bot estructuradamente siendo el 
function Mensajes({ mensajes }) {
  return (
    <div className="mensajes">
      {mensajes.map((mensaje, index) => (
        <Mensaje key={index} mensaje={mensaje} />
      ))}
    </div>
  );
}

function Mensaje({ mensaje }) {
  const className = mensaje.isUser
    ? 'respuestaBot mensajeUsuario col-lg-9'
    : 'mensajeUsuario col-lg-9';
  return (
    <div className={`col-lg-12 d-flex row ${mensaje.isUser ? 'justify-content-end align-items-end' : 'justify-content-start align-items-start'}`}>
      <span className={className}>{mensaje.text}</span>
    </div>
  );
}
export default Chatbot;