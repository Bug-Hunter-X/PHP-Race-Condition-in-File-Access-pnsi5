The solution employs `flock()` to acquire an exclusive lock on the file before accessing it. This ensures that only one process can modify the file at a time, preventing race conditions.  After the file is processed, `flock( $fp, LOCK_UN );` releases the lock, allowing other processes to access the file. 
```php
<?php
$filename = 'counter.txt';
$fp = fopen( $filename, 'c+' );

if ( flock( $fp, LOCK_EX ) ) { // Acquire an exclusive lock
    $counter = (int)fread( $fp, filesize( $filename ) );
    $counter++;
    ftruncate( $fp, 0 ); // Clear the file content
    fwrite( $fp, $counter );
    flock( $fp, LOCK_UN ); // Release the lock
}
fclose( $fp );
?>
```