<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/dashboard">LMS Dashboard</a>
        <a href="{{route('CoursePage')}}" class="btn btn-outline-light btn-sm">Back to List</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Add New Course</h5>
                </div>
                <div class="card-body p-4">
                    <form id="courseForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Course Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter course title" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price ($)</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Difficulty Level</label>
                                <select class="form-select" name="level" id="level" required>
                                    <option value="" selected disabled>Select Level</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="Write course details..."></textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary py-2" id="saveBtn">
                                <i class="bi bi-cloud-upload"></i> Save Course
                            </button>
                        </div>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('#courseForm').on('submit', function(e) {
        e.preventDefault();
         
        $('#saveBtn').prop('disabled', true).text('Saving...');
        $('#responseMessage').empty();

        let formData = {
            title: $('#title').val(),
            price: $('#price').val(),
            level: $('#level').val(),
            description: $('#description').val(),
        };

        $.ajax({
            url: '/api/courses',  
            type: 'POST',
            data: formData,
            success: function(res) {
                $('#saveBtn').prop('disabled', false).html('<i class="bi bi-cloud-upload"></i> Save Course');
                
                if(res.status === 'Success') {
                    $('#responseMessage').html('<div class="alert alert-success">Course created successfully! Redirecting...</div>');
                    $('#courseForm')[0].reset();
                     
                    setTimeout(() => {
                        window.location.href = '/courses';
                    }, 2000);
                }
            },
            error: function(xhr) {
                $('#saveBtn').prop('disabled', false).html('<i class="bi bi-cloud-upload"></i> Save Course');
                
                let message = "Something went wrong!";
                if(xhr.status === 403) message = "Only instructors can create courses!";
                if(xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;

                $('#responseMessage').html('<div class="alert alert-danger">' + message + '</div>');
            }
        });
    });
</script>

</body>
</html>