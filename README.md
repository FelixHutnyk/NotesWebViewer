# NotesWebViewer
A project to have a webpage display a directory tree of files and preview Markdown, PDFs, txts, and more

**NotesWebViewer** is based on [mdwebreader](https://github.com/jaimehrubiks/mdwebreader).

## Updates:

- favicon added
- The side bar is now collapsable!



## Installation Instructions

1. Dependancies
    * You will need PHP installed.

2. Install the repository into your webserver
    > git clone https://github.com/FelixHutnyk/NotesWebViewer.git 

3. Upload your documents
    * Upload your PDF's, Markdown Files, txt's, etc into the /docs folder

4. Enjoy!

## Usage

You can use this project to display static files, but personally i use this website to host all of my notes, and work from my classes.
To do so, i have a github project that i do all of my work in.

1. Create a folder for your git repository within the /docs/ folder.
2. Setup and link the folder to your github repo for notes.
3. Setup the script below and modify the paths.
4. Setup the cron job to automatically run the script every 5 minutes.
5. Enjoy!

### Auto-Pull Script
```sh
#!/bin/bash

cd /path/to/web_root/public_html/docs/created_folder

git pull origin master >> pull.log
```

### Cron Job for Auto-Pull Script
```
*/5 * * * * /path/to/script/pull.sh
```

## Notes
By default, if README.md exists in the root directory. It will be loaded by default when the website is loaded.

## Preview
![Preview](https://i.imgur.com/Ln3A2VH.png)