import $ from "jquery";
import TutorView from "local_digitalta/tutors/experience_view/main";
import { SELECTORS } from "local_digitalta/tutors/experience_view/selectors";
import {tutoringRequestsAccept} from "local_digitalta/repositories/tutoring_repository";

export const setEventListeners = () => {
  $(SELECTORS.ACTION.SEE_REQUESTS).on("click", function () {
    TutorView.openTutorsRequests();
  });

  $(document).on("click", SELECTORS.BUTTONS.ACCEPT, function () {
    acceptanceRequestHandler($(this).data("requestid"), true);
  });

  $(document).on("click", SELECTORS.BUTTONS.REJECT, function() {
    acceptanceRequestHandler($(this).data("requestid"), false);
  });
};


/**
 * Acceptance request handler
 * @param {int} requestid
 * @param {bool} acceptance
 */
export async function acceptanceRequestHandler(requestid, acceptance) {
  await tutoringRequestsAccept({
    requestid: requestid,
    acceptance: acceptance,
  });
  window.location.reload();
}