<?php namespace Pongo\Cms\Models\Observers;

class PageObserver extends BaseObserver {

	public function deleting($page) {

		// Page has still some blocks
		/*if (count($page->blocks)) {
			$this->setFlashError('alert.error.page_has_blocks');
			return false;
		}*/

		// Page has still some subpages
		if (count($page->subpages)) {
			$this->setFlashError('alert.error.page_has_subpages');
			return false;
		}

		// Page is homepage
		if ($page->is_home == 1) {
			$this->setFlashError('alert.error.page_is_homepage');
			return false;
		}

		// Page is still valid
		if ($page->is_active == 1) {
			$this->setFlashError('alert.error.page_is_active');
			return false;
		}

		// Your role level is not enough
		if ($page->edit_level > LEVEL) {
			$this->setFlashError('alert.error.page_not_level');
			return false;
		}

		// Page is currently viewed
		if ($page->id == \Input::get('current_page')) {
			$this->setFlashError('alert.error.page_is_current');
			return false;
		}
	}

}