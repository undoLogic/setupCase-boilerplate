# DockerCOPYINTO

A development workflow designed to copy source files directly into a running container.

- Source files are injected into the container at startup
- All subsequent changes are applied inside the container via SSH
- Well-suited for controlled environments where host-to-container bind mounts are undesirable or impractical

This approach prioritizes performance and consistency by avoiding filesystem translation overhead commonly encountered on Windows.

## How It Works

- All files in the `sourceFiles` directory are copied from the host into the container before startup
- The container operates exclusively on its internal filesystem
- File changes made on the host are synchronized into the container using an SSH-based workflow

## IDE Integration (PhpStorm Example)

For fast, reliable syncing from Windows into the container:

- Configure **Deployment via SSH**
    - Host: `localhost`
    - Port: `2222`
    - User: `root`
    - Password: `root`

This provides near-native development performance without the delays associated with bind-mounted volumes.
