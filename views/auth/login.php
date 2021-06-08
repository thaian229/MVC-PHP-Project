<link rel="stylesheet" href="views/auth/login.css">

<div width='100%' height='100vh' class="back-container">
    <div class="container login-container">
        <form class="form-login" id="login-form" role="form" method="post">
            <span id="login-title">LOGIN</span>

            <div class="input-box">
                <i class="fas fa-user prefix"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" required autofocus>
            </div>

            <div class="input-box">
                <i class="fas fa-unlock-alt prefix"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">LOG IN
            </button>
            <h4 class="form-warning" id="form-warning"></h4>

            <span>New comer? <a href="index.php?controller=auth&action=register"> Join us now</a></span>
        
        </form>
        <div class="login-preview"><img src="assets/images/login-image.jpg" alt="not found" /></div>
    </div>
</div>

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