const TEMPLATE_REGEX = /(?<=template\[).*(?=\])/;
const PLUGIN_BASE_URL = 'mkulpa/pagefields/PageFieldsEditor';
const doneTabs = [];

const findTemplateName = (panelItem) => {
    const inputName = panelItem.querySelector('input').getAttribute('name');
    return inputName.match(TEMPLATE_REGEX)[0].replace('.htm', '');
}

const onTabShown = (event) => {
    const target = event.target;

    if (target.closest('[data-control=tab]').getAttribute('id') != 'cms-master-tabs') return;
    if (doneTabs.includes(target)) return;

    const sidePanel = document.querySelector('#cms-side-panel');
    const currentTab = document.querySelector(target.getAttribute('data-target'));
    const formButtons = currentTab.querySelector('.form-buttons');
    const tabId = target.closest('li').getAttribute('data-tab-id');
    const selectedSidePanelItem = sidePanel.querySelector(`[data-id='${tabId}']`);

    if(!selectedSidePanelItem) return;

    const templateName = findTemplateName(selectedSidePanelItem);
    const editSchemaUrl = $.oc.backendUrl(`${PLUGIN_BASE_URL}/?page=${templateName}`);

    const editAnchor = document.createElement('a');
    editAnchor.innerHTML = `<a class="btn oc-icon-cogs" href="${editSchemaUrl}">Edit fields</a>`;
    formButtons.appendChild(editAnchor);

    doneTabs.push(target);
}


const getQueryParam = (key) => {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    return params.get(key);
}

const openTabByQuery = () => {
    const pageParam = getQueryParam('page');
    if(pageParam === null) return;

    const sidePanelItem = document.querySelector(`[name='template[${pageParam}.htm]']`).previousElementSibling;
    setTimeout(() => {
        sidePanelItem.click();
    },0)
}

$(function () {
    const $masterTabs = $('#cms-master-tabs')
    $masterTabs.on('shown.bs.tab', onTabShown);

    openTabByQuery();
})