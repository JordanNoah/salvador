import $ from "jquery";
import Template from "core/templates";
import Notification from "core/notification";
import { SELECTORS } from "local_digitalta/reactions/selectors";
import { reactionsAddComment, reactionsGetComments } from "local_digitalta/repositories/reactions_repository";

/**
 * Send the comment to the server.
 * @return {void}
 */
export function sendComment() {
    const component = $(SELECTORS.BUTTONS.comment).data("component");
    const componentinstance = $(SELECTORS.ACTIONS.sendComment).data("id");
    const comment = $(SELECTORS.COMMENTS.input).val().trim();

    if (comment) {
        reactionsAddComment({ component, componentinstance, comment })
            .then((response) => {
                if (response.result) {
                    return updateUI();
                }
                return Notification.exception(response);
            })
            .fail(Notification.exception);
        $(SELECTORS.COMMENTS.input).val("");
    }
}

/**
 * Update the comments in the UI.
 * @return {void}
 */
export async function updateUI() {
    const component = $(SELECTORS.BUTTONS.comment).data("component");
    const componentinstance = $(SELECTORS.ACTIONS.sendComment).data("id");
    if (!componentinstance) {
        return;
    }
    try {
        const response = await reactionsGetComments({ component, componentinstance });
        let comments = [];
        if (response.result && response.comments) {
            comments = response.comments.map((comment) => ({
                comment: comment.comment,
                created: comment.created_raw,
                userfullname: comment.user.fullname,
                userprofileurl: M.cfg.wwwroot + "/user/profile.php?id=" + comment.user.id,
            }));
        }
        const html = await Template.render("local_digitalta/reactions/comments", { comments });
        $(SELECTORS.COMMENTS.list).html(html);
        $(SELECTORS.ACTIONS.viewComments + SELECTORS.DATA.id(componentinstance) + " span").text(
            comments.length ? comments.length : ""
        );
    } catch (error) {
        Notification.exception(error);
    }
}