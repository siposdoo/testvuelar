<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        //Pokupi sve citate
        
        $citati= Article::orderBy('created_at', 'desc')->paginate(15);
        return ArticleResource::collection($citati);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $citat = $request->isMethod('put') ? Article::findOrFail($request->article_id): new Article;

       $citat->id= $request->input('article_id');
       $citat->naziv= $request->input('naziv');
       $citat->text= $request->input('text');

       if($citat->save())
       {
           return new ArticleResource($citat);
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
        $citat= Article::findOrFail($id);
        return new  ArticleResource($citat);
    }

    
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citat =   Article::findOrFail($id);
        

       if($citat->delete())
       {
           return new ArticleResource($citat);
       }
    }
}
