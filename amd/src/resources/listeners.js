import $ from "jquery";
import {
    manageResourcesModal
} from "local/digitalta/resources/modals";
import SELECTORS from "local_digitalta/experiences/selectors";

export const setEventListeners = () => {
    $(document).on("click", SELECTORS.BUTTONS.add, () => {
        manageResourcesModal();
    });
};
