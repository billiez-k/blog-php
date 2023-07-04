# Blog PHP

This repository contains a blog page that allows user to record down daily activities.

Features:

<h2>1. PHP Mailing System</h2><br>
   - The blog page uses PHP Mailer, a github project, to send mail via PHP<br>
   - Used in verifcation code and user credentials backup
<h2>2. Login, Logout and Registration System</h2><br>
   - User credentials are stored in user.txt<br>
   - Register will append new user credentials to user.txt, login will check by user.txt contents<br>
   - Logout will destroy session variables and redirect to public blog page
<h2>3. Anti-spam System</h2><br>
   - Users are only allowed to post 5 blogs per day<br>
   - Post button will be disabled, with an alert message of "reached limit" shown<br>
   - User cannot bypass the anti-spam system by developer mode in console, as all elements are blocked in PHP code
<h2>4. Public and Private Blog System</h2><br>
   - Public blog does not requires login and registration and login, while private blog does<br>
   - Protect users from sensitive blog contents being seen by others, or being deleted
<h2>5. Calendar and Progress Recording System</h2><br>
    - Calendar uses Hong Kong time (GMT + 8)<br>
    - The current date will be highlighted as blue<br>
    - If there isn't blog posted that day, a cross will be marked to remind user to record down simple words everyday<br>
    - Progress of blog writing will be recorded
<h2>6. Blog Deletion System</h2><br>
    - If blog content aren't satisfied, user can delete the blogs<br>
    - A confirmation message will be alerted before deletion to prevent accidents
