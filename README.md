I have successfully implemented the following features in my completed system:

Established a MySQL server and created three entities, 'users' ,'authors' and 'articles,' each with specific attributes such as
userId, Full_Name, email, phone_Number, User_Name, Password, UserType, AccessTime, profile_Image, 
Address for users, and authorId (FK), article_title, article_full_text, article_created_date, article_last_update, article_display, article_order for articles.

Developed PHP OOP code to handle various database operations, including the creation of constants
(Host_Name, Database_User, Password, Database_Name) stored in constant.php and establishing a connection to the MySQLi database server.

Implemented a login page for the Super_User, with the index page displaying a login form. Upon successful login, the Super_User gains access to four buttons: 
Update Profile, Manage Other Users, View Articles, and Logout.

Enabled the Super_User to update their profile details, manage other users (add, list, update, delete), and export the user list to PDF, text file, and Excel.

Implemented a functionality for the Super_User to view the last six posted articles in descending order based on the article creation date.

Introduced an 'Admin' role with similar functionalities as the Super_User, including the ability to manage authors, view articles, update the profile, and logout.

Defined an 'Author' role with functionalities such as updating their profile, managing articles (add, list, update, delete), 
viewing the last six articles in descending order by [article_created_date], and exporting articles to PDF and text file.

Implemented a logout option for the Super_User,Admin and the Author to sign out of the system and return to the index page.
