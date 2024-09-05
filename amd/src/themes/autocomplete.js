import Autocomplete from "theme_digitalta/form-autocomplete";

/**
 * Autocomplete themes.
 * @param {HTMLElement} area - The area to autocomplete.
 * @return {void}
 */
export function autocompleteThemes(area) {
    Autocomplete.enhance(area, null, "local_digitalta/themes/autocomplete_method");
    area = area.replace("#", "");
}
