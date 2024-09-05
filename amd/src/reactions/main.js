import { setEventListeners } from "local_digitalta/reactions/listeners";
import { updateUI as updateCommentsUI } from "local_digitalta/reactions/comments";

export const init = () => {
    setEventListeners();
    updateCommentsUI();
};
