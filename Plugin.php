<?php namespace MKulpa\PageFields;

use Backend;
use System\Classes\PluginBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Event;
use Yaml;

/**
 * PageFields Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'PageFields',
            'description' => 'Manage content structure for page',
            'author' => 'Mateusz Kulpa',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot(){

        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            if ($controller instanceof \Cms\Controllers\Index) {
                $controller->addJs('/plugins/mkulpa/pagefields/assets/js/main.js');
            }
        });
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('backend.form.extendFields', function ($widget) {
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            if ($widget->isNested) {
                return;
            }

            $currentPageFileName = $widget->model->getBaseFileName();
            $themeDirName = Theme::getEditTheme()->getDirName();
            $pageFieldsPath = themes_path('./' . $themeDirName . '/meta/page-fields/' . $currentPageFileName . '.yaml');
            if (!file_exists($pageFieldsPath)) return;

            $fields = Yaml::parseFile($pageFieldsPath);
            $fields = $this->updateFieldsNames($fields);
            $widget->addTabFields($fields);
        });
    }

    private function updateFieldsNames(array $fields)
    {
        $results = [];
        foreach ($fields as $key => $field) {
            if($field['type']  === 'repeater') {
                $results["viewBag[$key]"] = $field;
            }
            else {
                $results["settings[$key]"] = $field;
            }
        }
        return $results;
    }
}
