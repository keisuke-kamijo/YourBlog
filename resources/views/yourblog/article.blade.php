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
                <div class="showArticle">
                    <h1 class="articleTitle">{{ $articleData['title'] }}</h1>
                    <div class="tags">
                        @foreach ($articleData['tags'] as $tag)
                            <div class="tag">
                                {{ $tag->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mdResult" v-html="convertMarkdown"></div>
                </div>
            </div>
        </div>
        <script>
            new Vue({
                el:'#app',
                computed:{
                    convertMarkdown:function(){
                        var content = @json($articleData['content']);
                        console.log(content);
                        //const replaced = content.replace(/`/g,"\r\n");

                        return marked(content);
                    }
                }
            });
        </script>
    </body>
</html>
