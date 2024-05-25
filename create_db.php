<?php
    require 'credentials.php';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Create database
    $sql = "CREATE DATABASE $dbname";
    if (mysqli_query($conn, $sql)) {
        echo "<br>Database created successfully<br>";
    } else {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }
    
    // Choose database
    $sql = "USE $dbname";
    if (mysqli_query($conn, $sql)) {
        echo "<br>Database changed successfully<br>";
    } else {
        echo "<br>Error changing database: " . mysqli_error($conn);
    }
    
    // sql to create table  
    $sql = "CREATE TABLE cliente (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_name VARCHAR(30) NOT NULL,
      user_password VARCHAR(128) NOT NULL,
      email VARCHAR(64) NOT NULL,
      created_at DATETIME,
      updated_at DATETIME,
      last_login_at DATETIME,
      last_logout_at DATETIME,
      UNIQUE (email),
      UNIQUE (user_name)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "<br>Table created successfully<br>";
    } else {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }
    
    $sql = "CREATE TABLE liga (
        id_liga INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome_liga VARCHAR(20),
        senha_liga VARCHAR(128),
        FK_id_adm INT(6) UNSIGNED,
        data_criacao DATETIME,
        CONSTRAINT FK_liga_1 FOREIGN KEY (FK_id_adm) REFERENCES cliente (id)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "<br>Table created successfully<br>";
    } else {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }


    $sql = "CREATE TABLE pontos (
        FK_id INT(6) UNSIGNED,
        FK_id_liga INT(6) UNSIGNED,
        pontos INT,
        data_jogo DATETIME,
        PRIMARY KEY (FK_id, FK_id_liga),
        CONSTRAINT FK_pontos_1 FOREIGN KEY (FK_id) REFERENCES cliente (id),
        CONSTRAINT FK_pontos_2 FOREIGN KEY (FK_id_liga) REFERENCES liga (id_liga)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "<br>Table created successfully<br>";
    } else {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }


    $sql = "CREATE TABLE membros (
        FK_id INT(6) UNSIGNED,
        FK_id_liga INT(6) UNSIGNED,
        PRIMARY KEY (FK_id, FK_id_liga),
        CONSTRAINT FK_membros_1 FOREIGN KEY (FK_id) REFERENCES cliente (id),
        CONSTRAINT FK_membros_2 FOREIGN KEY (FK_id_liga) REFERENCES liga (id_liga)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "<br>Table created successfully<br>";
    } else {
        echo "<br>Error creating database: " . mysqli_error($conn);
    }

    mysqli_close($conn)
    
?>