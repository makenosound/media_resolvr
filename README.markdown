# Media Resolvr #

Version: 0.1  
Author: [Max Wheeler](http://makenosound.com)  
Build Date: 02 December 2009  
Requirements: Symphony 2.0.6+

***

**Media Resolvr** is an extension for [Symphony CMS](http://symphony-cms.com/) that makes it easier resolve page URIs to their embeddable media. Flickrs disconnect between page URIs (e.g., <http://www.flickr.com/photos/makenosound/4025741494/>) and the actual image URI (e.e.g, <http://farm4.static.flickr.com/3501/4025741494_5d20396e87.jpg>) was the impetus for developing this extension, though it can be useful for other services.

## Installation ##

1. Upload the `/media_resolvr/` folder in this archive to your Symphony `/extensions/` folder.
2. Enable it by selecting the **Media Resolvr**, choose Enable from the with-selected menu, then click Apply.
3. You can now use the **Media Resolvr** as per the usage instructions below.

## Usage ##

This extension add an extra rewrite rule to the Symphony `.htaccess` file that lets you construct URIs to embeddable media with the following structure:

    http://domain.tld/resolvr/http://service.tld/url-to-media-page/

So in the case of the Flickr photo page noted above, you would be able to use the following code to embed a (defult to medium size) image;

    <img src="http://domain.tld/resolvr/http://www.flickr.com/photos/makenosound/4025741494/"/>

## Services supported ##
### Flickr ###

Resolves Flickr photo page URIs to their respective images. Additional URI parameters are:

`size`, any value from 0-5 where:

  * `Square:    0`
  * `Thumbnail: 1`
  * `Small:     2`
  * `Medium:    3`
  * `Large:     4`
  * `Original:  5`

If the requested size is not available (or not set) the `Medium` size will be returned. For example, retrieving the `Original` size would go something like:

    http://domain.tld/resolvr/http://www.flickr.com/photos/makenosound/4025741494/?size=5

### Blip.tv ###

Resolves [blip.tv](http://blip.tv/) video page URIs to the Show Player Flash file. No additional settings available.
