<script>
    const currentUrl = window.location.href
    var video_id = parseInt(currentUrl.split("&id=")[1])

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
                    var upvote_icon = document.getElementById("upvote-icon")
                    var downvote_icon = document.getElementById("downvote-icon")
                    var vote_type = data.body.vote_type
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
            })
            .catch(e => {
                console.log(e)
            });
    }

    getVotedTypeVideo()
    
    vote = (clicked_id) => {
        if (clicked_id == 'upvote-icon') {
            var vote_type = 1
        }
        else if (clicked_id == 'downvote-icon') {
            var vote_type = 0
        }
        let formData = new FormData();
        formData.append('video_id', video_id);
        formData.append('vote_type', vote_type);
        fetch('index.php?controller=posts&action=voteVideo', {
            method: "post",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.success == true) {
                    console.log(data)
                }
            })
            .catch(e => {
                console.log(e)
            });
        getVotedTypeVideo()
    }

    sendComment = () => {
        var content = document.getElementById('comment-input').value
        if (content) {
            let formData = new FormData();
            formData.append('video_id', video_id);
            formData.append('content', content);
            console.log(formData)
            fetch('index.php?controller=posts&action=sendComment', {
                method: "post",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.success === true) {
                        addNewCommentLine(content);
                    } else {
                        document.getElementById("form-warning").innerText = data.body.errMessage;
                    }
                })
                .catch(e => {
                    console.log(e)
                });
        }
    }
    addNewCommentLine = (content) => {
        document.getElementById("comment-input").value = "";
        var commentContainer = document.getElementById("comments");
        commentContainer.innerHTML += '<p>' + content + '</p>'
    };
</script>

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
            </div>
        </div>
        <div class="show_column comments_part">
            <div id="comments">
                <?php
                for ($i = 0; $i < count($comments); $i++) {
                    if (!empty($comments[$i]))
                        echo '<p>' . $comments[$i]->content . '</p>';
                }
                ?>
            </div>
            <?php
                if(!empty($_SESSION['session_user_id'])) {
                    echo '<form>';
                    echo '<input type="text" id="comment-input" placeholder="Write a comment"/>';
                    echo '<input type="button" id="comment-submit" value="Send Comment" onclick="sendComment()"/>';
                    echo '</form>';
                }
            ?>
        </div>
    </div>
</div>








