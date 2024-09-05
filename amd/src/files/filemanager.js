import $ from "jquery";
import { prepareDraftAreaHTML, filesUploadFromDraft } from "local_digitalta/repositories/files_repository";
import Notification from "core/notification";

/**
 * Prepare the draft area HTML.
 * @param {string} fileArea - The area of the file.
 * @param {string} component - The component.
 * @param {number} fileContextId - The context id.
 * @return {Promise} Resolve with warnings.
 */
export const prepareDraftHTML = (fileArea, component, fileContextId) => {
    return prepareDraftAreaHTML({
        filearea: fileArea,
        component: component,
        filecontextid: fileContextId,
    })
    .then((response) => {
        return response;
    })
    .fail(Notification.exception);
};

/**
 * Save files to the server.
 * @param {string} containerId - The id of the container.
 * @param {string} fileinputId - The id of the file input.
 * @param {string} fileid - The id of the file.
 * @param {string} filearea - The area of the file.
 * @param {number} contextid - The context id.
 * @return {Promise} Resolve with warnings.
 */
export const saveFiles = (containerId, fileinputId, fileid, filearea, contextid = 1) => {
    const fileContainer = $(`#${containerId} `);
    const draftid = fileContainer.find(`#${fileinputId}`).attr("Value");
    return filesUploadFromDraft({
        draftid,
        fileid,
        filearea,
        contextid,
    })
    .then((response) => {
        return response;
    })
    .fail(Notification.exception);
};

/**
 * Initialize the file manager.
 * @param {string} containerId - The id of the container.
 * @return {void}
 */
export const init = (containerId) => {
    $(`#${containerId}`).html(M.custom.filemanager.html);
};
