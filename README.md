# CP3402-Group-7-Assignment-2


CP3402 Content Management Systems - Team 7
Made by:
- Ivan Ang
- Khant Kyaw Zin
- Ashish Adhana
- Hongzhe He


Instructions on installation
Requirements: 
- Varying Vagrant Vagrant (VVV)
- Wordpress
- WP All in One Migration Plugin

Installation:
1. Set up Wordpress and VVV
2. Clone Repository from Main branch inside desired folder. git clone https://github.com/IvanJeremiahAng/CP3402-Group-7-Assignment-2
3. Initialise repository through running: (vagrant up --provision)
4. Navigate to the directory you cloned file into (cd VVV_folder/www/wordpressone/)
5. replace public_html with files within this repository
6. run: (vagrant reload --provision)

OR
1. Set up Wordpress and VVV
2. Download file from Master Branch.
3. Navigate to your VVV file location (cd vvv-local)
4. Run Command: (vagrant up)
5. Open the following url: (http://one.wordpress.test/wp-admin/)
6. Login admin account (Username: admin) (Password: password)
7. Navigate to plugins
8. Search and install the plugin: All-in-One WP Migration
9. Activate plugin and click Import
10. Import file from master branch

# Theme
The child theme we have made is based of the starter parent theme: Pressbook

We have made changes regarding the aesthetics and structure of contents. We have removed unnecessary widgets such as the blog posts, archives, and comments. We relocated the searchbar and categories widgets to a more appropriate location, being the nav-bar. We have also added a logo, header and footer. Regarding the aesthetics changes, we changed the color and size of contents such that the background is more darker and the size of the contents are more appropriate to our client's product design.

There is 1 form included on our website, being a feedback form. This form is accessable through the nav bar and the call to action located on the front page of our site. The Call to Action is placed near the center of our homepage so that users will immediately see it without needing to navigate throughout our site.
