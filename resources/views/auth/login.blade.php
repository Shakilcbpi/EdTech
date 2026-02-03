<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="card shadow border-0">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4">Login</h4>

                        <form id="loginForm">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@mail.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="******" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Login
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account?</p>
                            <a href="{{route('RegistrationPage')}}" class="btn btn-outline-success btn-sm mt-2 w-100">
                                Create New Account
                            </a>
                        </div>

                        <p id="message" class="text-center mt-3 text-danger small"></p>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            let msgField = $('#message');

            $.ajax({
                url: '/api/login',
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = '/dashboard';
                },
                error: function(xhr) {
                    msgField.text(xhr.responseJSON.message || "Something went wrong!");
                }
            });
        });
    </script>

</body>

</html>