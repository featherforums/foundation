<?php namespace Feather\Controllers;

use View;

class Home extends Base {

	/**
	 * Show the Feather homepage.
	 * 
	 * @return Illuminate\View\View
	 */
	public function showHomepage()
	{
		return View::make('feather::homepage');
	}	

}