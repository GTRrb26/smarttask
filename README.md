# SmartTask - Project Management System

SmartTask is a modern, feature-rich project management system built with Laravel. It helps teams and individuals organize their projects, tasks, and collaborate effectively.

## Features

- **Project Management**
  - Create and manage projects
  - Add team members to projects
  - Set project timelines and deadlines
  - Track project progress

- **Task Management**
  - Create and assign tasks
  - Set task priorities and due dates
  - Track task status (To Do, In Progress, Done)
  - Add task descriptions and comments

- **User Management**
  - User authentication and authorization
  - Profile management
  - Theme customization (Light/Dark mode)
  - Language preferences (English/Hindi)

- **Dashboard**
  - Overview of projects and tasks
  - Task statistics and progress tracking
  - Recent activities and updates

## Technology Stack

### Backend
- **Laravel 10.x** - PHP framework
- **MySQL** - Database
- **Laravel Sanctum** - API authentication
- **Laravel Spatie** - Role and permission management

### Frontend
- **Blade** - Templating engine
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - JavaScript framework for interactivity
- **Vite** - Frontend build tool

### Development Tools
- **PHP 8.1+**
- **Node.js & NPM**
- **Composer** - PHP dependency manager
- **Git** - Version control

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/smarttask.git
cd smarttask
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smarttask
DB_USERNAME=root
DB_PASSWORD=
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Start the development server:
```bash
php artisan serve
```

9. In a new terminal, start Vite:
```bash
npm run dev
```

## Features in Detail

### Project Management
- Create projects with title, description, and timeline
- Add team members to collaborate
- Track project progress and completion
- View project details and associated tasks

### Task Management
- Create tasks with title, description, and due date
- Assign tasks to team members
- Update task status (To Do, In Progress, Done)
- Add comments and track task history

### User Features
- Secure authentication system
- Profile management with theme preferences
- Role-based access control
- Multi-language support

### Dashboard
- Overview of all projects and tasks
- Task statistics and progress tracking
- Recent activities feed
- Quick access to important information

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel Framework
- Tailwind CSS
- Alpine.js
- All contributors and supporters
