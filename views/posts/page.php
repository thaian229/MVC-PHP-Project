<div align="center" class="container">
    <div id="count" style="display: none;"><?php echo $videosCount; ?></div>
    <br/><br/>
    <div>
        <?php
        for($i = 0; $i <= count($posts); $i++) {
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
    <br/><br/><br/><br/>
    <div class="pagination-container">
        <button onclick="firstPageHandler()" id="back-to-first"><<</button>
        <button onclick="prevPageHandler()" id="back-to-previous"><</button>
        <div id="current-page"></div>
        <button onclick="nextPageHandler()" id="go-to-next">></button>
        <button onclick="lastPageHandler()" id="go-to-last">>></button>
    </div>
    <br/><br/><br/><br/>
</div>

<script>
    getPageUrl = window.location.href.slice(0, -1)
    pageId = window.location.href.split("&page=")[1]
    const totalVideos = document.getElementById("count").innerText
    const totalPages = Math.ceil(totalVideos/8)
    document.getElementById("current-page").innerText = pageId
    firstPageHandler = () => {
        window.location.href = getPageUrl + '1'
    }
    prevPageHandler = () => {
        window.location.href = getPageUrl + (parseInt(pageId)-1).toString()
    }
    nextPageHandler = () => {
        window.location.href = getPageUrl + (parseInt(pageId)+1).toString()
    }
    lastPageHandler = () => {
        window.location.href = getPageUrl + totalPages.toString()
    }

    if(pageId == 1) {
        document.getElementById("back-to-first").setAttribute("disabled", "disabled");
        document.getElementById("back-to-previous").setAttribute("disabled", "disabled");
    }
    else if(pageId == totalPages) {
        document.getElementById("go-to-last").setAttribute("disabled", "disabled");
        document.getElementById("go-to-next").setAttribute("disabled", "disabled");
    }
</script>
