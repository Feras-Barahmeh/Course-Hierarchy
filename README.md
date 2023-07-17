
# How Create Visual host Linux(Ubuntu)

1. Open a terminal window.
2. Navigate to the Apache configuration directory by running the following command:
   ```
   cd /opt/lampp/etc/extra
   ```
3. Create a new virtual host configuration file using a text editor. For example:
   ```
   sudo nano mysite.conf
   ```
   Replace "mysite" with the desired name for your virtual host.
4. In the editor, add the following content to the configuration file:
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
5. Save the file and exit the text editor.
6. Open the Apache configuration file for editing by running the following command:
   ```
   sudo nano /opt/lampp/etc/httpd.conf
   ```
7. Uncomment the following line by removing the "#" symbol:
   ```
   # Include etc/extra/httpd-vhosts.conf
   ```
   Save the file and exit the text editor.
8. Open the virtual hosts configuration file by running the following command:
   ```
   sudo nano /opt/lampp/etc/extra/httpd-vhosts.conf
   ```
9. Add the following content to the file:
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
10. Save the file and exit the text editor.
11. Open the hosts file for editing by running the following command:
    ```
    sudo nano /etc/hosts
    ```
12. In the editor, add the following line at the end of the file:
    ```
    127.0.0.1    mysite.local
    ```
    Replace "mysite.local" with the same domain name you used in the virtual host configuration file.
13. Save the file and exit the text editor.
14. Restart the Apache server to apply the changes by running the following command:
    ```
    sudo /opt/lampp/lampp restart
    ```
15. Now you should be able to access your virtual host by opening a web browser and entering "http://mysite.local" as the URL.

I apologize for any inconvenience caused, and I hope these steps help you set up the virtual host successfully.