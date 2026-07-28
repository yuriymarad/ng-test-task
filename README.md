## Installation

Requirements:

- Docker (via Laravel Sail)

Steps:

1. Clone the repo.
2. Copy the env file: `cp .env.example .env`.
3. Boot the stack with Sail (brings up the app and MySQL):

   ```bash
   sail up -d
   ```
4. Bootstrap the app:

   ```bash
   sail composer run setup
   ```

   This installs PHP & npm deps, generates `APP_KEY`, runs migrations, and builds frontend assets.
5. Visit http://localhost

