<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management | LMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body class="bg-light">



    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{route('dashboard')}}" class="btn btn-outline-secondary me-3 shadow-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <h2 class="fw-bold">Enrollment Management</h2>

            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#enrollModal">

                <i class="bi bi-plus-circle"></i> New Enrollment

            </button>

        </div>



        <div class="card shadow-sm border-0">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0 align-middle">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">Serial</th>

                                <th>Student</th>

                                <th>Course Title</th>

                                <th>Status</th>

                                <th class="text-end pe-4">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($enrollments as $enroll)

                            <tr>

                                <td class="ps-4">

                                    {{ ($enrollments->currentPage() - 1) * $enrollments->perPage() + $loop->iteration }}

                                </td>

                                <td><strong>{{ $enroll->user->name ?? 'N/A' }}</strong></td>

                                <td>{{ $enroll->course->title ?? 'N/A' }}</td>

                                <td><span class="badge bg-success">{{ ucfirst($enroll->status) }}</span></td>

                                <td class="text-end pe-4">

                                    <button class="btn btn-sm btn-outline-warning" onclick="openReviewModal({{ $enroll->course_id }})">

                                        <i class="bi bi-star"></i> Review

                                    </button>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <div class="mt-4 d-flex justify-content-center">

            {{ $enrollments->links('pagination::bootstrap-5') }}

        </div>

    </div>



    <div class="modal fade" id="enrollModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Enroll in Course</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Select Course</label>

                    <select id="course_select" class="form-select">

                        @foreach($courses as $course)

                        <option value="{{ $course->id }}">{{ $course->title }}</option>

                        @endforeach

                    </select>

                </div>

                <div class="modal-footer"><button class="btn btn-primary w-100" onclick="submitEnroll()">Enroll Now</button></div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="reviewModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Course Review</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="review_course_id">

                    <div class="mb-3"><label>Rating (1-5)</label><input type="number" id="rating" class="form-control" min="1" max="5" value="5"></div>

                    <div class="mb-3"><label>Comment</label><textarea id="comment" class="form-control" rows="3"></textarea></div>

                </div>

                <div class="modal-footer"><button class="btn btn-warning w-100" onclick="submitReview()">Submit Review</button></div>

            </div>

        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script> 

        function submitEnroll() {

            let courseId = $('#course_select').val();
 

            $.post(`/api/courses/${courseId}/enroll`, function(res) {

                Swal.fire('Success', 'Enrolled Successfully', 'success').then(() => location.reload());

            }).fail(function(err) {

                Swal.fire('Error', 'Enrollment failed', 'error');

            });

        }



        function openReviewModal(courseId) {

            $('#review_course_id').val(courseId);

            $('#reviewModal').modal('show');

        }


 

        function submitReview() {

            let courseId = $('#review_course_id').val();

            let data = {
                rating: $('#rating').val(),
                comment: $('#comment').val()
            };



            $.post(`/api/courses/${courseId}/review`, data, function(res) {

                $('#reviewModal').modal('hide');

                Swal.fire('Success', 'Review added!', 'success');

            }).fail(function(err) {

                Swal.fire('Error', 'You must be enrolled to review', 'error');

            });

        }
    </script>

</body>

</html>