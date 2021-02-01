<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Topics;
use App\Pages;
use App\User;
use App\Shares;
use Auth;

class SearchController extends Controller
{

	public function search(Request $request)
	{
		$keywords = explode(' ', $request->keyword);
		$shared = Shares::where('shared_with', auth()->id())->pluck('page_id')->toArray();
		$results = Pages::where(function($query) use($keywords){
						foreach($keywords as $keyword){
							$query->whereHas('section', function ($q) use ($keyword) {
						        $q->where('title', 'LIKE', '%'.$keyword.'%');
						    });
						    $query->orWhere('content', 'LIKE', '%'.$keyword.'%');
						    $query->orWhere('title', 'LIKE', '%'.$keyword.'%');

						}
					})
					->where(function($query) use($shared){
						$query->where('shared', 1);
						$query->orWhere('created_by', auth()->id());
						$query->orWhereIn('id', $shared);
					})
					->orderBy('updated_at','DESC')
					->with('section','section.topic')->get();
		
		 
		return view('search', compact('results', 'keywords'));

	}

	public function user(Request $request)
	{
		$users = User::select('id', 'name as text')
				 ->where('name', 'LIKE', '%'.$request->search.'%')
				 ->where('id', '!=', auth()->id())
				 ->inRandomOrder()->take(10)->get();

		return response($users);
	}


}
