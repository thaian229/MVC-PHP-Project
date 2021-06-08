<link rel="stylesheet" href="views/posts/page.css">

<div class="banner-container">
    <div class="banner-content container" style="text-transform: uppercase">
        <span id="page-name">
            <?php
            if (!empty($category)) {
                echo "<strong>";
                echo $category;
                echo "</strong>";
            } else if (!empty($key)) {
                echo "<strong>Search = ";
                echo $key;
                echo "</strong>";
            } else {
                echo "ALL VIDEOS";
            }
            ?></span>
        <span id="page-description">
            <?php
            if (!empty($category)) {
                echo "CATEGORY";
            } else if (!empty($key)) {
                echo "SEARCH RESULT";
            } else {
                echo "EVERYTHING WE OFFERS";
            }
            ?>
        </span>
    </div>
</div>

<div class=back-container>
    <div class="container page-container">
        <div id="count" style="display: none;"><?php echo $videosCount; ?></div>
        <br /><br />
        <div>
            <h2>
                <?php
                if ($videosCount == 0) {
                    echo '<div>';
                    echo "Sorry, no video found ";
                    echo '<span></span><i class="far fa-sad-tear"></i></span>';
                    echo '</div>';
                }
                ?>
            </h2>
        </div>
        <br /><br />
        <div class="video-list">
            <script>
                const onVideoClicked = (target) => {
                    vId = target.id.split('-')[1]
                    window.location.href = `index.php?controller=posts&action=showPost&id=` + vId
                }
            </script>
            <?php
            for ($i = 0; $i < count($posts); $i++) {
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
        <div class="pagination-container">
            <button onclick="firstPageHandler()" id="back-to-first">
                <i class="fas fa-angle-double-left"></i>
            </button>
            <button onclick="prevPageHandler()" id="back-to-previous">
                <i class="fas fa-angle-left"></i>
            </button>
            <div id="current-page"></div>
            <button onclick="nextPageHandler()" id="go-to-next">
                <i class="fas fa-angle-right"></i>
            </button>
            <button onclick="lastPageHandler()" id="go-to-last">
                <i class="fas fa-angle-double-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
    var getPageUrl = window.location.href.slice(0, -1)

    var pageId = window.location.href.split("&page=")[1]

    const totalVideos = document.getElementById("count").innerText
    console.log(totalVideos)
    const totalPages = Math.ceil(totalVideos / 8)

    if (totalVideos > 0) {
        document.getElementsByClassName("pagination-container")[0].removeAttribute("style");
    }

    document.getElementById("current-page").innerText = pageId

    firstPageHandler = () => {
        window.location.href = getPageUrl + '1'
    }
    prevPageHandler = () => {
        window.location.href = getPageUrl + (parseInt(pageId) - 1).toString()
    }
    nextPageHandler = () => {
        window.location.href = getPageUrl + (parseInt(pageId) + 1).toString()
    }
    lastPageHandler = () => {
        window.location.href = getPageUrl + totalPages.toString()
    }

    if (pageId == 1) {
        document.getElementById("back-to-first").setAttribute("disabled", "disabled");
        document.getElementById("back-to-previous").setAttribute("disabled", "disabled");
    }
    if (pageId == totalPages) {
        document.getElementById("go-to-last").setAttribute("disabled", "disabled");
        document.getElementById("go-to-next").setAttribute("disabled", "disabled");
    }
</script>