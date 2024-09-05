export default class Status {
    constructor() {
        // Status to save
        this._activeMessages = [];
    }

    get activeMessages() {
        return this._activeMessages;
    }

    set activeMessages(messages) {
        this._activeMessages = messages;
    }

    emptyActiveMessages() {
        this._activeMessages = [];
    }

    hasChanged(attribute, value) {
        if (this[attribute] !== value) {
            return true;
        }
        return false;
    }
}
