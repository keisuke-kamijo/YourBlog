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
                    <div class="search">
                        <form action="" method="post">
                            @csrf
                            <input type="text" name="search" class="searchForm" placeholder="記事を検索">
                        </form>
                    </div>
                    <a href="./account" class="myaccount">account</a>
                </div>
            </nav>
            <div class="main">
                <div class="showArticles">
                    @foreach ($articles as $item)
                        <div class="article" v-on:click="jumpArticle({{$item->article_id }})">
                            <div class="articleTitle">{{ $item->title }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
    <script>
        new Vue({
            el:'#app',
            methods:{
                jumpArticle: function(id){
                    var link = "/yourblog/article/" + id;
                    location.href=link;
                }
            }
        })
    </script>
</html>
