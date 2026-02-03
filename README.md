LMS - Course & Lesson Management System
Key Features
•	Course Management: Full CRUD operations for courses with instructor assignment.
•	Smart Lesson System: Lessons are linked to courses with custom ordering, content validation, and advanced search.
•	Dynamic Pagination: Integrated pagination for both Course listings and Lesson details to ensure high performance.
•	Role-Based Access Control (RBAC): * Admin: Full system control.
o	Instructor: Can manage their own courses and lessons.
o	Student: Can view and enroll in courses.
•	Security: Token-based authentication with a Background Token Refresh system to prevent session expiration.

•	 Backend: PHP (Laravel Framework)
•	 Frontend: Blade Templating, Bootstrap 5, Bootstrap Icons
•	Database: MySQL
•	Authentication: JWT / Custom Token Middleware
Installation & Setup
 1.  Environment Configuration
     cp .env.example .env # Update DB_DATABASE, DB_USERNAME, DB_PASSWORD         in .env
2. Database Setup
   php artisan key:generate
    php artisan migrate –seed
3.  Run the App
  php artisan serve

The backend architecture is built with Laravel API routes and Controllers, while the frontend utilizes Blade templates to showcase a complete workflow. Key features include:
•	Authentication Flow: Securely handled via JWT.
•	Course Listing: Includes search functionality and pagination.
•	Course Details: Shows lessons with independent search and pagination.
•	Course Enrollment: A simple flow for students to join courses.
•	Instructor Tools: Features to create and edit courses."



