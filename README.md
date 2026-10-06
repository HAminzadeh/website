# SakhtYar Flow Website

## Local development

Prerequisite:
- Docker Desktop
- Git
- IntelliJ IDEA / PhpStorm

Start the local site:

```powershell
.\scripts\start-local.ps1
```

URLs:
- Site: http://localhost:8080
- Admin: http://localhost:8080/wp-admin
- phpMyAdmin: http://localhost:8081

Stop:

```powershell
.\scripts\stop-local.ps1
```

Reset all local WordPress data:

```powershell
.\scripts\reset-local.ps1
```

Build an installable WordPress theme ZIP:

```powershell
.\scripts\build-theme.ps1 -Version 0.2.0
```

Output:
`dist\sakhtyar-flow-theme-0.2.0.zip`

## Repository layout

```text
theme/sakhtyar-flow/   WordPress theme source
scripts/               Local dev and build scripts
content/               Versioned pages/articles/data
dist/                  Generated ZIP packages (Git ignored)
docker-compose.yml     Local WordPress stack
```

`.env` is local-only and is ignored by Git. Use `.env.example` as the template.