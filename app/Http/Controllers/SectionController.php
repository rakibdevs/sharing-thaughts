<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Sections;
use Auth;

class SectionController extends Controller
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
            'title' => 'required',
            'topic_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'error' => $validator->messages()->first()]);
        }

        try{
            $section = new Sections();
            $section->title = $request->title;
            $section->slug = $section->slugify($request->title);
            $section->topic_id = $request->topic_id;
            $section->created_by = Auth::id();
            $section->save();

            $content = view('append.section_item', compact('section'))->render();

            return response(['status' => true, 'content' => $content]);
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return response(['status' => false, 'error' => $bug]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Sections::with('page')->where(['id' => $id, 'created_by' => Auth::id()])->first();
        $menu = view('append.page_menu', compact('section'))->render();
        // get first page
        $page = $section->page[0]??'';
        $content = view('append.page_content', compact('page'))->render();

        return response(['status' => true, 'content' => $content, 'menu' => $menu, 'section' => $section]);
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
            $section = Sections::where(['id' => $id, 'created_by' => Auth::id()])->first();
            if($section ){        
                $section->title = $request->title;
                $section->slug = $section->slugify($request->title);
                $section->save();
                $content = view('append.section_item', compact('section'))->render();

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
        Sections::where(['id' => $id, 'created_by' => Auth::id()])->delete();
        return response(['status' => true]);
    }
}
