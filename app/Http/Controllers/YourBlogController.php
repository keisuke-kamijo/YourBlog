<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class YourBlogController extends Controller{
    public function index(){
        $id = 1;//決め打ち
        $username = DB::table('users')->where('id',$id)->select('name')->first()->name;
        $articleNum = DB::table('users')->where('id',$id)->count();
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

        $tags = $request->tags;
        $tagList = explode(' ',$tags);
        foreach($tagList as $tag){
            if(DB::table('tags')->where('name',$tag)->exists($tag)){
                $tagNextID = DB::table('tags')->where('name',$tag)->first()->tag_id;
            }else{
                $tagData = ['name'=>$tag];
                $tagNextID = DB::table('tags')->insertGetId($tagData,'tag_id');
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

        $user_id = 1;
        $lists = DB::table('lists')->where('user_id',$user_id)->select('list_id','name')->get();

        $articleData = [
            'article_id' => $request->id,
            'title' => $title,
            'tags' => $tags,
            'content' => $content,
        ];

        return view('yourblog.article',['articleData'=>$articleData,'lists'=>$lists]);
    }

    public function appendArticle(Request $request){
        date_default_timezone_set('Asia/Tokyo');
        if(DB::table('list_mappings')->where('list_id',$request->list_id)->count()==0){
            $rank = 1;
        }else{
            $lists = DB::table('list_mappings')->orderBy('rank','desc')->where('list_id',$request->list_id)->select('rank')->first();
            $rank=$lists->rank+1;
        }
        $Timestamp = date("Y-m-d h:i:s");
        $new_record = [
            'article_id' => $request->article_id,
            'list_id' => $request->list_id,
            'rank' => $rank,
            'update_time' => $Timestamp,
        ];
        DB::table('list_mappings')->insert($new_record);

        return redirect('/yourblog/article/'.$request->article_id);
    }

    public function deleteArticle(Request $request){
        $article_id = $request->article_id;
        DB::table('articles')->where('article_id',$article_id)->delete();
        return redirect('/yourblog');
    }

    public function articles(Request $request){
        if(!$request->filled('keyword') && !$request->filled('tag')){
            $articles = DB::table('articles')->orderBy('create_time','desc')->select('article_id','title')->get();
        }elseif($request->filled('tag')){
            $tag = $request->tag;
            $articles = DB::table('articles')->join('article_tags','articles.article_id','=','article_tags.article_id')->join('tags','article_tags.tag_id','=','tags.tag_id')->where('tags.name',$tag)->orderBy('articles.create_time','desc')->select('articles.article_id','title')->get()->unique();
        }elseif($request->filled('keyword')){
            $keyword = $request->keyword;
            $articles = DB::table('articles')->where('title','like',"%$keyword%")->orderBy('create_time','desc')->select('article_id','title')->get();
        }

        //dump($articles);
        return view('yourblog.articles',['articles'=>$articles]);
    }

    public function lists(){
        $lists = DB::table('lists')->select('list_id','name')->get();
        return view('yourblog.lists',['lists'=>$lists]);
    }

    public function delete_list(Request $request){
        $list_id = $request->list_id;
        DB::table('lists')->where('list_id',$list_id)->delete();
        DB::table('list_mappings')->where('list_id',$list_id)->delete();
        return redirect('/yourblog/lists');
    }

    public function list_content(Request $request){
        $id = $request->id;
        $list_name = DB::table('lists')->where('list_id',$id)->select('name')->first()->name;
        $articles = DB::table('list_mappings')->join('articles','list_mappings.article_id','=','articles.article_id')->where('list_id',$id)->orderBy('rank')->select('list_mappings.article_id','title')->get();
        return view('yourblog.list_content',['articles'=>$articles,'list_id'=>$id ,'list_name'=>$list_name]);
    }

    public function deleteArticleOnList(Request $request){
        DB::table('list_mappings')->where('list_id',$request->list_id)->where('article_id',$request->article_id)->delete();
        return redirect('/yourblog/list_content/'.$request->list_id);
    }

    public function add_list(){
        return view('yourblog.addList');
    }

    public function create_list(Request $request){
        $listTitle = $request->listTitle;
        $listData = [
            'name'=>$listTitle,
            'user_id'=>1,
        ];
        DB::table('lists')->insert($listData);
        return redirect('/yourblog/lists');
    }
}
