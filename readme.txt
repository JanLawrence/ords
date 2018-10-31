/*** UPDATE IN LOCALHOST SERVER FOR FILE UPLOADING ***/

1. Go to xampp control.
2. Click "Config" button for Apache module.
3. Select "PHP (php.ini)" and will automatically open on Notepad.
4. Find upload_max_filesize (Ctrl+F) and change the value to 50M. e.g. "upload_max_filesize = 50M"
5. Find post_max_size (Ctrl+F) and change the value to 50M. e.g. "post_max_size = 50M"
6. Go back to xampp control and click "Config" button for MySQL module.
7. Select "my.ini" and will automatically open on Notepad.
4. Find innodb_log_file_size (Ctrl+F) and change the value to 50M. e.g. innodb_log_file_size = 50M"
5. Find max_allowed_packet (Ctrl+F) and change the value to 50M. e.g. max_allowed_packet = 50M"

Note: 
- For "php.ini" file you can also locate it on your xampp folder e.g. C:\xampp\php\php.ini and open it in Notepad.
- For "my.ini" file you can also locate it on your xampp folder e.g. C:\xampp\mysql\bin\my.ini and open it in Notepad.