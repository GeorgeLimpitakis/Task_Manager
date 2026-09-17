Task Management API & GUI

---

Project Description

A complete Task Management application that includes:

1. Backend API: Implemented in PHP with an SQLite database.
2. Graphical User Interface (GUI): A modern SPA (Single Page Application) built with Vanilla JS and a Glassmorphism design.
3. Automated Testing: Integration tests in Python using the "pytest" framework.
4. Dockerization: Full Docker and Docker Compose support for easy installation on Ubuntu.
5. CI/CD: GitHub Actions for automated code checks on every push/pull request.

API Functionality

- "GET /tasks": Retrieve all tasks.
- "GET /tasks/{id}": Retrieve a specific task.
- "POST /tasks": Create a new task.
- "PUT /tasks/{id}": Update an existing task (Edit).
- "DELETE /tasks/{id}": Delete a task.

---

Installation & Execution Instructions

1. Automated Execution (Recommended)

This method builds the application and automatically runs the tests:

docker-compose up --build --abort-on-container-exit

2. Application Only (Docker)

If you simply want to run the application and view the graphical interface:

docker build -t task-api .
docker run -p 8000:80 task-api

Then, open the following address in your browser: http://localhost:8000

---

File Structure

- "/src": PHP code (API and GUI).
- "/tests": Python tests.
- ".github/workflows": GitHub Actions configuration.
- "Dockerfile" & "docker-compose.yml": Docker configuration.