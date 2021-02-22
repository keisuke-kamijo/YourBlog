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
                        <form action="/yourblog/articles" method="get">
                            @csrf
                            <input type="text" name="keyword" class="searchForm" placeholder="記事を検索" required>
                        </form>
                    </div>
                    <a href="./account" class="myaccount">account</a>
                </div>
            </nav>
            <div class="articleForm">
                <form action="/yourblog/editor" method="post">
                    @csrf
                    <input type="text" name="title" class="titleForm" placeholder="タイトル">
                    <input type="text" name="tags" class="tagsForm" placeholder="タグをスペース区切りで入力 (例 Docker Golang)">
                    <div class="flexbox">
                        <textarea name="content" class="mdEditor" v-model="input" placeholder="記事をMarkDown形式で記述"></textarea>
                        <div class="mdResult" v-html="convertMarkdown"></div>
                    </div>
                    <div class="bt">
                        <button type="submit" name="send" class="sendButton">投稿する</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            new Vue({
                el:'#app',
                data:{
                    input:''
                },
                computed:{
                    convertMarkdown:function(){
                        return marked(this.input);
                    }
                }
            });
        </script>
    </body>
</html>
