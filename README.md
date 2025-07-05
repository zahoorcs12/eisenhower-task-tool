# Task Prioritization Tool – Eisenhower Matrix

This is a simple web-based application to help users manage and prioritize their tasks using the Eisenhower Matrix methodology. Users can input tasks, mark them as urgent or important, and view them in one of the four quadrants: Do First, Schedule, Delegate, or Eliminate.

---

## 🚀 Features

- User registration and login system
- Add tasks with urgency and importance
- Automatic categorization using the Eisenhower Matrix
- Interactive drag-and-drop functionality to move tasks between quadrants
- Ability to delete tasks with confirmation

---

## 🛠️ Tech Stack

- **Backend:** PHP (Symfony-compatible structure)
- **Frontend:** HTML, CSS, JavaScript (Vanilla), Bootstrap (optional styling)
- **Database:** MySQL
- **Version Control:** Git + GitHub

---

## 📁 Project Structure

```
├── index.php           # Main task dashboard
├── db.php              # Database connection
├── login.php           # User login
├── register.php        # User registration
├── logout.php          # Logout script
├── delete.php          # Deletes a task
├── move.php            # Updates a task's category via drag-and-drop
├── init.sql            # MySQL table setup
├── composer.json       # Composer dependencies
└── README.md           # Project description and instructions
```

---

## 🧪 Installation Instructions

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/eisenhower-task-tool.git
cd eisenhower-task-tool
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Database
- Create a MySQL database (e.g., `eisenhower`)
- Import `init.sql`

```bash
mysql -u root -p < init.sql
```

- Update `db.php` with your database credentials.

### 4. Run the App
```bash
php -S localhost:8000
```
Visit: [http://localhost:8000](http://localhost:8000)

---

## 👤 Default Test Account
```
Username: testuser
Password: test123
```

---

## 📌 Future Improvements
- Task editing
- Responsive mobile view
- UI enhancements with Bootstrap
- Data export (CSV/PDF)

---

## 📄 License
This project is developed for educational use in IU's DLMCSPCSP01 portfolio course.
# eisenhower-task-tool
