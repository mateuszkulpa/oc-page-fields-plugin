<?php namespace MKulpa\PageFields;

use Backend;
use System\Classes\PluginBase;

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
            'name'        => 'PageFields',
            'description' => 'Manage content structure for page',
            'author'      => 'Mateusz Kulpa',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'MKulpa\PageFields\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'mkulpa.pagefields.some_permission' => [
                'tab' => 'PageFields',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'pagefields' => [
                'label'       => 'PageFields',
                'url'         => Backend::url('mkulpa/pagefields/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['mkulpa.pagefields.*'],
                'order'       => 500,
            ],
        ];
    }
}
