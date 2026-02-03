<!DOCTYPE html>
<html>
<head>
    <title>Register | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Create Account</h4>

                    <form id="registerForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Register As</label>
                            <select class="form-select" name="role" id="role">
                                <option value="student">Student</option>
                                <option value="instructor">Instructor</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2" id="submitBtn">
                            Register Now
                        </button>
                    </form>

                    <p class="text-center mt-3">
                        Already registered? <a href="{{route('loginPage')}}" class="text-decoration-none">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $('#registerForm').submit(function(event) {
        event.preventDefault();
 
        $('#submitBtn').attr('disabled', true).text('Processing...');

        let formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            role: $('#role').val()
        };

        $.ajax({
            url: '/api/register',  
            type: 'POST',
            data: formData,
            success: function(response) { 
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Account created successfully. Please login.',
                }).then(() => {
                    window.location.href = "{{route('loginPage')}}";
                });
            },
            error: function(xhr) {
                $('#submitBtn').attr('disabled', false).text('Register Now');
                 
                let errorMsg = xhr.responseJSON.message || "Registration Failed!";
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                });
            }
        });
    });
</script>

</body>
</html>