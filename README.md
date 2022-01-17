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
