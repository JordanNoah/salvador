import {
    autocompleteThemes
} from "local_digitalta/themes/autocomplete";
import {
    autocompleteTags
} from "local_digitalta/tags/autocomplete";
import {
    createTinyMCE,
    getTinyMCEContent
} from "local_digitalta/tiny/manage";
import {
    displayLinkResourceModal,
    displayLinkResourcesModal
} from "local_digitalta/experiences/modals";
import {
    experiencesGet
} from "local_digitalta/repositories/experiences_repository";
import {
    getList
} from "core/normalise";
import {
    languagesGet
} from "local_digitalta/repositories/languages_repository";
import {
    resourcesGet,
    resourcesUpsert,
    resourcesTypesGet
} from "local_digitalta/repositories/resources_repository";
import Modal from 'core/modal';
import ModalEvents from "core/modal_events";
import ModalFactory from "core/modal_factory";
import ModalRegistry from 'core/modal_registry';
import Notification from "core/notification";

const manageResourcesModal = class extends Modal {
    static TYPE = 'local_digitalta/manageResourcesModal';
    static TEMPLATE = 'local_digitalta/resources/modals/modal-manage';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(manageResourcesModal.TYPE, manageResourcesModal, manageResourcesModal.TEMPLATE);

/**
 * Show the add resources modal.
 *
 * @param {Number} resourceid
 * @param {Number} experienceid
 */
export const showManageResourcesModal = async (resourceid = null, experienceid = null) => {
    // Types
    const types = await resourcesTypesGet().then((response) => { return response.types; });
    // Languages
    const languages = await languagesGet({prioritizeInstalled: true});
    // Resource
    const resource = resourceid === null
        ? {}
        : await resourcesGet({id: resourceid}).then((response) => { return response.resources[0]; });
    // Experience
    const experience = experienceid === null
        ? Promise.resolve({})
        : await experiencesGet(experienceid).then((response) => response.experience);
    Promise.all([languages, resource, experience])
        .then(([languages, resource, experience]) =>
            displayManageResourcesModal(types, languages, resource, experience));
};

/**
 * Display the add resource modal.
 *
 * @param {Array} types
 * @param {Array} languages
 * @param {Object} resource
 * @param {Object} experience
 */
export const displayManageResourcesModal = async (types, languages, resource = {}, experience = {}) => {
    // Languages
    let anyLanguageSelected = false;
    languages = languages.map((language) => {
        language.selected = false;
        if (resource.hasOwnProperty('lang') && language.code === resource.lang) {
            language.selected = anyLanguageSelected = true;
        }
        return {
            key: language.code,
            value: language.name,
            selected: language.selected
        };
    });
    if (!anyLanguageSelected) {
        languages[0].selected = true;
    }
    languages[0].selected = true;
    // Types
    let anyTypeSelected = false;
    types = types.map((type) => {
        type.selected = false;
        if (resource.hasOwnProperty('type') && type.id === resource.type) {
            type.selected = anyTypeSelected = true;
        }
        return {
            key: type.id,
            value: type.name,
            selected: type.selected
        };
    });
    if (!anyTypeSelected) {
        types[0].selected = true;
    }
    const modal = await ModalFactory.create({
        type: manageResourcesModal.TYPE,
        templateContext: {
            experienceid: experience.id,
            languages: languages,
            types: types,
            current: {
                id: resource.id ?? 0,
                name: resource.name ?? null,
                path: resource.path ?? null,
                description: resource.description ?? null,
                themes: resource.themes ?? [],
                tags: resource.tags ?? [],
                type: resource.type ?? null,
                format: resource.format ?? 'Link'
            }
        },
        large: true,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    createTinyMCE('resource-manage-description');
    autocompleteTags('#resource-manage-tags');
    autocompleteThemes('#resource-manage-themes');
    if (experience) {
        const changeElement = $root.find("#changeToImportResource").get(0);
        if (changeElement) {
            changeElement.onclick = () => {
                displayLinkResourcesModal(true);
                modal.destroy();
            };
        }
    }
    $root.on(ModalEvents.save, (event, modal) => {
        event.preventDefault();
        const form = $root[0].querySelector('form');
        if (validateManageRequiredFields(form)) {
            handleManageResourcesModalSubmission(event, modal);
        }
    });
};

/**
 * Handle the submission of the dialogue.
 *
 * @param {Event} event
 * @param {Modal} modal
 */
const handleManageResourcesModalSubmission = async (event, modal) => {
    const form = getList(modal.getRoot())[0].querySelector("form");

    if (!form) {
        return;
    }
    const experienceid = form.querySelector('input[name="resource-manage-experienceid"]').value;
    const formData = {
        id: form.querySelector('input[name="resource-manage-id"]').value,
        name: form.querySelector('input[name="resource-manage-name"]').value,
        description: getTinyMCEContent('resource-manage-description'),
        type: form.querySelector('select[name="resource-manage-type"]').value,
        format: form.querySelector('input[name="resource-manage-format"]').value,
        path: form.querySelector('input[name="resource-manage-path"]').value,
        lang: form.querySelector('select[name="resource-manage-language"]').value,
        themes: Array.from(
            form.querySelectorAll('select[name="resource-manage-themes"] option:checked'),
            option => option.value),
        tags: Array.from(
            form.querySelectorAll('select[name="resource-manage-tags"] option:checked'),
            option => option.value)
    };
    try {
        const resourceid = await resourcesUpsert(formData).then((response) => { return response.resourceid; });
        Notification.addNotification({
            message: "Resource saved successfully.",
            type: 'success'
        });
        if (experienceid) {
            displayLinkResourceModal(experienceid, resourceid);
            return;
        }
        location.reload();
    } catch (error) {
        Notification.exception(error);
    }
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
            field.focus();
            return false;
        }
    }
    return true;
};
