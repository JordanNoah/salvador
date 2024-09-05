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
    showManageResourcesModal
} from "local_digitalta/resources/modals";
import {
    experiencesGet,
    experiencesUpsert,
    experiencesToggleStatus
} from "local_digitalta/repositories/experiences_repository";
import {
    resourcesGet,
    resourcesAssign,
    resourcesUnassign
} from "local_digitalta/repositories/resources_repository";
import {
    sectionsUpsert
} from "local_digitalta/repositories/sections_repository";
import {
    languagesGet
} from "local_digitalta/repositories/languages_repository";
import {
    getList
} from "core/normalise";
import * as Cfg from "core/config";
import * as Str from "core/str";
import Modal from "core/modal";
import ModalEvents from "core/modal_events";
import ModalFactory from "core/modal_factory";
import ModalRegistry from "core/modal_registry";
import Notification from "core/notification";

const manageModal = class extends Modal {
    static TYPE = 'local_digitalta/manageModal';
    static TEMPLATE = 'local_digitalta/experiences/modals/modal-manage';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(manageModal.TYPE, manageModal, manageModal.TEMPLATE);

const lockModal = class extends Modal {
    static TYPE = 'local_digitalta/lockModal';
    static TEMPLATE = 'local_digitalta/experiences/modals/modal-lock';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(lockModal.TYPE, lockModal, lockModal.TEMPLATE);

const unlockModal = class extends Modal {
    static TYPE = 'local_digitalta/unlockModal';
    static TEMPLATE = 'local_digitalta/experiences/modals/modal-lock';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(unlockModal.TYPE, unlockModal, unlockModal.TEMPLATE);

const manageReflectionModal = class extends Modal {
    static TYPE = 'local_digitalta/manageReflectionModal';
    static TEMPLATE = 'local_digitalta/experiences/modals/modal-reflection';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(manageReflectionModal.TYPE, manageReflectionModal, manageReflectionModal.TEMPLATE);

const linkResourcesModal = class extends Modal {
    static TYPE = "local_digitalta/linkResourcesModal";
    static TEMPLATE = "local_digitalta/experiences/modals/modal-resources";
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(linkResourcesModal.TYPE, linkResourcesModal, linkResourcesModal.TEMPLATE);

const linkResourceModal = class extends Modal {
    static TYPE = "local_digitalta/linkResourceModal";
    static TEMPLATE = "local_digitalta/experiences/modals/modal-resource-link";
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(linkResourceModal.TYPE, linkResourceModal, linkResourceModal.TEMPLATE);

const unlinkResourceModal = class extends Modal {
    static TYPE = 'local_digitalta/unlinkResourceModal';
    static TEMPLATE = 'local_digitalta/experiences/modals/modal-resource-unlink';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(unlinkResourceModal.TYPE, unlinkResourceModal, unlinkResourceModal.TEMPLATE);

// Manage modal

/**
 * Display the manage modal for asking questions
 *
 * @param {int} experienceid The experience id.
 */
export const showManageAskModal = async (experienceid = null) => {
    const string_keys = [
        { key: "teacheracademy:actions:ask", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:description", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:title", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:title:placeholder", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:visibility", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:language", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:themes", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:tags", component: "local_digitalta" },
        { key: "teacheracademy:actions:ask:picture", component: "local_digitalta" },
        { key: "visibility:public", component: "local_digitalta" },
        { key: "visibility:private", component: "local_digitalta" }
    ];
    showManageModal(experienceid, string_keys);
};

/**
 * Display the manage modal for sharing experiences.
 *
 * @param {int} experienceid The experience id.
 */
export const showManageShareModal = async (experienceid = null) => {
    const string_keys = [
        { key: "teacheracademy:actions:share", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:description", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:title", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:title:placeholder", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:visibility", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:language", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:themes", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:tags", component: "local_digitalta" },
        { key: "teacheracademy:actions:share:picture", component: "local_digitalta" },
        { key: "visibility:public", component: "local_digitalta" },
        { key: "visibility:private", component: "local_digitalta" }
    ];
    showManageModal(experienceid, string_keys);
};

/**
 * Display the manage modal.
 *
 * @param {int} experienceid The experience id.
 * @param {Array} string_keys The string keys to display.
 */
export const showManageModal = async (experienceid = null, string_keys) => {
    // Strings
    const strings = await Str.get_strings(string_keys);
    // Languages
    const languages = await languagesGet({prioritizeInstalled: true});
    // Experience
    const experience = experienceid === null
        ? Promise.resolve({})
        : await experiencesGet(experienceid).then((response) => response.experience);
    Promise.all([strings, languages, experience])
        .then(([strings, languages, experience]) =>
            displayManageModal(strings, languages, experience));
};

/**
 * Display the manage modal.
 *
 * @param {Array} strings The strings to display.
 * @param {Array} languages The list of available languages.
 * @param {Object} experience The experience object.
 *
 */
export const displayManageModal = async (strings, languages, experience = {}) => {
    // Languages
    let anyLanguageSelected = false;
    languages = languages.map((language) => {
        language.selected = false;
        if (experience.hasOwnProperty('lang') && language.code === experience.lang) {
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
    // Sections
    let sections = {};
    if (experience.sections) {
        experience.sections.forEach((section) => {
            sections[section.groupname_simplified] = section;
        });
    }
    experience.sections = sections;
    // Visibility
    let visibility = [
        { key: 1, value: strings[9] },
        { key: 0, value: strings[10] }
    ];
    let anyVisibilitySelected = false;
    visibility = visibility.map((item) => {
        item.selected = false;
        if (experience.hasOwnProperty('visible') && item.key === experience.visible) {
            item.selected = anyVisibilitySelected = true;
        }
        return {
            key: item.key,
            value: item.value,
            selected: item.key === experience.visible
        };
    });
    if (!anyVisibilitySelected) {
        visibility[0].selected = true;
    }
    const modal = await ModalFactory.create({
        type: manageModal.TYPE,
        templateContext: {
            modal: {
                title: strings[0],
                description: strings[1],
                sections: {
                    title: {
                        label: strings[2],
                        placeholder: strings[3]
                    },
                    visibility: {
                        label: strings[4]
                    },
                    language: {
                        label: strings[5]
                    },
                    themes: {
                        label: strings[6]
                    },
                    tags: {
                        label: strings[7]
                    },
                    picture: {
                        label: strings[8]
                    }
                },
                visibility: visibility,
                languages: languages
            },
            current: {
                id: experience.id ?? 0,
                title: experience.title ?? null,
                visible: experience.visible ?? null,
                lang: experience.lang ?? null,
                sections: experience.sections ?? [],
                tags: experience.tags ?? [],
                themes: experience.themes ?? []
            }
        },
        large: true,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    createTinyMCE('experience-manage-reflection-what-content');
    autocompleteTags('#experience-manage-tags');
    autocompleteThemes('#experience-manage-themes');
    $root.on(ModalEvents.save, (event, modal) => {
        event.preventDefault();
        const form = $root[0].querySelector('form');
        if (validateManageRequiredFields(form)) {
            handleManageModalSubmission(event, modal);
        }
    });
};

/**
 * Handle the submission of the modal.
 *
 * @param {Event} event
 * @param {Modal} modal
 */
const handleManageModalSubmission = async (event, modal) => {
    const form = getList(modal.getRoot())[0].querySelector("form");
    if (!form) {
        return;
    }
    const formData = {
        id: form.querySelector('input[name="experience-manage-id"]').value,
        title: form.querySelector('input[name="experience-manage-title"]').value,
        visible: form.querySelector('select[name="experience-manage-visibility"]').value,
        lang: form.querySelector('select[name="experience-manage-lang"]').value,
        sections: [
            {
                id: form.querySelector('textarea[name="experience-manage-reflection-what-content"]')
                    .getAttribute('data-id') || null,
                groupid: form.querySelector('textarea[name="experience-manage-reflection-what-content"]')
                    .getAttribute('data-groupid') || null,
                groupname: form.querySelector('textarea[name="experience-manage-reflection-what-content"]')
                    .getAttribute('data-groupname') || null,
                typename: 'text',
                content: getTinyMCEContent('experience-manage-reflection-what-content')
            }
        ],
        themes: Array.from(
            form.querySelectorAll('select[name="experience-manage-themes"] option:checked'),
            option => option.value),
        tags: Array.from(
            form.querySelectorAll('select[name="experience-manage-tags"] option:checked'),
            option => option.value)
    };
    try {
        const response = await experiencesUpsert(formData);
        Notification.addNotification({
            message: "Experience saved successfully.",
            type: 'success'
        });
        location.href = Cfg.wwwroot + '/local/digitalta/pages/experiences/view.php?id=' + response.experienceid;
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

// Lock and unlock modals

/**
 * Display the lock modal.
 *
 * @param {int} experienceid The experience id.
 */
export const showLockModal = async (experienceid) => {
    const string_keys = [
        { key: "experience:lock", component: "local_digitalta" },
        { key: "experience:lock:confirm", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    Promise.all([strings])
        .then(([strings]) => displayLockModal(strings, experienceid));
};

/**
 * Display the unlock modal.
 *
 * @param {int} experienceid The experience id.
 */
export const showUnlockModal = async (experienceid) => {
    const string_keys = [
        { key: "experience:unlock", component: "local_digitalta" },
        { key: "experience:unlock:confirm", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    Promise.all([strings])
        .then(([strings]) => displayLockModal(strings, experienceid));
};

/**
 * Display the lock/unlock modal.
 *
 * @param {Array} strings The strings to display.
 * @param {int} experienceid The experience id.
 */
const displayLockModal = async (strings, experienceid) => {
    const modal = await ModalFactory.create({
        type: lockModal.TYPE,
        templateContext: {
            modal: {
                title: strings[0],
                description: strings[1]
            }
        },
        large: false,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    $root.on(ModalEvents.save, (event) => {
        event.preventDefault();
        experiencesToggleStatus(experienceid);
        modal.destroy();
        window.location.reload();
    });
};

// Manage reflection modal

/**
 * Display the manage reflection modal.
 *
 * @param {int} experienceid The experience id.
 */
export const showManageReflectionModal = async (experienceid) => {
    // Strings
    const string_keys = [
        { key: "experience:reflection:title", component: "local_digitalta" },
        { key: "experience:reflection:description", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    // Experience
    const experience = experienceid === null
        ? Promise.resolve({})
        : await experiencesGet(experienceid).then((response) => response.experience);
    Promise.all([strings, experience])
        .then(([strings, experience]) => displayManageReflectionModal(strings, experience));
};

/**
 * Display the manage reflection modal.
 *
 * @param {Array} strings The strings to display.
 * @param {Object} experience The experience object.
 */
export const displayManageReflectionModal = async (strings, experience) => {
    let sections = {};
    experience.sections.forEach((section) => {
        sections[section.groupname_simplified] = section;
    });
    experience.sections = sections;
    const modal = await ModalFactory.create({
        type: manageReflectionModal.TYPE,
        templateContext: {
            modal: {
                title: strings[0],
                description: strings[1]
            },
            experienceid: experience.id ?? 0,
            sections: experience.sections ?? []
        },
        large: true,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    createTinyMCE('experience-manage-reflection-what-content');
    createTinyMCE('experience-manage-reflection-so_what-content');
    createTinyMCE('experience-manage-reflection-now_what-content');
    $root.on(ModalEvents.save, (event, modal) => {
        event.preventDefault();
        const form = $root[0].querySelector('form');
        if (validateManageRequiredFields(form)) {
            handleManageReflectionModalSubmission(event, modal);
        }
    });
};

/**
 * Handle the submission of the modal.
 *
 * @param {Event} event
 * @param {Modal} modal
 */
const handleManageReflectionModalSubmission = async (event, modal) => {
    const form = getList(modal.getRoot())[0].querySelector("form");
    if (!form) {
        return;
    }
    const formData = {
        id: form.querySelector('input[name="experience-manage-id"]').value,
        sections: [
            {
                id: form.querySelector('textarea[name="experience-manage-reflection-what-content"]')
                    .getAttribute('data-id'),
                groupid: form.querySelector('textarea[name="experience-manage-reflection-what-content"]')
                    .getAttribute('data-groupid'),
                content: getTinyMCEContent('experience-manage-reflection-what-content')
            },
            {
                id: form.querySelector('textarea[name="experience-manage-reflection-so_what-content"]')
                    .getAttribute('data-id'),
                groupid: form.querySelector('textarea[name="experience-manage-reflection-so_what-content"]')
                    .getAttribute('data-groupid'),
                content: getTinyMCEContent('experience-manage-reflection-so_what-content')
            },
            {
                id: form.querySelector('textarea[name="experience-manage-reflection-now_what-content"]')
                    .getAttribute('data-id'),
                groupid: form.querySelector('textarea[name="experience-manage-reflection-now_what-content"]')
                    .getAttribute('data-groupid'),
                content: getTinyMCEContent('experience-manage-reflection-now_what-content')
            }
        ]
    };
    try {
        let promises = [];
        for (const section of formData.sections) {
            promises.push(sectionsUpsert({
                'id': section.id,
                'component': 'experience',
                'componentinstance': formData.id,
                'groupid': section.groupid,
                'groupname': null,
                'sequence': null,
                'type': null,
                'typename': 'text',
                'title': null,
                'content': section.content
            }));
        }
        await Promise.all(promises);
        Notification.addNotification({
            message: "Reflection saved successfully.",
            type: 'success'
        });
        location.href = Cfg.wwwroot + '/local/digitalta/pages/experiences/view.php?id=' + formData.id;
    } catch (error) {
        Notification.exception(error);
    }
};

// Link resources modal

/**
 * Display the link resources modal.
 *
 * @param {int} experienceid The experience id.
 */
export const displayLinkResourcesModal = async (experienceid = null) => {
    const { resources } = await resourcesGet({});
    const modal = await ModalFactory.create({
        type: linkResourcesModal.TYPE,
        templateContext: {
            experienceid: experienceid,
            resources
        },
        large: true,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    const changeElement = $root.find("#changeToManageResource").get(0);
    if (changeElement) {
        changeElement.onclick = () => {
            showManageResourcesModal(null, experienceid);
            modal.destroy();
        };
    }
};

/**
 * Display the link resource modal.
 *
 * @param {int} experienceid The experience id.
 * @param {int} resourceid The resource id.
 */
export const displayLinkResourceModal = async (experienceid, resourceid) => {
    // Resource
    const resource = await resourcesGet({id: resourceid})
        .then((response) => { return response.resources[0]; });
    const modal = await ModalFactory.create({
        type: linkResourceModal.TYPE,
        templateContext: {
            experienceid: experienceid,
            resourceid: resource.id,
            resourcename: resource.name
        },
        large: true,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    createTinyMCE('experience-link-resource-description');
    $root.on(ModalEvents.save, (event, modal) => {
        handleLinkResourceModalSubmission(event, modal);
    });
};

/**
 * Handle the submission of the modal.
 *
 * @param {Event} event
 * @param {Modal} modal
 */
const handleLinkResourceModalSubmission = async (event, modal) => {
    const form = getList(modal.getRoot())[0].querySelector("form");
    if (!form) {
        return;
    }
    const formData = {
        resourceid: form.querySelector('input[name="resourceid"]').value,
        component: 'experience',
        componentinstance: form.querySelector('input[name="experienceid"]').value,
        description: getTinyMCEContent('experience-link-resource-description')
    };
    try {
        await resourcesAssign(formData);
        Notification.addNotification({
            message: "Resource linked successfully.",
            type: 'success'
        });
        location.reload();
    }
    catch (error) {
        Notification.exception(error);
    }
};

/**
 * Display the unlink resource modal.
 *
 * @param {int} experienceid The experience id.
 * @param {int} resourceid The resource id.
 */
export const showUnlinkResourceModal = async (experienceid, resourceid) => {
    const string_keys = [
        { key: "experience:resources:unlink", component: "local_digitalta" },
        { key: "experience:resources:unlink:confirm", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    Promise.all([strings])
        .then(([strings]) => displayUnlinkResourceModal(strings, experienceid, resourceid));
};

/**
 * Display the unlink resource modal.
 *
 * @param {Array} strings The strings to display.
 * @param {int} experienceid The experience id.
 * @param {int} resourceid The resource id.
 */
const displayUnlinkResourceModal = async (strings, experienceid, resourceid) => {
    const modal = await ModalFactory.create({
        type: lockModal.TYPE,
        templateContext: {
            modal: {
                title: strings[0],
                description: strings[1]
            }
        },
        large: false,
        removeOnClose: true
    });
    modal.show();
    const $root = modal.getRoot();
    $root.on(ModalEvents.save, async (event, modal) => {
        event.preventDefault();
        try {
            await resourcesUnassign({
                id: resourceid,
                component: 'experience',
                componentinstance: experienceid
            });
            Notification.addNotification({
                message: "Resource unlinked successfully.",
                type: 'success'
            });
            modal.destroy();
            window.location.reload();
        } catch (error) {
            Notification.exception(error);
        }
    });
};
