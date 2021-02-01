<?php
use App\Topics;
use App\User;
use App\Shares;

if (! function_exists('topics')) {
	function topics()
	{
		return Topics::where('created_by', auth()->id())->get();
	}
}

if (! function_exists('toBangla')) {
	function toBangla($string)
	{
		$numbers = array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
		return strtr($string,$numbers);
	}
}

if (! function_exists('users')) {
	function users()
	{
		return User::where('id', '!=', auth()->id())->pluck('name','id');
	}
}

if (! function_exists('check_private')) {
	function check_private($id)
	{
		return  Shares::where('shared_with', auth()->id())
					->where('page_id', $id)
					->first();

	}
}