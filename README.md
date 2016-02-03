# RandomImages Plugin for October CMS

## How it works

This plugin provides a simple component to display random images from your media library.

## Use the component

Add the `randomImages` component to the page where you want to display an image.

### Properties

#### sourcePath

Path to the source folder in your media library.

#### limit

Limit the number of returned images. Default is to return all available images.

### Example

```
[randomImages]
sourcePath = "/folder-path/"
limit = 4
==

{% component 'randomImages' %}
```

#### Access the images directly

You can access all the returned images via

```
{{ randomImages.images }}
```

##### Orientation and resizer

Use can access an `ImageResizer` instance for each image via `image.resizer`. The creation of thumbnails is currently not implemented. You have to do this yourself. 

To automatically resize the images to the viewport size use the [OFFLINE.ResponsiveImages](http://octobercms.com/plugin/offline-responsiveimages) plugin.

You can get the orientation of an image via `image.orientation`. Possible return values are `portrait` and `landscape`.

### Overwrite default markup

To overwrite the default markup of the component create a
`themes/<your-theme>/partials/randomImages/default.htm`. Paste and change the following code as needed.

```
{% for image in randomImages.images %}
    <img src="{{ image.publicUrl | app }}"
         class="image-{{ image.orientation }}"
         alt=""
    />
{% endfor %}
```