import $ from 'jquery';
import Templates from 'core/templates';
import Notification from 'core/notification';
import {
    casesEdit
} from 'local_digitalta/repositories/cases_repository';
import {
    sectionsUpsert,
    sectionsDelete
} from 'local_digitalta/repositories/sections_repository';
import setEventListeners from 'local_digitalta/cases/listeners';
import {
    createTinyMCE,
    getTinyMCEContent,
    removeTinyMCEFromArea
} from 'local_digitalta/tiny/manage';
import {
    autocompleteTags
} from "local_digitalta/tags/autocomplete";
import {
    autocompleteThemes
} from "local_digitalta/themes/autocomplete";
import SELECTORS from "local_digitalta/cases/selectors";

let urlView = null;

/**
 * Add a new section to the page
 *
 * @param {number} caseid The id of the case to add the section to
 * @param {string} typename A string representing the type of section to add
 */
export const addSection = (caseid, typename) => {
    const formData = {
        id: null,
        component: 'case',
        componentinstance: caseid,
        groupid: null,
        groupname: 'General',
        sequence: null,
        type: null,
        typename: typename,
        title: null,
        content: null
    };
    sectionsUpsert(formData).then((data) => {
        Templates.render('local_digitalta/cases/manage/manage-section-text-edit', {
            id: data.sectionid,
            title: null,
            content: null
        }).then((html) => {
            $(SELECTORS.SECTIONS.sections).append(html);
            createTinyMCE(`content_${data.sectionid}`);
        }).fail(Notification.exception);
    }).fail(Notification.exception);
};

/**
 * Switches the section to view or edit mode
 *
 * @param {number} sectionid The id of the section being switched
 * @param {boolean} toEdit Whether to change to edit mode or not
 * @param {string} title The title of the section to display
 * @param {string} content The content of the section to display
 */
export const switchSectionEdition = (sectionid, toEdit = false, title = null, content = null) => {
    return new Promise((resolve, reject) => {
        const template = toEdit
            ? 'local_digitalta/cases/manage/manage-section-text-edit'
            : 'local_digitalta/cases/manage/manage-section-text-view';
        Templates.render(template, {id: sectionid, title: title, content: content})
            .then((html) => {
                if (!toEdit) {
                    removeTinyMCEFromArea(`content_${sectionid}`);
                }
                $(`#section_${sectionid}`).replaceWith(html);
                if (toEdit) {
                    createTinyMCE(`content_${sectionid}`);
                }
                return resolve();
            })
            .fail((error) => {
                reject(error);
                Notification.exception(error);
            });
    });
};

/**
 * Save the section data
 *
 * @param {number} caseid The id to which the section belongs
 * @param {number} sectionid The id of the section to save
 */
export const saveSection = (caseid, sectionid) => {
    const formData = {
        id: sectionid,
        component: 'case',
        componentinstance: caseid,
        groupid: null,
        groupname: 'General',
        sequence: null,
        type: null,
        typename: 'text',
        title: $(`#title_${sectionid}`).val(),
        content: getTinyMCEContent(`content_${sectionid}`)
    };
    sectionsUpsert(formData).then((data) => {
        switchSectionEdition(data.sectionid, false, formData.title, formData.content);
    }).fail(Notification.exception);
};

/**
 * Deletes a section
 *
 * @param {number} sectionid The id of the section to delete.
 */
export const deleteSection = (sectionid) => {
    sectionsDelete({id: sectionid}).then((data) => {
        if (data.result) {
            $(`#section_${sectionid}`).remove();
        }
        return;
    }).fail(Notification.exception);
};

/**
 * Change the status of the case to complete.
 */
export const changeStatusToComplete = async () => {
    const form = document.querySelector('#case-manage-form');
    const formData = {
        id: form.querySelector('input[name="case-id"]').value,
        title: form.querySelector('input[name="case-manage-title"]').value,
        description: getTinyMCEContent('case-manage-description'),
        lang: form.querySelector('select[name="case-manage-lang"]').value,
        status: parseInt(1),
        themes:  Array.from(
            form.querySelectorAll('select[name="case-manage-themes"] option:checked'),
            option => option.value),
        tags: Array.from(
            form.querySelectorAll('select[name="case-manage-tags"] option:checked'),
            option => option.value)
    };
    try {
        const response = await casesEdit(formData);
        Notification.addNotification({
            message: 'Case updated successfully',
            type: 'success'
        });
        location.href = urlView + response.caseid;
    } catch (error) {
        Notification.exception(error);
    }
};

/**
 * Validate the form data.
 *
 * @return {boolean} True if the form is valid.
 */
export const validateFormData = () => {
    // Declare error as false
    let error = false;
    // Hide all error messages
    $([SELECTORS.SECTIONS.formDataError,
        SELECTORS.SECTIONS.errorMissingRequiredFields,
        SELECTORS.SECTIONS.errorEditingSections
    ].join(', ')).hide();
    // Get the form
    const form = document.getElementById(SELECTORS.SECTIONS.form.replace('#', ''));
    // Validate required fields
    if (!validateManageRequiredFields(form)) {
        $(SELECTORS.SECTIONS.errorMissingRequiredFields).show();
        error = true;
    }
    // Validate editing sections
    if (!validateManageEditingSections()) {
        $(SELECTORS.SECTIONS.errorEditingSections).show();
        error = true;
    }
    // Show the error message if there is an error
    if (error) {
        $(SELECTORS.SECTIONS.formDataError).show();
        return false;
    }
    return true;
};

/**
 * Validate required fields.
 *
 * @param {HTMLElement} form The form to validate.
 * @return {boolean} True if all required fields are filled.
 */
const validateManageRequiredFields = (form) => {
    const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
    for (const field of requiredFields) {
        if (!field.value) {
            return false;
        }
    }
    return true;
};

/**
 * Validate editing sections.
 *
 * @return {boolean} True if there are no editing sections.
 */
const validateManageEditingSections = () => {
    const editingSections = document.querySelectorAll('.case-manage-section-edit');
    if (editingSections.length) {
        return false;
    }
    return true;
};

/**
 * Initialize the module.
 * @param {string} dataUrlView - The url to redirect after save the case.
 * @return {void}
 */
export const init = async(dataUrlView) => {
    urlView = dataUrlView;
    setEventListeners();
    autocompleteTags("#case-manage-tags");
    autocompleteThemes("#case-manage-themes");
    createTinyMCE('case-manage-description');
};
