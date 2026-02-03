<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .badge {
            text-transform: capitalize;
        }

        .modal-header {
            border-bottom: none;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/dashboard">LMS Dashboard</a>
            <button id="logoutBtn" class="btn btn-outline-light btn-sm">Logout</button>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h2 class="fw-bold text-dark">Available Courses</h2>
            </div>

            <div class="col-md-4 text-md-center mt-3 mt-md-0">
                <a href="{{ route('create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle"></i> Add New Course
                </a>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <form id="searchForm" action="{{ route('course.search') }}" method="GET" class="d-flex">
                    <div class="input-group shadow-sm">
                        <input type="text" name="search" id="searchInput" class="form-control"
                            placeholder="Search course name..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Serial</th>
                                <th>Course Name</th>
                                <th>Instructor</th>
                                <th>Level</th>
                                <th>Price</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="courseTableBody">
                            @forelse($courses as $course)
                            <tr>
                                <td class="ps-4 text-muted">
                                    {{ ($courses instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($courses->currentPage() - 1) * $courses->perPage() + $loop->iteration : $loop->iteration }}
                                </td>
                                <td><strong>{{ $course->title }}</strong></td>
                                <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $course->level == 'beginner' ? 'bg-info' : ($course->level == 'intermediate' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $course->level }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success">${{ number_format($course->price, 2) }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('details', $course->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="bi bi-eye"></i>
                                        <a>
                                            <a href="{{ route('edit', $course->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $course->id }})" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No courses found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($courses instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4 d-flex justify-content-center">
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-info-circle"></i> Course Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="text-center p-5">
                        <div class="spinner-border text-info" role="status"></div>
                        <p class="mt-2 text-muted">Loading data, please wait...</p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/api/courses/' + id,
                        type: 'DELETE',
                        success: function(res) {
                            Swal.fire('Deleted!', 'Course has been removed.', 'success').then(() => location.reload());
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Unauthorized action.', 'error');
                        }
                    });
                }
            })
        }

        $('#searchForm').submit(function(e) {
            if ($('#searchInput').val().trim() === "") {
                e.preventDefault();
                window.location.href = "{{ route('CoursePage') }}";
            }
        });

        $('#logoutBtn').click(function() {
            $.post('/api/logout', function() {
                window.location.href = '/login-page';
            });
        });

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