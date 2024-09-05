import Ajax from 'core/ajax';

/**
 * Get themes
 *
 * Valid args are:
 * - searchText: The theme to search
 * @method themesGet
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with themes.
 */
export const themesGet = args => {
    const request = {
        methodname: 'local_digitalta_themes_get',
        args: args
    };
    return Ajax.call([request])[0];
};
