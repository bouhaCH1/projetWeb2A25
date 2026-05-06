# WorkWave - Job Platform

A comprehensive web platform connecting job seekers with employers in Tunisia. Built with PHP following MVC architecture and modern web development best practices.

## 🚀 Features

### User Management
- **Multi-role Authentication**: Job seekers, employers, and administrators
- **Advanced Security**: Two-factor authentication, login history tracking
- **Identity Verification**: OCR-based document verification system
- **Profile Management**: Complete CRUD operations with file uploads
- **Password Reset**: Secure token-based password recovery system

### Job & Mission Management
- **Mission Posting**: Employers can create and manage job postings
- **Application System**: Job seekers can apply with motivation letters
- **Status Tracking**: Real-time application status updates
- **Advanced Search**: Filter jobs by skills, budget, and dates

### Admin Dashboard
- **User Management**: Complete user administration with search and filtering
- **Statistics Dashboard**: Real-time analytics and growth charts
- **Content Moderation**: Account verification and suspension capabilities
- **System Monitoring**: Login history and security tracking

### AI-Powered Features
- **Profile Analysis**: AI-powered career suggestions using HuggingFace API
- **Smart Matching**: Automated job-candidate compatibility analysis
- **OCR Verification**: Document verification using OCR.space API

## 🛠 Technical Stack

### Backend
- **PHP 8.x**: Server-side programming
- **MySQL**: Database management with PDO
- **MVC Architecture**: Clean separation of concerns
- **Object-Oriented Programming**: Modern PHP practices

### Frontend
- **HTML5/CSS3**: Responsive design
- **JavaScript**: Interactive features
- **Bootstrap**: UI framework components
- **Custom CSS**: Professional styling

### APIs & Integrations
- **HuggingFace**: AI profile analysis
- **OCR.space**: Document verification
- **PHP Mail**: Email notifications

## 📁 Project Structure

```
WorkWave/
├── Controller/
│   ├── UserController.php    # User-related operations
│   └── index.php           # Main router
├── Model/
│   ├── User.php           # User business logic
│   ├── Database.php       # Database connection
│   └── create_tables.sql  # Database schema
├── View/
│   ├── admin/             # Admin interface
│   ├── user/              # User interface
│   └── layout/            # Common templates
└── uploads/               # File uploads directory
```

## 🚀 Installation

### Prerequisites
- XAMPP/WAMP/MAMP (PHP 8.x, MySQL, Apache)
- Git
- Composer (optional)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/WorkWave.git
   cd WorkWave
   ```

2. **Database Setup**
   ```bash
   # Import database schema
   mysql -u root -p job_platform < Model/create_tables.sql
   ```

3. **Configuration**
   - Update database credentials in `Model/Database.php`
   - Configure email settings for password reset
   - Set up API keys for external services

4. **Web Server**
   - Point your web server to the project root
   - Ensure `uploads/` directory is writable

5. **Access the Application**
   - URL: `http://localhost/WorkWave/Controller/`
   - Default admin: `admin@workwave.com` / `password`

## 🎯 Core Features Demonstration

### Authentication Flow
1. **Registration**: Multi-role signup with validation
2. **Login**: Secure authentication with 2FA option
3. **Password Recovery**: Token-based email reset system
4. **Profile Management**: Complete user data management

### Admin Operations
1. **User Management**: Search, edit, suspend, verify users
2. **Statistics**: Real-time dashboard analytics
3. **Security**: Login history and monitoring

### Job Management
1. **Mission Creation**: Employers post job opportunities
2. **Applications**: Job seekers apply with detailed submissions
3. **Status Tracking**: Real-time application updates

## 🔒 Security Features

- **Password Hashing**: Bcrypt encryption
- **SQL Injection Prevention**: PDO prepared statements
- **XSS Protection**: Input sanitization and output encoding
- **CSRF Protection**: Token-based request validation
- **Session Security**: Secure session management
- **Access Control**: Role-based permissions

## 📊 Database Schema

### Core Tables
- **users**: User accounts and profiles
- **mission**: Job postings and opportunities
- **candidature**: Job applications
- **password_resets**: Password recovery tokens
- **login_history**: Security audit trail

## 🎨 UI/UX Features

- **Responsive Design**: Mobile-friendly interface
- **Modern Styling**: Professional color scheme and layout
- **Interactive Elements**: Smooth transitions and micro-interactions
- **Accessibility**: Semantic HTML and ARIA labels
- **Error Handling**: Comprehensive validation and feedback

## 🚀 Performance Optimizations

- **Database Indexing**: Optimized query performance
- **Caching**: Session-based data caching
- **File Organization**: Efficient code structure
- **API Integration**: Async external service calls

## 📈 Project Statistics

- **Development Time**: 3+ weeks of active development
- **Git Commits**: 20+ commits with detailed history
- **Features Implemented**: 15+ major features
- **API Integrations**: 4 external services
- **Security Measures**: 6+ security implementations

## 🤝 Team Contributions

This project demonstrates collaborative development with:
- **Version Control**: Git workflow with proper branching
- **Code Reviews**: Peer review process
- **Documentation**: Comprehensive project documentation
- **Testing**: Manual testing and validation

## 📞 Contact & Support

- **Project Repository**: [GitHub Link]
- **Documentation**: This README file
- **Issues**: Report via GitHub Issues
- **Email**: projet.web@Esprit.tn

## 📜 License

This project is developed for educational purposes as part of the Esprit Engineering School curriculum.

---

**Note**: This project showcases advanced PHP development skills, modern web technologies, and software engineering best practices. It's designed to be scalable, secure, and maintainable.
