<div class="container">
    <?php
    for ($i = 0; $i < count($categories); $i++) {
        echo '<div>';
        echo '<div class="category-name"><h2>' . ucfirst($categories[$i]->catName) . '</h2></div>';
        echo '<div>
                    <a href="index.php?controller=posts&action=getCategory&category=' . $categories[$i]->catName . '&page=1"
                    style="text-decoration: none;">
                        View more...
                    </a>
              </div>';
        echo '<div id="' . $categories[$i]->catName . '-videos"></div>';
        echo '</div>';
    }
    ?>
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
                        <div>
                            <a href="index.php?controller=posts&action=showPost&id=` + video.id + `" style="text-decoration: none;">
                                <div class="thumbnail">
                                    <img src="` + video.thumbnailUrl + `" width="240" height="180">
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="index.php?controller=posts&action=showPost&id=` + video.id + `" style="text-decoration: none;">
                                <div class="title">
                                    <p ><strong>` + video.title + `</strong></p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <div><i class="fas fa-eye"></i></div>
                            <div><strong>` + video.views + `</strong></div>
                        </div>
                        <div>
                            <div><i class="fas fa-thumbs-up"></i></div>
                            <div><strong>` + video.upvotes + `</strong></div>
                        </div>
                        <div>
                            <div><i class="fas fa-thumbs-down"></i></div>
                            <div><strong>` + video.downvotes + `</strong></div>
                        </div>
                        `
                    })
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

</script>
