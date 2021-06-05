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
    <h2>
        Favourite videos
    </h2>
    <table id="fav-video">

    </table>

    <div class="pagination-container">
        <div id="back-to-first"><<</div>
        <div id="back-to-previous"><</div>
        <div id="current-page"></div>
        <div id="go-to-next">></div>
        <div id="go-to-last">>></div>
    </div>

</div>

<script>
    fetchFavList = (page) => {
        fetch('index.php?controller=users&action=getFavourites&page=' + page)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    let htmlarray = `
                    <tr>
                        <th width="200px"></th>
                        <th>Title</th>
                        <th>Favourite</th>
                    </tr>
                    `
                    data.body.videos.forEach((video) => {
                        htmlarray += `
                            <tr>
                                <td width="200px"><img src=` + video.thumbnail + `/></td>
                                <td><a style={{color: "black"}} href="index.php?controller=posts&action=showPost&id=` + video.id + `">` + video.title + `</a></td>
                                <td>Favourite</td>
                            </tr>
                        `
                    })

                    pagination = `
                        <div>pagination</div>
                    `

                    if (data.body.videos.length == 0) {
                        htmlarray = `
                            <div>
                                <h2>You haven't like any video</h2>
                                <a href="index.php?controller=posts"> Start exoloring now</a>
                            </div>`
                    }

                    document.getElementById("fav-video").innerHTML = htmlarray
                    document.getElementById("current-page").innerHTML = page
                } else
                    document.getElementById("fav-video").innerHTML = htmlarray

            });
    }

    fetchFavList(1)
</script>