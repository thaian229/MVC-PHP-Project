<link rel="stylesheet" href="views/posts/index.css">

<div class="banner-container">
    <div class="banner-content container">
        <span id="page-name">EXPLORE</span>
        <span id="page-description">Start exploring the world of entertainments</span>
    </div>
</div>
<div class="back-container">
    <div class="container list-category-container">
        <?php
        for ($i = 0; $i < count($categories); $i++) {
            echo '<div class=category-container>';
            echo '<div class="category-name"><h2>' . ucfirst($categories[$i]->catName) . '</h2></div>';
            echo '<div class="category-more">
                    <a href="index.php?controller=posts&action=getCategory&category=' . $categories[$i]->catName . '&page=1"
                    style="text-decoration: none;">
                        View more
                    </a>
              </div>';
            echo '<div class="category-contents" id="' . $categories[$i]->catName . '-videos"></div>';
            echo '</div>';
        }
        ?>

    </div>

    <div class="show-all-banner-container container">
        <span>Want to see more?</span>
        <a href="index.php?controller=posts&action=getPage&page=1">SHOW ALL VIDEOS</a>
    </div>



</div>

<script>
    var categories = document.getElementsByClassName('category-name')
    for (i = 0; i < categories.length; i++) {
        var categoryName = categories[i].innerText.toLowerCase()
        let formData = new FormData();
        formData.append('category', categoryName);
        formData.append('page', 1);
        fetch('index.php?controller=posts&action=videosByCategory', {
                method: "post",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success == true) {
                    console.log(data.body.category)
                    var videosByCategory = document.getElementById(data.body.category + '-videos')
                    data.body.videos.forEach((video) => {
                        videosByCategory.innerHTML += `
                            <div id="video-` + video.id + `-card-` + data.body.category + `" class="video-card">
                                <div class="video-card-overlay" id="video-` + video.id + `-card-overlay-` + data.body.category + `" onclick="onVideoClicked(this)"></div>
                                <img  class="video-card-thumbnail" src="` + video.thumbnailUrl + `"/>
                                <div class="video-card-title">` + video.title + ` </div>
                                <div class="video-card-info">
                                    <div class="video-card-views">
                                        <i class="fas fa-eye"></i>
                                        <span>` + video.views + `</span>
                                    </div>

                                    <div class="video-card-liking">
                                        <div class="video-card-like">
                                            <i class="fas fa-thumbs-up"></i>
                                            <div>` + video.upvotes + `</div>
                                        </div>

                                        <div class="video-card-dislike">
                                            <i class="fas fa-thumbs-down"></i>
                                            <div>` + video.downvotes + `</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        // document.getElementById(`video-` + video.id + `-card-overlay-` + data.body.category).addEventListener("click", onVideoClicked)
                    })
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    onVideoClicked = (target) => {
        console.log(target)
        let vId = target.id.split("-")[1]
        window.location.href = `index.php?controller=posts&action=showPost&id=` + vId
    }
</script>