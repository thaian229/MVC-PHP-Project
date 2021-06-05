<script>
    const currentUrl = window.location.href

    getVotedTypeVideo = () => {
        var video_id = parseInt(currentUrl.split("&id=")[1])
        let formData = new FormData();
        formData.append('video_id', video_id);
        console.log(video_id)
        fetch('index.php?controller=posts&action=getVotedTypeVideo', {
            method: "post",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // var viewNumber = document.getElementById("view-number").value;
                console.log(data)
            })
            .catch(e => {
                console.log(e)
            });
    }

    getVotedTypeVideo()

    sendComment = () => {
        var video_id = parseInt(currentUrl.split("&id=")[1])
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
                <span>Views: </span>
                <span id="view-number">
                    <?php
                    echo $post->views;
                    ?>
                </span>
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








