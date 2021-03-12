<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Markdown Editor</title>
        <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
        <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.2/vuedraggable.umd.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
                    <div class="myaccount" v-on:click="applySortResult({{$list_id}})">適用</div>
                </div>
            </nav>
            <div class="main">
                <div class="titleAndSeries">
                    <div class="titleOfSeries">リスト：{{$list_name}}</div>
                    <div class="showArticles">
                        <div id="sort" class="draggableArea">
                            @foreach ($articles as $item)
                                <div class="article">
                                    <input type="hidden" class="articleID" value="{{$item->article_id}}"/>
                                    <div class="articleTitle">{{ $item->title }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        new Vue({
            el:'#app',
            methods:{
                applySortResult: function(list_id){
                    let sort = document.getElementById('sort');
                    let items = sort.querySelectorAll('div.article');
                    let rank = [];
                    for (var i = 0; i < items.length; i++) {
                        rank.push(items[i].querySelector('.articleID').value);
                    }

                    const modify = {list_id: list_id,article_id_array: rank}

                    axios.post('/yourblog/applySort',modify)
                        .then(res => {
                            console.log(res);
                            location.href=res['data'];
                        })
                        .catch(err => {
                            console.log(err)
                        });

                    console.log(modify);
                }
            }
        });

        let rank = [];
        var sort = document.getElementById('sort');
        var sortable = Sortable.create(sort);
    </script>
</html>
