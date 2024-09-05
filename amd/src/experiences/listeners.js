import $ from "jquery";
import {
    displayLinkResourceModal,
    displayLinkResourcesModal,
    showUnlinkResourceModal,
    showLockModal,
    showUnlockModal,
    showManageShareModal,
    showManageReflectionModal
} from "local_digitalta/experiences/modals";
import {
    getTutors,
    handlerAddTutorRequest,
    handlerRemoveTutorRequest
} from "local_digitalta/experiences/tutoring";
import SELECTORS from "local_digitalta/experiences/selectors";
import setChat from "local_digitalta/chat/main";

export const setEventListeners = () => {
    const experienceid = $(SELECTORS.INPUTS.experienceid).val();

    $(document).on("click", SELECTORS.BUTTONS.manage, () => {
        showManageShareModal(experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.lock, () => {
        showLockModal(experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.unlock, () => {
        showUnlockModal(experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.manageReflection, () => {
        showManageReflectionModal(experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.linkResources, () => {
        $('#reflection-resources-tab').trigger('click');
        displayLinkResourcesModal(experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.linkResource, (event) => {
        const resourceid = event.currentTarget.dataset.id;
        displayLinkResourceModal(experienceid, resourceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.unlinkResource, (event) => {
        const resourceid = event.currentTarget.dataset.id;
        showUnlinkResourceModal(experienceid, resourceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.sendTutorRequest, (event) => {
        const tutorid = event.currentTarget.dataset.tutorid;
        handlerAddTutorRequest(tutorid, experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.tutoringRequestsRemove, (event) => {
        const tutorid = event.currentTarget.dataset.tutorid;
        handlerRemoveTutorRequest(tutorid, experienceid);
    });

    $(document).on("click", SELECTORS.BUTTONS.openChat, () => {
        setChat(SELECTORS.SECTIONS.tutoringSection, experienceid);
    });

    $(document).on("input", SELECTORS.INPUTS.tutorsSearch, async(event) => {
        getTutors(event.currentTarget.value);
    });
};
