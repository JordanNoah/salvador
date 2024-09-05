import Autocomplete from "theme_digitalta/form-autocomplete";
import {tagsCreate} from "local_digitalta/repositories/tags_repository";
import Notification from "core/notification";

/**
 * Autocomplete tags.
 * @param {HTMLElement} area - The area to autocomplete.
 * @return {void}
 */
export function autocompleteTags(area) {
    Autocomplete.enhance(area, null, "local_digitalta/tags/autocomplete_method");
    area = area.replace("#", "");
    document.getElementById(area).addEventListener("change", function(e) {
        handleNewTag(e.target.selectedOptions);
    });
}

/**
 * Handle new tag.
 * @param {Array} selectedOptions - The selected options.
 * @return {void}
 */
async function handleNewTag(selectedOptions) {
    for (var i = 0; i < selectedOptions.length; i++) {
        if (selectedOptions[i].value === "-1") {
            selectedOptions[i].label = selectedOptions[i].label.replace("Create: ", "");
            const {id} = await saveNewTag(selectedOptions[i].label);
            selectedOptions[i].value = parseInt(id);
        }
    }
}

/**
 * Save new tag
 * @param {string} tagName - The tag name.
 * @return {Promise}
 */
async function saveNewTag(tagName) {
    try {
        return await tagsCreate({
            tag: tagName
        });
    } catch (error) {
        return Notification.exception(error);
    }
}
