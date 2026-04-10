<?php 
include("header.php");
include("security.php");

// 1. Handle the Form Submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // FIX: Ensure we use the specific session key, not the whole array
    $qry = $conn->prepare("UPDATE users SET name=?, phone=?, gender=?, email=?, address=? WHERE username=?");
    $qry->bind_param("ssssss", $name, $phone, $gender, $email, $address, $_SESSION['username']);
    
    if($qry->execute()){
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('Failed to update profile');</script>";
    }
}

// 2. Fetch current user data to populate the form
$qry = $conn->prepare("SELECT * FROM users WHERE username=?");
$qry->bind_param("s", $_SESSION["username"]);
$qry->execute();
$result = $qry->get_result();
$user = $result->fetch_assoc();
?>

<div class="container profile-page">
    <div class="profile-card">
        <form action="" method="post">
            <h1>Profile Page</h1>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" class="form-control" value="<?= htmlspecialchars($_SESSION['username']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" >
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" >
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="male" <?= ($user['gender'] == 'male') ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= ($user['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" >
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>" >
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>
<?php include('footer.php') ?>