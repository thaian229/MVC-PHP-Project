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
                <i class="prefix"></i>
                <input type="text" id="fullname" name="fullname" placeholder="full name" required>
            </div>

            <div class="input-box">
                <i class="fas fa-unlock-alt prefix"></i>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>

            <div class="input-box">
                <i class="fas fa-unlock-alt prefix"></i>
                <input type="password" id="cpassword" name="cpassword" placeholder="confirm password" required>
            </div>

            <div class="input-box">
                <i class="fas fa-envelope prefix"></i>
                <input type="email" id="email" name="email" placeholder="email" required>
            </div>

            <div class="input-box">
                <span class="prefix">+84 </span>
                <input type="number" id="phone-number" name="phone-number" placeholder="phone number" min=0 max=999999999999 oninput="validity.valid||(value='');" required>
            </div>

            <button type="submit" name="register">REGISTER</button>
            <h4 class="form-warning" id="form-warning"></h4>

            <span>Already had an account? <a href="index.php?controller=auth&action=login">Click here to log in</a></span>
        </form>

    </div>
</div>



<script>
    onFormSubmit = (event) => {
        event.preventDefault();

        let regex_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/;
        let regex_name = /^[a-zA-Z ]+$/;
        let regex_email = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        let regex_phone = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;

        if (!regex_password.test(document.getElementById("password").value)) {
            document.getElementById("form-warning").innerText = 'Password too weak'
            return;
        }
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

        if (document.getElementById("cpassword").value.localeCompare(document.getElementById("password").value) != 0)
        {
            document.getElementById("form-warning").innerText = 'Confirm password does not matches'
            return;
        }

        let formData = new FormData();
        formData.append('username', document.getElementById("username").value);
        formData.append('password', document.getElementById("password").value);
        formData.append('full_name', document.getElementById("fullname").value);
        formData.append('email', document.getElementById("email").value);
        formData.append('phone_number', '84' + document.getElementById("phone-number").value);

        fetch('index.php?controller=auth&action=verifyRegister', {
                body: formData,
                method: "post"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success === true) {
                    alert("Successfully registered")
                    window.location.href = "index.php?controller=auth"
                } else {
                    document.getElementById("form-warning").innerText = data.body.errMessage;
                }
            })
            .catch(e => {
                alert(e.message)
            });
    }

    const form = document.getElementById('register-form');

    form.addEventListener('submit', onFormSubmit);
</script>