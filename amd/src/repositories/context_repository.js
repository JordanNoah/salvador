import Ajax from 'core/ajax';

/**
 * Upsert a context.
 *
 * Valid args are:
 * - component: The component name.
 * - componentinstance: The component instance.
 * - modifier: The modifier.
 * - modifierinstance: The modifier instance.
 * @method contextUpsert
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const contextUpsert = args => {
    const request = {
        methodname: 'local_digitalta_context_upsert',
        args
    };
    return Ajax.call([request])[0];
};


/**
 * Delete a context.
 *
 * Valid args are:
 * - id (int): The context id.
 * @method contextDelete
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const contextDelete = args => {
    const request = {
        methodname: 'local_digitalta_context_delete',
        args
    };
    return Ajax.call([request])[0];
};
