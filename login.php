<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f7fa;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        padding: 30px;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div class="login-container">
    <div class="card">
        <div class="card-body">
            <h4 class="text-center mb-4">Login</h4>
            <!-- <form id="loginForm" method="POST"> -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" onclick="login_submit()">Login</button>
            <!-- </form> -->
            <!-- <div class="text-center mt-3">
                <a href="register.html">Don't have an account? Register here</a>
            </div> -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    function login_submit() {
        var username = $('#username').val();
        var password = $('#password').val();
        var datastr = "username=" + username + "&password=" + password;

        $.ajax({
            url: 'login_action.php',
            type: 'POST',
            data: datastr,
            success: function(response) {
                if (response == 'customer') {
                    window.location.href = 'user_dashboard.php';
                } else if (response == 'admin') {
                    window.location.href = 'admin_dashboard.php';
                } else {
                    alert('Invalid login credentials');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }
</script>