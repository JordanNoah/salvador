import {
    showManageAskModal as experienceAskQuestion,
    showManageShareModal as experienceShare
} from "local_digitalta/experiences/modals";
import {
    showManageModal as caseCreate
} from "local_digitalta/cases/modals";

export const handleAction = async (action) => {
    const actionType = action.action;
    const actionValue = action.value;
    switch (actionType) {
        case "modal_ask":
            experienceAskQuestion();
            break;
        case "modal_share":
            experienceShare();
            break;
        case "modal_create":
            caseCreate();
            break;
        case "open_url":
            location.href = actionValue;
            break;
        default:
    }
};

export const init = () => {
    document.querySelectorAll(".action").forEach((action => {
        action.addEventListener("click", (() => handleAction(action.dataset)));
    }));
};
