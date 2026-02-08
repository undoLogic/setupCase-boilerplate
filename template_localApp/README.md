# This allows to create a local app that can be compiled into local application to run on Windows, Mac or Linux

1. Copy all template files to a new directory
```bash
cp -R template_localApp localApp_TEST
cd localApp_TEST/runtime/python
```

2. Use Poetry to install the dependancies
```angular2svg
poetry install
```

3. Start up our app
```angular2svg
poetry run python app/main.py
```