<a name="readme-top">

<br/>

<br />
<div align="center">
  <a href="https://github.com/zyx-0314/">
    <img src="./assets/img/HomeLogo.png" alt="THE LAST TRADE POST" width="130" height="100">
  </a>
  <h3 align="center">THE LAST TRADE POST</h3>
</div>
<div align="center">
  <b>An advanced inventory and marketplace web application for trading and managing survival gear.</b>
</div>

<br />

![](https://visit-counter.vercel.app/counter.png?page=pejisean/AD-Final-Task)

[![wakatime](https://wakatime.com/badge/github/pejisean/AD-Final-Task.svg)]

---

<br />
<br />

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#overview">Overview</a>
      <ol>
        <li>
          <a href="#key-components">Key Components</a>
        </li>
        <li>
          <a href="#technology">Technology</a>
        </li>
      </ol>
    </li>
    <li>
      <a href="#rules-practices-and-principles">Rules, Practices and Principles</a>
    </li>
    <li>
      <a href="#resources">Resources</a>
    </li>
  </ol>
</details>

---

## Overview

**THE LAST TRADE POST** is a modern web application designed for trading, buying, and managing survival and outdoor gear. It features a robust inventory system, user authentication, and a dynamic marketplace for users to list and purchase items. The project leverages PHP, CodeIgniter, and modern frontend frameworks for a seamless experience.

### Key Components

### Key Components

- User Authentication & Authorization
- Product Management & Marketplace
- Utility Functions
- Routing & Bootstrap
- Dockerized Deployment

### Technology

#### Language
![HTML](https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

#### Framework/Library
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

#### Databases
![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)
![MongoDB](https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white)

#### Deployment
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Vercel](https://img.shields.io/badge/Vercel-000000?style=for-the-badge&logo=vercel&logoColor=white)

---

## Rules, Practices and Principles

1. Always use `AD-` in the front of the Title of the Project for the Subject followed by your custom naming.
2. Do not rename `.php` files if they are pages; always use `index.php` as the filename.
3. Add `.component` to the `.php` files if they are components code; example: `footer.component.php`.
4. Add `.util` to the `.php` files if they are utility codes; example: `account.util.php`.
5. Place Files in their respective folders.
6. Different file naming Cases
   | Naming Case | Type of code         | Example                           |
   | ----------- | -------------------- | --------------------------------- |
   | Pascal      | Utility              | Account.util.php                  |
   | Camel       | Components and Pages | index.php or footer.component.php |
7. Renaming of Pages folder names are a must, and relates to what it is doing or data it holding.
8. Use proper label in your github commits: `feat`, `fix`, `refactor` and `docs`
9. File Structure to follow below.

```
AD-TheLastTradePost
└─ assets
|   └─ css
|   |   └─ main.css
|   └─ img
|   |   └─ logo.webp
|   └─ js
|       └─ script.js
└─ components
|   ├─ header.component.php
|   ├─ footer.component.php
|   └─ templates
|       └─ card.component.php
└─ handlers
|   ├─ user.handler.php
|   └─ product.handler.php
└─ layouts
|   ├─ main.layout.php
|   └─ auth.layout.php
└─ pages
|   ├─ dashboard
|   |   ├─ assets
|   |   |   ├─ css
|   |   |   |   └─ dashboard.css
|   |   |   ├─ img
|   |   |   |   └─ dashboard-bg.webp
|   |   |   └─ js
|   |   |       └─ dashboard.js
|   |   └─ index.php
|   ├─ login
|   |   └─ index.php
|   └─ register
|       └─ index.php
└─ staticDatas
|   └─ items.staticdata.php
└─ utils
|   ├─ Auth.util.php
|   └─ Inventory.util.php
└─ vendor
└─ .gitignore
└─ bootstrap.php
└─ composer.json
└─ composer.lock
└─ index.php
└─ readme.md
└─ router.php
```

## Resources

| Title                        | Purpose                                                      | Link                                                                 |
|------------------------------|--------------------------------------------------------------|----------------------------------------------------------------------|
| PHP Manual                   | Official PHP documentation                                   | https://www.php.net/manual/en/                                       |
| CodeIgniter Documentation    | Guide for CodeIgniter framework                              | https://codeigniter.com/user_guide/                                  |
| Bootstrap Documentation      | Frontend framework documentation                             | https://getbootstrap.com/docs/5.0/getting-started/introduction/      |
| Tailwind CSS Documentation   | Utility-first CSS framework                                  | https://tailwindcss.com/docs                                         |
| MySQL Documentation          | Official MySQL documentation                                 | https://dev.mysql.com/doc/                                           |
| MongoDB Manual               | Official MongoDB documentation                               | https://www.mongodb.com/docs/manual/                                 |
| PostgreSQL Documentation     | Official PostgreSQL documentation                            | https://www.postgresql.org/docs/                                     |
| Docker Documentation         | Containerization platform docs                               | https://docs.docker.com/                                             |
| Composer PHP                 | Dependency manager for PHP                                   | https://getcomposer.org/doc/                                         |
| Visual Studio Code Docs      | VS Code editor documentation                                 | https://code.visualstudio.com/docs                                   |
| W3Schools HTML/CSS/JS        | Reference for HTML, CSS, and JavaScript basics               | https://www.w3schools.com/                                           |
| Mozilla Developer Network    | In-depth web technology documentation                        | https://developer.mozilla.org/                                       |
| GitHub Docs                  | GitHub platform documentation                                | https://docs.github.com/                                             |
| DigitalOcean PHP Deployment  | Guide for deploying PHP apps                                 | https://www.digitalocean.com/community/tutorials/tag/php             |
| FreeCodeCamp PHP Tutorials   | Beginner to advanced PHP tutorials                           | https://www.freecodecamp.org/news/tag/php/                           |
| Stack Overflow               | Community Q&A for programming                                | https://stackoverflow.com/questions/tagged/php                       |

---