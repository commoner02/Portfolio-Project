# Portfolio Project

A dynamic portfolio website with admin dashboard built with PHP, MySQL, HTML, CSS, and JavaScript.<br/>

## Features

### Frontend Portfolio
- **Responsive Design** - Works on mobile and desktop
- **Dynamic Projects** - Projects loaded from database
- **Contact Form** - AJAX form submission with validation
- **Skills Section** - JavaScript-generated skill showcase
- **Smooth Navigation** - Mobile hamburger menu and smooth scrolling
- **Visit Counter** - Cookie-based visitor tracking with persistent count storage

### Admin Dashboard
- **Secure Login** - Session-based authentication
- **Project Management** - Full CRUD operations (Create, Read, Update, Delete)
- **Image Handling** - File upload validation and preview
- **Message Management** - View and delete contact messages
- **Dashboard Stats** - Project and message counts
- **Responsive Interface** - Mobile-friendly admin panel

## Technology Stack

- **Backend**: PHP 7+, MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Database**: MySQL with PDO
- **Security**: Password hashing, SQL injection prevention, session management

## Project Structure
```
Portfolio-Project/
├── admin/
│   ├── index.php           # Main admin dashboard (CRUD operations)
│   ├── login.php           # Admin login page
│   ├── logout.php          # Admin logout handler
│   └── style.css           # Admin dashboard styles
├── includes/
│   ├── auth.php            # Authentication functions (protectPage, checkLogin)
│   └── config.php          # Database configuration and PDO connection
├── uploads/
│   ├── logos/              # Skill icons and logos
│   ├── me/                 # Profile images
│   └── project-image.png   # Project images
├── index.php               # Main portfolio page
├── style.css               # Portfolio main styles
├── script.js               # Frontend JavaScript functionality
└── README.md               # Project documentation
```

##  Database Schema
```
Database: portfolio_db

Tables:
1. users       - Admin login credentials
2. projects    - Portfolio projects (title, description, image, URL)
3. messages    - Contact form submissions

------------------------------------------------
Table: users
------------------------------------------------
- id          INT, PRIMARY KEY, AUTO_INCREMENT
- username    VARCHAR(255)
- email       VARCHAR(255)
- password    VARCHAR(255)
- created_at  TIMESTAMP

------------------------------------------------
Table: projects
------------------------------------------------
- id          INT, PRIMARY KEY, AUTO_INCREMENT
- title       VARCHAR(255)
- description TEXT
- project_url VARCHAR(255)
- image_url   VARCHAR(255)
- created_at  TIMESTAMP

------------------------------------------------
Table: messages
------------------------------------------------
- id          INT, PRIMARY KEY, AUTO_INCREMENT
- name        VARCHAR(255)
- email       VARCHAR(255)
- message     TEXT
- created_at  TIMESTAMP
```



## Quick Setup

1. **Clone the repository**
2. **Import database** (create tables for users, projects, messages)
3. **Configure database** in `includes/config.php`
4. **Set up admin user** (hashed password in users table)
5. **Upload to web server** (XAMPP/LAMPP)

## Admin Features

- **Login System** - Secure admin authentication
- **Add Projects** - Title, description, URL, image filename
- **Edit Projects** - Modify existing project details
- **Delete Projects** - Remove projects and associated images
- **View Messages** - Contact form submissions
- **Image Preview** - Live preview of uploaded images
- **Responsive Design** - Works on all devices

## User Features

- **Portfolio Display** - Showcase of projects and skills
- **Contact Form** - AJAX submission with validation
- **Mobile Navigation** - Hamburger menu for mobile devices
- **Smooth Scrolling** - Navigation between sections
- **Visit Tracking** - Cookie-based visit counter

## Design Highlights

- **Modern UI** - Clean, professional design
- **Color Scheme** - Orange/red accents on dark background
- **Typography** - Mozilla Text font family
- **Responsive Grid** - CSS Grid and Flexbox layouts
- **Smooth Animations** - CSS transitions and transforms

## Key Technologies

- **PHP Sessions** - User authentication and flash messages
- **PHP Cookies** - Visitor tracking and persistent data storage
- **PDO Prepared Statements** - SQL injection prevention
- **JavaScript Fetch API** - AJAX form submissions
- **CSS Grid/Flexbox** - Responsive layouts

## Contact
* **GitHub:** [commoner02](https://github.com/commoner02)
* **LinkedIn:** [Sree Shuvo Kumar Joy](https://www.linkedin.com/in/sree-shuvo-kumar-joy-b6a60737a/)

## Author
- **Name:** Sree Shuvo Kumar Joy  
- **Roll:** 2107116  
- **Course:** Web Programming Laboratory  
- **Institution:** KUET    
