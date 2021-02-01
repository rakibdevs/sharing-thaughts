<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Topics;
use Auth;

class TopicController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'error' => $validator->messages()->first()]);
        }

        try{
            $topic = new Topics();
            $topic->title = $request->title;
            $topic->slug = $topic->slugify($request->title);
            $topic->created_by = Auth::id();
            $topic->save();

            $content = view('append.topic_item', compact('topic'))->render();

            return response(['status' => true, 'content' => $content]);
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return response(['status' => false, 'error' => $bug]);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'error' => $validator->messages()->first()]);
        }

        try{
            $topic = Topics::where(['id' => $id, 'created_by' => Auth::id()])->first();
            if($topic ){        
                $topic->title = $request->title;
                $topic->slug = $topic->slugify($request->title);
                $topic->save();
                $content = view('append.topic_item', compact('topic'))->render();

                return response(['status' => true, 'content' => $content]);
            }

            return response(['status' => false, 'error' => 'not found']);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return response(['status' => false, 'error' => $bug]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Topics::where(['id' => $id, 'created_by' => Auth::id()])->delete();
        return response(['status' => true]);
    }
}
