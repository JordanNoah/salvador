import Ajax from 'core/ajax';

/**
 * Get tags
 *
 * Valid args are:
 * - searchText: The tag to search
 * @method tagsGet
 * @param {object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tags.
 */
export const tagsGet = args => {
    const request = {
        methodname: 'local_digitalta_tags_get',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Create tags.
 *
 * Valid args are:
 * - tag: The tag to create
 * @method tagsCreate
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with tags.
 */
export const tagsCreate = args => {
    const request = {
        methodname: 'local_digitalta_tags_create',
        args: args
    };
    return Ajax.call([request])[0];
};
