import Ajax from 'core/ajax';

/**
 * Get all resources.
 *
 * Valid args are:
 * - id: The resource id
 * - filters: The resource filters
 * @method resourcesGet
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const resourcesGet = args => {
    const request = {
        methodname: 'local_digitalta_resources_get',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Upsert a resource.
 *
 * Valid args are:
 * - id: The resource id
 * - name: The resource name
 * - description: The resource description
 * - themes: The resource themes
 * - tags: The resource tags
 * - format: The resource format
 * - type: The resource type
 * - path: The resource path
 * - lang: The resource language
 * @method resourcesUpsert
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const resourcesUpsert = args => {
    const request = {
        methodname: 'local_digitalta_resources_upsert',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Get all resources types.
 *
 * @method resourcesTypesGet
 * @return {Promise} Resolve with warnings.
 */
export const resourcesTypesGet = () => {
    const request = {
        methodname: 'local_digitalta_resources_types_get',
        args: {}
    };
    return Ajax.call([request])[0];
};

/**
 * Assign resources to a context.
 *
 * Valid args are:
 * - resourceid: The resource id
 * - component: The component name
 * - componentinstance: The component instance
 * - description: The description
 * @method resourcesAssign
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const resourcesAssign = args => {
    const request = {
        methodname: 'local_digitalta_resources_assign',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Unassign resources from a context.
 *
 * Valid args are:
 * - id: The resource id
 * - component: The component name
 * - componentinstance: The component instance
 * @method resourcesUnassign
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const resourcesUnassign = args => {
    const request = {
        methodname: 'local_digitalta_resources_unassign',
        args: args
    };
    return Ajax.call([request])[0];
};

/**
 * Get the resources assigned to a component.
 *
 * Valid args are:
 * - component: The component name
 * - componentinstance: The component instance
 * @method resourcesGetComponentAssignments
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const resourcesGetComponentAssignments = args => {
    const request = {
        methodname: 'local_digitalta_resources_get_assignments_for_component',
        args: args
    };
    return Ajax.call([request])[0];
};
