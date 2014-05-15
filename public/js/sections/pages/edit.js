$(function() {
	Pongo.Nestable.blockList();
	Pongo.Factory.createBlock();
	Pongo.Toggle.toggleOverallLayout();
	ko.applyBindings(new Pongo.VM.pageEdit());
	console.log('sections/pages/edit.js loaded!');
});