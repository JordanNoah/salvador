/**
 * @module reactions/selectors
 */

const SELECTORS = {
    TARGET: "",
    OPEN_CHAT_ID: 0,
    TEMPLATES: {
        "MENU_CHAT": "local_digitalta/test/menu_chat/index",
        "CHAT": "local_digitalta/test/chat/index",
        "MY_MESSAGE": "local_digitalta/test/chat/message_my",
        "OTHER_MESSAGE": "local_digitalta/test/chat/message_other",
        "MENU_MENTOR": "local_digitalta/test/menu_tutor/index",
    },
    BUTTONS: {
        "OPEN_CHAT": ".open-chat",
        "BACK_MENU": "#back-menu",
        "BACK_MENU_EXPERIENCE": "#back-menu-experience",
        "REPLY": "#reply-message"
    },
    INPUTS: {
        "CHAT_REPLY": "#chat-reply-input",
    },
    CONTAINERS: {
        "MESSAGES": "#message-list"
    }
};

export default SELECTORS;