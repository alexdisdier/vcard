# VCARD Website Template

Responsive personal vCard template. Designed and developed both as a personal business card and a final project.

As an end-user, you will have a template to describe your skills.

As a developer, you can use this template and build upon its functionalities.

My goal was to build a CMS to understand the MVC architecture

## Features

* Mobile responsive
* Customizable content (text, photo, favicon, META)
* Retrieve Password through email

## Usage example

See a live version running this template - https://www.alexdisdier.fr/

### Prerequisites

You need to create a database.

## How can I use this template

1. Within the "prod" folder, download the file "install-vcard.php" and the zip "vcard_archive.zip"
2. Upload those 2 files in the root directory of your future website or localhost for further testing
3. In your navigation bar, type the url of your root directory followed by "install-vcard.php".
It should be something like "https://yourdomain.com/install-vcard.php"
4. Follow the instructions
5. Create your administrator login by clicking on "Made with a" link.
6. You can now log in. Click on the smily face in the footer.
7. Edit your content.

## For Development purposes

1. Comment the lines 9-11 of **/library/ErrorView.phtml** in order to get specific error messages.
2. Change the credentials as you see fit in **/application/config/database.php**

## Directory Structure

```bash
-------------------------------------------

├── application
│   ├── classes
│   ├── config
│   ├── controllers
│   ├── forms
│   ├── models
│   ├── www
│   │   ├── about
│   │   ├── admin
│   │   ├── assets
│   │   │   ├── scss
│   │   │   │   │
│   │   │   ├── fonts
│   │   │   │   │
│   │   │   ├── images
│   │   │   │   └── raw
│   │   │   └──js
│   │   ├── node_modules
│   │   ├── quotes
│   │   ├── site
│   │   ├── social
│   │   ├── user
│   │   │   ├── login
│   │   ├── .htaccess
│   │   ├── footer.phtml
│   │   ├── header.phtml
│   │   ├── HomeView.phtml
│   │   ├── index.php
│   │   ├── style.css
│   │   ├── style.css.map
│   │   └── style.min.css
├── library
├── node_modules
├── dist
├── .htaccess
├── gulpfile.js
├── index.php
├── install-card.php
├── package-lock.json
├── package.json
├── README_3W.txt
├── README_GITHUB.md
├── vcard.sql
└── version2.txt
```

## Built With

* html
* css/ scss
* JavaScript
* php - [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) framework developed by [3W school](https://3wa.fr/)
* mySQL
* Gulp

## Authors

* **Alex Disdier** - *Initial work* - [alexdisdier](https://github.com/alexdisdier)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* README.md based on [PurpleBooth](https://github.com/PurpleBooth) and [dbader](https://github.com/dbader).
