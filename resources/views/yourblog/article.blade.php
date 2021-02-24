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
                    <form action="/yourblog/article/delete" method="post" onsubmit="return disp()">
                        @csrf
                        @if(Auth::check())
                            <input type="hidden" name="article_id" value="{{$articleData['article_id']}}"/>
                            <input type="submit" class="deleteButton" value="記事を削除"/>
                        @endif
                    </form>
                </div>
            </nav>
            <div class="main">
                <div class="showArticle">
                    <h1 class="articleTitle">{{ $articleData['title'] }}</h1>
                    <div class="tags">
                        @foreach ($articleData['tags'] as $tag)
                            <div class="tag" v-on:click="searchWithTag('{{ $tag->name }}');">
                                {{ $tag->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class ="appendArticle">
                        <input type="button" class="expansionButton" value="+" v-on:click="clickBtn" />
                        <form action="/yourblog/article" method="post">
                            @csrf
                            <div v-if="isVisible">
                                <input type="hidden" name="article_id" value = "{{$articleData['article_id']}}" />
                                <select v-model="selected" name="list_id">
                                    <option disabled value="">リストを選択</option>
                                    @foreach ($lists as $item)
                                        <option value="{{$item->list_id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                に記事を追加
                                <input type="submit" class="sendButton" value="完了"/>
                            </div>
                        </form>
                    </div>
                    <div class="mdResult" v-html="convertMarkdown"></div>
                </div>
            </div>
        </div>
        <script>
            new Vue({
                el:'#app',
                data:{
                    isVisible:false,
                    selected:""
                },
                methods:{
                    clickBtn:function(){
                        this.isVisible=!this.isVisible;
                    },
                    searchWithTag: function(id){
                        var link = "/yourblog/articles?tag=" + id;
                        location.href=link;
                    }
                },
                computed:{
                    convertMarkdown:function(){
                        var content = @json($articleData['content']);
                        console.log(content);
                        return marked(content);
                    }
                }
            });

            function disp(){
            if(window.confirm('この記事を削除しますか?')){
                return true;
            } else{
                window.alert('キャンセルされました');
                return false;
            }
        }
        </script>
    </body>
</html>
