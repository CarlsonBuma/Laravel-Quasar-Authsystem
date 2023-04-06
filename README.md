# Read me
Gigup-Solution - v1.0.1 / 08.01.2023
by Carlson

## Current Version:
full-auth-system - v1.0.0

## System Details
 - Full Stack Auth System, v1.0.0
    - Login, Logout
    - Register, Email verification, 
    - Reset password
    - Transfer Email
    - User Profile
 - Guest
    - Legal & Compliance
 - Globals
    - Cookie Consent (cookieConsent.js)
    - Request Handling (Toast.js)

## Current Bugs: 08.01.2023
 1. Auth System: Transfer Account (simple?)
 2. Avatar Path to Server: CORS error

## Requirements
 - php 8.1
     - Xdebug from Zend Engine v.4.1
 - node.js 18.7
 - docker 20.10
     - docker-desktop
     - mysql image
     - phpMyAdmin
 - powershell

## Infrastructure
 - .docker:
     - Docker images
          - MySql
          - PSQL  
 - backend: 
     - Laravel v9 - PHP 8.1
 - frontend: 
     - Vue.js        - Node 18.7.0
     - Quasar        - Vue - Framework 1.3.2
     - Axios         - API Requests
 - root:
     - env-start.ps1 - start environement
     - env-end.ps1 - stop environment
