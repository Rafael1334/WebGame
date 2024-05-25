<?php
  require 'credentials.php';

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  function verifica_campo($conn, $texto){
    $texto = trim($texto);
    $texto = stripslashes($texto);
    $texto = htmlspecialchars($texto);
    $texto = mysqli_real_escape_string($conn, $texto);
    return $texto;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = false;
    if(isset($_POST['email'])){
      $email = verifica_campo($conn, $_POST['email']);
    }
    else{
      $error = true;
      $emailerror = "E-mail não válido";
    }
    if(isset($_POST['username'])){
      $username = verifica_campo($conn, $_POST['username']);
    }
    else{
      $error = true;
      $usernameerror = "Nome de usuário não válido";
    }
    if(isset($_POST['senha'])){
      $senha = verifica_campo($conn, $_POST['senha']);
      if(isset($_POST['confirmasenha'])){
        $confirmasenha = verifica_campo($conn, $_POST['confirmasenha']);
        if($senha != $confirmasenha){
          $error = true;
          $confirmasenhaerror = "As senhas digitadas são diferentes";
        }
      }
      else{
        $error = true;
        $confirmasenhaerror = "Senha não válida";
      }
  
    }
    else{
      $error = true;
      $senhaerror = "Senha não válida";
    }

    //checar emails iguais antes de continuar
    
    if(!$error){
      $senha = password_hash($senha, PASSWORD_DEFAULT); 
      $sql = "INSERT INTO cliente (email, user_name, user_password, created_at) VALUES ('$email', '$username', '$senha', now())";
      
      if (mysqli_query($conn, $sql)) {
        echo "Conta criada com sucesso";
      } else {
        echo "Erro ao criar conta: " . mysqli_error($conn) . "<br>";
      }          
    }
    
  }

  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORDSPACE</title>
    <link rel="stylesheet" href="trabalhofinal.css">
    <link rel="shortcut icon" href="imagens/homenLua.jpeg" type="image/x-icon">
</head>
<body>
    <main id="cadastro">
        <h1>Cadastro</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="inputContainer">
            <input name="email"  required="required" placeholder="E-Mail" type="text">
            <?php if (!empty($emailerror)): ?>
                          <span class="help-block"><?php echo $emailerror ?></span>
                        <?php endIf; ?>
            <input name="username" required="required" placeholder="Username" type="text">
            <?php if (!empty($usernameerror)): ?>
                          <span class="help-block"><?php echo $usernameerror ?></span>
                        <?php endIf; ?>
        </div>

        <br>
        <br>
        <br>
  
        <label class="password-label">
          <input placeholder="Senha" required="" name="senha" type="password">
          <?php if (!empty($senhaerror)): ?>
                          <span class="help-block"><?php echo $senhaerror ?></span>
                        <?php endIf; ?>
          <input placeholder="Confirmação" required="" name="confirmasenha" type="password">
          <?php if (!empty($confirmasenhaerror)): ?>
                          <span class="help-block"><?php echo $confirmasenhaerror ?></span>
                        <?php endIf; ?>
          <!-- <input placeholder="Confirmação" required="" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$" name="confirmasenha" type="password"> --> 
          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="20" width="20" class="close">
            <g clip-path="url(#clip0_4_24)">
              <path fill="#4EF54B" d="M17.1354 10.3645C16.8922 10.1214 16.5972 10 16.2498 10H6.66659V5.83341C6.66659 4.91312 6.99217 4.12763 7.64325 3.47655C8.29438 2.82561 9.07991 2.50007 10.0001 2.50007C10.9202 2.50007 11.7059 2.82556 12.3567 3.47655C13.0079 4.12763 13.3335 4.91316 13.3335 5.83341C13.3335 6.05903 13.4159 6.25431 13.5806 6.41923C13.7458 6.58419 13.9412 6.66669 14.1665 6.66669H15.0003C15.2258 6.66669 15.4211 6.58419 15.5862 6.41923C15.7507 6.25431 15.8334 6.05903 15.8334 5.83341C15.8334 4.22733 15.2627 2.85389 14.1213 1.71231C12.9798 0.570683 11.606 7.62939e-06 10.0001 7.62939e-06C8.39412 7.62939e-06 7.02045 0.570683 5.87883 1.71226C4.73738 2.8537 4.16666 4.22728 4.16666 5.83337V9.99999H3.75005C3.40293 9.99999 3.10772 10.1216 2.86464 10.3645C2.62156 10.6073 2.50006 10.9026 2.50006 11.2499V18.75C2.50006 19.0974 2.6216 19.3925 2.86464 19.6355C3.10772 19.8784 3.40293 20 3.75005 20H16.2498C16.5972 20 16.8925 19.8784 17.1354 19.6355C17.3782 19.3925 17.4999 19.0974 17.4999 18.75V11.2499C17.5001 10.9027 17.3785 10.6077 17.1354 10.3645Z"></path>
              <path fill="#4EF54B" d="M2.86464 10.3645C3.10777 10.1214 3.4028 10 3.75019 10H13.3334V5.83341C13.3334 4.91312 13.0078 4.12763 12.3567 3.47655C11.7056 2.82561 10.9201 2.50007 9.99989 2.50007C9.07978 2.50007 8.29411 2.82556 7.64326 3.47655C6.99213 4.12763 6.66655 4.91316 6.66655 5.83341C6.66655 6.05903 6.58413 6.25431 6.41936 6.41923C6.25422 6.58419 6.05884 6.66669 5.83345 6.66669H4.99972C4.77419 6.66669 4.5789 6.58419 4.41376 6.41923C4.24931 6.25431 4.16657 6.05903 4.16657 5.83341C4.16657 4.22733 4.73734 2.85389 5.87869 1.71231C7.02023 0.570683 8.39403 7.62939e-06 9.99989 7.62939e-06C11.6059 7.62939e-06 12.9795 0.570683 14.1212 1.71226C15.2626 2.8537 15.8333 4.22728 15.8333 5.83337V9.99999H16.25C16.5971 9.99999 16.8923 10.1216 17.1354 10.3645C17.3784 10.6073 17.4999 10.9026 17.4999 11.2499V18.75C17.4999 19.0974 17.3784 19.3925 17.1354 19.6355C16.8923 19.8784 16.5971 20 16.25 20H3.75019C3.4028 20 3.1075 19.8784 2.86464 19.6355C2.62179 19.3925 2.50006 19.0974 2.50006 18.75V11.2499C2.49988 10.9027 2.62147 10.6077 2.86464 10.3645Z"></path>
            </g>
            <defs>
              <clipPath id="clip0_4_24">
                <rect fill="white" height="20" width="20"></rect>
              </clipPath>
            </defs>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="20" width="20" class="open">
            <g clip-path="url(#clip0_4_24)">
              <path fill="currentColor" d="M17.1354 10.3645C16.8922 10.1214 16.5972 10 16.2498 10H6.66659V5.83341C6.66659 4.91312 6.99217 4.12763 7.64325 3.47655C8.29438 2.82561 9.07991 2.50007 10.0001 2.50007C10.9202 2.50007 11.7059 2.82556 12.3567 3.47655C13.0079 4.12763 13.3335 4.91316 13.3335 5.83341C13.3335 6.05903 13.4159 6.25431 13.5806 6.41923C13.7458 6.58419 13.9412 6.66669 14.1665 6.66669H15.0003C15.2258 6.66669 15.4211 6.58419 15.5862 6.41923C15.7507 6.25431 15.8334 6.05903 15.8334 5.83341C15.8334 4.22733 15.2627 2.85389 14.1213 1.71231C12.9798 0.570683 11.606 7.62939e-06 10.0001 7.62939e-06C8.39412 7.62939e-06 7.02045 0.570683 5.87883 1.71226C4.73738 2.8537 4.16666 4.22728 4.16666 5.83337V9.99999H3.75005C3.40293 9.99999 3.10772 10.1216 2.86464 10.3645C2.62156 10.6073 2.50006 10.9026 2.50006 11.2499V18.75C2.50006 19.0974 2.6216 19.3925 2.86464 19.6355C3.10772 19.8784 3.40293 20 3.75005 20H16.2498C16.5972 20 16.8925 19.8784 17.1354 19.6355C17.3782 19.3925 17.4999 19.0974 17.4999 18.75V11.2499C17.5001 10.9027 17.3785 10.6077 17.1354 10.3645Z"></path>
            </g>
            <defs>
              <clipPath>
                <rect fill="currentColor" height="20" width="20"></rect>
              </clipPath>
            </defs>
          </svg>
        </label>
        <button type="submit" class = "btn">Entrar</button>
        <p><a href="login.php">Login</a>  <a href="cadastro.php">Cadastre-se</a></p>
      </form>
    </main>

    <main id="links">
        <div class="main">
            <div class="up">
                <a href="" target="_blank">
                    <button class="card1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0,0,256,256" width="30px" height="30px" fill-rule="nonzero" class="instagram"><g fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(8,8)"><path d="M11.46875,5c-3.55078,0 -6.46875,2.91406 -6.46875,6.46875v9.0625c0,3.55078 2.91406,6.46875 6.46875,6.46875h9.0625c3.55078,0 6.46875,-2.91406 6.46875,-6.46875v-9.0625c0,-3.55078 -2.91406,-6.46875 -6.46875,-6.46875zM11.46875,7h9.0625c2.47266,0 4.46875,1.99609 4.46875,4.46875v9.0625c0,2.47266 -1.99609,4.46875 -4.46875,4.46875h-9.0625c-2.47266,0 -4.46875,-1.99609 -4.46875,-4.46875v-9.0625c0,-2.47266 1.99609,-4.46875 4.46875,-4.46875zM21.90625,9.1875c-0.50391,0 -0.90625,0.40234 -0.90625,0.90625c0,0.50391 0.40234,0.90625 0.90625,0.90625c0.50391,0 0.90625,-0.40234 0.90625,-0.90625c0,-0.50391 -0.40234,-0.90625 -0.90625,-0.90625zM16,10c-3.30078,0 -6,2.69922 -6,6c0,3.30078 2.69922,6 6,6c3.30078,0 6,-2.69922 6,-6c0,-3.30078 -2.69922,-6 -6,-6zM16,12c2.22266,0 4,1.77734 4,4c0,2.22266 -1.77734,4 -4,4c-2.22266,0 -4,-1.77734 -4,-4c0,-2.22266 1.77734,-4 4,-4z"></path></g></g></svg>
                    </button>
                </a>

              <button class="card2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="30px" height="30px" class="twitter"><path d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429"></path></svg>
              </button>
            </div>
            <div class="down">
              <button class="card3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30px" height="30px" class="github">    <path d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z"></path></svg>
              </button>
              <button class="card4">
                <svg height="30px" width="30px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="discord"><path d="M40,12c0,0-4.585-3.588-10-4l-0.488,0.976C34.408,10.174,36.654,11.891,39,14c-4.045-2.065-8.039-4-15-4s-10.955,1.935-15,4c2.346-2.109,5.018-4.015,9.488-5.024L18,8c-5.681,0.537-10,4-10,4s-5.121,7.425-6,22c5.162,5.953,13,6,13,6l1.639-2.185C13.857,36.848,10.715,35.121,8,32c3.238,2.45,8.125,5,16,5s12.762-2.55,16-5c-2.715,3.121-5.857,4.848-8.639,5.815L33,40c0,0,7.838-0.047,13-6C45.121,19.425,40,12,40,12z M17.5,30c-1.933,0-3.5-1.791-3.5-4c0-2.209,1.567-4,3.5-4s3.5,1.791,3.5,4C21,28.209,19.433,30,17.5,30z M30.5,30c-1.933,0-3.5-1.791-3.5-4c0-2.209,1.567-4,3.5-4s3.5,1.791,3.5,4C34,28.209,32.433,30,30.5,30z"></path></svg>
              </button>
            </div>
          </div>   
    </main>
    
</body>
<script src="cadastro.js"></script>
</html>