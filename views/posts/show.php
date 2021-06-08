<link rel="stylesheet" href="views/posts/show.css">
<div class="container">
    <div class="show_row">
        <div class="show_column video_part">
            <iframe width=100% style="aspect-ratio: 16/9;" <?php echo 'src="' . $post->videoUrl . '"' ?> frameborder="1"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            <br/><br/>
            <div>
                <?php
                echo $post->title;
                ?>
            </div>
            <div>
                <div id="view">
                    <span>Views: </span>
                    <span id="view-number">
                    <?php
                    echo $post->views;
                    ?>
                </span>
                </div>
                <div id="vote">
                    <div id="upvote">
                        <div id="upvote-icon" onclick="vote(this.id);"></div>
                        <div id="upvote-number">
                            <?php
                            echo $post->upvotes;
                            ?>
                        </div>
                    </div>
                    <div id="downvote">
                        <div id="downvote-icon" onclick="vote(this.id);"></div>
                        <div id="downvote-number">
                            <?php
                            echo $post->downvotes;
                            ?>
                        </div>
                    </div>
                </div>
                <div id="favourite">
                    <div id="favourite-icon" onclick="clickFav();"></div>
                </div>
            </div>
        </div>
        <div class="show_column comments_part">
            <div id="comments">
                <?php
                if(!empty($comments)) {
                    for ($i = 0; $i < count($comments); $i++) {
                        if (!empty($comments[$i])) {
                            echo '<div>';
                            echo '<span><img height="32" width="32" src="' . $comments[$i]->ava_url . '"/></span>';
                            echo '<span>' . $comments[$i]->username . '</span>';
                            echo '<span>' . $comments[$i]->content . '</span>';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
            <?php
                if(!empty($_SESSION['session_user_id'])) {
                    echo '<div>';
                    echo '<form>';
                    echo '<span><img height="32" width="32" src="' . $_SESSION['session_user_ava_url'] . '"/></span>';
                    echo '<input type="text" id="comment-input" placeholder="Write a comment"/>';
                    echo '<input type="button" id="comment-submit" value="Send Comment" onclick="sendComment()"/>';
                    echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <div>
        <div>
            <div>
                <span><h2>You may like!</h2></span>
            </div>
            <div>
                <?php
                for($i = 0; $i < 4; $i++) {
                    if(!empty($same_posts[$i])) {
                        echo '<div>';
                        echo '<a href="index.php?controller=posts&action=showPost&id=' . $same_posts[$i]->id . '" style="text-decoration: none;">
                            <div class="thumbnail">
                                <img src="' . $same_posts[$i]->thumbnailUrl . '" width="240" height="180">
                            </div>
                        </a>';
                        echo '</div>';
                        echo '<div>';
                        echo '<a href="index.php?controller=posts&action=showPost&id=' . $same_posts[$i]->id . '" style="text-decoration: none;">
                            <div class="title">
                                <p ><strong>' . $same_posts[$i]->title . '</strong></p>
                            </div>
                        </a>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-eye"></i></div>';
                        echo '<div><strong>' . $same_posts[$i]->views . '</strong></div>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-thumbs-up"></i></div>';
                        echo '<div><strong>' . $same_posts[$i]->upvotes . '</strong></div>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-thumbs-down"></i></div>';
                        echo '<div><strong>' . $same_posts[$i]->downvotes . '</strong></div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <div>
            <div>
                <span><h2>Explore more...</h2></span>
            </div>
            <div>
                <?php
                for($i = 0; $i < 4; $i++) {
                    if(!empty($posts[$i])) {
                        echo '<div>';
                        echo '<a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                            <div class="thumbnail">
                                <img src="' . $posts[$i]->thumbnailUrl . '" width="240" height="180">
                            </div>
                        </a>';
                        echo '</div>';
                        echo '<div>';
                        echo '<a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                            <div class="title">
                                <p ><strong>' . $posts[$i]->title . '</strong></p>
                            </div>
                        </a>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-eye"></i></div>';
                        echo '<div><strong>' . $posts[$i]->views . '</strong></div>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-thumbs-up"></i></div>';
                        echo '<div><strong>' . $posts[$i]->upvotes . '</strong></div>';
                        echo '</div>';
                        echo '<div>
                      <div><i class="fas fa-thumbs-down"></i></div>';
                        echo '<div><strong>' . $posts[$i]->downvotes . '</strong></div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    const currentUrl = window.location.href
    var video_id = parseInt(currentUrl.split("&id=")[1])
    var vote_type = -1
    var is_fav = false

    createFavIcon = () => {
        var fav_icon = document.getElementById("favourite-icon")
        if(is_fav == true) {
            fav_icon.innerHTML = '<i class="fas fa-heart"></i>'
        }
        else {
            fav_icon.innerHTML = '<i class="far fa-heart"></i>'
        }
    }

    getIsFavVideo = () => {
        let formData = new FormData();
        formData.append('video_id', video_id);
        fetch('index.php?controller=users&action=isFavouriteVideo', {
            method: "post",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.success == true) {
                    is_fav = data.body.isFav
                    createFavIcon()
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    clickFav = () => {
        if(is_fav == true) {
            let formData = new FormData();
            formData.append('video_id', video_id);
            fetch('index.php?controller=users&action=removeFavouriteVideo', {
                method: "post",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success == true) {
                        is_fav = false;
                        createFavIcon()
                    }
                })
                .catch(e => {
                    console.log(e)
                });
        }
        else {
            let formData = new FormData();
            formData.append('video_id', video_id);
            fetch('index.php?controller=users&action=addFavouriteVideo', {
                method: "post",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success == true) {
                        is_fav = true
                        createFavIcon()
                    }
                })
                .catch(e => {
                    console.log(e)
                });
        }
    }

    createVoteIcon = () => {
        var upvote_icon = document.getElementById("upvote-icon")
        var downvote_icon = document.getElementById("downvote-icon")
        if(vote_type == 1) {
            upvote_icon.innerHTML = '<i class="fas fa-thumbs-up"></i>'
            downvote_icon.innerHTML = '<i class="far fa-thumbs-down"></i>'
        }
        else if(vote_type == 0) {
            upvote_icon.innerHTML = '<i class="far fa-thumbs-up"></i>'
            downvote_icon.innerHTML = '<i class="fas fa-thumbs-down"></i>'
        }
        else {
            upvote_icon.innerHTML = '<i class="far fa-thumbs-up"></i>'
            downvote_icon.innerHTML = '<i class="far fa-thumbs-down"></i>'
        }
    }

    getVotedTypeVideo = () => {
        let formData = new FormData();
        formData.append('video_id', video_id);
        fetch('index.php?controller=posts&action=getVotedTypeVideo', {
            method: "post",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.success == true) {
                    vote_type = data.body.vote_type
                    createVoteIcon()
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    vote = (clicked_id) => {
        var upvote_num = parseInt(document.getElementById("upvote-number").innerText)
        var downvote_num = parseInt(document.getElementById("downvote-number").innerText)
        if (clicked_id == 'upvote-icon') {
            var new_vote = 1
        }
        else if (clicked_id == 'downvote-icon') {
            var new_vote = 0
        }
        let formData = new FormData();
        formData.append('video_id', video_id);
        formData.append('vote_type', new_vote);
        fetch('index.php?controller=posts&action=voteVideo', {
            method: "post",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.success == true) {
                    if(vote_type == -1) {
                        if(new_vote == 1) {
                            upvote_num += 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                        }
                        else if (new_vote == 0) {
                            downvote_num += 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                    }
                    else if(vote_type == 1) {
                        if(new_vote == 1) {
                            upvote_num -= 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                        }
                        else if (new_vote == 0) {
                            upvote_num -= 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                            downvote_num += 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                    }
                    else if(vote_type == 0) {
                        if(new_vote == 1) {
                            upvote_num += 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                            downvote_num -= 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                        else if (new_vote == 0) {
                            downvote_num -= 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                    }
                    getVotedTypeVideo()
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    sendComment = () => {
        var content = document.getElementById('comment-input').value
        if (content) {
            let formData = new FormData();
            formData.append('video_id', video_id);
            formData.append('content', content);
            fetch('index.php?controller=posts&action=sendComment', {
                method: "post",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        addNewCommentLine(content, data.body.acc_name, data.body.avatar_url);
                    } else {
                        document.getElementById("form-warning").innerText = data.body.errMessage;
                    }
                })
                .catch(e => {
                    console.log(e)
                });
        }
    }
    addNewCommentLine = (content, accName, avatarUrl) => {
        document.getElementById("comment-input").value = "";
        var commentContainer = document.getElementById("comments");
        var userAvatar = document.getElementById('user-avatar').src
        commentContainer.innerHTML += `<div>
                                            <span><img height="32" width="32" src="` + userAvatar + `"/></span>
                                            <span>` + accName + `</span>
                                            <span>` + content + `</span>
                                       </div>`
    };

    getIsFavVideo()
    createVoteIcon()
    getVotedTypeVideo()

</script>








