<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;


class ArticleController extends Controller
{
    public function index(){
        $articles=Article::all();
        return response()->json($articles,200);
    }
    public function show($id){
        $article=Article::find($id);
        return response()->json($article,200);
    }
    public function store(Request $request){
        $article=Article::create($request->all());
        return response()->json($article,201);
    }
    public function update(Request $request,$id){
        $article=Article::find($id);
        $items=$request->all();
        $article=$article->update($items);
//        $article=$article->update($request->all());
        return response()->json($article,200);
    }
    public function delete($id){
        Article::find($id)->delete();
        return response()->json(null,204);
    }
}
