# 💻 PHP + MySQL CRUD Laboratory Activity

## 🎯 Project Overview
A complete Student Management System implementing CRUD (Create, Read, Update, Delete) operations using PHP, MySQL, and Bootstrap for an enhanced user interface.

## ✨ Features

### ✅ Core Features
- **Create**: Add new student records with form validation
- **Read**: View all students in a sortable, searchable table
- **Update**: Edit existing student information
- **Delete**: Remove student records with confirmation dialogs

### 🎁 Bonus Features Implemented
- ✅ **Form Validation**: Both client-side and server-side validation
- ✅ **Bootstrap Modal**: Confirmation dialogs before deleting records
- ✅ **Table Sorting**: Sort by name, email, age, course, and date
- ✅ **Search Functionality**: Search by name, email, or course
- ✅ **Responsive Design**: Mobile-friendly Bootstrap interface
- ✅ **Dashboard**: Statistics and recent activity overview

## 🚀 Getting Started

### Prerequisites
- **XAMPP** or **WAMP** server
- **PHP** 7.4 or higher
- **MySQL** 5.7 or higher
- Modern web browser

### Installation Steps

1. **Start your server**:
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL** services

2. **Copy project files**:
   ```
   Copy the entire `student_lab_crud` folder to:
   - XAMPP: C:\xampp\htdocs\
   - WAMP: C:\wamp64\www\
   ```

3. **Database Setup**:
   The application automatically creates the database and table on first run.
   - Database: `student_lab_db`
   - Table: `students`
   
   **Manual setup (optional)**:
   ```sql
   CREATE DATABASE student_lab_db;
   USE student_lab_db;
   
   CREATE TABLE students (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL UNIQUE,
       age INT NOT NULL CHECK (age >= 16 AND age <= 100),
       course VARCHAR(100) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

4. **Access the application**:
   - Open browser and navigate to: `http://localhost/student_lab_crud/`

## 📁 File Structure

```
student_lab_crud/
├── index.php          # Dashboard with statistics and navigation
├── db_connect.php     # Database connection and initialization
├── insert.php         # Add new student form
├── select.php         # View all students with sorting/search
├── update.php         # Edit existing student records
├── delete.php         # Delete student records with confirmation
└── README.md          # Project documentation
```

## 🔧 Configuration

### Database Settings
Edit `db_connect.php` to modify database connection:
```php
$host = 'localhost';        // Database host
$dbname = 'student_lab_db'; // Database name
$username = 'root';         // Database username
$password = '';             // Database password (empty for XAMPP)
```

## 🎨 User Interface

### Navigation
- **Home**: Dashboard with statistics and quick actions
- **View Students**: Paginated table with sorting and search
- **Add Student**: Form with validation for new records

### Features Demonstration
- **Form Validation**: Real-time validation with Bootstrap styling
- **Modal Confirmations**: Safe delete operations with user confirmation
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Sort & Search**: Click column headers to sort, use search box to filter

## 🔒 Security Features

- **PDO Prepared Statements**: Prevents SQL injection attacks
- **Input Validation**: Server-side validation for all user inputs
- **XSS Protection**: HTML encoding for all output data
- **Email Validation**: Proper email format checking
- **Age Constraints**: Database-level constraints for valid age ranges

## 📚 Reflection Questions & Answers

### 1. What function is used to connect PHP to MySQL?
**Answer**: The **PDO (PHP Data Objects)** class is used in this project for database connections. Specifically:
```php
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
```

**Alternative methods**:
- `mysqli_connect()` - MySQLi procedural
- `new mysqli()` - MySQLi object-oriented

**Why PDO?**
- Database-agnostic (works with multiple database types)
- Built-in prepared statements for security
- Exception handling support
- More consistent API

### 2. What is the difference between INSERT and UPDATE queries?

| Aspect | INSERT | UPDATE |
|--------|---------|---------|
| **Purpose** | Creates new records | Modifies existing records |
| **Syntax** | `INSERT INTO table (columns) VALUES (values)` | `UPDATE table SET column=value WHERE condition` |
| **Result** | Adds new rows to table | Changes existing rows |
| **WHERE clause** | Not used | Required (recommended) to specify which records to update |

**Examples from this project**:
```sql
-- INSERT (creating new student)
INSERT INTO students (name, email, age, course) VALUES (?, ?, ?, ?)

-- UPDATE (modifying existing student)
UPDATE students SET name=?, email=?, age=?, course=? WHERE id=?
```

### 3. How do you prevent SQL injection in PHP?

**Primary Method: Prepared Statements with PDO**
```php
// ❌ Vulnerable to SQL injection
$sql = "SELECT * FROM students WHERE name = '" . $_POST['name'] . "'";

// ✅ Safe with prepared statements
$sql = "SELECT * FROM students WHERE name = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['name']]);
```

**Additional Security Measures**:
1. **Input Validation**: Check data types and formats
2. **Whitelist Validation**: Only allow expected values
3. **Escape Output**: Use `htmlspecialchars()` for XSS protection
4. **Principle of Least Privilege**: Use database users with minimal permissions

**Implementation in this project**:
- All database queries use PDO prepared statements
- Input validation on both client and server side
- HTML encoding for all output data

### 4. Why is CRUD important in web applications?

**CRUD** forms the foundation of most web applications by providing the basic operations needed for data management:

**Business Value**:
- **Data Management**: Efficiently handle information lifecycle
- **User Interaction**: Allow users to interact with application data
- **Content Management**: Enable dynamic content creation and updates
- **Administrative Control**: Provide tools for data maintenance

**Technical Benefits**:
- **Standardized Operations**: Consistent patterns for data handling
- **RESTful Architecture**: Maps directly to HTTP methods (GET, POST, PUT, DELETE)
- **Database Independence**: Abstract database operations through common interface
- **Maintainable Code**: Organized structure for data operations

**Real-world Applications**:
- **E-commerce**: Product management, order processing
- **Social Media**: User posts, comments, profiles
- **Content Management**: Articles, pages, media
- **Business Systems**: Customer records, inventory, transactions

## 🧪 Testing the Application

### Manual Testing Checklist

**Create (Insert) Operations**:
- [ ] Add student with all valid information
- [ ] Test form validation with empty fields
- [ ] Test email format validation
- [ ] Test age range validation (16-100)
- [ ] Test duplicate email handling

**Read (Select) Operations**:
- [ ] View all students in table
- [ ] Test search functionality
- [ ] Test sorting by different columns
- [ ] Test responsive design on mobile

**Update Operations**:
- [ ] Edit existing student information
- [ ] Test validation on update forms
- [ ] Verify data persistence after update

**Delete Operations**:
- [ ] Test delete confirmation modal
- [ ] Verify record is actually deleted
- [ ] Test delete from both table and update page

## 🔍 Advanced Features

### Dashboard Analytics
- Student count statistics
- Recent additions tracking
- Course distribution visualization
- Quick action buttons

### Search & Filter
- Real-time search across name, email, and course
- Case-insensitive matching
- Search result highlighting

### Responsive Design
- Mobile-first Bootstrap layout
- Touch-friendly buttons and forms
- Collapsible navigation menu

## 🎓 Learning Outcomes Achieved

Upon completion of this project, students have demonstrated:

1. **Database Connection**: Successfully connected PHP to MySQL using PDO
2. **Database Design**: Created normalized table structure with appropriate constraints
3. **CRUD Implementation**: Built all four fundamental data operations
4. **Security Awareness**: Implemented SQL injection prevention and input validation
5. **UI/UX Design**: Created user-friendly interface with Bootstrap
6. **Error Handling**: Implemented proper error handling and user feedback
7. **Code Organization**: Structured code with separation of concerns

## 🚨 Troubleshooting

### Common Issues

**Database Connection Error**:
```
Solution: Check XAMPP/WAMP MySQL service is running
Verify database credentials in db_connect.php
```

**Page Not Found (404)**:
```
Solution: Ensure files are in correct directory (htdocs or www)
Check file permissions
Verify Apache service is running
```

**Form Submission Not Working**:
```
Solution: Check form method is POST
Verify input names match PHP variables
Check for PHP errors in browser console
```

**Styling Issues**:
```
Solution: Check internet connection (Bootstrap CDN)
Verify Bootstrap CSS/JS links are correct
Clear browser cache
```

## 📈 Future Enhancements

- **User Authentication**: Login/logout system with role management
- **File Upload**: Profile picture upload for students
- **Export Functionality**: CSV/PDF export of student data
- **Advanced Search**: Filter by date ranges, multiple criteria
- **Audit Trail**: Track changes to student records
- **API Integration**: RESTful API for mobile app integration

## 👨‍💻 Author

Created as part of PHP + MySQL CRUD Laboratory Activity

## 📄 License

This project is created for educational purposes as part of a laboratory activity.