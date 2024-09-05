/**
 * @module reactions/selectors
 */

export const SELECTORS = {
    ACTIONS: {
        addLike: '[data-action="like"]',
        addDislike: '[data-action="dislike"]',
        sendComment: '[data-action="send-comment"]',
        viewComments: '[data-action="view-comments"]',
        sendReport: '[data-action="flag"]',
    },
    COMMENTS: {
        list: '#commentsList',
        input: '#commentInput',
    },
    BUTTONS: {
        likes: '#like-button',
        dislikes: '#dislike-button',
        comment: '#comment-button[data-toggle="collapse"]',
        report: "#flag-button"
    },
    COUNTS: {
        likes: '#like-button span',
        dislikes: '#dislike-button span',
        comment: '#comment-button span',
    },
    DATA: {
        id: function(id) {
            return `[data-id="${id}"]`;
        },
    },
};
