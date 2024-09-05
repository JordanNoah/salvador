import {
    changeStatusToComplete,
    deleteSection
} from "local_digitalta/cases/main";
import * as Str from "core/str";
import Modal from "core/modal";
import ModalEvents from "core/modal_events";
import ModalFactory from "core/modal_factory";
import ModalRegistry from "core/modal_registry";

const saveModal = class extends Modal {
    static TYPE = 'local_digitalta/saveModal';
    static TEMPLATE = 'local_digitalta/cases/modals/modal-save';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(saveModal.TYPE, saveModal, saveModal.TEMPLATE);

const deleteSectionModal = class extends Modal {
    static TYPE = 'local_digitalta/deleteSectionModal';
    static TEMPLATE = 'local_digitalta/cases/modals/modal-section-delete';
    registerEventListeners() {
        super.registerEventListeners();
        this.registerCloseOnSave();
        this.registerCloseOnCancel();
    }
};
ModalRegistry.register(deleteSectionModal.TYPE, deleteSectionModal, deleteSectionModal.TEMPLATE);

/**
 * Display the save modal.
 */
export const showSaveModal = async () => {
    const string_keys = [
        { key: "case:save", component: "local_digitalta" },
        { key: "case:save:confirm", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    Promise.all([strings])
        .then(([strings]) => displaySaveModal(strings));
};

/**
 * Display the save modal.
 *
 * @param {Array} strings The strings to display.
 */
const displaySaveModal = async (strings) => {
    const modal = await ModalFactory.create({
        type: saveModal.TYPE,
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
        changeStatusToComplete();
        modal.destroy();
    });
};

/**
 * Display the delete section modal.
 *
 * @param {int} sectionid The section id.
 */
export const showDeleteSectionModal = async (sectionid) => {
    const string_keys = [
        { key: "case:section:delete", component: "local_digitalta" },
        { key: "case:section:delete:confirm", component: "local_digitalta" }
    ];
    const strings = Str.get_strings(string_keys);
    Promise.all([strings])
        .then(([strings]) => displayDeleteSectionModal(strings, sectionid));
};

/**
 * Display the delete section modal.
 *
 * @param {Array} strings The strings to display.
 * @param {int} sectionid The section id.
 */
const displayDeleteSectionModal = async (strings, sectionid) => {
    const modal = await ModalFactory.create({
        type: deleteSectionModal.TYPE,
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
        deleteSection(sectionid);
        modal.destroy();
    });
};
