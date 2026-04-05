# FTPHP-UP - FTP Deployment Workflow with GitHub Actions
FTP Server Upload w/GitHub Actions

## Overview

This repository contains a complete, step-by-step guide and workflow configuration to automate deploying your website or files to an FTP server using GitHub Actions.  
**Automate your deployment process easily and securely!**

---

## Features

- Trigger deployment automatically on pushes to a specific branch (e.g., `main`)
- Fetch latest code from your repository
- Optionally build your project before deployment
- Upload files securely via FTP or FTPS
- Exclude specific files or folders from deployment
- Use secrets for sensitive credentials
- Supports dry-run mode for testing

---

## Prerequisites

- A GitHub repository
- Access to an FTP or FTPS server
- FTP credentials (server address, username, password)
- (Optional) Build commands if deploying a static website or app
- GitHub Secrets configured for secure credential storage

---

## Setup Instructions

### 1. Prepare Your Repository

- Navigate to your GitHub repository
- Go to **Settings** > **Secrets and variables** > **Actions** > **New repository secret**

### 2. Add Secrets

Create the following secrets:

| Secret Name     | Description                                              |
|-----------------|----------------------------------------------------------|
| `FTP_SERVER`    | Your FTP server address (e.g., ftp.example.com)        |
| `FTP_USERNAME`  | Your FTP username                                       |
| `FTP_PASSWORD`  | Your FTP password                                       |

> **Important:** Never commit sensitive credentials directly into your code.

### 3. Create Workflow File

- In your repo, navigate to `.github/workflows/`
- Create a new file, e.g., `deploy.yml`
- Paste the provided workflow configuration (see below)

### 4. Customize the Workflow

- Adjust `server-dir`, `local-dir`, and other optional parameters as per your project structure
- Uncomment build steps if needed
- Enable `protocol: ftps` if your server supports secure transfer

---

## Example Workflow Configuration

```yaml
name: Deploy Anything via FTP - Complete Documentary Workflow

on:
  push:
    branches:
      - main  # Trigger deployment on pushes to 'main' branch

jobs:
  web-deploy:
    name: 🎉 Automated FTP Deployment Workflow
    runs-on: ubuntu-latest

    steps:
      - name: 🚚 Get the Latest Code
        uses: actions/checkout@v4

      # Optional: Configure Node.js environment if building your project
      # - name: Set up Node.js
      #   uses: actions/setup-node@v3
      #   with:
      #     node-version: '16'

      # Optional: Build your project before deployment
      # - name: Build Project
      #   run: |
      #     npm install
      #     npm run build

      - name: 📂 Sync Files to FTP Server
        uses: SamKirkland/FTP-Deploy-Action@v4.3.6
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          server-dir: ./htdocs/  # Adjust as needed
          # protocol: ftps  # Uncomment for secure transfer
          # dry-run: false  # Enable for testing
          # exclude: |
          #   **/.git*
          #   **/node_modules/**
```

---

## Usage Tips

- **Dry-Run Mode:** Use `dry-run: true` during testing to see what files would be uploaded without affecting your server.
- **Excluding Files:** Customize the `exclude` list to prevent uploading sensitive files or unnecessary data.
- **Secure Transfer:** Use `protocol: ftps` for encrypted file transfer if your host supports it.
- **Multiple Environments:** Create different workflows or secrets for staging and production deployments.

---

## Troubleshooting

- Ensure secrets are correctly added and referenced.
- Verify your FTP server details and credentials.
- Check the logs in GitHub Actions for errors or warnings.
- Confirm that your server directory paths are correct and writable.

---

## Support and Contributions

If you encounter issues or want to contribute enhancements, feel free to open an issue or pull request!

---

## License

This project is open-source and available under the MIT License.
[github.com/SamKirkland/FTP-Deploy-Action/LICENSE](https://github.com/SamKirkland/FTP-Deploy-Action/blob/master/LICENSE)

---

## Final Notes

Automating your FTP deployments with GitHub Actions saves time, reduces errors, and secures your credentials. Customize the workflow to fit your project's needs and enjoy seamless deployment!

---

Happy deploying! 🚀
