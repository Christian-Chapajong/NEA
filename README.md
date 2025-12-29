# Spacer

**The Spaced Repetition Algorithm for Cognitive Expansion & Recall**

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)
![Status](https://img.shields.io/badge/status-active-success.svg)

## 📚 Overview

Spacer is an intelligent flashcard application that leverages spaced repetition algorithms to optimize learning and long-term memory retention. Built with PHP, Spacer helps students, professionals, and lifelong learners master any subject through scientifically-backed study techniques.

## ✨ Features

- **🧠 Intelligent Spaced Repetition** - Algorithm-driven card scheduling based on your performance
- **📇 Custom Deck Creation** - Organize your study materials into themed decks
- **🔍 Smart Search** - Quickly find cards and decks across your library
- **📊 Progress Tracking** - Monitor your learning progress and retention rates
- **👤 User Accounts** - Secure authentication with personalized study sessions
- **🎨 Clean Interface** - Intuitive design focused on distraction-free learning

## 🚀 Getting Started

### Prerequisites

- PHP 7.4 or higher
- MySQL/MariaDB database
- Web server (Apache/Nginx)
- Composer (for dependency management)

### Installation

1. Clone the repository
```bash
git clone https://github.com/Christian-Chapajong/NEA.git
cd NEA
```

2. Install dependencies
```bash
npm install
composer install
```

3. Configure your database connection
```php
// Update your database credentials in the configuration file
```

4. Set up the database
```bash
php setup.php
```

5. Start your local server
```bash
php -S localhost:8000
```

6. Visit `http://localhost:8000` in your browser

## 📖 Usage

### Creating Your First Deck

1. Sign up or log in to your account
2. Navigate to "Create Deck"
3. Add a deck name and description
4. Start adding flashcards with questions and answers

### Studying with Spacer

1. Select a deck from your library
2. Begin reviewing cards
3. Rate your recall (Easy, Medium, Hard)
4. Spacer automatically schedules the next review based on your performance

### Search Functionality

Use the search feature to quickly find specific cards or decks across your entire library.

## 🧮 The Algorithm

Spacer uses a modified version of the SM-2 algorithm, which adjusts card intervals based on:

- **Recall difficulty** - How easily you remembered the answer
- **Previous performance** - Your historical accuracy with the card
- **Time elapsed** - How long since your last review
- **Card maturity** - How many times you've successfully recalled the card

Cards you struggle with appear more frequently, while mastered cards have longer intervals, optimizing your study time.

## 🛠️ Technology Stack

- **Backend**: PHP
- **Frontend**: HTML, CSS, SCSS, JavaScript
- **Database**: MySQL
- **Build Tools**: Node.js, npm

## 📁 Project Structure

```
spacer/
├── assets/          # Static assets (CSS, JS, images)
├── images/          # Image resources
├── partials/        # Reusable PHP components
├── node_modules/    # Node dependencies
├── create.php       # Deck creation interface
├── decks.php        # Deck management
├── home.php         # User dashboard
├── index.php        # Landing page
├── login.php        # Authentication
├── review.php       # Study session interface
├── search.php       # Search functionality
└── view.php         # Card viewing
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Author

**Christian Chapajong**

- GitHub: [@Christian-Chapajong](https://github.com/Christian-Chapajong)

## 🙏 Acknowledgments

- Inspired by research in cognitive psychology and memory retention
- Built as part of a Non-Exam Assessment (NEA) project
- Thanks to the spaced repetition research community

## 📧 Contact

Have questions or suggestions? Feel free to open an issue or reach out!

---

**Remember**: Consistent practice with Spacer leads to lasting knowledge. Happy learning! 🎓
