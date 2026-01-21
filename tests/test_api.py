import requests
import pytest
import os
import sqlite3

# Get URL from environment variable, default to local docker-exposed port
BASE_URL = os.getenv("API_URL", "http://localhost:8000/index.php/tasks")

def setup_module(module):
    # Reset database before tests if needed
    if os.path.exists("database.sqlite"):
        os.remove("database.sqlite")

def test_create_task():
    payload = {
        "username": "testuser",
        "title": "Test Task",
        "description": "This is a test task",
        "deadline": "2026-12-31"
    }
    print(f"\n[POST] Creating task with: {payload}")
    response = requests.post(f"{BASE_URL}", json=payload)
    print(f"Response ({response.status_code}): {response.text}")
    
    assert response.status_code == 201
    data = response.json()
    assert data["username"] == "testuser"
    assert "id" in data

def test_get_all_tasks():
    print(f"\n[GET] Fetching all tasks from {BASE_URL}")
    response = requests.get(f"{BASE_URL}")
    print(f"Response ({response.status_code}): {response.text}")
    
    assert response.status_code == 200
    assert isinstance(response.json(), list)

def test_get_task_by_id():
    # Create a task first
    payload = {"username": "user2", "title": "Single Task"}
    print(f"\n[PRE-TEST] Creating helper task for ID test: {payload}")
    create_res = requests.post(f"{BASE_URL}", json=payload)
    task_id = create_res.json()["id"]

    print(f"[GET] Fetching task with ID: {task_id}")
    response = requests.get(f"{BASE_URL}/{task_id}")
    print(f"Response ({response.status_code}): {response.text}")
    
    assert response.status_code == 200
    assert response.json()["id"] == task_id

def test_update_task():
    # Create a task first
    payload = {"username": "user_update", "title": "Old Title"}
    print(f"\n[PRE-TEST] Creating helper task for update test: {payload}")
    create_res = requests.post(f"{BASE_URL}", json=payload)
    task_id = create_res.json()["id"]

    # Update it
    update_payload = {"title": "New Updated Title", "description": "Updated description"}
    print(f"[PUT] Updating task ID {task_id} with: {update_payload}")
    response = requests.put(f"{BASE_URL}/{task_id}", json=update_payload)
    print(f"Response ({response.status_code}): {response.text}")
    
    assert response.status_code == 200
    updated_data = response.json()
    assert updated_data["title"] == "New Updated Title"
    assert updated_data["description"] == "Updated description"
    assert updated_data["username"] == "user_update" # Should remain same

def test_delete_task():
    # Create a task first
    payload = {"username": "user3", "title": "To Delete"}
    print(f"\n[PRE-TEST] Creating helper task for delete test: {payload}")
    create_res = requests.post(f"{BASE_URL}", json=payload)
    task_id = create_res.json()["id"]

    print(f"[DELETE] Deleting task with ID: {task_id}")
    response = requests.delete(f"{BASE_URL}/{task_id}")
    print(f"Response status: {response.status_code}")
    
    assert response.status_code == 204

    # Verify it's gone
    get_res = requests.get(f"{BASE_URL}/{task_id}")
    print(f"Verification GET for deleted task ({get_res.status_code}): {get_res.text}")
    assert get_res.status_code == 404

def test_get_non_existent_task():
    print(f"\n[GET] Fetching non-existent task ID: 9999")
    response = requests.get(f"{BASE_URL}/9999")
    print(f"Response ({response.status_code}): {response.text}")
    assert response.status_code == 404

def test_create_task_missing_fields():
    payload = {"username": "missing_title"}
    print(f"\n[POST] Testing invalid creation (missing title): {payload}")
    response = requests.post(f"{BASE_URL}", json=payload)
    print(f"Response ({response.status_code}): {response.text}")
    assert response.status_code == 400
