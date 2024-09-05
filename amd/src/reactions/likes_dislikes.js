import $ from "jquery";
import { reactionsToogleLikeAndDislike } from "local_digitalta/repositories/reactions_repository";
import { SELECTORS } from "local_digitalta/reactions/selectors";
import Notification from "core/notification";

/**
 * Toggle the like and dislike buttons.
 * @param {number} componentinstance - The id of the component.
 * @param {number} reactiontype - The reaction to add. 1 for like, 0 for dislike.
 */
export function toggle(componentinstance, reactiontype) {
    const component = $(SELECTORS.BUTTONS.likes).data("component");
    reactionsToogleLikeAndDislike({component, componentinstance, reactiontype})
        .then((response) => {
            return updateUI(componentinstance, response.likes, response.dislikes, response.reactiontype);
        })
        .fail(Notification.exception);
}

/**
 * Update the like and dislike buttons in the UI.
 * @param {number} componentinstance - The id of the component.
 * @param {number} likes - The number of likes.
 * @param {number} dislikes - The number of dislikes.
 * @param {number} reactiontype - The reaction to add. 1 for like, 0 for dislike.
 * @return {void}
 */
function updateUI(componentinstance, likes, dislikes, reactiontype) {
    const reactionSelectors = {
        1: SELECTORS.BUTTONS.likes,
        0: SELECTORS.BUTTONS.dislikes,
    };

    $(SELECTORS.BUTTONS.likes + SELECTORS.DATA.id(componentinstance)).removeClass("active");
    $(SELECTORS.BUTTONS.dislikes + SELECTORS.DATA.id(componentinstance)).removeClass("active");

    if (reactionSelectors.hasOwnProperty(reactiontype) && reactiontype >= 0) {
        $(reactionSelectors[reactiontype] + SELECTORS.DATA.id(componentinstance)).addClass("active");
    }

    const likesText = likes ? likes : "";
    $(SELECTORS.DATA.id(componentinstance) + SELECTORS.COUNTS.likes).text(likesText);
}
