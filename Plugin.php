<?php namespace OFFLINE\RandomImages;

use Backend;
use System\Classes\PluginBase;

/**
 * RandomImages Plugin Information File
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
            'name'        => 'RandomImages',
            'description' => 'Display random images from your media library',
            'author'      => 'OFFLINE GmbH',
            'icon'        => 'icon-file-image-o'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'OFFLINE\RandomImages\Components\RandomImages' => 'randomImages',
        ];
    }
    
    /**
     * Registers any static pages snippets.
     *
     * @return array
     */
    public function registerPageSnippets()
    {
        return [
            'OFFLINE\RandomImages\Components\RandomImages' => 'randomImages',
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
            'offline.randomimages.some_permission' => [
                'tab' => 'RandomImages',
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
            'randomimages' => [
                'label'       => 'RandomImages',
                'url'         => Backend::url('offline/randomimages/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['offline.randomimages.*'],
                'order'       => 500,
            ],
        ];
    }

}
