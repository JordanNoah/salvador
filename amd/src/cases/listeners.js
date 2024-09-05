import $ from "jquery";
import {
    addSection,
    switchSectionEdition,
    saveSection,
    validateFormData
} from "local_digitalta/cases/main";
import {
    showDeleteSectionModal,
    showSaveModal
} from "local_digitalta/cases/modals";
import SELECTORS from "local_digitalta/cases/selectors";

/**
 * Set event listeners for the page.
 * @return {void}
 */
export default function setEventListeners() {
    const caseid = $(SELECTORS.INPUTS.caseid).val();

    $(document).on('click', SELECTORS.BUTTONS.addSection, (event) => {
        event.preventDefault();
        addSection(caseid, 'text');
    });

    $(document).on('click', SELECTORS.BUTTONS.editSection, async function (event) {
        const sectionid = event.currentTarget.dataset.id;
        const sectiontitle = $(`#title_${sectionid}`).text().trim();
        const sectioncontent = $(`#content_${sectionid}`).html();
        await switchSectionEdition(sectionid, true, sectiontitle, sectioncontent);
    });

    $(document).on('click', SELECTORS.BUTTONS.cancelEditSection, function (event) {
        const sectionid = event.currentTarget.dataset.id;
        const sectiontitle = $(`#title_${sectionid}_original`).val();
        const sectioncontent = $(`#content_${sectionid}_original`).val();
        switchSectionEdition(sectionid, false, sectiontitle, sectioncontent);
    });

    $(document).on('click', SELECTORS.BUTTONS.saveSection, function (event) {
        const sectionid = event.currentTarget.dataset.id;
        saveSection(caseid, sectionid);
    });

    $(document).on('click', SELECTORS.BUTTONS.deleteSection, function(event) {
        const sectionid = event.currentTarget.dataset.id;
        showDeleteSectionModal(sectionid);
    });

    $(document).on('click', SELECTORS.BUTTONS.saveCase, function() {
        if (validateFormData()) {
            showSaveModal();
        }
    });
}
