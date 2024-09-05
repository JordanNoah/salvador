import $ from 'jquery';
import {sendTutorRequest } from 'local_digitalta/tutors/main';
import { SELECTORS } from 'local_digitalta/tutors/selectors';


export const setEventListeners = () => {
    $(SELECTORS.BUTTONS.ADDREQUEST).on('click', function() {
        const id = $(this).closest('.tutor').data('id');
        sendTutorRequest(id);
    });
};