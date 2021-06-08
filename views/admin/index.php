<link rel="stylesheet" href="views/admin/index.css">

<div class="banner-container">
    <div class="banner-content container">
        <span id="page-name">ADMIN</span>
        <span id="page-description">Administration tool for videos</span>
    </div>
</div>

<div class="back-container">
    <div class="container admin-container">
        <div class="upload-video">
            <form method="POST" role="form" class="upload-form" id="upload-video-form">
                <h2 class="form-title" id="password-form-title">Upload video</h2>

                <input type="file" accept="image/*" name="thumbnail" id="v_thumbnail" onchange="loadFile(event)" style="display: none;">
                <label for="v_thumbnail" id="change-thumbnail" style="cursor: pointer;"><img id="preview-img" alt="Image not found" src="assets/images/video-default.jpeg" /></label>
                <div class="input-box">
                    <input type="text" placeholder="URL" id="v_url" name="url" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Title" id="v_title" name="title" required>
                </div>
                <div class="input-box">
                    <label for="v_category">Categories</label>
                    <select id="v_category" name="category[]" size="4" multiple>
                        <?php
                        foreach ($categories as $c) {
                            echo '<option value="' . $c->id . '">' . $c->catName . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <h4 class="form-warning" id="form-warning"></h4>
                <button type="submit">Upload</button>
            </form>
        </div>

        <div class="browse-video">
            <div class="admin-search-container">
                <span>Videos List</span>
                <form method='POST' action="index.php?controller=admin&action=search">
                    <input type="text" placeholder="Search..." name="search">
                    <button class="fa fa-search" type="submit"></i></button>
                </form>
            </div>
            <div class="video-list" id="admin-video-list">
                <?php
                if (is_countable($videos) && count($videos) > 0) {
                    echo '<table>';
                    foreach ($videos as $v) {
                        echo '<tr>';
                        echo '
                            <td class="col1">
                                <img src="' . $v->thumbnailUrl . '">
                            </td>
                            <td class="col2">
                                <div> ' . $v->title . ' </div>
                            </td>
                            <td>
                                <button class="update-video-button" id="' . $v->id . '" onClick="onClickChange(this.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <form class="delete-video" method="post" action="index.php?controller=admin&action=delete&id=' . $v->id . '">
                                    <button class="delete-video-button" type="submit">
                                        <i class="fas fa-window-close"></i>
                                    </button>
                                </form>
                            </td>
                        ';
                        echo '</tr>';
                        echo '<tr id="c' . $v->id . '"> </tr>';
                    }
                    echo '</table>';
                } else {
                    echo '
                    <div class="no-video-found"> 
                        <span>No videos found!</span>
                        <span>Try again or upload a new video</span>
                    <div>
                    ';
                }

                ?>
            </div>
        </div>


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
                    alert(data.body.errMessage);
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    uploadNewVideo = (thumbnail_url) => {
        let regex_url = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g

        if (!regex_url.test(document.getElementById("v_url").value)) {
            document.getElementById(`form-warning`).innerText = 'Invalid url'
            return;
        }

        let formData = new FormData();
        formData.append('video_url', document.getElementById("v_url").value);
        formData.append('video_title', document.getElementById("v_title").value);
        var select = document.getElementById(`v_category`);
        var selected = [...select.selectedOptions].map(option => option.value);
        if (selected.length > 0) {
            formData.append('video_category', selected);
        }
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
                    alert(data.body.errMessage);
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
        var image = document.getElementById('preview-img');
        image.src = URL.createObjectURL(event.target.files[0]);
    };



    loadImage = (event, video_id) => {
        var image = document.getElementById(`` + video_id + `_preview_img`);
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
        let regex_url = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g

        if (!regex_url.test(document.getElementById(`` + video_id + `_url`).value)) {
            document.getElementById(video_id + `form_warning`).innerText = 'Invalid url'
            return;
        }

        let formData = new FormData();
        formData.append('video_id', video_id);
        formData.append('video_url', document.getElementById(`` + video_id + `_url`).value);
        formData.append('video_title', document.getElementById(`` + video_id + `_title`).value);
        var select = document.getElementById(`` + video_id + `_category`);
        var selected = [...select.selectedOptions].map(option => option.value);
        if (selected.length > 0) {
            formData.append('video_category', selected);
        }

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

        let newThumbnail = document.getElementById(`` + video_id + `_thumbnail`).files[0];

        console.log(newThumbnail)

        if (newThumbnail === undefined) {
            console.log("NO THUMBNAIL")
            updateVideo(null, video_id);
        } else {
            console.log("HAS THUMBNAIL")
            updateThumbnail(newThumbnail, video_id);
        }
    }

    getListOfCategories = (video_id) => {
        fetch('index.php?controller=admin&action=getCategoryInfo', {
                body: '',
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    var target_html = document.getElementById('c' + video_id);

                    let formData = new FormData();
                    formData.append('video_id', video_id);

                    cat_list = data.body;

                    fetch('index.php?controller=admin&action=getVideoInfo', {
                            body: formData,
                            method: "POST"
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            if (data.success === true) {
                                let str_html = `
                                <td></td>
                                <td class="update-form-container">
                                    <form method="POST" role="form" class="update-form">
                                        <input type="text" name="id" value="` + video_id + `" style="display: none;"> 
                                        <input type="file" accept="image/*" name="thumbnail" id="` + video_id + `_thumbnail" onchange="loadImage(event, ` + video_id + `)" style="display: none;">
                                        <label for="v_thumbnail" id="change-thumbnail" style="cursor: pointer;"><img id="` + video_id + `_preview_img" alt="Choose thumbnail" src="` + data.body.video_thumbnailUrl + `"/></label>
                                        <div class="input-box">
                                            <input type="text" id="` + video_id + `_url" name="url" value="` + data.body.video_url + `" required>
                                        </div>
                                        <div class="input-box">
                                            <input type="text" id="` + video_id + `_title" name="title" value="` + data.body.video_title + `" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="` + video_id + `_category">Category</label>
                                            <select id="` + video_id + `_category" name="category[]" size="4" multiple>
                                `;



                                cat_list.forEach(c => {
                                    str_html = str_html + `s
                                        <option value="` + c.id + `">` + c.catName + `</option>                            
                                    `;
                                });

                                str_html = str_html + `
                                            </select>
                                        </div>
                                        <h4 class="form-warning" id="` + video_id + `form_warning"></h4>
                                        <button type="reset" onClick="closeUpdateForm(` + video_id + `)">Cancel</button>
                                        <button type="submit" onClick="onUpdateFormSubmit(` + video_id + `)">Update</button>
                                    </form>
                                </td>
                                <td></td>
                                <td></td>
                                `;

                                console.log(str_html)

                                target_html.innerHTML = str_html;

                            } else {
                                alert(data.body.errMessage)
                            }
                        })
                        .catch(e => {
                            console.log(e)
                        });

                } else {
                    alert(data.body.errMessage)
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    onClickChange = (video_id) => {
        getListOfCategories(video_id);
    }

    closeUpdateForm = (video_id) => {
        var target_html = document.getElementById('c' + video_id);
        target_html.innerHTML = ``;
    }

    const form = document.getElementById('upload-video-form');
    form.addEventListener('submit', onFormSubmit);
</script>