<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pages;
use App\Sections;
use App\Attatchment;
use Auth, Image;

class PageController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $section_id = $request->section_id;
        $content = view('append.page_blank', compact('section_id'))->render();

        return response(['status' => true, 'content' => $content]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'section_id' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'error' => $validator->messages()->first()]);
        }

        try{
            $section = Sections::find($request->section_id);
            if(!$section){
                return response(['status' => false, 'error' => 'section not found']);
            }
            $content = $this->domPost($request->content);

            $page = new Pages();
            $page->title = $request->title;
            $page->content = $content;
            $page->section_id = $request->section_id;
            $page->created_by = Auth::id();
            $page->save();

            if($request->file('attatcement') != null){

                foreach ($request->file('attatcement') as $key => $att) 
                {
                    $originalName = $att->getClientOriginalName();
                    $fileName = uniqid().'.'.$att->extension();  
       
                    $att->move(public_path('attatchments'), $fileName);

                    Attatchment::create([
                        'page_id' => $page->id,
                        'url' => 'attatchments/'.$fileName,
                        'name' => $request->name[$key]??$originalName
                    ]);

                }
            }

            $menu_item = view('append.page_item', compact('page'))->render();
            $content = view('append.page_content', compact('page'))->render();



            return response(['status' => true, 'content' => $content, 'menu_item' => $menu_item, 'page' => $page, 'section' => $section]);
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
        $page = Pages::where(['id' => $id, 'created_by' => Auth::id()])->first();
        $section = Sections::find($page->section_id);
        $content = view('append.page_content', compact('page'))->render();

        return response(['status' => true, 'content' => $content, 'page' => $page, 'section' => $section]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Pages::where(['id' => $id, 'created_by' => Auth::id()])->first();
        $content = view('append.page_edit', compact('page'))->render();

        return response(['status' => true, 'content' => $content]);
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
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'error' => $validator->messages()->first()]);
        }

        try{
            $page = Pages::where(['id' => $id, 'created_by' => Auth::id()])->first();
            if($page){

                $content = $this->domPost($request->content);

                $page->title = $request->title;
                $page->content = $content;
                $page->save();

                if($request->file('attatcement') != null){

                    foreach ($request->file('attatcement') as $key => $att) 
                    {
                        $originalName = $att->getClientOriginalName();
                        $fileName = uniqid().'.'.$att->extension();  
           
                        $att->move(public_path('attatchments'), $fileName);

                        Attatchment::create([
                            'page_id' => $id,
                            'url' => 'attatchments/'.$fileName,
                            'name' => $request->name[$key]??$originalName
                        ]);

                    }
                }
                $page = Pages::find($id);
                $content = view('append.page_content', compact('page'))->render();
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
        Pages::where(['id' => $id, 'created_by' => Auth::id()])->delete();
        return response(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAtt($id)
    {
        $att = Attatchment::with('page')->find($id);
        if($att->page['created_by'] == auth()->id()){
            unlink(public_path($att->url));
            $att->delete();
        }
        return response(['status' => true]);

    }


    public function domPost($content)
    {
        libxml_use_internal_errors(true);
        $dom = new \DomDocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$content);    
        $images = $dom->getElementsByTagName('img');
        if(count($images)>0)
        {
            foreach($images as $k => $img)
            {
                $src = $img->getAttribute('src');
                # if the img source is 'data-url'
                if(preg_match('/data:image/', $src))
                {
                    # get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    # Generating a random filename
                    $filename = uniqid();
                    $filepath = "images/uploads/$filename.$mimetype";
                    $image = Image::make($src)
                            ->encode($mimetype, 100)  # encode file to the specified mimetype
                            ->save(public_path($filepath));
                    

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                }
            }
        }
        # modified entity ready to store in database
        $content = $dom->saveHTML($dom->documentElement);

        return $content;

    }
}
