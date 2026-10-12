<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="student.css">
</head>
<body>
  <?php
 require_once "db.php";

$fullname = "";
$age = "";
$gender = "";
$phone = "";
$department = "";
$email = "";
 
$errors = [];
$success = false;
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $age = trim($_POST["age"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $email = trim($_POST["email"] ?? "");
 
    if ($fullname == "") {
        $errors[] = "Full name is required.";
    }
 
    if ($age == "") {
        $errors[] = "Age is required.";
    } elseif (!is_numeric($age) || $age < 1 || $age > 100) {
        $errors[] = "Please enter a valid age.";
    }
 
    if ($gender == "") {
        $errors[] = "Please select your gender.";
    }
 
    if ($phone == "") {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
        $errors[] = "Phone number must contain exactly 11 digits.";
    }
 
    if ($department == "") {
        $errors[] = "Please select your department.";
    }
 
    if ($email == "") {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
 
    if (empty($errors)) {
      $stmt = $conn->prepare(
        "INSERT INTO students
        (fullname,age,gender,phone,department,email)
        VALUES (?,?,?,?,?,?)"
      );
      $stmt->bind_param(
        "sissss",
        $fullname,
        $age,
        $gender,
        $phone,
        $department,
        $email
      );
      if($stmt->execute()){
        $success = true;
      }else{
        $errors[] = "Unable to save registration."; 
      }
      $stmt->close();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Student Registration</h1>
        <p class="intro">Please fill in your details to register.</p>
 
        <?php if ($success): ?>
            <div class="success-message">
                <h2>Registration Successful!</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($fullname); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        <?php endif; ?>
 
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <h3>Please correct the following:</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
 
        <form action="" method="POST">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname"
                   placeholder="Enter your full name"
                   value="<?php echo htmlspecialchars($fullname); ?>">
 
            <label for="age">Age</label>
            <input type="number" id="age" name="age"
                   placeholder="Enter your age"
                   value="<?php echo htmlspecialchars($age); ?>">
 
            <label>Gender</label>
            <div class="gender">
                <label class="radio">
                    <input type="radio" name="gender" value="Female"
                        <?php if ($gender == "Female") { echo "checked"; } ?>>
                    Female
                </label>
                <label class="radio">
                    <input type="radio" name="gender" value="Male"
                        <?php if ($gender == "Male") { echo "checked"; } ?>>
                    Male
                </label>
            </div>
 
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone"
                   placeholder="08012345678"
                   value="<?php echo htmlspecialchars($phone); ?>">
 
            <label for="department">Department</label>
            <select id="department" name="department">
                <option value="">-- Select Department --</option>
                <option value="Computer Science"
                    <?php if ($department == "Computer Science") { echo "selected"; } ?>>
                    Computer Science
                </option>
                <option value="Business Administration"
                    <?php if ($department == "Business Administration") { echo "selected"; } ?>>
                    Business Administration
                </option>
                <option value="Accounting"
                    <?php if ($department == "Accounting") { echo "selected"; } ?>>
                    Accounting
                </option>
            </select>
 
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   placeholder="example@email.com"
                   value="<?php echo htmlspecialchars($email); ?>">
 
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

</body>
</html>