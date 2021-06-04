<h2>PROFILE FORM</h2>
<p><input type="file" accept="image/*" name="image" id="ava_file" onchange="loadFile(event)" style="display: none;"></p>
<p><label for="ava_file" style="cursor: pointer;">Upload Image</label></p>
<p><img id="preview_img" alt="Image not found" src="<?php echo $_SESSION['session_ava_url'] ?>" width="200" /></p>
<?php
// require_once('');
?>

<form class="form-login" id="login-form" role="form" method="post">
    <!-- <input type="text" class="form-control" id="username" name="username" placeholder="username" required autofocus>
    </br> -->
    <span>Username: <?php echo $_SESSION['session_username'] ?></span>
    </br>
    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required autofocus>
    </br>
    <input type="text" class="form-control" id="tel_no" name="tel_no" placeholder="Phone Number" required autofocus>
    </br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Confirm
    </button>
</form>
<h4 class="form-warning" id="form-warning">
    <!--    --><?php
                //    if (isset($errorMessage))
                //        echo $errorMessage;
                //    
                ?>
</h4>

<!-- Trigger the Modal -->


<script>
    updateAvatar = (newAvatar) => {
        let imgFormData = new FormData();
        imgFormData.append('image', newAvatar);
        fetch('index.php?controller=images&action=updateAvatar', {
                body: imgFormData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    updateUserDetails(data.body.ava_url);
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            })
            .catch(e => {
                console.log(e)
            });
    }

    updateUserDetails = (ava_url) => {
        let formData = new FormData();
        formData.append('email', document.getElementById("email").value);
        formData.append('tel_no', document.getElementById("tel_no").value);
        if (ava_url !== null) {
            formData.append('ava_url', ava_url);
        }

        fetch('index.php?controller=users&action=updateProfile', {
                body: formData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    window.location.href = "index.php?controller=users"
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

        let newAvatar = document.getElementById("ava_file").files[0];

        console.log(newAvatar)

        if (newAvatar === undefined) {
            console.log("NO NEW AVA")
            updateUserDetails(null);
        } else {
            console.log("NEW AVA")
            updateAvatar(newAvatar);
        }
    }


    loadFile = (event) => {
        var image = document.getElementById('preview_img');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    const form = document.getElementById('login-form');
    form.addEventListener('submit', onFormSubmit);
</script>