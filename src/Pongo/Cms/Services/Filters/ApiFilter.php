<?php namespace Pongo\Cms\Services\Filters;

use Alert, Auth;

class ApiFilter {
	
	public function authFilter()
	{
		if (Auth::guest())	{
			$msg = t('alert.error.session_exp');
			Alert::error($msg)->flash();
			return json_encode(
				array(
					'status' => 'error',
					'type' => 'expired'
				)
			);
		}
	}

}