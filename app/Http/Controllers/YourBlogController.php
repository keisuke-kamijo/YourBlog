<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class YourBlogController extends Controller{
    public function index(){
        $id = 1;//決め打ち
        $username = DB::table('users')->where('user_id',$id)->select('username')->first()->username;
        $articleNum = DB::table('users')->where('user_id',$id)->count();
        $articleIDs = DB::table('articles')->where('user_id',$id)->select('article_id')->get();
        $tagArray = array();
        foreach($articleIDs as $articleID){
            $tags = DB::table('article_tags')->join('tags','article_tags.tag_id','=','tags.tag_id')->where('article_id',$articleID->article_id)->select('name')->get();
            foreach($tags as $tag){
                array_push($tagArray,$tag->name);
            }
        }
        $items = [
            'username' => $username,
            'articleNum' => $articleNum,
            'tagArray' => $tagArray,
        ];
        return view('yourblog.index',['items'=> $items]);
    }
    public function editor(Request $request){
        return view('yourblog.editor');
    }
    public function post(Request $request){
        date_default_timezone_set('Asia/Tokyo');

        $Timestamp = date("Y-m-d h:i:s");

        $articleData = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => 0,
            'create_time' => $Timestamp,
            'update_time' => $Timestamp,
            'user_id' => 1,                               //ユーザID決め打ち：いずれ直すべき
        ];
        $articleNextID = DB::table('articles')->insertGetId($articleData,'article_id');
        //DB::table('articles')->insert($articleData);

        $tags = $request->tags;
        $tagList = explode(' ',$tags);
        foreach($tagList as $tag){
            if(DB::table('tags')->where('name',$tag)->exists($tag)){
                $tagNextID = DB::table('tags')->where('name',$tag)->first()->tag_id;
            }else{
                $tagData = ['name'=>$tag];
                $tagNextID = DB::table('tags')->insertGetId($tagData,'tag_id');
                //DB::table('tags')->insert($tagData);
            }
            $articleTagsData = [
                'article_id' => $articleNextID,
                'tag_id' => $tagNextID,
            ];
            DB::table('article_tags')->insert($articleTagsData);
        }

        return redirect('/yourblog');
    }
    public function article(Request $request){
        $id = $request->id;
        $title = DB::table('articles')->where('article_id',$id)->select('title')->first()->title;
        $tags = DB::table('article_tags')->join('tags','article_tags.tag_id','=','tags.tag_id')->where('article_id',$id)->select('name')->get();
        $content = DB::table('articles')->where('article_id',$id)->select('content')->first()->content;

        $articleData = [
            'title' => $title,
            'tags' => $tags,
            'content' => $content,
        ];

        return view('yourblog.article',['articleData'=>$articleData]);
    }

    public function articles(Request $request){
        $articles = DB::table('articles')->orderBy('create_time','desc')->select('article_id','title')->get();
        //dump($articles);
        return view('yourblog.articles',['articles'=>$articles]);
    }

    public function lists(){
        $lists = DB::table('lists')->select('list_id','name')->get();
        return view('yourblog.lists',['lists'=>$lists]);
    }

    public function list_content(Request $request){
        $id = $request->id;
        $articles = DB::table('list_mappings')->join('articles','list_mappings.article_id','=','articles.article_id')->where('list_id',$id)->orderBy('rank')->select('list_mappings.article_id','title')->get();
        return view('yourblog.articles',['articles'=>$articles]);
    }
}
