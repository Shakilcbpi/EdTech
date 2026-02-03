<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/dashboard">LMS System</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">Welcome to Dashboard</span>
                <button id="logoutBtn" class="btn btn-outline-danger btn-sm">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">User Dashboard</h2>
                <p class="text-muted">Manage your courses, lessons, and enrollments from here.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-collection-play text-primary display-4"></i>
                        <h5 class="card-title mt-3">Course Listing</h5>
                        <a href="{{route('CoursePage')}}" class="btn btn-primary w-100">View All</a>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-person-plus-fill text-success display-4"></i>
                        <h5 class="card-title mt-3">Enrollment</h5>
                        <a href="{{route('EnrollPage')}}" class="btn btn-success w-100">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $('#logoutBtn').click(function() {
            $.post('/api/logout', function() {
                window.location.href = '/';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function refreshToken() {
            let token = localStorage.getItem('token');
            if (token) {
                fetch('/api/refresh-token', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.token) {
                            localStorage.setItem('token', data.token);
                        }
                    })
                    .catch(err => console.log("Refresh failed"));
            }
        }

        setInterval(refreshToken, 15 * 60 * 1000);
    </script>
</body>

</html>