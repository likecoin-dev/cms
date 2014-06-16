$(function() {
	Pongo.Block.init();
	Pongo.Factory.createBlock('select');
	Pongo.Toggle.toggleTools();
	Pongo.Toggle.toggleZone();
	Pongo.Toggle.toggleApi();
	Pongo.Toggle.toggleLangBlockCopy();
	Pongo.UI.magnificPopup();
	Pongo.Nestable.blockList();	
	Pongo.UI.paginateList('.file-item');
	ko.applyBindings(new Pongo.VM.blockEdit());
	console.log('sections/blocks/edit.js loaded!');
});