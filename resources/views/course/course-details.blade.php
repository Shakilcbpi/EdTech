<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} | Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sticky-sidebar { top: 20px; }
        .lesson-card:hover { background-color: #f8f9fa; transition: 0.3s; }
        .pagination { margin-bottom: 0; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/dashboard">LMS Dashboard</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('CoursePage') }}" class="btn btn-outline-secondary mb-4 shadow-sm">
                <i class="bi bi-arrow-left"></i> Back to Courses
            </a>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h1 class="fw-bold text-primary">{{ $course->title }}</h1>
                    <p class="text-muted mt-3" style="font-size: 1.1rem; line-height: 1.6;">
                        {{ $course->description ?? 'No description available for this course.' }}
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="fw-bold mb-0"><i class="bi bi-journal-text me-2"></i>Course Lessons</h4>
                        </div>
                        <div class="col-md-6 mt-2 mt-md-0">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search lesson title..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @if($lessons->count() > 0)
                            @foreach($lessons as $lesson)
                                <div class="list-group-item p-3 lesson-card">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold">
                                            <span class="text-primary me-2">
                                                {{ ($lessons->currentPage() - 1) * $lessons->perPage() + $loop->iteration }}.
                                            </span> 
                                            {{ $lesson->title }}
                                        </h6>
                                        <span class="badge bg-light text-dark border">Order: {{ $lesson->order }}</span>
                                    </div>
                                    <p class="mb-1 text-secondary small mt-2">
                                        {{ Str::limit($lesson->content, 120) }}
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="p-5 text-center text-muted">
                                <i class="bi bi-search fs-1 d-block mb-3"></i>
                                <p class="mb-0">No lessons found matching your criteria.</p>
                                <a href="{{ url()->current() }}" class="btn btn-sm btn-link mt-2">Clear Search</a>
                            </div>
                        @endif
                    </div>
                </div>

                @if($lessons->hasPages())
                <div class="card-footer bg-white py-3 border-top">
                    <div class="d-flex justify-content-center">
                        {{ $lessons->appends(request()->input())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top sticky-sidebar">
                <div class="card-body p-4 text-center">
                    <h2 class="text-success fw-bold mb-3">${{ number_format($course->price, 2) }}</h2>
                    <hr>
                    <div class="text-start mb-4">
                        <div class="mb-3">
                            <small class="text-muted d-block text-uppercase small fw-bold">Instructor</small>
                            <span class="fw-bold text-dark"><i class="bi bi-person-circle me-1"></i> {{ $course->instructor->name ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block text-uppercase small fw-bold">Course Level</small>
                            <span class="badge bg-info text-dark text-capitalize">{{ $course->level }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block text-uppercase small fw-bold">Total Lessons</small>
                            <span><i class="bi bi-play-btn me-1"></i> {{ $course->lessons->count() }} Lessons</span>
                        </div>
                        <div>
                            <small class="text-muted d-block text-uppercase small fw-bold">Last Updated</small>
                            <span><i class="bi bi-calendar3 me-1"></i> {{ $course->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>