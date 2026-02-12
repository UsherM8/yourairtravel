# Copilot Instructions for Your Air Travel Project

## Project Overview
This project is built using the Laravel framework, which provides a robust structure for web applications. The architecture is designed to facilitate rapid development while maintaining a clean and organized codebase.

### Key Components
- **Controllers**: Located in `app/Http/Controllers`, these handle incoming requests and return responses.
- **Models**: Found in `app/Models`, these represent the data structure and interact with the database.
- **Views**: Located in `resources/views`, these are the templates rendered to the user.
- **Service Providers**: Located in `app/Providers`, these are responsible for bootstrapping application services.

### Data Flow
1. **Request Handling**: Incoming requests are routed through `routes/web.php`.
2. **Controller Logic**: Requests are processed in controllers, which interact with models to fetch or manipulate data.
3. **Response Rendering**: Data is passed to views for rendering.

## Developer Workflows
### Building the Project
To build the project, use the following command:
```bash
npm run build
```
This compiles the assets defined in `vite.config.js`.

### Running Tests
To run tests, use:
```bash
php artisan test
```
This command executes all tests defined in the `tests` directory.

### Debugging
For debugging, utilize Laravel's built-in logging capabilities. Configure logging in `config/logging.php` to set the desired log level and channels.

## Project Conventions
- **Naming Conventions**: Follow PSR-12 standards for naming classes and methods.
- **File Structure**: Maintain the existing directory structure for easy navigation and understanding.

## Integration Points
- **Database**: Configured in `config/database.php`, supports multiple connections (e.g., MySQL, SQLite).
- **Queues**: Managed in `config/queue.php`, allowing background job processing.
- **External Services**: Credentials for services like AWS and Mailgun are stored in `config/services.php`.

## External Dependencies
- **Laravel Framework**: The core framework for building the application.
- **Vite**: Used for asset bundling and hot module replacement.

## Conclusion
This document serves as a guide for AI coding agents to understand the structure and workflows of the Your Air Travel project. For further details, refer to the Laravel documentation or the README.md file in the project root.