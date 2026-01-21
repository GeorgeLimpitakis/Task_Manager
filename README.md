# Task Management API & GUI 

Αυτή η εφαρμογή αναπτύχθηκε στο πλαίσιο της απαλλακτικής εργασίας για το μάθημα **Τεχνολογία Λογισμικού 2025-26**.

## Στοιχεία Φοιτητή
- **Όνομα:** Γεωργιος Λυμπιτάκης
- **Αριθμός Μητρώου:** inf2023111

## Στοιχεία Μαθήματος
- **Μάθημα:** Τεχνολογία Λογισμικού
- **Εξάμηνο:** Ε Χειμερινό 2025-26


---

## Περιγραφή Project
Μια ολοκληρωμένη εφαρμογή διαχείρισης εργασιών (Task Management) που περιλαμβάνει:
1.  **Backend API:** Υλοποιημένο σε **PHP** με βάση δεδομένων **SQLite**.
2.  **Graphical User Interface (GUI):** Μια σύγχρονη SPA (Single Page Application) με Vanilla JS και Glassmorphism design.
3.  **Automated Testing:** Integration tests σε **Python** χρησιμοποιώντας το framework `pytest`.
4.  **Dockerization:** Πλήρης υποστήριξη Docker και Docker Compose για εύκολη εγκατάσταση σε Ubuntu.
5.  **CI/CD:** GitHub Actions για αυτόνομο έλεγχο του κώδικα σε κάθε push/pull request.

### Λειτουργικότητες API
- `GET /tasks`: Ανάκτηση όλων των tasks.
- `GET /tasks/{id}`: Ανάκτηση συγκεκριμένου task.
- `POST /tasks`: Δημιουργία νέου task.
- `PUT /tasks/{id}`: Ενημέρωση υπάρχοντος task (Edit).
- `DELETE /tasks/{id}`: Διαγραφή task.

---

## Οδηγίες Εγκατάστασης & Εκτέλεσης

### 1. Αυτοματοποιημένη Εκτέλεση (Προτεινόμενο)
Αυτός ο τρόπος χτίζει την εφαρμογή και τρέχει αυτόματα τα tests:

```bash
docker-compose up --build --abort-on-container-exit
```

### 2. Μόνο η Εφαρμογή (Docker)
Αν θέλετε απλώς να τρέξετε την εφαρμογή και να δείτε το γραφικό περιβάλλον:

```bash
docker build -t task-api .
docker run -p 8000:80 task-api
```
Στη συνέχεια, ανοίξτε στον browser τη διεύθυνση: **[http://localhost:8000](http://localhost:8000)**

---

## Δομή Αρχείων
- `/src`: Ο κώδικας της PHP (API και GUI).
- `/tests`: Τα tests σε Python.
- `.github/workflows`: Ρυθμίσεις για το GitHub Actions.
- `Dockerfile` & `docker-compose.yml`: Ρυθμίσεις Docker.

## Screenshots & Αναφορά
Στο φάκελο της εργασίας θα βρείτε την αναφορά PDF με αναλυτικές περιγραφές και screenshots από τη λειτουργία της εφαρμογής και των tests.
