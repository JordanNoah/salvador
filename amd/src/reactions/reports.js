import $ from "jquery";
import { SELECTORS } from "local_digitalta/reactions/selectors";
import Notification from "core/notification";
import { reactionsToggleReport } from "local_digitalta/repositories/reactions_repository";

/**
 * Toggle the like and dislike buttons.
 * @param {number} componentinstance - The id of the instance
 */
export function sendReport(componentinstance) {
    const component = $(SELECTORS.BUTTONS.report).data("component");
    reactionsToggleReport({ component, componentinstance })
        .then((response) => {
            return updateUI(componentinstance, response.reactiontype);
        })
        .fail(Notification.exception);
}

/**
 * Update report button in the UI.
 * @param {number} componentinstance - The id of the experience.
 * @param {number} reactiontype - The type of reaction. 1 to add, -1 to remove.
 * @return {void}
 */
function updateUI(componentinstance, reactiontype) {
    const element = $(SELECTORS.BUTTONS.report + SELECTORS.DATA.id(componentinstance));
          element.removeClass("active");
    if (reactiontype === 1) {
        element.addClass("active");
    }
}
