import Ajax from 'core/ajax';

/**
 * Get cases.
 * @method casesGet
 * @return {Promise} Resolve with warnings.
 */
export const casesGet = () => {
    const request = {
        methodname: 'local_digitalta_cases_get',
        args: {}
    };
    return Ajax.call([request])[0];
};

/**
 * Edit a case.
 *
 * Valid args are:
 * - caseid: The id of the case.
 * - title: The title of the case.
 * - description: The description of the case.
 * - lang: The language of the case.
 * - status: The status of the case.
 * - themes: The themes of the case.
 * - tags: The tags of the case.
 * @method casesEdit
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const casesEdit = args => {
    const request = {
        methodname: 'local_digitalta_cases_edit',
        args: args
    };
    return Ajax.call([request])[0];
};
