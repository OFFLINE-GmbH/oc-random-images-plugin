<?php namespace OFFLINE\RandomImages\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Cms\Classes\MediaLibrary;
use Config;
use Illuminate\Support\Collection;

/**
 * Display random images from your media library
 * on your website.
 *
 * @package OFFLINE\RandomImages\Components
 */
class RandomImages extends ComponentBase
{
    /**
     * @var MediaLibrary
     */
    public $mediaLibrary;
    /**
     * @var Collection
     */
    public $images;
    /**
     * @var string
     */
    protected $storagePath;

    /**
     * RandomImages constructor.
     *
     * Get an MediaLibrary instance to work with.
     *
     * @param CodeBase|null $cmsObject
     * @param array         $properties
     */
    public function __construct(CodeBase $cmsObject = null, $properties = [], $mediaLibrary = null)
    {
        parent::__construct($cmsObject, $properties);

        $this->mediaLibrary = $mediaLibrary ?: MediaLibrary::instance();
        $storagePath        = rtrim(Config::get('cms.storage.media.path', '/storage/app/media'), '/');

        $this->storagePath = str_replace('/storage', '', $storagePath);
    }

    /**
     * Component details.
     *
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Random images',
            'description' => 'Displays random images',
        ];
    }

    /**
     * Component properties.
     *
     * @return array
     */
    public function defineProperties()
    {
        return [
            'sourcePath' => [
                'title'       => 'Source path',
                'description' => 'Where to load your images from',
                'type'        => 'dropdown',
                'default'     => '/',
            ],
            'limit'      => [
                'title'             => 'Limit count',
                'description'       => 'Only load a specific number of images',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Only numbers are allowed',
                'default'           => '',
            ],
        ];
    }

    /**
     * Gets all available directories from the media library.
     *
     * @return array
     */
    public function getSourcePathOptions()
    {
        $directories = $this->mediaLibrary->listAllDirectories();

        array_unshift($directories, '/');

        return array_combine($directories, $directories);
    }


    /**
     * Set the images property.
     *
     * Shuffles all files and sets the selected slice of
     * the collection as the image property.
     *
     * @return void
     */
    public function onRun()
    {
        $images = $this->getImageCollection()
                       ->shuffle();

        if ($this->property('limit')) {
            $images->slice(0, (int)$this->property('limit'));
        }

        $this->images = $images;
    }

    /**
     * Gets the contents of sourcePath, filters out all
     * the files and returns them as a Collection object.
     *
     * @return Collection
     */
    protected function getImageCollection()
    {
        return collect($this->getFolderContents($this->property('sourcePath')))
            ->filter(function ($image) {
                return $image->type === 'file';
            })->each(function ($image) {
                $resizer = new \OFFLINE\RandomImages\Classes\ImageResizer(
                    storage_path($this->storagePath . $image->path)
                );

                $image->orientation = $resizer->getWidth() > $resizer->getHeight() ? 'landscape' : 'portrait';
                $image->resizer     = $resizer;

                return $image;
            });
    }

    /**
     * Returns the raw contents of sourcePath.
     *
     * @param $path
     *
     * @return array
     */
    protected function getFolderContents($path)
    {
        return $this->mediaLibrary->listFolderContents($path, 'title', 'image');
    }

}