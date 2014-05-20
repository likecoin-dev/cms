/**
 * Js Library init
 * 
 * PongoCMS v2
 * (c) Fabio Fumis - f.fumis@gmail.com
 */

var Pongo = {
	
	base: "{{{ route('cms.index') }}}",
	site: "{{{ Request::root() }}}",
	mimes: "{{{ Media::getMimes() }}}",
	max_upload_size: "{{{ Pongo::settings('max_upload_size') * 1024000 }}}",
	max_upload_items: "{{{ Pongo::settings('max_upload_items') }}}",
	locale: "{{{ Pongo::settings('languages.'.CMSLANG.'.locale') }}}",
	directionality: "{{{ Pongo::settings('languages.'.CMSLANG.'.dir') }}}",
	cancel: "{{{ t('form.button.cancel') }}}",
	upload: "{{{ t('form.button.upload') }}}",
	load: "{{{ t('form.button.loadmore') }}}",
	noresult: "{{{ t('label.noresult.empty') }}}",
	ipp: "{{{ XPAGE }}}"

};