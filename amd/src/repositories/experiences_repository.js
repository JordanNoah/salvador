import Ajax from 'core/ajax';

/**
 * Gets an experience.
 *
 * Valid args are:
 * - experienceid: The experience id
 * @method experiencesGet
 * @param {number} experienceid The experience id.
 * @return {Promise} Resolve with warnings.
 */
export const experiencesGet = (experienceid) => {
    const request = {
        methodname: 'local_digitalta_experiences_get',
        args: {id: experienceid}
    };
    return Ajax.call([request])[0];
};

/**
 * Upsert an experience.
 *
 * Valid args are:
 * - id: The experience id (optional)
 * - title: The title of the experience
 * - visible: The visibility of the experience
 * - lang: The language of the experience
 * - status: The status of the experience (optional)
 * - themes: The themes of the experience
 * - tags: The tags of the experience
 * @method experiencesUpsert
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const experiencesUpsert = args => {
    const request = {
        methodname: 'local_digitalta_experiences_upsert',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Toggle the status of an experience.
 *
 * Valid args are:
 * - experienceid: The experience id
 * @method experiencesToggleStatus
 * @param {number} experienceid The experience id.
 * @return {Promise} Resolve with warnings.
 */
export const experiencesToggleStatus = (experienceid) => {
    const request = {
        methodname: 'local_digitalta_experiences_toggle_status',
        args: {id: experienceid}
    };
    return Ajax.call([request])[0];
};
