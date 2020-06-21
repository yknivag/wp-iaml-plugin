=== Internet Archive Media Library ===
Contributors: yknivag
Donate link: https://www.paypal.com/gb/fundraiser/charity/3140872
Tags: internet archive, archive.org, internet archive mapping, archive.org mapping, internet archive media library, archive.org media library
Requires at least: 3.5
Tested up to: 5.4
Stable tag: 1.0.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Mapping file from Internet Archive into Wordpress Media Library.

== Description ==

Mapping file(s) from Internet Archive (archive.org) into Wordpress Media Library.

Supported File Types:
* Any file for general addition
* JPG/PNG/GIF files for picture meta-data
* [FUTURE (v1.1)] MP3 files for audio meta-data
* [FUTURE] More types to be added in due-course.

Features:
* Mapping file(s) from Internet Archive into WordPress Media Library.
* Determination of MIME type from file extension (for images and mp3 only).
* Real meta-data added for JPG/PNG/GIF files.
* [FUTURE (v1.1+ as above)] Addition of real meta-data to Wordpress for file where available, or sensible generic meta-data where not.
* [FUTURE (v1.2+ as above)] Option to manually edit the meta-data.

Required:
* PHP 5.3.0
* Wordpress 3.5 or greater

How it works:

1. Upload file(s) to Internet Archive (archive.org).
2. Set up IA prefix in Admin >> Media >> Internet Archive Media Library >> URL Prefix.
3. Add file name in Wordpress Admin >> Media >> Internet Archive Media Library >> Map File.
4. Go to Wordpress Admin >> Media >> Library. Now you can see your Internet Archive file in preview.
5. Once added you can edit meta-data and/or delete media from the Media Library in the normal way.

== Installation ==

1. Extract internet-archive-media-library into your WordPress plugins directory (wp-content/plugins).
2. Log in to WordPress Admin. Go to the Plugins page and click Activate for Internet Archive Media Library
3. On Wordpress Admin, go to Media => Internet Archive Media Library
4. Follow the instructions.

== Changelog ==

= 1.0.0 =
* Initial release, it's a "lite" version. Versions 1.1 will come in the future with automatic meta-data detection.

= 1.0.2 =
* Updated latest tested WP version.

== ROADMAP ==

* See version numbering next to [FUTURE] statements for anticipated future functionality steps.
