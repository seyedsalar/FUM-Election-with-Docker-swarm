<?
require_once('main.php');

$studentNumber = $_POST['studentNumber'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$fieldName = $_POST['fieldName'];
$lastName = $_POST['lastName'];

$name = $_POST['name'];
$nationalNumber = $_POST['nationalNumber'];
$phoneNumber = $_POST['phoneNumber'];

$db = Db::getInstance();
$record = $db->first("SELECT * FROM students WHERE student_number='$studentNumber'");
if ($record != null){
  $message = _already_registered;
  require_once("msg-fail.php");
  exit;
}

if (strlen($password1)<3 || strlen($password2)<3){
  $message = _weak_password;
  require_once("msg-fail.php");
  exit;
}

if ($password1 != $password2){
  $message = _password_not_match;
  require_once("msg-fail.php");
  exit;
}

$db->insert("INSERT INTO students
(  id,  field_name,  first_name, last_name, national_number, password, phone_number, student_number) VALUES
(:id, :field_name, :first_name, :last_name,:national_number, :password, :phone_number, :student_number)", array(
    'id'                => $studentNumber,
    'field_name'        => $fieldName,
    'first_name'        => $name,
    'last_name'         => $lastName,
    'national_number'   => $nationalNumber,
    'password'          => $password1,
    'phone_number'      => $phoneNumber,
    'student_number'    => $studentNumber,
));

$message = _successfully_registered;
require_once("msg-success.php");
exit;
?>
