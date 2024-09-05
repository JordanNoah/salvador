import Notification from "core/notification";
import { setEventListeners } from "local_digitalta/tutors/listeners";

export const sendTutorRequest = () => {
  // Enviar solicitud de tutoría
  Notification.success("Solicitud enviada correctamente");
};

export const init = () => {
  setEventListeners();
};
