import Ajax from 'core/ajax';

/**
 * Upsert a section
 *
 * Valid args are:
 * - id: The identifier of the section.
 * - component: The component name.
 * - componentinstance: The component instance.
 * - groupid: The identifier of the section group.
 * - groupname: The name of the section group.
 * - sequence: The sequence of the section.
 * - type: The identifier of the section type.
 * - typename: The name of the section type.
 * - title: The title of the section.
 * - content: The content of the section.
 * @method sectionsUpsert
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const sectionsUpsert = args => {
    const request = {
        methodname: 'local_digitalta_sections_upsert',
        args
    };
    return Ajax.call([request])[0];
};

/**
 * Delete a section.
 *
 * Valid args are:
 * - id (int): The section id.
 * @method sectionsDelete
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const sectionsDelete = args => {
    const request = {
        methodname: 'local_digitalta_sections_delete',
        args
    };
    return Ajax.call([request])[0];
};
