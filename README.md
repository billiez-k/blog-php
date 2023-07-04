# Blog PHP

This repository contains a blog page that allows user to record down daily activities.

Features:

1. PHP Mailing System
   - The blog page uses PHP Mailer, a github project, to send mail via PHP
   - Used in verifcation code and user credentials backup
3. Login, Logout and Registration System
   - User credentials are stored in user.txt
   - Register will append new user credentials to user.txt, login will check by user.txt contents
   - Logout will destroy session variables and redirect to public blog page
5. Anti-spam System
   - Users are only allowed to post 5 blogs per day
   - Post button will be disabled, with an alert message of "reached limit" shown
   - User cannot bypass the anti-spam system by developer mode in console, as all elements are blocked in PHP code
7. Public and Private Blog System
   - Public blog does not requires login and registration and login, while private blog does
   - Protect users from sensitive blog contents being seen by others, or being deleted
9. Calendar and Progress Recording System
    - Calendar uses Hong Kong time (GMT + 8)
    - The current date will be highlighted as blue
    - If there isn't blog posted that day, a cross will be marked to remind user to record down simple words everyday
    - Progress of blog writing will be recorded
11. Blog Deletion System
    - If blog content aren't satisfied, user can delete the blogs
    - A confirmation message will be alerted before deletion to prevent accidents
