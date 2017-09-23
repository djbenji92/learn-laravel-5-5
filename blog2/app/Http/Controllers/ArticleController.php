<?php

namespace App\Http\Controllers;

use Validator;
use App\Article as Article;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::all();
    }
    //mode web - return view('articles/articles', ['articles' => $articles]);

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'contenu' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error'=> 400, 'message'=> 'Bad Request' ], 400);
        }

        $article = Article::create($request->all());

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        if($article == null){
            return response()->json([ 'error'=> 404, 'message'=> 'Not found' ], 404);
        }
        return $article;  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if($article == null){
            return response()->json([ 'error'=> 404, 'message'=> 'Not found' ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titre' => 'required',
            'contenu' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error'=> 400, 'message'=> 'Bad Request' ], 400);
        }

        $article->titre = $request->input('titre');
        $article->contenu = $request->input('contenu');
        $article->save();

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if($article == null){
            return response()->json([ 'error'=> 404, 'message'=> 'Not found' ], 404);
        }
        $article->delete();
        return response('', 204);
    }
}
