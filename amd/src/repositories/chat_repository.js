import Ajax from 'core/ajax';

/**
 * Get chat rooms.
 *
 * Valid args are:
 * experienceid (int) - The experience id (optional)
 * @method chatsGetRooms
 * @param {Object} args
 * @return {Promise}
 */
export const chatsGetRooms = args => {
    const request = {
        methodname: 'local_digitalta_chats_get_rooms',
        args
    };
    return Ajax.call([request])[0];
};


/**
 * Send chat message
 *
 * Valid args are:
 * chatid (int) - The chat id
 * message (string) - The message
 * userid (int) - The user id
 * @method chatsSendMessage
 * @param {Object} args
 * @return {Promise}
 */
export const chatsSendMessage = args => {
    const request = {
        methodname: 'local_digitalta_chats_add_message',
        args
    };
    return Ajax.call([request])[0];
};


/**
 * Get Messages
 *
 * Valid args are:
 * chatid (int) - The chat id
 * userid (int) - The user id (optional)
 * @method chatsGetMessage
 * @param {Object} args
 * @return {Promise}
 */
export const chatsGetMessage = args => {
    const request = {
        methodname: 'local_digitalta_chats_get_messages',
        args
    };
    return Ajax.call([request])[0];
};
