# app/main.py

from app.version import APP_NAME, APP_VERSION


def main():
    """
    Public entry point.
    Keep this readable and short.
    """
    print(f"{APP_NAME} starting...")
    _run()
    print(f"{APP_NAME} exiting cleanly.")


def _run():
    """
    Private implementation.
    Can grow without affecting the public API.
    """
    print(f"Hello from {APP_NAME} v{APP_VERSION}")


if __name__ == "__main__":
    main()
