# WorkWave - Next Generation Recruitment & Freelance Platform

![WorkWave Banner](https://via.placeholder.com/1200x300.png?text=WorkWave+-+Advanced+AI+Job+Platform)

**WorkWave** is a comprehensive, AI-powered web platform designed to seamlessly connect job seekers, freelancers, and employers. Built natively in PHP with a robust, custom **MVC architecture**, WorkWave entirely bypasses legacy database drivers (strictly utilizing `PDO`) to ensure maximum security, modularity, and academic excellence.

---

## 🌟 Key Features (Métiers Avancés)

WorkWave goes beyond standard CRUD operations by integrating advanced, real-world technologies:

- 🧠 **AI Profile Analysis**: Integrates the **HuggingFace API** for zero-shot text classification, automatically analyzing candidate profiles and predicting optimal job categories.
- 🆔 **Automated KYC (OCR)**: Uses the **OCR.space API** to automatically read uploaded ID cards (CIN) and instantly verify user identities.
- 💬 **Smart NLP Chatbot**: A custom-built AJAX chatbot capable of guiding users through complex platform features (Missions, 2FA, Payments, AI Analysis).
- 📅 **Google Calendar Integration**: Direct API payload generation allowing users to add registered events directly to their personal Google Calendar.
- 💳 **Stripe-Style Payment Gateway**: A front-end simulated secure payment workflow for premium events and services.
- 🔒 **Two-Factor Authentication (2FA)**: High-security authentication utilizing automated SMTP email verification codes.
- 📄 **Native PDF Export**: Custom CSS print media integration allowing Admins to export comprehensive user tables, and Seekers to export their AI-analyzed CVs.

---

## 🏗️ Architecture

The project strictly adheres to the **Model-View-Controller (MVC)** design pattern, built entirely without external PHP frameworks. 

- **Model (`/Model`)**: Contains entity classes (`User`, `Mission`, `Event`, `Resource`, `AdminStats`). Database interactions are exclusively handled via PDO Prepared Statements to prevent SQL Injection. `MySQLi` is strictly forbidden across the entire codebase.
- **View (`/View`)**: Clean, responsive interfaces built with HTML5, CSS3, and modern UI libraries. Role-based layouts are split dynamically (Admin Dashboard vs. User Dashboard).
- **Controller (`/Controller`)**: Features a centralized Front-Controller (`index.php`) that securely routes all incoming HTTP requests to their appropriate class methods.

---

## 👥 Role Management & Security

The platform supports a robust 3-tier access control system:

1. **Job Seekers (Candidats)**: Can browse missions, apply, view events, and utilize AI profile enhancement.
2. **Employers (Employeurs)**: Can publish missions, manage applications, and create/manage custom company events and resource logistics. Ownership tracking ensures Employers can only modify their own data.
3. **Administrators**: Have access to a comprehensive real-time dashboard featuring SQL-joined KPIs, Chart.js analytics, and full CRUD authority over the entire platform.

---

## 🚀 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/workwave.git
   ```
2. **Environment Setup:**
   Ensure you are running an environment with PHP 8.x and MySQL (e.g., XAMPP, WAMP).
3. **Database Import:**
   Import the `Model/create_tables.sql` file into your MySQL database to build the schema.
4. **Configuration:**
   Update the PDO connection string in `Model/Database.php` with your local database credentials.
5. **Run the Application:**
   Navigate to the project root directory via your local server (e.g., `http://localhost/workwave/Controller/index.php`).

---

## 📈 Git & Integration Status

This repository reflects the final integrated state of the project. All feature branches (Events, APIs, Missions, Users) have been successfully merged into the master branch with a continuous Git commit history spanning over 30 days, demonstrating consistent teamwork and Agile integration practices.

---
*Developed as a final academic project. Demonstrates strict adherence to security protocols, MVC design patterns, and modern API integration.*
