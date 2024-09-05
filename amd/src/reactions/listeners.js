import $ from "jquery";
import { SELECTORS } from "local_digitalta/reactions/selectors";
import { toggle as toggleLikesDislikes } from "local_digitalta/reactions/likes_dislikes";
import { sendComment } from "local_digitalta/reactions/comments";
import { sendReport } from "local_digitalta/reactions/reports";

/**
 * Set event listeners for the module.
 * @return {void}
 * */
export function setEventListeners() {
    // LIKES AND DISLIKES
    $(document).on("click", SELECTORS.ACTIONS.addLike, function () {
        toggleLikesDislikes($(this).data("id"), 1);
    });
    $(document).on("click", SELECTORS.ACTIONS.addDislike, function () {
        toggleLikesDislikes($(this).data("id"), 0);
    });
    // COMMENTS
    $(document).on("click", SELECTORS.ACTIONS.sendComment, function () {
        sendComment();
    });
    // REPORTS
    $(document).on("click", SELECTORS.ACTIONS.sendReport, function () {
        sendReport($(this).data("id"));
    });
}
