<link rel="stylesheet" href="views/user/change_profile.css">

<div class="back-container">
    <div class="container profile-container">
        <div class="left-container">
            <input type="file" accept="image/*" name="image" id="ava_file" onchange="loadFile(event)" style="display: none;">
            <label for="ava_file" id="change-avatar" style="cursor: pointer;"><img id="preview-img" alt="Image not found" src="<?php echo $_SESSION['session_user_ava_url'] ?>" /></label>
            <div class="fixed-details-container">
                <h1><?php echo $_SESSION['session_username'] ?></h1>
            </div>
        </div>

        <div class="right-container">
            <form class="form-profile" role="form" id="password-form" method="post">
                <h2 class="form-title" id="password-form-title">Password</h2>

                <div class="input-box">
                    <i class="fas fa-unlock-alt prefix"></i>
                    <input type="password" id="old-password" name="old-password" placeholder="old password" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-unlock-alt prefix"></i>
                    <input type="password" id="new-password" name="new-password" placeholder="new password" required>
                </div>

                <div class="input-box">
                    <i class="fas fa-unlock-alt prefix"></i>
                    <input type="password" id="cpassword" name="cpassword" placeholder="confirm new password" required>
                </div>


                <button type="submit" name="password">Change password</button>
                <h4 class="form-warning" id="form-warning-password"></h4>
            </form>

            <form class="form-profile" role="form" id="profile-form" method="post">
                <h2 class="form-title" id="profile-form-title">Profile Infos</h2>

                <div class="input-box">
                    <i class="prefix"></i>
                    <input type="text" id="fullname" name="fullname" placeholder="full name" value="<?php echo $_SESSION['session_user_fullname'] ?>" required>
                </div>

                <div class="input-box">
                    <i class="fas fa-envelope prefix"></i>
                    <input type="email" id="email" name="email" placeholder="email" value="<?php echo $_SESSION['session_user_email'] ?>" required>
                </div>

                <div class="input-box">
                    <span class="prefix">+84</span>
                    <input type="number" id="phone-number" name="phone-number" placeholder="phone number" min=0 max=999999999999 oninput="validity.valid||(value='');" value="<?php echo $_SESSION['session_user_tel_no'] ?>" required>
                </div>

                <button type="submit" name="profile">Confirm changes</button>
                <h4 class="form-warning" id="form-warning"></h4>

            </form>
        </div>


    </div>
</div>



<script>
    updateAvatar = (newAvatar) => {
        let imgFormData = new FormData();
        imgFormData.append('image', newAvatar);
        fetch('index.php?controller=images&action=uploadAvatar', {
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

        let regex_name = /^[a-zA-Z ]+$/;
        let regex_email = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        let regex_phone = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;

        if (!regex_name.test(document.getElementById("fullname").value)) {
            document.getElementById("form-warning").innerText = 'Name can only contain letters'
            return;
        }
        if (!regex_email.test(document.getElementById("email").value)) {
            document.getElementById("form-warning").innerText = 'Invalid email format'
            return;
        }
        if (!regex_phone.test(document.getElementById("phone-number").value)) {
            document.getElementById("form-warning").innerText = 'Invalid Vietnamese phone number'
            return;
        }

        formData.append('email', document.getElementById("email").value);
        formData.append('tel_no', document.getElementById("phone-number").value);
        formData.append('fullname', document.getElementById("fullname").value);
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

    updateUserDetails = (ava_url) => {
        let formData = new FormData();
        formData.append('email', document.getElementById("email").value);
        formData.append('tel_no', document.getElementById("phone-number").value);
        formData.append('fullname', document.getElementById("fullname").value);
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


    onProfileFormSubmit = (event) => {
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

    onPasswordFormSubmit = (event) => {
        event.preventDefault();
        
        let formData = new FormData();

        let regex_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/;

        if (!regex_password.test(document.getElementById("new-password").value)) {
            document.getElementById("form-warning-password").innerText = 'New password is too weak'
            return;
        }

        if (document.getElementById("cpassword").value.localeCompare(document.getElementById("new-password").value) != 0)
        {
            document.getElementById("form-warning-password").innerText = 'Confirm password does not matches'
            return;
        }

        formData.append('old_password', document.getElementById("old-password").value);
        formData.append('new_password', document.getElementById("new-password").value);

        fetch('index.php?controller=auth&action=changePassword', {
                body: formData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    document.getElementById("old-password").value = ""
                    document.getElementById("new-password").value = ""
                    document.getElementById("cpassword").value = ""
                    alert("password changed");
                } else {
                    document.getElementById("form-warning-password").innerText = data.body.errMessage;
                }
            })
            .catch(e => {
                console.log(e)
            });
    }



    loadFile = (event) => {
        var image = document.getElementById('preview-img');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    const formProfile = document.getElementById('profile-form');
    formProfile.addEventListener('submit', onProfileFormSubmit);

    const formPassword = document.getElementById('password-form');
    formPassword.addEventListener('submit', onPasswordFormSubmit);
</script>