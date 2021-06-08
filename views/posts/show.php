<link rel="stylesheet" href="views/posts/show.css">

<div class="back-container">
    <div class="container video-container">
        <div class="upper-section-container">
            <div class="video-section">
                <iframe <?php echo 'src="' . $post->videoUrl . '"' ?> title="video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
                <div id="video-title">
                    <?php
                    echo $post->title;
                    ?>
                </div>
                <div id="video-infos">
                    <div id="video-view">
                        <span>Views: </span>
                        <span id="view-number">
                            <?php
                            echo $post->views;
                            ?>
                        </span>
                    </div>
                    <div id="video-upvote">
                        <div id="upvote-icon" onclick="vote(this.id);"></div>
                        <div id="upvote-number">
                            <?php
                            echo $post->upvotes;
                            ?>
                        </div>
                    </div>
                    <div id="video-downvote">
                        <div id="downvote-icon" onclick="vote(this.id);"></div>
                        <div id="downvote-number">
                            <?php
                            echo $post->downvotes;
                            ?>
                        </div>
                    </div>
                    <div id="add-to-favourite">
                        <div id="favourite-icon" onclick="clickFav();"></div>
                    </div>
                </div>

            </div>
            <div class="comments-section">
                <div id="comments">
                    <?php
                    if (!empty($comments)) {
                        for ($i = 0; $i < count($comments); $i++) {
                            if (!empty($comments[$i])) {
                                echo '<div class="comment">';
                                echo '<img class="comment-ava" src="' . $comments[$i]->ava_url . '"/>';
                                echo '<div class="comment-box">';
                                echo '<span class="comment-name">' . $comments[$i]->username . '</span>';
                                echo '<span class="comment-content">' . $comments[$i]->content . '</span>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="comment-input-box">
                    <?php
                    if (!empty($_SESSION['session_user_id'])) {
                        echo '<form>';
                        echo '<div class="input-box">
                                <span class="prefix"><img height="32" width="32" src="' . $_SESSION['session_user_ava_url'] . '"/></span>
                                <input type="text" id="comment-input" placeholder="Write a comment"/ required>
                                <button type="button" id="comment-submit" value="Send Comment" onclick="sendComment()">Send</button>
                            </div>';
                        echo '</form>';
                    } else {
                        echo ' 
                            <a href="index.php?controller=auth&action=login" >Login </a> <space>
                            <span>&nbsp;to comment</span>
                        ';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="similar-section">
            <div class="similar-title">
                <h2>You may also like</h2>
            </div>
            <div class="similar-content">
                <?php
                for ($i = 0; $i < 4; $i++) {
                    if (!empty($same_posts[$i])) {
                        echo '
                                <div id="video-' . $same_posts[$i]->id . '-card"class="video-card">
                                <div class="video-card-overlay" id="video-' . $same_posts[$i]->id . '-card-overlay"  onclick="onVideoClicked(this)"></div>
                                <img  class="video-card-thumbnail" src="' . $same_posts[$i]->thumbnailUrl . '"/>
                                <div class="video-card-title">' . $same_posts[$i]->title . '</div>
                                <div class="video-card-info">
                                    <div class="video-card-views">
                                        <i class="fas fa-eye"></i>
                                        <span>' . $same_posts[$i]->views . '</span>
                                    </div>

                                    <div class="video-card-liking">
                                        <div class="video-card-like">
                                            <i class="fas fa-thumbs-up"></i>
                                            <div>' . $same_posts[$i]->upvotes . '</div>
                                        </div>

                                        <div class="video-card-dislike">
                                            <i class="fas fa-thumbs-down"></i>
                                            <div>' . $same_posts[$i]->downvotes . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                    }
                }
                ?>
            </div>
        </div>
        <div class="explore-section">
            <div class="explore-title">
                <h2>Explore more videos</h2>
            </div>
            <div class="explore-content">
                <?php
                for ($i = 0; $i < 4; $i++) {
                    if (!empty($posts[$i])) {
                        echo '
                        <div id="video-' . $posts[$i]->id . '-card"class="video-card">
                        <div class="video-card-overlay" id="video-' . $posts[$i]->id . '-card-overlay"  onclick="onVideoClicked(this)"></div>
                        <img  class="video-card-thumbnail" src="' . $posts[$i]->thumbnailUrl . '"/>
                        <div class="video-card-title">' . $posts[$i]->title . '</div>
                        <div class="video-card-info">
                            <div class="video-card-views">
                                <i class="fas fa-eye"></i>
                                <span>' . $posts[$i]->views . '</span>
                            </div>

                            <div class="video-card-liking">
                                <div class="video-card-like">
                                    <i class="fas fa-thumbs-up"></i>
                                    <div>' . $posts[$i]->upvotes . '</div>
                                </div>

                                <div class="video-card-dislike">
                                    <i class="fas fa-thumbs-down"></i>
                                    <div>' . $posts[$i]->downvotes . '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    }
                }
                ?>
            </div>
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
        if (is_fav == true) {
            fav_icon.innerHTML = '<i class="fas fa-heart" style="color:red"></i>'
        } else {
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
                if (data.success == true) {
                    is_fav = data.body.isFav
                    createFavIcon()
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    clickFav = () => {
        if (is_fav == true) {
            let formData = new FormData();
            formData.append('video_id', video_id);
            fetch('index.php?controller=users&action=removeFavouriteVideo', {
                    method: "post",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success == true) {
                        is_fav = false;
                        createFavIcon()
                    }
                })
                .catch(e => {
                    console.log(e)
                });
        } else {
            let formData = new FormData();
            formData.append('video_id', video_id);
            fetch('index.php?controller=users&action=addFavouriteVideo', {
                    method: "post",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success == true) {
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
        if (vote_type == 1) {
            upvote_icon.innerHTML = '<i class="fas fa-thumbs-up" style="color:darkorange"></i>'
            downvote_icon.innerHTML = '<i class="far fa-thumbs-down"></i>'
        } else if (vote_type == 0) {
            upvote_icon.innerHTML = '<i class="far fa-thumbs-up"></i>'
            downvote_icon.innerHTML = '<i class="fas fa-thumbs-down" style="color:#FF4800"></i>'
        } else {
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
                if (data.success == true) {
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
        } else if (clicked_id == 'downvote-icon') {
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
                if (data.success == true) {
                    if (vote_type == -1) {
                        if (new_vote == 1) {
                            upvote_num += 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                        } else if (new_vote == 0) {
                            downvote_num += 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                    } else if (vote_type == 1) {
                        if (new_vote == 1) {
                            upvote_num -= 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                        } else if (new_vote == 0) {
                            upvote_num -= 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                            downvote_num += 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        }
                    } else if (vote_type == 0) {
                        if (new_vote == 1) {
                            upvote_num += 1
                            document.getElementById("upvote-number").innerText = upvote_num.toString()
                            downvote_num -= 1
                            document.getElementById("downvote-number").innerText = downvote_num.toString()
                        } else if (new_vote == 0) {
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
        commentContainer.innerHTML += `
            <div class="comment">
                <img class="comment-ava" src="` + userAvatar + `"/>
                <div class="comment-box">
                    <span class="comment-name">` + accName + `</span>
                    <span class="comment-content">` + content + `</span>
                </div>
            </div>`
    };

    getIsFavVideo()
    createVoteIcon()
    getVotedTypeVideo()
</script>