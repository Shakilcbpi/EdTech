<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light p-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Edit Course</h4>
                        <a href="/course-page" class="btn btn-sm btn-outline-secondary">Back</a>
                    </div>
                    
                    <div id="msg" class="alert d-none shadow-sm"></div>

                    <form id="editForm">
                        <input type="hidden" id="courseId" value="{{ $course->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Course Title</label>
                            <input type="text" id="title" class="form-control" value="{{ $course->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price ($)</label>
                                <input type="number" id="price" class="form-control" value="{{ $course->price }}" step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Difficulty Level</label>
                                <select id="level" class="form-select" required>
                                    <option value="beginner" {{ $course->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ $course->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ $course->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea id="description" class="form-control" rows="4">{{ $course->description }}</textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" id="btn" class="btn btn-primary py-2 fw-bold">
                                <i class="bi bi-save"></i> Update Changes
                            </button>
                            <a href="/course-page" class="btn btn-light py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $('#editForm').submit(function(e) {
        e.preventDefault();

        let id = $('#courseId').val();
        let btn = $('#btn');
        let msgBox = $('#msg');
 
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Updating...');
        msgBox.addClass('d-none').removeClass('alert-success alert-danger');
 
        let data = {
            _method: 'PUT',
            title: $('#title').val(),
            price: $('#price').val(),
            level: $('#level').val(),
            description: $('#description').val()
        };

        $.ajax({
            url: '/api/courses/' + id,
            type: 'POST', 
            data: data,
            success: function(res) {
                btn.prop('disabled', false).html('<i class="bi bi-save"></i> Update Changes');
 
                if (res.status.toLowerCase() === 'success') {
                    msgBox.removeClass('d-none alert-danger').addClass('alert-success')
                          .text('Course Updated Successfully! Redirecting to list...');
                     
                    setTimeout(function() {
                        window.location.href = '/course-page';
                    }, 2000);
                } else {
                    msgBox.removeClass('d-none').addClass('alert-danger').text(res.message || 'Update failed!');
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-save"></i> Update Changes');
                
                let errorText = "Update Failed!";
                if(xhr.status === 403) {
                    errorText = "Unauthorized: You don't have permission to edit this course.";
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorText = xhr.responseJSON.message;
                }

                msgBox.removeClass('d-none').addClass('alert-danger').text(errorText);
                console.error(xhr.responseText);
            }
        });
    });
</script>

</body>
</html>