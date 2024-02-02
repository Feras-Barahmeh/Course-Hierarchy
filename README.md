
# About Project
The purpose of the Pre-Catalog is to allow students to indicate their program
preferences and update their personal information before the official catalog and course registration period.
This process helps the university plan course offerings, allocate resources, and provide students with a streamlined registration experience.

# Steps to browse project

1) Install XAMPP and run it 
2) Create visual host if you use linux follow this steps to create it 

    ## How Create Visual host Linux(Ubuntu)
    
    1. Open a terminal window.
       1. Navigate to the Apache configuration directory by running the following command:
          ```
          cd /opt/lampp/etc/extra
          ```
       2. Create a new virtual host configuration file using a text editor. For example:
          ```
          sudo nano mysite.conf
          ```
          Replace "mysite" with the desired name for your virtual host.
       3. In the editor, add the following content to the configuration file:
          ```
          <VirtualHost *:80>
              DocumentRoot "/path/to/your/project"
              ServerName mysite.local
              <Directory "/path/to/your/project">
                  Require all granted
                  AllowOverride All
              </Directory>
          </VirtualHost>
          ```
          Replace "/path/to/your/project" with the actual path to your project directory.
          Replace "mysite.local" with the desired domain name for your virtual host.
       4. Save the file and exit the text editor.
       5. Open the Apache configuration file for editing by running the following command:
          ```
          sudo nano /opt/lampp/etc/httpd.conf
          ```
       6. Uncomment the following line by removing the "#" symbol:
          ```
          # Include etc/extra/httpd-vhosts.conf
          ```
          Save the file and exit the text editor.
       7. Open the virtual hosts configuration file by running the following command:
          ```
          sudo nano /opt/lampp/etc/extra/httpd-vhosts.conf
          ```
       8. Add the following content to the file:
          ```
          NameVirtualHost *:80
    
          <VirtualHost *:80>
              DocumentRoot "/path/to/your/project"
              ServerName mysite.local
              <Directory "/path/to/your/project">
                  Require all granted
                  AllowOverride All
              </Directory>
          </VirtualHost>
          ```
          Replace "/path/to/your/project" with the actual path to your project directory.
          Replace "mysite.local" with the desired domain name for your virtual host.
       9. Save the file and exit the text editor.
       10. Open the hosts file for editing by running the following command:
           ```
           sudo nano /etc/hosts
           ```
       11. In the editor, add the following line at the end of the file:
           ```
           127.0.0.1    mysite.local
           ```
           Replace "mysite.local" with the same domain name you used in the virtual host configuration file.
       12. Save the file and exit the text editor.
       13. Restart the Apache server to apply the changes by running the following command:
           ```
           sudo /opt/lampp/lampp restart
           ```
       14. Now you should be able to access your virtual host by opening a web browser and entering "http://mysite.local" as the URL.

3) install project in open it in terminal
4) change permissions for app dir run `sudo chmod -R 777 app`
5) create db and named it `PreCatalog` then import it
6) login

   | Privileges | Email                        | Password |
   |------------|------------------------------|----------|
   | admin      | feras @adm.ttu.edu.jo        | password |
   | student    | majd@stu.ttu.edu.jo          | password |
   | guides     | ahmadmohammad@gui.ttu.edu.jo | password |
   | instructor | naem@ins.ttu.edu.jo          | password |

