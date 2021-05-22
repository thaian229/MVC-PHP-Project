<?php
echo "Login";
?>
<form class="form-login" id="login-form" role="form" method="post">
<!--      action="--><?php //echo BASE_PATH . 'index.php?controller=auth&action=login'?><!--"-->


<input type="text" class="form-control"
       id="username"
       name="username" placeholder="username"
       required autofocus>
</br>
<input type="password" class="form-control"
       id="password"
       name="password" placeholder="password" required>
<button class="btn btn-lg btn-primary btn-block" type="submit"
        name="login">Login
</button>
</form>

<h4 class="form-warning" id="form-warning">
    <!--    --><?php
    //    if (isset($errorMessage))
    //        echo $errorMessage;
    //    ?>
</h4>

<script>
    onFormSubmit = (event) => {
        event.preventDefault();

        let formData = new FormData();
        formData.append('username', document.getElementById("username").value);
        formData.append('password', document.getElementById("password").value);

        fetch('index.php?controller=auth&action=verifyLogin', {
            body: formData,
            method: "post"
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    window.location.href = "index.php"
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            });
    }

    const form = document.getElementById('login-form');

    form.addEventListener('submit', onFormSubmit);
</script>
