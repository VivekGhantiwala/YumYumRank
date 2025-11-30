# Contributing to Yum Yum Rank 🍽️

First off, thank you for considering contributing to Yum Yum Rank! It's people like you that make this project better.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Pull Request Process](#pull-request-process)
- [Style Guidelines](#style-guidelines)

---

## 📜 Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code. Please be respectful and constructive in all interactions.

---

## 🤝 How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When you create a bug report, include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples**
- **Describe the behavior you observed and expected**
- **Include screenshots if possible**
- **Include your environment details** (OS, PHP version, browser, etc.)

### 💡 Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion:

- **Use a clear and descriptive title**
- **Provide a detailed description of the proposed feature**
- **Explain why this enhancement would be useful**
- **Include mockups or examples if applicable**

### 🔧 Pull Requests

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Make your changes
4. Test your changes thoroughly
5. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
6. Push to the branch (`git push origin feature/AmazingFeature`)
7. Open a Pull Request

---

## 🛠️ Development Setup

### Prerequisites

- XAMPP/WAMP/LAMP with PHP 8.0+
- MySQL 5.7+ or MariaDB 10.4+
- Git

### Setup Steps

1. **Fork and clone the repository**
   ```bash
   git clone https://github.com/VivekGhantiwala/yum-yum-rank.git
   cd yum-yum-rank
   ```

2. **Set up the database**
   - Create a database named `yumyumrank`
   - Import `db.sql`

3. **Configure database connection**
   - Update credentials in `admin/connection.php` and other config files

4. **Start your local server**
   - Navigate to `http://localhost/yum-yum-rank/`

---

## ✅ Pull Request Process

1. **Ensure your code follows the style guidelines**
2. **Update documentation if needed**
3. **Add tests for new features if applicable**
4. **Ensure all tests pass**
5. **Update the README.md if needed**
6. **Request review from maintainers**

### PR Checklist

- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Comments added for complex logic
- [ ] Documentation updated
- [ ] No new warnings generated
- [ ] Tested locally

---

## 🎨 Style Guidelines

### PHP

- Use meaningful variable and function names
- Follow PSR-12 coding standards
- Add comments for complex logic
- Use prepared statements for database queries

### HTML/CSS

- Use semantic HTML5 elements
- Follow BEM naming convention for CSS classes
- Ensure responsive design
- Optimize images

### JavaScript

- Use ES6+ features
- Add JSDoc comments for functions
- Handle errors appropriately

### Git Commit Messages

- Use present tense ("Add feature" not "Added feature")
- Use imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit first line to 72 characters
- Reference issues and PRs when applicable

**Examples:**
```
feat: Add user profile picture upload
fix: Resolve login redirect issue
docs: Update installation instructions
style: Format code according to standards
refactor: Simplify database queries
```

---

## 🏷️ Issue Labels

| Label | Description |
|-------|-------------|
| `bug` | Something isn't working |
| `enhancement` | New feature or request |
| `documentation` | Documentation improvements |
| `good first issue` | Good for newcomers |
| `help wanted` | Extra attention needed |
| `question` | Further information requested |

---

## 💬 Questions?

Feel free to open an issue with the `question` label or reach out to the maintainers.

---

Thank you for contributing! 🙏
