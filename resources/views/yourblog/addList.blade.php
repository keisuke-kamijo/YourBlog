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

            <div class="main">
                <div class="addListForm">
                    <div class="description">リストを追加</div>
                    <form action="" method="post">
                        @csrf
                        <input type="text" name="listTitle" class="listNameForm" placeholder="リスト名を入力">
                        <input type="submit" class="sendButton" value="決定">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
