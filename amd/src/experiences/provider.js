import {exception as displayException} from 'core/notification';
import Templates from 'core/templates';
import $ from 'jquery';
import Ajax from 'core/ajax';
export const init = () => {

    let experiences = {experiences: {data: []}};

    let selectedPage = 1;

    getExperiences(selectedPage);
    $(document).on("click","li.page-item.page-link.page",function() {
        const clickedPage = $(this).attr('attr-page');
        if (selectedPage !== clickedPage) {
            selectedPage = clickedPage;
            getExperiences(selectedPage);
        }
    });

    if (experiences.experiences.data.length === 0) {
        Templates.renderForPromise('local_digitalta/_common/empty-view',experiences).then(({html, js}) => {
            Templates.appendNodeContents("#list-experience-body", html, js);
        }).catch((error) => displayException(error));
    }else{
        Templates.renderForPromise('local_digitalta/experiences/dashboard/experience-list', experiences).then(({html, js}) => {
            Templates.appendNodeContents("#list-experience-body", html, js);
        }).catch((error) => displayException(error));
    }
};

const getExperiences = async (selectedPage) => {
    let pagination = [{
        page:1,
        selected:false
    },{
        page:2,
        selected:false
    },{
        page:3,
        selected:false
    }];
    pagination = pagination.map(item => {
        return {
            ...item,
            selected: item.page == selectedPage
        };
    });

    const request = {
        methodname: 'local_digitalta_experiences_get_by_pagination',
        args: {
            'pagenumber':selectedPage,
            'filters':JSON.stringify([])
        }
    };
    const response = await Ajax.call([request])[0];

    console.log(response);
    Templates.renderForPromise('local_digitalta/_common/pagination', {pages:pagination}).then(({html, js}) => {
        $("#digital-pagination").empty();
        Templates.appendNodeContents("#digital-pagination", html, js);
    }).catch((error) => displayException(error));
};