<body>
    <!-- navbar navigation -->
    <nav class="navbar bg-light sticky-top">
        <div class="nav-wrap container">
            <!-- web logo -->
            <a href=""><img src="../img/logo.png" class="logo"></a>
            <!-- search button -->
            <div class="search">
                <input type="search" placeholder="Find someone..">
                <i class="fas fa-search"></i>
            </div>
            <div class="options">
                <a><i class="fas fa-home"></i></a>
                <a><i class="fas fa-comments"></i></a>
                <a><i class="fas fa-plus-square"></i></a>
                <a><i class="fas fa-bell"></i></a>
                <a><img src="../img/user.png"></a>
            </div>
        </div>
    </nav>
    <!-- navigation bar end -->
    <!-- body post recomandetion -->
    <section class="mt-3">
        <div class="container body-wrap">
            <!-- news feed -->
            <div class="news">
                <!-- friends posts -->
                <div class="posts">
                    <!-- initial post -->
                    <div class="post">
                        <!-- post header -->
                        <div class="post-header">
                            <span><img src="assets/img/pp/user.png">Username username<i class="fas fa-check-circle"></i></span>
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <!-- post body -->
                        <div class="post-body">
                            <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, fugiat? Labore
                                recusandae illo nemo commodi?</small>
                            <img src="assets/img/post_pic/me.jpg">
                        </div>
                        <!-- post footer -->
                        <div class="post-footer">
                            <i class="far fa-heart"></i>
                            <i class="far fa-comment-dots"></i>
                            <i class="fas fa-share-alt"></i>
                            <span>0 like 0 comment</span>
                        </div>
                        <form class="comment">
                            <input type="text" placeholder="Write a comment..">
                            <button>Post</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- side bar -->
            <div class="side-nav">
                <!-- initial profile -->
                <h5>Your Profile</h5>
                <div class="uprofile">
                    <img src="assets/img/pp/user.png">
                    <div>
                        <span>User name <i class="fas fa-check-circle"></i></span>
                        <small>@user1232</small>
                    </div>
                </div>
                <!-- suggested people -->
                <h5 class="mt-3">You can follow them.</h5>
                <div class="sug-pro">
                    <div class="suggested">
                        <img src="assets/img/pp/user.png">
                        <div>
                            <span>User name <i class="fas fa-check-circle"></i></span>
                            <small>@user1232</small>
                        </div>
                        <button>Follow</button>
                    </div>
                    <div class="suggested">
                        <img src="assets/img/pp/user.png">
                        <div>
                            <span>User name</span>
                            <small>@user1232</small>
                        </div>
                        <button>Follow</button>
                    </div>
                    <div class="suggested">
                        <img src="assets/img/pp/user.png">
                        <div>
                            <span>User name</span>
                            <small>@user1232</small>
                        </div>
                        <button>Follow</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of body -->