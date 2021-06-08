<link rel="stylesheet" href="views/user/index.css">

<div class="banner-container">
    <div class="banner-content container">
        <span id="page-name">USER PROFILE</span>
        <span id="page-description">See and update your personal information</span>
    </div>
</div>

<div class="back-container">
    <div class="container profile-container">
        <div class="profile-info-container">
            <div class="profile-info-left-container">
                <img src="<?php echo $_SESSION['session_user_ava_url'] ?>" alt="NOT FOUND">
                <br>
                <span><?php echo  $_SESSION['session_user_type'] == 1 ? 'ADMIN' : 'BASIC ACCOUNT' ?></span>
                <br>
                <a href="index.php?controller=users&action=changeProfile">CHANGE PROFILE</a>
            </div>
            <div class="profile-info-right-container">
                <table id="info-table">
                    <tr>
                        <td class="td1">Username</td>
                        <td><span><?php echo $_SESSION['session_username'] ?></span></td>
                    </tr>
                    <tr>
                        <td class="td1">Password</td>
                        <td><span>*****</span></td>
                    </tr>
                    <tr>
                        <td class="td1">Fullname</td>
                        <td><span><?php echo $_SESSION['session_user_fullname'] ?></span></td>
                    </tr>
                    <tr>
                        <td class="td1">Email</td>
                        <td><span><?php echo $_SESSION['session_user_email'] ?></span></td>
                    </tr>
                    <tr>
                        <td class="td1">Phone Number</td>
                        <td><span><?php echo $_SESSION['session_user_tel_no'] ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
    </div>

    <div class="container fav-container">
        <div class="container fav-banner-container">
            <div class="fav-banner-content">
                <span id="favourite-name">Favourite Videos</span>

            </div>
        </div>
        <div class="fav-content-container">
            <div id="has-fav">
                <table id="fav-videos">

                </table>

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

            <div id="no-fav">
                <div>
                    <h2>You haven't like any video</h2>
                    <a href="index.php?controller=posts"> Start exoloring now</a>
                </div>
            </div>
        </div>

    </div>

</div>


<script>
    var currentPage = 0
    var lastPage = 0

    nextPageHandler = (event) => {
        fetchFavList(currentPage + 1);
    }

    prevPageHandler = (event) => {
        fetchFavList(currentPage - 1);
    }

    lastPageHandler = (event) => {
        fetchFavList(lastPage);
    }
    firstPageHandler = (event) => {
        fetchFavList(1);
    }

    removeVideoFromFavouriteHandler = (event) => {
        console.log(event)
        let videoId = event.id.split('-')[2]
        let formData = new FormData()
        formData.append('video_id', videoId);

        fetch('index.php?controller=users&action=removeFavouriteVideo', {
                body: formData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    fetchFavList(currentPage);
                }
            })
            .catch(e => {
                console.log(e)
            });

    }

    fetchFavList = (page) => {

        fetch('index.php?controller=users&action=getFavourites&page=' + page)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {

                    let totalPage = 0
                    // let htmlString = `
                    //     <tr>
                    //         <th width="200px"></th>
                    //         <th>Title</th>
                    //         <th>Favourite</th>
                    //     </tr>
                    // `

                    let htmlString = ``

                    totalPage = data.body.totalPage

                    data.body.videos.forEach((video) => {
                        console.log(video)
                        htmlString += `
                            <tr>
                                <td class="td1"><img alt="NOT FOUND" src="` + video.thumbnailUrl + `"/></td>
                                <td class="td2"><a href="index.php?controller=posts&action=showPost&id=` + video.id + `">` + video.title + `</a></td>
                                <td class="td3"><button onclick="removeVideoFromFavouriteHandler(this)" id="remove-fav-` + video.id + `"><i class="fas fa-window-close"></i></button></td>
                            </tr>
                        `
                    })

                    document.getElementById("fav-videos").innerHTML = htmlString

                    console.log(page)
                    console.log(totalPage)

                    currentPage = page
                    lastPage = totalPage

                    if (totalPage === 0) {
                        document.getElementById("has-fav").style.display = "none"
                        document.getElementById("no-fav").style.display = "flex"
                    } else {
                        document.getElementById("has-fav").style.display = "flex"
                        document.getElementById("no-fav").style.display = "none"
                    }

                    document.getElementById("current-page").innerHTML = page

                    if (page >= totalPage) {
                        document.getElementById("go-to-last").setAttribute("disabled", "disabled");
                        document.getElementById("go-to-next").setAttribute("disabled", "disabled");
                    } else {
                        document.getElementById("go-to-last").removeAttribute("disabled")
                        document.getElementById("go-to-next").removeAttribute("disabled")
                    }

                    if (page <= 1) {
                        document.getElementById("back-to-first").setAttribute("disabled", "disabled");
                        document.getElementById("back-to-previous").setAttribute("disabled", "disabled");
                    } else {
                        document.getElementById("back-to-first").removeAttribute("disabled")
                        document.getElementById("back-to-previous").removeAttribute("disabled")
                    }

                } else {
                    document.getElementById("fav-videos").innerHTML = htmlarray
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    fetchFavList(1)
</script>