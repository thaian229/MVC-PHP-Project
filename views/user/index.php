<link rel="stylesheet" href="views/user/index.css">

<div class="container">
    <h2> INFO </h2>
    <img src="<?php echo $_SESSION['session_user_ava_url'] ?>" height="200px" alt="NOT FOUND">
    <br>
    <span>Username: <?php echo $_SESSION['session_username'] ?></span>
    <br>
    <span>Email: <?php echo $_SESSION['session_user_email'] ?></span>
    <br>
    <span>Phone Number: <?php echo $_SESSION['session_user_tel_no'] ?></span>
    <br>
    <span></span>
    <br>
    <span></span>
    <br>
    <a href="index.php?controller=users&action=changeProfile">Change profile</a>
    <br>
    <br>
    <h2>
        Favourite videos
    </h2>
    <div id="has-fav">
        <table id="fav-videos">

        </table>

        <div class="pagination-container">
            <button onclick="firstPageHandler()" id="back-to-first"><<</button>
            <button onclick="prevPageHandler()" id="back-to-previous"><</button>
            <div id="current-page"></div>
            <button onclick="nextPageHandler()" id="go-to-next">></button>
            <button onclick="lastPageHandler()" id="go-to-last">>></button>
        </div>
    </div>

    <div id="no-fav">
        <div>
            <h2>You haven't like any video</h2>
            <a href="index.php?controller=posts"> Start exoloring now</a>
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
        let videoId =  event.id.split('-')[2]
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
                    let htmlString = `
                        <tr>
                            <th width="200px"></th>
                            <th>Title</th>
                            <th>Favourite</th>
                        </tr>
                    `

                    totalPage = data.body.totalPage

                    data.body.videos.forEach((video) => {
                        console.log(video)
                        htmlString += `
                            <tr>
                                <td width="250px"><img alt="NOT FOUND" width="200px" src="` + video.thumbnailUrl + `"/></td>
                                <td><a href="index.php?controller=posts&action=showPost&id=` + video.id + `">` + video.title + `</a></td>
                                <td><button onclick="removeVideoFromFavouriteHandler(this)" id="remove-fav-`+ video.id +`">Remove</button></td>
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
                        document.getElementById("has-fav").style.display = "block"
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