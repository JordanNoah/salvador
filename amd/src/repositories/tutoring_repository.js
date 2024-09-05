import Ajax from "core/ajax";

/**
 * Delete meeting by chatid
 *
 * Valid args are:
 * - chatid: Chat id to delete meeting from
 * @method tutoringMeetingsDelete
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with boolean indicating if meeting was deleted.
 */
export const tutoringMeetingsDelete = (args) => {
  const request = {
    methodname: "local_digitalta_tutoring_meetings_delete",
    args: args,
  };
  return Ajax.call([request])[0];
};

/**
 * Get tutors by search text
 * @method tutoringTutorsGet
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tutors.
 */
export const tutoringTutorsGet = async (args) => {
  const request = {
    methodname: "local_digitalta_tutoring_tutors_get",
    args: args,
  };
  return await Ajax.call([request])[0];
};

/**
 * Load tutors.
 *
 * Valid args are:
 * - experienceid (int): The experience id.
 * @method tutoringRequestsGet
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const tutoringRequestsGet = args => {
  const request = {
      methodname: 'local_digitalta_tutoring_requests_get',
      args: args,
  };
  return Ajax.call([request])[0];
};

/**
 * Valid args are:
 * - tutorid (int): The tutor id.
 * - experienceid (int): The experience id.
 * Add experience to tutor.
 * @method tutoringRequestsAdd
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tutors.
 */
export const tutoringRequestsAdd = async(args) => {
  const request = {
    methodname: "local_digitalta_tutoring_requests_add",
    args: args,
  };
  return await Ajax.call([request])[0];
};

/**
 * Valid args are:
 * - tutorid (int): The tutor id.
 * - experienceid (int): The experience id.
 * Add experience to tutor.
 * @method tutoringRequestsRemove
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tutors.
 */
export const tutoringRequestsRemove = async(args) => {
  const request = {
    methodname: "local_digitalta_tutoring_requests_remove",
    args: args,
  };
  return await Ajax.call([request])[0];
};

/**
 * Valid args are:
 * - requestid (int): The request id.
 * - acceptance (bool): The acceptance.
 * Add experience to tutor.
 * @method tutoringRequestsAccept
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tutors.
 */
export const tutoringRequestsAccept = async(args) => {
  const request = {
    methodname: "local_digitalta_tutoring_requests_accept",
    args: args,
  };
  return await Ajax.call([request])[0];
};
