import $ from 'jquery';
import Template from 'core/templates';
import Notification from 'core/notification';
import SELECTORS from 'local_digitalta/chat/selectors';
import { chatsGetRooms, chatsSendMessage, chatsGetMessage } from 'local_digitalta/repositories/chat_repository';
import setEventListeners from 'local_digitalta/chat/listeners';
import Status from 'local_digitalta/chat/status';
import tutorHandler from 'local_digitalta/tutors/experience_view/main';

const status = new Status();

/**
 * Create a chat in the target
 * @param {string} target
 * @param {int} experienceid
 */
export default function createChatInTarget(target, experienceid = null) {
    SELECTORS.TARGET = target;
    initComponent(experienceid);
    return;
}

/**
 * Initialize chat component
 * @param {*} experienceid
 */
const initComponent = (experienceid) => {
    setEventListeners();
    if (experienceid) {
        openChatFromExperience(experienceid);
        return;
    } else {
        renderMenuChat();
    }
    setInterval(reloaderMessages, 1000);
    tutorHandler();
};

/**
 * Render menu chat
 */
export async function renderMenuChat() {
    const { chatrooms } = await chatsGetRooms({experienceid: 0});
    Template.render(SELECTORS.TEMPLATES.MENU_CHAT, {
        chatrooms
    }).then((html) => {
        $(SELECTORS.TARGET).html(html);
        status.emptyActiveMessages();
        SELECTORS.OPEN_CHAT_ID = 0;
        tutorHandler();
        return;
    }).fail(Notification.exception);
}

/**
 * Open chat
 * @param {number} id
 * @param {boolean} hideBack
 * Render chat
 */
export async function renderChat(id, hideBack = false) {
    const { messages } = await chatsGetMessage({ chatid: id });
    SELECTORS.OPEN_CHAT_ID = id;
    Template.render(SELECTORS.TEMPLATES.CHAT, {
        hideBack
    }).then((html) => {
        $(SELECTORS.TARGET).html(html);
        handlerMessages(messages);
        status.activeMessages = messages;
        return;
    }).fail(Notification.exception);
}


/**
 * Render messages in chat
 * @param {Array} messages
 */
export async function handlerMessages(messages) {
    let html = '';
    const promises = messages.map((msg) => {
        const { message, timecreated, is_mine } = msg;
        return renderMessage(message, timecreated, is_mine);
    });
    try {
        html = (await Promise.all(promises)).join('');
        $(SELECTORS.CONTAINERS.MESSAGES).html(html);
    } catch (error) {
        Notification.exception(error);
    }
}
/**
 * Reload messages
 */
export async function reloaderMessages() {
    if (SELECTORS.OPEN_CHAT_ID) {
        const { messages } = await chatsGetMessage({ chatid: SELECTORS.OPEN_CHAT_ID });
        handlerNewOtherMessage(messages);
        return;
    }
}

/**
 * Handler new other message
 * @param {object} messages
 */
export async function handlerNewOtherMessage(messages) {
    const newMessages = findDefferencies(messages, status.activeMessages);
    const promises = newMessages.map((msg) => {
        const { message, timecreated, is_mine } = msg;
        status.activeMessages.push(msg);
        return renderMessage(message, timecreated, is_mine);
    });
    try {
        const html = (await Promise.all(promises)).join('');
        $(SELECTORS.CONTAINERS.MESSAGES).append(html);
    } catch (error) {
        Notification.exception(error);
    }
}

/**
 * Check if two objects are equals
 * @param {Array} arr1
 * @param {Array} arr2
 * @returns {Array}
 */
function findDefferencies(arr1, arr2) {
    return arr1.filter(objeto1 => {
        return !arr2.some(objeto2 => areEqualsByid(objeto1, objeto2));
    });
}

/**
 * Check if two objects are equals
 * @param {object} objeto1
 * @param {object} objeto2
 * @returns {boolean}
 */
function areEqualsByid(objeto1, objeto2) {
    return objeto1.message === objeto2.message;
}

/**
 * Render my message
 * @param {string} text
 * @param {string} time
 * @param {boolean} mine
 * @returns {Promise}
 */
export async function renderMessage(text, time, mine) {
    const TEMPLATE = mine ? SELECTORS.TEMPLATES.MY_MESSAGE : SELECTORS.TEMPLATES.OTHER_MESSAGE;
    return Template.render(TEMPLATE, { text, time });
}

/**
 * Handle send message
 * @returns {Promise}
 */
export async function handleSendMessage() {
    const message = $(SELECTORS.INPUTS.CHAT_REPLY).val().trim();
    chatsSendMessage({
        chatid: SELECTORS.OPEN_CHAT_ID,
        message,
    }).then(() => {
        $(SELECTORS.INPUTS.CHAT_REPLY).val('');
        addNewMessage(message);
        return;
    }).fail(Notification.exception);
    return;
}

/**
 * Add new message
 * @param {string} message
 */
async function addNewMessage(message) {
    const date = new Date().toLocaleTimeString('es-ES', { hour12: false, hour: '2-digit', minute: '2-digit' });
    const html = await renderMessage(message, date, true);
    status.activeMessages.push({ message, timecreated: date, is_mine: true });

    $(SELECTORS.CONTAINERS.MESSAGES).append(html);
}

/**
 * Open chat from experience
 * @param {int} experienceid
 */
export async function openChatFromExperience(experienceid) {
    const {chatrooms} = await chatsGetRooms({experienceid});
    renderChat(chatrooms[0].id, true);
}

/**
 * Render menu tutor
 * @returns {Promise}
 */
export async function renderMenuTutor() {
    Template.render(SELECTORS.TEMPLATES.MENU_MENTOR, {}).then((html) => {
        $(SELECTORS.TARGET).html(html);
        return;
    }).fail(Notification.exception);
}