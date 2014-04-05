/**
 *	PongoCMS v2
 *
 *	Pongo Namespace definition
 *
 *	Javascript Library Bootstrap
 *	ver 0.0.1
 *
 *	Fabio Fumis - pongoweb.it
 */

var Pongo = {};

Pongo.base = '{{route('cms.index')}}';
Pongo.mimes = '{{str_replace(' ', '', Pongo::settings('mimes'))}}';
Pongo.max_upload_size = '{{Pongo::settings('max_upload_size') * 1024000}}';
Pongo.max_upload_items = '{{Pongo::settings('max_upload_items')}}';
Pongo.locale = '{{Pongo::settings('languages.'.CMSLANG.'.locale')}}';
Pongo.directionality = '{{Pongo::settings('languages.'.CMSLANG.'.dir')}}';
Pongo.cancel = '{{t('form.button.cancel')}}';
Pongo.upload = '{{t('form.button.upload')}}';
Pongo.load = '{{t('form.button.load')}}';
Pongo.results = '{{t('label.user.all.results')}}';