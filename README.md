E-Learning Platform API (Laravel & JWT)
This is a full-featured RESTful API for an E-Learning Platform built with Laravel. It supports multiple user roles, JWT authentication, and comprehensive course management.
🚀 Features
•	JWT Authentication: Secure login, registration, and token management.
•	Role-Based Access Control: Admin, Instructor, and Student roles using Laravel Policies/Gates.
•	Course Management: Instructors can create and manage courses and lessons.
•	Student Interaction: Course enrolment, and reviews.
•	Search & Filtering: Advanced filtering for courses by title.
•	AJAX-ready: Optimized for seamless frontend integration via Ajax.
________________________________________
🛠️ Tech Stack
•	Backend: Laravel  12
•	Auth: JWTToken package
•	Database: MySQL  
•	Frontend Tools: AJAX  
________________________________________
⚙️ Setup Instructions
Follow these steps to get the project running locally:
1.	Clone the repository:
Bash
git clone https://github.com/Shakilcbpi/EdTech.git 
cd EdTech
2.	Install dependencies:
Bash
composer install
3.	Environment Setup:
Bash
cp .env.example .env
Update the .env file with your Database credentials.
4.	Generate App Key:
Bash
php artisan key:generate

5.	Run Migrations & Seeders:
Bash
php artisan migrate --seed
6.	Start the Server:
Bash
php artisan serve
________________________________________
🔐 JWT Setup Steps
1.	Installation: We use jwttoken php-jwt package 
2.	Token Refresh: Use the /api/auth/refresh endpoint to get a new token before expiration.
________________________________________
👥 User Roles & Permissions
Role	Permissions
Admin	Full system access, manage all users and content.
Instructor	Create courses, add lessons, and manage their own content.
Student	Browse courses, enroll, and leave reviews.
________________________________________
📡 API Flow Overview
1.	Auth Flow: User Registers → Login → Receives JWT Token → Includes token in Authorization: Bearer {token} header for protected routes.
2.	Instructor Flow: Login → Create Course → Add Lessons → View Enrollments.
3.	Student Flow: Login → Browse Courses (with pagination) → Enroll → View Lessons → Add Review.
Key Endpoints
  Authentication
•	POST /api/register - Create a new account
•	POST /api/login - Get JWT token
•	POST /api/refresh-token - Get a new token
•	POST /api/logout - Invalidate current token
Course Management
•	GET /api/courses - Fetch all courses (with pagination/filtering)
•	POST /api/courses - Create a new course (Instructor only)
•	GET /api/courses/{id} - Get detailed information of a course
•	PUT /api/courses/{id} - Update course details (Owner only)
📖 Lesson Management
•	POST /api/courses/{courseId}/lessons - Add a lesson to a specific course
•	GET /api/courses/{courseId}/lessons - View all lessons of a course
•	PUT /api/lessons/{id} - Update a specific lesson
Student & Enrollments
•	POST /api/courses/{courseId}/enroll - Enroll in a course
•	GET /api/my-courses - View courses enrolled by the current user
•	POST /api/courses/{courseId}/review - Add a rating & comment to a course
 Web Routes (Frontend UI)
The project also includes a simple UI for interaction:
•	/ - Login Page
•	/registration-page - Signup Page
•	/dashboard - Main Dashboard (Protected)
•	/course-page - Course Management UI
•	/enrollment-page - Student Enrollment UI

________________________________________
📮 Postman Collection
You can find the Postman collection from here:
https://github.com/Shakilcbpi/edtech_postman.git
