=== Internet Archive Media Library ===
Contributors: Gavin Smalley
Donate link: http://www.gavinsmalley.co.uk/
Tags: internet archive, archive.org, internet archive mapping, archive.org mapping, internet archive media library, archive.org media library
Requires at least: 3.5
Tested up to: 4.6
Stable tag: 1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Mapping file from Internet Archive into Wordpress Media Library.

== Description ==

Mapping file(s) from Internet Archive into Wordpress Media Library.

Supported File Types:
* Any file for general addition
* [FUTURE (v1.2)] JPG/PNG/GIF files for picture meta-data
* [FUTURE (v1.1)] MP3 files for audio meta-data
* [FUTURE] More types to be added in due-course.

Features:
* Mapping file(s) from Internet Archive into WordPress Media Library.
* [FUTURE (v1.1)] Determination of MIME type from file extension.
* [FUTURE (v1.1+ as above)] Addition of real meta-data to Wordpress for file where available, or sensible generic meta-data where not.
* [FUTURE (v1.1+ as above)] Option to manually edit the meta-data.

Required:
* PHP 5.3.0
* Wordpress 3.5 or greater

How it works:

1. Upload file(s) to Internet Archive (archive.org).
2. Set up IA prefix in Admin >> Media >> Internet Archive Media Library >> URL Prefix.
3. Add file name in Wordpress Admin >> Media >> Internet Archive Media Library >> Map File.
4. Go to Wordpress Admin >> Media >> Library. Now you can see your Internet Archive file in preview.

== Installation ==

1. Extract internet-archive-media-library into your WordPress plugins directory (wp-content/plugins).
2. Log in to WordPress Admin. Go to the Plugins page and click Activate for Internet Archive Media Library
3. On Wordpress Admin, go to Media => Internet Archive Media Library
4. Follow the instructions.

== Changelog ==

= 0.1 =
* Initial release, it's a "lite" version. Versions 1.x will come soon with automatic meta-data detection.

== ROADMAP ==

* See version numbering next to [FUTURE] statements for anticipated future functionality steps.