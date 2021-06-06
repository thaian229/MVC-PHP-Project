<link rel="stylesheet" href="views/auth/register.css">

<div class="back-container">
    <div class="container register-container">
        <div class="register-preview"><img src="assets/images/register-image.jpg" alt="not found" /></div>

        <form class="form-register" role="form" id="register-form" method="post">
            <h2 id="register-title">REGISTER</h2>

            <div class="input-box">
                <i class="fas fa-user prefix"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" required autofocus>
            </div>

            <div class="input-box">
                <i class="fas fa-unlock-alt prefix"></i>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>

            <div class="input-box">
                <i class="fas fa-unlock-alt prefix"></i>
                <input type="password" name="cpassword" placeholder="confirm password" required>
            </div>

            <div class="input-box">
                <i class="fas fa-envelope prefix"></i>
                <input type="email" id="email" name="email" placeholder="email" required>
            </div>

            <div class="input-box">
                <span class="prefix">+84 </span>
                <input type="number" id="phone-number" name="phone-number" placeholder="phone number" min=0 max=999999999999 oninput="validity.valid||(value='');" required>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">REGISTER</button>
            <h4 class="form-warning" id="form-warning"></h4>

            <span>Already had a account? <a href="index.php?controller=auth&action=login">Click here to log in</a></span>
        </form>

    </div>
</div>



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