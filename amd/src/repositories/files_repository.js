import Ajax from "core/ajax";

/**
 * Prepare draft area HTML.
 *
 * Valid args are:
 * - filearea: The file area.
 * - component: The component.
 * - filecontextid: The context id.
 *
 * @method prepareDraftAreaHTML
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const prepareDraftAreaHTML = args => {
    const request = {
        methodname: "local_digitalta_files_prepare_draft_area_html",
        args: args,
    };
    return Ajax.call([request])[0];
};

/**
 * Upload file from draft.
 *
 * Valid args are:
 * - draftid: The id of the draft.
 * - fileid: The id of the file.
 * - filearea: The file area.
 * - contextid: The context id.
 *
 * @method filesUploadFromDraft
 * @param {Object} args Arguments send to the webservice.
 * @return {Promise} Resolve with warnings.
 */
export const filesUploadFromDraft = args => {
    const request = {
        methodname: "local_digitalta_files_upload_from_draft",
        args: args,
    };
    return Ajax.call([request])[0];
};
