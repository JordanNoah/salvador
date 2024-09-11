import {exception as displayException} from 'core/notification';
import Templates from 'core/templates';
import $ from 'jquery';
import Ajax from 'core/ajax';
let pages = 0;

let filters = [];
let selectedPage = 1;
export const init = () => {
    getAndRenderFilters();
    getExperiences();

    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });

    $(document).on("click", "li.page-item.page-link.page", function() {
        const clickedPage = $(this).attr('attr-page');
        if (selectedPage !== clickedPage) {
            selectedPage = parseInt(clickedPage);
            getExperiences();
        }
    });
    $(document).on("click", "li.page-item.page-link.state", function() {
        const state = $(this).attr('aria-label');
        if (state === 'Next') {
            const posibleNextPage = selectedPage + 1;
            if (posibleNextPage > 0 && posibleNextPage <= pages) {
                selectedPage++;
                getExperiences();
            }
        } else if (state === 'Previous') {
            const posiblePreviousPage = selectedPage - 1;
            if (posiblePreviousPage > 0 && posiblePreviousPage <= pages) {
                selectedPage--;
                getExperiences();
            }
        }
    });

    $(document).on("change", ".filterThemeSelect", function() {
        //const selectedValue = $(this).val();
        const selectedText = $("option:selected.enable", this).text();
        if (selectedText.length > 0) {
            const element = $("option:selected.enable", this);
            element.addClass('disabled');
            element.removeClass('enable');
            console.log(element);
            const filterObject = {"type": "theme", "value": selectedText};
            setFilter(filterObject);
        }
    });

    $(document).on("keydown", "#inlineFormInputGroup", function(event) {
        // Verificamos si la tecla Enter fue presionada (keyCode 13 o event.which 13)
        if (event.key === "Enter" || event.keyCode === 13) {
            const filterText = $(this).val(); // Obtenemos el valor del input
            const filterObject = {"type": "tag", "value": filterText};
            setFilter(filterObject);
            $(this).val(''); // Limpiamos el input
        }
    });

    $(document).on("keydown", "#autorFilters", async function() {
        const filterText = $(this).val(); // Obtenemos el valor del input
        const request = {
            methodname: 'core_enrol_get_potential_users',
            args: {courseid: 1, enrolid: 1, page: 0, perpage: 10, search: filterText, searchanywhere: true}
        };
        const response = await Ajax.call([request])[0];

        const authorsSuggestions = await Templates.renderForPromise('local_digitalta/_common/listAutors', {users: response});
        Templates.replaceNodeContents("#suggestionsAutors", authorsSuggestions.html, authorsSuggestions.js);


        console.log(authorsSuggestions);
        console.log(response);
    });

    $(".tagsInputFilter").on("click", function() {
        console.log($(this));
    });


    $(document).on("click", "#removeFilter", function() {
        const filterText = $(this).attr('attr-filter');
        const filterType = $(this).attr('attr-type');
        const filterObject = {"type": filterType, "value": filterText};
        removeFilter(filterObject);
    });
};

const getExperiences = async() => {
    const request = {
        methodname: 'local_digitalta_experiences_get_by_pagination',
        args: {
            'pagenumber': selectedPage,
            'filters': JSON.stringify(filters)
        }
    };
    const response = await Ajax.call([request])[0];

    if (response.data.length === 0) {
        Templates.renderForPromise('local_digitalta/_common/empty-view', response).then(({html, js}) => {
            Templates.replaceNodeContents("#list-experience-body", html, js);
        }).catch((error) => displayException(error));
    } else {
        let obj = {"experiences": response};
        let paginationArray = generatePagination(response.pages, selectedPage);
        const experienceList = await Templates.renderForPromise('local_digitalta/experiences/dashboard/experience-list',
            obj
        );
        pages = response.pages;
        const pagination = await Templates.renderForPromise('local_digitalta/_common/pagination', {"pages": paginationArray});
        Templates.replaceNodeContents("#list-experience-body", experienceList.html, experienceList.js);
        Templates.replaceNodeContents("#digital-pagination", pagination.html, pagination.js);
    }
};

const generatePagination = (totalPages, selectedPage) => {
    let pagination = [];
    for (let i = 0; i < totalPages; i++) {
        let page = {
            page: i + 1,
            selected: i + 1 === selectedPage
        };
        pagination.push(page);
    }
    return pagination;
};

const getAndRenderFilters = async() => {
    const themesRequest = {
        methodname: 'local_digitalta_themes_get',
        args: {}
    };
    const tagsRequest = {methodname: 'local_digitalta_tags_get', args: {}};
    const languajesRequest = {methodname: 'local_digitalta_experiences_get_used_langs', args: {}};
    const themesResponse = await Ajax.call([themesRequest])[0];
    const tagsResponse = await Ajax.call([tagsRequest])[0];
    const languajesResponse = await Ajax.call([languajesRequest])[0];

    // eslint-disable-next-line max-len
    const templateFilterThemes = await Templates.renderForPromise('local_digitalta/_common/filterTheme', {"themes": themesResponse});
    // eslint-disable-next-line max-len
    const templateFilterLanguajes = await Templates.renderForPromise('local_digitalta/_common/filterLanguajes', {"languajes": languajesResponse});
    Templates.replaceNodeContents("#filterThemeSelect", templateFilterThemes.html, templateFilterThemes.js);
    Templates.replaceNodeContents("#filterLanguajeSelect", templateFilterLanguajes.html, templateFilterLanguajes.js);

    const availableTags = tagsResponse.map(function(tag) {
        return tag.name;
    });

    // Evento de entrada en el campo de texto
    $('#inlineFormInputGroup').on('input', function() {
        var input = $(this).val().toLowerCase();
        var suggestions = availableTags.filter(function(tag) {
            return tag.toLowerCase().startsWith(input);
        });

        // Mostrar sugerencias
        showSuggestions(suggestions);
    });


};

const showSuggestions = (suggestions) => {
    // Eliminar las sugerencias anteriores
    $('.autocomplete-suggestions').remove();

    // Crear una lista para las sugerencias
    var suggestionList = $('<ul class="autocomplete-suggestions list-group list-group-tags" id="list-group-tags"></ul>');
    if (suggestions.length === 0) {
        var item = $('<li class="list-group-item">No hay sugerencias</li>');
        suggestionList.append(item);
    } else {
        suggestions.forEach(function(suggestion) {
            var item = $('<li class="list-group-item tagFilters enable">' + suggestion + '</li>');
            item.on('click', function() {
                $('#inlineFormInputGroup').val(suggestion);
                suggestionList.remove(); // Eliminar la lista de sugerencias al seleccionar
            });
            suggestionList.append(item);
        });

        // Añadir la lista de sugerencias justo después del input
        $('.autocomplete-wrapper').append(suggestionList);
    }
};

const setFilter = (filterObject) => {
    filters.push(filterObject);
    selectedPage = 1;
    renderFilters();
};

const removeFilter = (filterObject) => {
    const index = filters.findIndex((filter) => {
        return filter.type === filterObject.type && filter.value === filterObject.value;
    });
    if (index > -1) {
        if (filterObject.type === 'theme') {
            let themeSelect = $("#filterThemes");
            let option = $('option[value="'+filterObject.value+'"].disabled', themeSelect);
            option.removeClass('disabled');
            option.addClass('enable');
        }
        filters.splice(index, 1);
        selectedPage = 1;
        renderFilters();
    }
};

const renderFilters = () => {
    getExperiences();
    Templates.renderForPromise('local_digitalta/_common/filterList', {filters: filters}).then(({html, js}) => {
        Templates.replaceNodeContents("#filtersList", html, js);
    }).catch((error) => displayException(error));
};