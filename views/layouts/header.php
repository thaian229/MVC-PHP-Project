<link rel="stylesheet" href="views/layouts/header.css">

<header>
    <div class="topnav">
        <div class="container nav-container">
            <div class="left-nav-container">
                <a class="home" href="index.php?controller=posts"><span class="web-name">FILM</span><span class="web-name" style="color: #ff8303;">SFERE</span></a>
                <div class="search-container">
                    <div>
                        <div class="dropdown">
                            <input type="text" id="search-box" autocomplete="off" placeholder="Search...">
                            <div class="dropdown-content" id="search-result">
                            </div>
                        </div>
                        <button class="fa fa-search" onclick="getSearch();"></button>
                    </div>
                </div>
            </div>
            <div class="right-nav-container">
                <?php
                if (isset($_SESSION['session_user_id'])) {
                    if ($_SESSION['session_user_type'] == 1) {
                        echo '
                            <a class="logout" href="index.php?controller=auth&action=logout">Logout</a>
                            <a class="profile" href="index.php?controller=users"><img id="user-avatar" src="' . $_SESSION['session_user_ava_url'] . '"/></a>
                            <a class="admin" href="index.php?controller=admin">Admin</a>
                        ';
                    } else {
                        echo '
                            <a class="logout" href="index.php?controller=auth&action=logout">Logout</a>
                            <a class="profile" href="index.php?controller=users"><img id="user-avatar" src="' . $_SESSION['session_user_ava_url'] . '"/></a>
                        ';
                    }
                } else {
                    echo '
                        <a class="login" href="index.php?controller=auth&action=login">Login</a>
                        <a class="register" href="index.php?controller=auth&action=register"">Register</a>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</header>

<script>
    onSearchBoxKeyPress = (kbevent) => {
        // console.log(kbevent.target.value)

        let formData = new FormData();
        formData.append('keyword', kbevent.target.value);

        fetch('index.php?controller=posts&action=quickSearch', {
                body: formData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data)
                if (data.success === true) {
                    let htmlarray = ""
                    data.body.videos.forEach((video) => {
                        htmlarray += `
                            <div>
                                <a style={{color: "black"}} href="index.php?controller=posts&action=showPost&id=` + video.id + `">` + video.title + `</a>
                            </div>
                            <br>
                        `
                    })

                    htmlarray += `<a href="index.php?controller=posts&action=searchVideos&key=` + kbevent.target.value + `&page=1"> More </a>`

                    if (data.body.videos.length == 0 || kbevent.target.value == "") {
                        document.getElementById("search-result").style.display = "none"
                    } else {
                        document.getElementById("search-result").style.display = "block"
                        document.getElementById("search-result").innerHTML = htmlarray
                    }
                    // window.location.href = "index.php"
                } else {
                    document.getElementById("search-result").style.display = "none"
                    // console.log(data.body.errMessage)
                }
            });
    }

    document.getElementById("search-box").addEventListener("keydown", onSearchBoxKeyPress)

    getSearch = () => {
        var key = document.getElementById('search-box').value
        console.log(key)
        window.location.href = 'index.php?controller=posts&action=searchVideos&key=' + key + '&page=1'
    }
</script>