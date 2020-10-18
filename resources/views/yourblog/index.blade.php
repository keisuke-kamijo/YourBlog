<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Page</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    </head>
    <body>
        <div id="app">
            <nav>
                <div class="main-nav">
                    <div class="home">blog</div>
                    <a href="/yourblog/articles" class="myaccount">記事一覧</a>
                    <div class="search">
                        <form action="" method="post">
                            <input type="text" name="search" class="searchForm" placeholder="記事を検索">
                        </form>
                    </div>
                </div>
            </nav>
            <div class="main">
                <div class="accountInfo">
                    <div class="profile-topic">
                        <div class="profile">
                            <p class="trim-image-to-circle">

                            </p>
                            <div class="username">
                                {{$items['username']}}
                            </div>
                            <div class="articleInfo">
                                投稿：{{$items['articleNum']}}件
                            </div>
                        </div>
                        <div class="topic">
                            <div class="description">関連する話題:</div>
                            @foreach ($items['tagArray'] as $tag)
                            <div class="tag">
                                {{ $tag }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="articles">
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                    </div>
                    <div class="articles">
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                    </div>
                    <div class="articles">
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                        <div class="article"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
