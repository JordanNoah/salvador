import {tutoringTutorsGet, tutoringRequestsAdd, tutoringRequestsRemove} from "local_digitalta/repositories/tutoring_repository";
import Templates from "core/templates";
import Notification from "core/notification";
import SELECTORS from "local_digitalta/experiences/selectors";
import $ from "jquery";

export const getTutors = async (searchText) => {
  if (!searchText.trim()) {
    $(SELECTORS.SECTIONS.tutoringTutorsGetResults).empty();
    return;
  }
  const experienceid = $("#experience-id").val();
  const tutors = await tutoringTutorsGet({ searchText: searchText, experienceid });
  await addTutorsResults(tutors);
};

/**
 * Add tutors to the results div
 * @param {object} tutorsData
 * @return {void}
 */
export function addTutorsResults(tutorsData) {
  Templates.render("local_digitalta/test/menu_tutor/item-search", {
    tutors: tutorsData,
  }).then((html) => {
    $(SELECTORS.SECTIONS.tutoringTutorsGetResults).html(html);
    return;
  }).catch((error) => {
    Notification.exception(error);
  });
}

/**
 * Add tutor request
 * @param {int} tutorid
 * @param {int} experienceid
 */
export function handlerAddTutorRequest(tutorid, experienceid) {
  const args = {tutorid, experienceid};
  tutoringRequestsAdd(args).then(() => {
    getTutors($(SELECTORS.INPUTS.tutorsSearch).val());
    return;
  }).catch((error) => {
    Notification.exception(error);
  });
}


/**
 * Remove tutor request
 * @param {int} tutorid
 * @param {int} experienceid
 */
export function handlerRemoveTutorRequest(tutorid, experienceid) {
  const args = {tutorid, experienceid};
  tutoringRequestsRemove(args).then(() => {
    getTutors($(SELECTORS.INPUTS.tutorsSearch).val());
    return;
  }).catch((error) => {
    Notification.exception(error);
  });
}
