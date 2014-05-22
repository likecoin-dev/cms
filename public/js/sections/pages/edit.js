$(function() {
	Pongo.Nestable.blockList();
	Pongo.Factory.createBlock();
	Pongo.File.uploadFile();
	Pongo.Toggle.toggleOverallLayout();
	Pongo.UI.checkAllCopy();
	Pongo.UI.magnificPopup();
	Pongo.UI.paginateList('.file-item');
	Pongo.UI.tagSelectize();
	ko.applyBindings(new Pongo.VM.pageEdit());
	console.log('sections/pages/edit.js loaded!');
});