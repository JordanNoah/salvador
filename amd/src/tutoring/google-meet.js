import { tutoringMeetingsDelete } from "local_digitalta/repositories/tutoring_repository";
import $ from 'jquery';


export const SELECTORS = {
  BUTTONS: {
    closeCall: "#close-video-meeting",
  },
};

/**
 * Sets event listeners for the Google Meet functionality.
 */
export const setEventListeners = () => {
  $(document).on("click", SELECTORS.BUTTONS.closeCall, (event) => {
    const id = event.currentTarget.dataset.chatid;
    closeCallOnClick(id);
  });
};

/**
 * Closes the Google Meet call when the close call button is clicked.
 * @param {string} id - The ID of the chat associated with the Google Meet call.
 */
export async function closeCallOnClick(id) {

  const isDeleted = await tutoringMeetingsDelete({ chatid: id });
  if (isDeleted) {
    location.reload();
  }
}

/**
 * Initializes the Google Meet functionality by setting event listeners.
 */
export const init = () => {
  setEventListeners();
};
