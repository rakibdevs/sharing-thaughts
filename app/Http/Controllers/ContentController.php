<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topics;
use App\Sections;
use App\Pages;
use Auth;
class ContentController extends Controller
{
    public function show(Request $request)
    {
    	// get parameters
    	$parameter = [];
    	$parameter['topic'] = $request->topic??null;
    	$parameter['section'] = $request->section??null;
    	$parameter['page'] = $request->page??null;

    	// if not set get first values of nested category;
    	if($parameter['topic'] == null){
            $topic = Topics::where('created_by', Auth::id())->first();
            $parameter['topic_name'] = $topic->title??'';
    		$parameter['topic'] = $topic->id??'';
    	}else{
            $topic = Topics::where(['created_by' => Auth::id(), 'id' => $parameter['topic']])->first();
            $parameter['topic_name'] = $topic->title??'';
        }
    	if($parameter['section'] == null){
    		// nested section based on topic
    		$parameter['section'] = Sections::where([
    			'topic_id' => $parameter['topic'], 
    			'created_by'=> Auth::id()
    		])->first()->id??null; 
    	}

    	if($parameter['page'] == null){
    		// nested page based on section
    		$parameter['page'] = Pages::where([
    			'section_id' => $parameter['section'], 
    			'created_by'=> Auth::id()
    		])->first()->id??null; 
    	}

    	$sections = Sections::where([
    		'topic_id' => $parameter['topic'], 
    		'created_by'=> Auth::id()
    	])->get();

    	$pages = Pages::where([
    		'section_id' => $parameter['section'], 
    		'created_by'=> Auth::id()
    	])->get();

    	$page = Pages::where(['id' => $parameter['page'], 'created_by'=> Auth::id()])->first();
        
        return view('content', compact('sections','pages','page', 'parameter'))->with('id', 1);
    }
}
