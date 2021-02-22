<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Markdown Editor</title>
        <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
        <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    </head>
    <body>
        <div id="app">
            <nav>
                <div class="main-nav">
                    <a href="/yourblog/" class="home">YourBlog</a>
                    <a href="/yourblog/addList" class="myaccount">リストを追加</a>
                    <div class="search">
                        <form action="/yourblog/articles" method="get">
                            @csrf
                            <input type="text" name="keyword" class="searchForm" placeholder="記事を検索" required>
                        </form>
                    </div>
                    <a href="./account" class="myaccount">account</a>
                </div>
            </nav>
            <div class="main">
                <div class="showArticles">
                    <form action="/yourblog/lists" method="post" name="deleteform" onsubmit="return disp()">
                        @csrf
                        @foreach ($lists as $item)
                            <div class ="articleWithButton">
                                <div class="article" v-on:click="jumpListContent({{$item->list_id }})">
                                    <div class="articleTitle">{{ $item->name }}</div>
                                </div>
                                @if(Auth::check())
                                    <input type="hidden" name="list_id" value="{{$item->list_id}}" />
                                    <input type="submit" class="deleteButton" value="削除">
                                @endif
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        new Vue({
            el:'#app',
            methods:{
                jumpListContent: function(id){
                    var link = "/yourblog/list_content/" + id;
                    location.href=link;
                }
            }
        })

        function disp(){
            if(window.confirm('このリストを削除しますか?')){
                return true;
            } else{
                window.alert('キャンセルされました');
                return false;
            }
        }
    </script>
</html>
