<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

// lecture des friends
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

// var_dump($friends) ;

// liste des friends de la base
echo "<h1> Liste des friends</h1>" ;
echo "<ul>" ;
  foreach ($friends as $key => $value) {
    //echo '<br>' . $key . '<br>' ;
    foreach ($value as $key => $val) {
      switch ($key) {
        case 'firstname':
          echo "<li>" . $val . " "; 
          break;
        case 'lastname':
          echo $val . "</li>"; 
          break;      
        default:
          # code...
          break;
      }
    }
  }
echo "<ul>" ;

?>

<div>
  <form action="" method="post">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name.." required>

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name.." required>

    
    <input type="submit" value="Submit">
  </form>
</div>

<?php


function checkLength (string $input) : bool {
  if (strlen($input) < 45) {
    return true;
  }
  return false;
}

if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
    $firstname = $_POST['firstname'] ;
    $lastname = $_POST['lastname'] ;
    
    $firstname = trim($firstname); 
    $lastname = trim($lastname);
    

    if (checkLength($firstname) && checkLength($lastname)) {

    
      $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
      $statement = $pdo->prepare($query);
      
      $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
      $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
      
      $statement->execute();
      echo "Insertion ok" ;
      header("Location: http://localhost:8000/");



    } else {
      echo "Un des champs est trop long, PAS d'insertion" ;
    }


}

