<?php
require_once 'pdoconfig.php';

$host = "localhost";
$username = "root";
$password = "";
$dbname = "t_dados";

$sql = "mysql:host=$host;dbname=$dbname;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  echo "Conectado a $dbname em $host com sucesso.";
} catch (PDOException $pe) {
  die("Não foi possível se conectar ao banco de dados $dbname :" . $pe->getMessage());
}
?>

<style>
  * {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
  }

  body {
    font-family: Helvetica, Arial, Helvetica, sans-serif;
    -webkit-font-smoothing: antialiased;
    background-color: #eeeeee;
  }

  .container {
    margin: 1rem 0rem;
  }
</style>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <div class="container">
    <div class="row">

      <div class="container data-container">
        <div class="row row-charts">

          <div class="col col-md-6 col-sm-12">
            <?php
            //$insert_db = $my_Db_Connection->prepare("INSERT INTO dados (arquivo, id, usuarios) VALUES ('arquivo1.jpg', 2, 'Leonardo Jacob')");

            /* if ($insert_db->execute()) {
    echo "Registro incluido com sucesso!";
  } else {
    echo "Não foi possível inserir este registro!";
  }
 */

            $data = $conn->query('SELECT * FROM dados');

            $consult = "SELECT * FROM dados";
            $result = $conn->query($consult);
            $rows = $result->fetchAll();
            echo "<pre>";
            print_r($rows);
            echo "</pre>";

            echo "<br>";

            echo "<pre>";
            print_r($data);
            echo "</pre>";


            if (isset($_POST['send'])) {
              $arquivo = $_FILES['file'];

              $image = addslashes($arquivo['tmp_name']);
              $name = addslashes($arquivo['name']);
              $image = file_get_contents($image);
              $image = base64_encode($image);

              // form foi enviado
              $file = explode('.', $arquivo['name']);

              $fileName = strval($arquivo['tmp_name']);
              $dataFile = strval($arquivo['name']);

              $nome = strval($arquivo['name']);

              echo "<pre> <--  FILENAME -->";
              print_r($nome);
              echo "</pre>";


              echo "<pre> <--  DATA FILE -->";
              print_r($dataFile);
              echo "</pre>";
              if ($file[sizeof($file) - 1] != 'jpg') {
                die('Não é possivel fazer o upload deste tipo de arquivo');
              } else {
                echo "Upload realizado com sucesso.";
                move_uploaded_file($arquivo['tmp_name'], 'Arquivos' . $arquivo['name']);


                $insert_db = $conn->prepare("INSERT INTO dados (nome_arquivo, arquivo) VALUES ('$fileName', '$dataFile')");
                if ($insert_db->execute()) {
                  echo "Registro incluido com sucesso!";
                } else {
                  echo "Não foi possível inserir este registro!";
                }
              }
                //   if (move_uploaded_file($arquivo['tmp_name'], 'Arquivos/imagens' . $arquivo['name'])) {
                //     $s = $conn->prepare("INSERT INTO dados (nome_arquivo, arquivo) VALUES ('$name', '$image')");
                //     $s->bindValue(':name', $name, PDO::PARAM_STR);
                //     $s->bindValue(':file', $image, PDO::PARAM_STR);
                //     if (!$s->execute()) {
                //       // echo 'Sucesso!';
                //       throw new Exception($s->errorInfo());
                //     }
                //   }
                //   //move_uploaded_file($arquivo['tmp_name'], 'Arquivos/imagens' . $arquivo['name']);
                // }











                // if (move_uploaded_file($_FILES['file']['tmp_name'], 'Arquivos/imagens')) {
                //   $s = $dbh->prepare("INSERT INTO dados (id, usuarios, nome_arquivo, arquivo) VALUES (3, 'Leonardo J', '$name', '$image')");
                //   $s->bindValue(':name', $name, PDO::PARAM_STR);
                //   $s->bindValue(':file', $image, PDO::PARAM_STR);
                //   if (!$s->execute()) {
                //     throw new Exception($s->errorInfo());
                //   }
                // }
              ;
            }
            ?>
          </div>

          <div class="col col-md-6 col-sm-12">
            <form action="" method="post" enctype="multipart/form-data">
              <input type="file" name="file" />
              <input type="submit" name="send" value="Enviar" />
            </form>
          </div>

        </div>
      </div>




    </div>
  </div>
</body>

</html>