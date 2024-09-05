import Ajax from 'core/ajax';

/**
 * Get languages
 *
 * Valid args are:
 * - prioritizeInstalled: Prioritize installed languages
 * @method languagesGet
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with languages.
 */
export const languagesGet = args => {
    const request = {
        methodname: 'local_digitalta_languages_get',
        args: args
    };
    return Ajax.call([request])[0];
};
