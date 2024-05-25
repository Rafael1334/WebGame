<?php
  require 'credentials.php';
  require 'authenticate.php';
  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  if ($login && $_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["user_name"] = $row["user_name"];
    $_SESSION["user_email"] = $row["email"];
    $error = false;
    if(isset($_POST['username'])){
      $username = verifica_campo($conn, $_POST['username']);
    }
  }

  

?>

<!DOCTYPE html>
<html lang="pr-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORDSPACE</title>
    <link rel="stylesheet" href="trabalhofinal.css">
    <link rel="shortcut icon" href="imagens/homenLua.jpeg" type="image/x-icon">
    
</head>
<body>
    <main id="principal">

        <h1>TRABALHO FINAL</h1>
        <h2>WORDSPACE</h2>
        
        <select name="nivel" id="nivel">
            <option value="nivel1">5min</option>
            <option value="nivel2">2,5min</option>
            <option value="nivel3">1min</option>
            <option value="nivel4">30s</option>
        </select>

        <select name="liga" id="liga">
          <option value="geral">Geral</option>  
          <option value="liga">Liga</option>
        </select>

        <button id = "botao">Iniciar</button>

        <br>

        <main id="secundario">
            <form name="form_main">
                <div id="cronometro">
                    <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>:<span id="millisecond">000</span>
                </div>
                <br/>
            </form>
            <div id="palavra">Espere trocar de palavra até digitar</div>
        
        </main>

        <br>


        <input type="text" id="digitoUsuario" >
        <p>Pontos: </p>
        <p>Acertos: </p>
        <p id="acertos">0</p>
        <p>Erros: </p>
        <p id="erros">0</p>
        <p>Pontuação: </p>
        <p id="pontos">0</p>
        
        

        <h2>Ultimas pontuações</h2>

        <ol class="pontuacoes">
          <li>1</li>
          <li>2</li>
          <li>3</li>
          <li>4</li>
          <li>5</li>
        </ol>

        <button type="submit">Criar Liga</button>
        <button type="submit">Entrar Liga</button>
        <button type="submit">Excluir Liga</button>

        <p><a class="btn" href="logout.php">Logout</a></p> 
        
        
    </main>    
</body>
<script src="trabalhofinal2.js"></script>
</html>