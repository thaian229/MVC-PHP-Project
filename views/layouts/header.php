<link rel="stylesheet" href="views/layouts/header.css">

<header>
    <div class="topnav">
        <a class="home" href="index.php?controller=posts">Home</a>
        <?php
        if (isset($_SESSION['session_user_id'])) {
            echo '
                <a class="logout" href="index.php?controller=auth&action=logout">Logout</a>
                <a class="profile" href="index.php?controller=users">Profile</a>
            ';
        } else {
            echo '
                <a class="login" href="index.php?controller=auth&action=login">Login</a>
                <a class="register" href="index.php?controller=auth&action=register"">Register</a>
            ';
        }
        ?>

        <div class="search-container">
            <form action="/action_page.php">
                <div class="dropdown">
                    <input type="text" id="search-box" autocomplete="off" placeholder="Search..." name="search">
                    <div class="dropdown-content" id="search-result">
                    </div>
                </div>

                <button class="fa fa-search" type="submit"></i></button>
            </form>

        </div>
    </div>
</header>

<script>
    onSearchBoxKeyPress = (kbevent) => {
        console.log(kbevent.target.value)

        let formData = new FormData();
        formData.append('keyword', kbevent.target.value);

        fetch('index.php?controller=posts&action=quickSearch', {
            body: formData,
            method: "post"
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
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

                    htmlarray += `<a href="index.php?controller=posts&action=search&keyword=`+ kbevent.target.value + `"> More </a>`

                    if (data.body.videos.length == 0 || kbevent.target.value == "") {
                        document.getElementById("search-result").style.display = "none"
                    } else {
                        document.getElementById("search-result").style.display = "block"
                        document.getElementById("search-result").innerHTML = htmlarray
                    }
                    // window.location.href = "index.php"
                } else {
                    document.getElementById("search-result").style.display = "none"
                    console.log(data.body.errMessage)
                }
            });
    }

    document.getElementById("search-box").addEventListener("keydown", onSearchBoxKeyPress)
</script>