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
        $items = DB::select('select * from users');
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
        $content = str_replace("\r\n",'`',$content);
        $content = str_replace("\r",'`',$content);
        $content = str_replace("\n",'`',$content);
        $articleData = [
            'title' => $title,
            'tags' => $tags,
            'content' => $content,
        ];

        dump($articleData['content']);
        return view('yourblog.article',['articleData'=>$articleData]);
    }
}
