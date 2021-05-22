<?php
echo "Login";
?>

<form class="form-register" role="form"
      id="register-form"
      method="post">
    <input type="text" class="form-control"
           id = "username"
           name="username" placeholder="username"
           required autofocus>
    </br>
    <input type="password" class="form-control"
           id = "password"
           name="password" placeholder="password" required>
    </br>
    <input type="cpassword"
           id = "cpassword"
           name="cpassword" placeholder="confirm password" required>
    </br>
    <button class="btn btn-lg btn-primary btn-block" type="submit"
            name="register">Register
    </button>
</form>

<h4 class="form-warning" id="form-warning">
    <?php
    if (isset($errorMessage))
        echo $errorMessage;
    ?>
</h4>


<script>
    onFormSubmit = (event) => {
        event.preventDefault();

        let formData = new FormData();
        formData.append('username', document.getElementById("username").value);
        formData.append('password', document.getElementById("password").value);

        fetch('index.php?controller=auth&action=verifyRegister', {
            body: formData,
            method: "post"
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    window.location.href = "index.php?controller=auth"
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            });
    }

    const form = document.getElementById('register-form');

    form.addEventListener('submit', onFormSubmit);
</script>

