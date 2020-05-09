<?php

namespace MKulpa\PageFields\Controllers;

use MKulpa\PageFields\Models\PageFieldsSchema;
use Backend\Classes\Controller;
use Cms\Classes\Theme;
use Request;


class PageFieldsEditor extends Controller
{
    private function getFieldsPath($page)
    {
        $themeDirName = Theme::getActiveTheme()->getDirName();
        return themes_path('./' . $themeDirName . '/meta/page-fields/' . $page . '.yaml');
    }

    public function index()
    {
        $page = Request::input('page');
        $config = $this->makeConfig('$/mkulpa/pagefields/models/pagefieldsschema/fields.yaml');
        $config->model = (new PageFieldsSchema())->loadSchema($this->getFieldsPath($page));
        $this->vars['widget'] = $this->makeWidget('Backend\Widgets\Form', $config);
    }

    public function onUpdate()
    {
        $page = Request::input('page');
        $content = Request::input('content');
        PageFieldsSchema::saveSchema($this->getFieldsPath($page), $content);
    }

    public function onDelete()
    {
        $page = Request::input('page');
        PageFieldsSchema::deleteSchema($this->getFieldsPath($page));
    }
}