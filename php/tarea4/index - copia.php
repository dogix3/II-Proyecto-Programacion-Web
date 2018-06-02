<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:universidad.db');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 
 
    /**************************************
    * Create tables                       *
    **************************************/
 	// Create table messages
    //$file_db->exec("universidad.sqlite3");
 	
    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS books (
                    title_id INTEGER PRIMARY KEY, 
                    title TEXT, 
                    pages TEXT)");
 	    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS authors (
                    author_id INTEGER PRIMARY KEY, 
                    title_id TEXT, 
                    author TEXT)");
 	
 
    /**************************************
    * Play with databases and tables      *
    **************************************/

 	// Prepare INSERT statement to SQLite3 memory db
    $insert = "INSERT INTO books (title_id, title, pages) 
                VALUES (:title_id, :title, :pages)";
    $stmt = $file_db->prepare($insert);
 	//********* Insert book 

    // Bind parameters to statement variables
    $stmt->bindParam(':title_id', $title_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':pages', $pages);
 

      // Set values to bound variables
      $title_id = NULL;
      $title = 'Linux in a nutshell';
      $pages = '112';
 
      // Execute statement
      $stmt->execute();

    // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM books');
 
    foreach($result as $row) {
      echo "Id: " . $row['title_id'] . "\n";
      echo "Title: " . $row['title'] . "\n";
      echo "Pages: " . $row['pages'] . "\n";
      echo "\n";
    }
 	
 	// Prepare INSERT statement to SQLite3 memory db
    $insert = "INSERT INTO authors (author_id, title_id, author) 
                VALUES (:author_id, :title_id, :author)";
    $stmt = $file_db->prepare($insert);  
 	//********* Insert authors 
 	
    // Bind parameters to statement variables
    $stmt->bindParam(':author_id', $author_id);
    $stmt->bindParam(':title_id', $title_id);
    $stmt->bindParam(':author', $author);
 

      // Set values to bound variables
      $author_id = NULL;
      $title_id = '1';
      $author = 'Ellen Siever';
 
      // Execute statement
      $stmt->execute();
     
    // Select all data from file db messages table 
    $result = $file_db->query('SELECT * FROM authors');
 	echo '<br><br>';
    foreach($result as $row) {
      echo "Id: " . $row['author_id'] . "\n";
      echo "Title: " . $row['title_id'] . "\n";
      echo "author: " . $row['author'] . "\n";
      echo "\n";
    }
 	
 	$update2 = "UPDATE books SET title = 'Nothing more' WHERE title_id = 1";
    $stmt = $file_db->prepare($update2);
    $stmt->execute();
    
    $result2 = $file_db->query('SELECT * FROM books');
 	echo '<br><br>';
    foreach($result2 as $row) {
      echo "Title Id: " . $row['title_id'] . "\n";
      echo "Title: " . $row['title'] . "\n";
      echo "Pages: " . $row['pages'] . "\n";
      echo "\n";
    }
    
 
    /**************************************
    * Drop tables                         *
    **************************************/
 
    // Drop table messages from file db
    $file_db->exec("DROP TABLE books");
    $file_db->exec("DROP TABLE authors");
    // Drop table messages from memory db
    //$memory_db->exec("DROP TABLE messages");
 
 
    /**************************************
    * Close db connections                *
    **************************************/
 
    // Close file db connection
    $file_db = null;
    // Close memory db connection
    $memory_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

 
?>
