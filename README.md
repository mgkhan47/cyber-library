# 📚 Cyber Library  
**Building a Cyber Library: From Web Scraping to User Interface**  

## 🚀 Overview  
The **Cyber Library Project** is a digital platform that combines **web scraping**, **database integration**, and a **user-friendly interface** to provide users with access to a large collection of books. Developed as part of an ICT project at Air University, this application demonstrates how modern tools can make knowledge more accessible.  

---

## ✅ Features  
- **Web Scraping with Python**  
  - Utilizes **Google Books API** to fetch book data (Title, Author, Description, ISBN, URL).  
  - Stores data in **JSON** and **Excel** for flexibility.  

- **Backend**  
  - Built using **PHP**, **MySQL**, and **XAMPP** for data handling.  
  - Database table: `finalbook` with fields (`id`, `title`, `author`, `description`, `isbn`, `url`).  

- **Frontend**  
  - Developed using **HTML** and **PHP** for a responsive and easy-to-use interface.  
  - Supports **search functionality** and **dynamic book display**.  

---

## 🛠 Tech Stack  
- **Python** (Web Scraping, JSON Handling)  
- **Google Books API**  
- **PHP & MySQL** (Backend)  
- **HTML + PHP** (Frontend)  
- **XAMPP** (Local Server)  

---

## 🔑 How It Works  
1. **Data Acquisition**:  
   - Python script scrapes book data from Google Books API.  
   - Data saved in `finalbook.json` and Excel file.  

2. **Database Setup**:  
   - Create database `cyber_library` in **phpMyAdmin**.  
   - Table `finalbook` with columns:  
     ```
     id (INT, PK, Auto Increment)
     title (VARCHAR)
     author (VARCHAR)
     description (TEXT)
     isbn (VARCHAR)
     url (TEXT)
     ```  

3. **Data Import**:  
   - Use `import_json.php` to insert JSON data into the database.  

4. **Frontend Integration**:  
   - Access `books.php` via `http://localhost/books_project/books.php`.  
   - Search for books and view results dynamically from the database.  

---

## ▶ Installation Guide  
### **Requirements**  
- XAMPP installed  
- Python 3.x with `requests` & `json` libraries  

### **Steps**  
1. Clone the repository:  
   ```bash
   git clone https://github.com/mgkhan47/cyber-library.git
   ```
2. Place project files in `htdocs` folder of XAMPP.  
3. Start **Apache** and **MySQL** from XAMPP.  
4. Import the database structure via **phpMyAdmin**.  
5. Run Python script to generate `finalbook.json` (if needed).  
6. Access the app at:  
   ```
   http://localhost/books_project/books.php
   ```  

---

## 📂 Project Structure  
```
cyber-library/
│── webscraper.py          # Python script for data scraping
│── import_json.php        # Imports JSON data to MySQL
│── books.php              # Frontend display and search
│── finalbook.json             # Book data in JSON
│── README.md              # Project documentation
```


---

## 📜 License  
This project is open-source and available under the **MIT License**.  
