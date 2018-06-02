<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:prueba.sqlite');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 
    // Create new database in memory
    $memory_db = new PDO('sqlite::memory:');
    // Set errormode to exceptions
    $memory_db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION);

 
    /**************************************
    * Play with databases and tables      *
    **************************************/
 
    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO books (title_id, tittle, pages) 
                VALUES (:title_id, :tittle, :pages)";
    $stmt = $file_db->prepare($insert);
 
    // Bind parameters to statement variables
    $stmt->bindParam(':title_id', $title_id);
    $stmt->bindParam(':tittle', $tittle);
    $stmt->bindParam(':pages', $pages);
 
    // Set values to bound variables
    $title_id = null;
    $tittle = "Linux in a Nutshell";
    $pages = 112;

    // Execute statement
    $stmt->execute();
 
    // Select all data from memory db messages table 
    $result = $file_db->query('SELECT * FROM books');
 
    foreach($result as $row) {
      echo "Tittle Id: " . $row['title_id'] . "\n";
      echo "Tittle: " . $row['tittle'] . "\n";
      echo "Pages: " . $row['pages'] . "\n";
      echo "\n";
    }

    $update = "UPDATE books SET pages = 476 WHERE tittle = 'Linux in a Nutshell'";
    $stmt = $file_db->prepare($update);

    $result2 = $file_db->query('SELECT * FROM books');
 
    foreach($result2 as $row) {
      echo "Tittle Id: " . $row['title_id'] . "\n";
      echo "Tittle: " . $row['tittle'] . "\n";
      echo "Pages: " . $row['pages'] . "\n";
      echo "\n";
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>