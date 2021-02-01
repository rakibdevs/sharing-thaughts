<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Topics;
use App\Pages; 
use App\Shares;
use Auth;

class ShareController extends Controller
{
	public function shared()
	{

		$private = Shares::where('shared_with', Auth::id())
					->pluck('page_id')
					->toArray();

		$results = Pages::with('user','section','section.topic')
				    ->where('created_by','!=', auth()->id())
				    ->where('shared',1)
					->orWhere(function ($query) use ($private) {
					    $query->whereIn('id', $private);
					})
					->orderBy('updated_at', 'DESC')
					->paginate(16);
		

		return view('shared', compact('results'));

	}

	public function sharedContent($id, $slug)
	{

		$query = Pages::with('user','section','section.topic')
				 ->findOrFail($id);
		$page = null;
		if(check_private($id) != null || $query->shared == 1){
			$page  = $query;
		}
		
					    
		return view('shared-single', compact('page'));
	}

	public function shareToAll($id)
	{
		$page = Pages::find($id)->update([
			'shared' => 1
		]);

		Shares::where('page_id', $id)->delete();
		return response(['status' => true]);

	}

	public function shareRemoveAll($id)
	{
		$page = Pages::find($id)->update([
			'shared' => 0
		]);
		return response(['status' => true]);

	}

	public function share($id, Request $request)
	{
		$users = json_decode($request->shared_with);
		if (isset($users)) {
			foreach ($users as $key => $user) {
				$share = new Shares();
				$share->page_id = $id;
				$share->shared_with = $user;
				$share->save();
			}
		}

		$page = Pages::find($id)->update([
			'shared' => 0
		]);
		
		$count = toBangla(count($users));

		return response(['status' => true, 'count' => $count]);

	}

	public function shareRemove($id)
	{
		$page = Shares::where('page_id',$id)->delete();

		return response(['status' => true]);

	}

	public function shareUpdate($id, Request $request)
	{
		$existing = Shares::where('page_id',$id)->pluck('shared_with')->toArray();
		$users = json_decode($request->shared_with);

		$deleted = array_diff($existing, $users);
		if($deleted){
			foreach ($deleted as $key => $user) {
				Shares::where(['page_id' => $id, 'shared_with' => $user])->delete();
			}
		}
		// create
		if (isset($users)) {
			foreach ($users as $key => $user) {
				$share = Shares::firstOrCreate([
					'page_id' => $id,
					'shared_with' => $user
				]);
			}
		}


		
		$count = toBangla(count($users));

		return response(['status' => true, 'count' => $count]);

	}

	public function edit($id, Request $request)
	{
		$page = Pages::find($id);
		$shared_with = Shares::where('page_id',$id)->pluck('shared_with')->toArray();
		$share = $request->shared_with;
		$content = view('append.share_edit', compact('page','share','shared_with'))->render();
		
		return response(['status' => true, 'content' => $content]);

	}


}
