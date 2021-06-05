<div class="container">
    <div class="search-container">
        <form method='POST' action="index.php?controller=admin&action=search">
            <input type="text" placeholder="Search..." name="search">
            <button class="fa fa-search" type="submit"></i></button>
        </form>
    </div>

    <div class="upload-video">
        <form method="POST" role="form" id="upload-video-form">
            <label for="v_url">URL</label>
            <input type="text" id="v_url" name="url"><br>
            <label for="v_title">Title</label>
            <input type="text" id="v_title" name="title"><br>
            <label for="v_category">Category</label>
            <input type="text" id="v_category" name="category"><br>
            <label for="v_thumbnail" style="cursor: pointer;">Thumbnail</label>
            <input type="file" accept="image/*" name="thumbnail" id="v_thumbnail" onchange="loadFile(event)"
                style="display: none;">
            <img id="preview_img" alt="No thumbnail" src="" width="200" height="100" /><br>
            <input type="submit" value="Upload">
        </form>
        <h4 class="form-warning" id="form-warning"></h4>
    </div>

    <div class="video-list" id="admin-video-list">
        <table>
            <?php
                if(is_countable($videos))
                {
                    foreach ($videos as $v)
                    {
                        echo '<tr>';
                        echo '
                            <td>
                                <img src="' . $v->thumbnailUrl . '" width="100" height="80">
                            </td>
                            <td>
                                <p> ' . $v->title . ' </p>
                            </td>
                            <td>
                                <button class="update-video-button" id="'.$v->id.'" onClick="onClickChange(this.id)">change</button>
                            </td>
                            <td>
                                <form class="delete-video" method="post" action="index.php?controller=admin&action=delete&id=' . $v->id .'">
                                    <input type="submit" value="delete">
                                </form>
                            </td>
                        ';
                        echo '</tr>';
                        echo '<tr id="c'.$v->id.'"> </tr>';
                    }
                } 
                else 
                {
                    echo '<tr>';
                    echo '
                        <td>
                            <img src="' . $videos->thumbnailUrl . '" width="100" height="80">
                        </td>
                        <td>
                            <p> ' . $videos->title . ' </p>
                        </td>
                        <td>
                        <button class="update-video-button" id="'.$videos->id.'" onClick="onClickChange(this.id)">change</button>
                        </td>
                        <td>
                            <form class="delete-video" method="post" action="index.php?controller=admin&action=delete&id=' . $videos->id .'">
                                <input type="submit" value="delete">
                            </form>
                        </td>
                    ';
                    echo '</tr>';
                    echo '<tr id="c'.$videos->id.'"> </tr>';
                }
                
            ?>
        </table>
    </div>
</div>

<script>
    uploadThumbnail = (newThumbnail) => {
        let imgFormData = new FormData();
        imgFormData.append('image', newThumbnail);
        fetch('index.php?controller=images&action=uploadThumbnail', {
                body: imgFormData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    uploadNewVideo(data.body.thumbnail_url);
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    uploadNewVideo = (thumbnail_url) => {
        let formData = new FormData();
        formData.append('video_url', document.getElementById("v_url").value);
        formData.append('video_title', document.getElementById("v_title").value);
        formData.append('video_category', document.getElementById("v_category").value);
        if (thumbnail_url !== null) {
            formData.append('thumbnail_url', thumbnail_url);
        }

        fetch('index.php?controller=admin&action=upload', {
                body: formData,
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    alert(`Uploaded Successfully!`)
                    window.location.href = "index.php?controller=admin&action=show"
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    onFormSubmit = (event) => {
        event.preventDefault();

        let newThumbnail = document.getElementById("v_thumbnail").files[0];

        console.log(newThumbnail)

        if (newThumbnail === undefined) {
            console.log("NO THUMBNAIL")
            uploadNewVideo(null);
        } else {
            console.log("HAS THUMBNAIL")
            uploadThumbnail(newThumbnail);
        }
    }

    loadFile = (event) => {
        var image = document.getElementById('preview_img');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    

    loadImage = (event, video_id) => {
        var image = document.getElementById(``+video_id+`_preview_img`);
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    updateThumbnail = (newThumbnail, video_id) => {
        let imgFormData = new FormData();
        imgFormData.append('image', newThumbnail);
        fetch('index.php?controller=images&action=uploadThumbnail', {
                body: imgFormData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    updateVideo(data.body.thumbnail_url, video_id);
                } else {
                    alert(data.body.errMessage);
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    updateVideo = (thumbnail_url, video_id) => {
        let formData = new FormData();
        formData.append('video_id', video_id);
        formData.append('video_url', document.getElementById(``+video_id+`_url`).value);
        formData.append('video_title', document.getElementById(``+video_id+`_title`).value);
        formData.append('video_category', document.getElementById(``+video_id+`_category`).value);
        if (thumbnail_url !== null) {
            formData.append('thumbnail_url', thumbnail_url);
        }

        fetch('index.php?controller=admin&action=update', {
                body: formData,
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    alert(`Updated Successfully!`)
                    window.location.href = "index.php?controller=admin&action=show"
                } else {
                    alert(data.body.errMessage);
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    onUpdateFormSubmit = (video_id) => {
        event.preventDefault()

        let newThumbnail = document.getElementById(``+video_id+`_thumbnail`).files[0];

        console.log(newThumbnail)

        if (newThumbnail === undefined) {
            console.log("NO THUMBNAIL")
            updateVideo(null, video_id);
        } else {
            console.log("HAS THUMBNAIL")
            updateThumbnail(newThumbnail, video_id);
        }
    }

    onClickChange = (video_id) => {
        var target_html = document.getElementById('c' + video_id);

        let formData = new FormData();
        formData.append('video_id', video_id);

        fetch('index.php?controller=admin&action=getVideoInfo', {
                body: formData,
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    target_html.innerHTML = `
                        <form method="POST" class="update-video-form" onsubmit="onUpdateFormSubmit(`+video_id+`)">
                            <input type="text" name="id" value="`+video_id+`" style="display: none;"> 
                            <label for="`+video_id+`_url">URL</label>
                            <input type="text" id="`+video_id+`_url" name="url" value="`+data.body.video_url+`"><br>
                            <label for="`+video_id+`_title">Title</label>
                            <input type="text" id="`+video_id+`_title" name="title" value="`+data.body.video_title+`"><br>
                            <label for="`+video_id+`_category">Category</label>
                            <input type="text" id="`+video_id+`_category" name="category"><br>
                            <label for="`+video_id+`_thumbnail" style="cursor: pointer;">Thumbnail</label>
                            <input type="file" accept="image/*" name="thumbnail" id="`+video_id+`_thumbnail" onchange="loadImage(event, `+video_id+`)"
                                style="display: none;">
                            <img id="`+video_id+`_preview_img" alt="No thumbnail" src="`+data.body.video_thumbnailUrl+`" width="200" height="100" /><br>
                            <input type="submit" value="Update" onClick="onUpdateFormSubmit(`+video_id+`)">
                        </form>
                    `;
                } else {
                    alert(data.body.errMessage)
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    const form = document.getElementById('upload-video-form');
    form.addEventListener('submit', onFormSubmit);
</script>