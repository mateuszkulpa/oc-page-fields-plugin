<?php

namespace MKulpa\PageFields\Controllers;

use MKulpa\PageFields\Models\PageFieldsSchema;
use Backend\Classes\Controller;
use Cms\Classes\Theme;
use October\Rain\Filesystem\Filesystem;
use October\Rain\Support\Facades\Flash;
use Request;


class PageFieldsEditor extends Controller
{
    private $fileSystem;
    public function __construct()
    {
        $this->fileSystem = new Filesystem();
        parent::__construct();
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
        $this->saveSchema($this->getFieldsPath($page), $content);
        Flash::success('Page fields schema updated');
    }

    public function onDelete()
    {
        $page = Request::input('page');
        $this->deleteSchema($this->getFieldsPath($page));
        Flash::info('Page fields schema deleted');
    }

    private function getFieldsPath($page)
    {
        $themeDirName = Theme::getActiveTheme()->getDirName();
        return themes_path('./' . $themeDirName . '/meta/page-fields/' . $page . '.yaml');
    }

    private function createDirectoryForSchemaIfNotExists($schemaPath)
    {
        $schemaPath = $this->fileSystem->normalizePath($schemaPath);
        $pathSegments = explode("/", $schemaPath);
        array_pop($pathSegments);
        $dirPath = implode("/", $pathSegments);

        if (!$this->fileSystem->exists($dirPath))
            $this->fileSystem->makeDirectory($dirPath, null, true);
    }

    private function saveSchema($schemaPath, $content)
    {
        if ($this->fileSystem->exists($schemaPath)) {
            $this->fileSystem->put($schemaPath, $content);
        } else {
            $this->createDirectoryForSchemaIfNotExists($schemaPath);
            $this->fileSystem->put($schemaPath, $content);
        }
    }

    private function deleteSchema($schemaPath)
    {
        $this->fileSystem->delete($schemaPath);
    }

}