<?php
session_start();

// Check if the user is a logged-in coach or admin
$is_coach = false;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && ($_SESSION['userType'] === 'coach' || $_SESSION['userType'] === 'admin')) {
    $is_coach = true;
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /pro/login.php");
    exit;
}

require_once 'config.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_coach) {
    if (!isset($_SESSION['id'])) {
        $error = "User ID not found in session. Please log in again.";
    } else {
        $user_id = $_SESSION['id'];
    
        // Sanitize and validate form data
        $province = trim($_POST['province'] ?? '');
        $region = trim($_POST['region'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $religion = trim($_POST['religion'] ?? '');
        $nationality = trim($_POST['nationality'] ?? '');
        $battingType = trim($_POST['battingType'] ?? '');
        $cricketPlayed = trim($_POST['cricketPlayed'] ?? '');
        $nationalID = trim($_POST['nationalID'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $birthPlace = trim($_POST['birthPlace'] ?? '');
        $dob = trim($_POST['dob'] ?? '');
        $residencePhone = trim($_POST['residencePhone'] ?? '');
        $mobileNo = trim($_POST['mobileNo'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $residenceCity = trim($_POST['residenceCity'] ?? '');
        $maritalStatus = trim($_POST['maritalStatus'] ?? '');
        $bloodGroup = trim($_POST['bloodGroup'] ?? '');
        $postalAddress = trim($_POST['postalAddress'] ?? '');
        
        // File upload handling
        // PHP file se Flask app ke static/player_images tak ka path
        $target_dir = "C:/xampp/htdocs/pro/Project/static/player_images/";
        // Database mein save karne ke liye path (jo Flask app ke static folder se relative hai)
        $db_target_dir = "player_images/";
        
        // Player Image
        $playerImage = $_FILES['playerImage'] ?? null;
        $playerImagePath = '';
        
        
        // Basic validation
        if (empty($name) || empty($email) || empty($nationalID)) {
            $error = "Name, Email, and National ID are required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            // Create the uploads directory if it's writable
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            // Check if directory is writable
            if (!is_writable($target_dir)) {
                $error = "Upload directory is not writable. Please check permissions.";
            } else {

                // Handle file uploads with unique names
                if ($playerImage && $playerImage['error'] == UPLOAD_ERR_OK) {
                    $uniqueName = uniqid() . '_' . basename($playerImage['name']);
                    $uploadPath = $target_dir . $uniqueName;
                    $playerImagePath = $db_target_dir . $uniqueName;
                    move_uploaded_file($playerImage['tmp_name'], $uploadPath);
                }
                
                // Prepare and execute the SQL statement
                try {
                    $sql = "INSERT INTO players (user_id, province, region, district, city, religion, nationality, batting_type, cricket_played, player_image_path, national_id, gender, name, birth_place, date_of_birth, residence_phone, mobile_no, email, residence_city, marital_status, blood_group, postal_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $user_id,
                        $province, $region, $district, $city, $religion, $nationality, $battingType, $cricketPlayed, $playerImagePath, $nationalID, $gender, $name, $birthPlace, $dob, $residencePhone, $mobileNo, $email, $residenceCity, $maritalStatus, $bloodGroup, $postalAddress
                    ]);
                    
                    $success = "Registration successful!";
                    
                    $_SESSION['registration_data'] = $_POST;
                    $_SESSION['registration_data']['playerImagePath'] = $playerImagePath;
                    
                    header("Location: successful.php");
                    exit;
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Player Registration Form</title>
    <link rel="icon" type="image/png" href="/pro/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .upload-icon {
            width: 120px;
            height: 120px;
            border: 2px dashed #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .upload-icon:hover {
            background-color: #f1fdf4;
        }
        .upload-icon i {
            font-size: 2rem;
            color: #28a745;
        }
        .upload-text {
            text-align: center;
            margin-top: 10px;
            color: #28a745;
        }
        .btn-1{
            background-color: #00c700;
            color: white;
        }
        .btn-1:hover{
            background-color: #00c700;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'admin/includes/header.php'; ?>

    <?php if ($is_coach): ?>
        <?php if ($_SESSION['userType'] === 'coach'): ?>
            <div class="container text-center mt-5">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Permission Denied!</h4>
                    <p>You do not have access to "Registration" page. As a coach, you should view player reports directly from Dashboard.</p>
                    <hr>
                    <p class="mb-0">Please go back to your dashboard to manage players.</p>
                    <a href="/pro/coach/player.php" class="btn btn-success mt-3">Go to Player Management</a>
                </div>
            </div>
        <?php elseif ($_SESSION['userType'] === 'admin'): ?>
            <div class="container text-center mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Access Denied!</h4>
                    <p>This page is restricted. As an administrator, you should manage coach registrations through the admin panel.</p>
                    <hr>
                    <p class="mb-0">Please return to the admin dashboard.</p>
                    <a href="/pro/admin/manage_coaches.php" class="btn btn-danger mt-3">Go to Admin Dashboard</a>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-light text-center py-5">
            <?php if ($error): ?>
                <div class="alert alert-danger mx-auto w-75 w-md-50" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success mx-auto w-75 w-md-50" role="alert"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <img src="/pro/img/logo.png" alt="PCB Logo" width="120" class="mb-3" />

            <h2 class="fw-bold mb-4">Player Registration Form</h2>

            <form action="registration.php" method="POST" enctype="multipart/form-data">
                <input type="file" id="imageUpload" name="playerImage" accept=".jpg,.jpeg,.png" hidden />
                
                <label for="imageUpload" class="upload-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </label>
                <div class="upload-text">Upload Image</div>

                <div class="alert alert-light border border-danger-subtle mt-4 mx-auto w-75 w-md-50" role="alert">
                    <h5 class="fw-bold text-start">Image Upload Guidelines</h5>
                    <ul class="text-start mb-0">
                        <li>Accepted File Formats: JPG, JPEG, PNG</li>
                        <li>Maximum File Size: 2MB</li>
                    </ul>
                </div>
                
                <div class="bg-white py-5">
                    <div class="container">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="province" class="form-label text-start d-block">Province <span class="text-danger">*</span></label>
                                <select class="form-select" id="province" name="province" required>
                                    <option value="">Select Province</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Sindh">Sindh</option>
                                    <option value="KPK">KPK</option>
                                    <option value="Balochistan">Balochistan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="region" class="form-label text-start d-block">City Name <span class="text-danger">*</span></label>
                                <select class="form-select" id="region" name="region" disabled required>
                                    <option value="">Select City Name</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="district" class="form-label text-start d-block">District/Zone <span class="text-danger">*</span></label>
                                <select class="form-select" id="district" name="district" disabled required>
                                    <option value="">Select District/Zone</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label text-start d-block">Region Name <span class="text-danger">*</span></label>
                                <select class="form-select" id="city" name="city" disabled required>
                                    <option value="">Region Name</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="religion" class="form-label text-start d-block">Religion <span class="text-danger">*</span></label>
                                <select class="form-select" id="religion" name="religion" required>
                                    <option selected disabled value="">Select Religion</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nationality" class="form-label text-start d-block">Nationality <span class="text-danger">*</span></label>
                                <select class="form-select" id="nationality" name="nationality" required>
                                    <option value="Pakistan" selected>Pakistan</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-start d-block">Batting Type</label>
                                <select class="form-select" name="battingType">
                                    <option selected disabled>Select Batting Type</option>
                                    <option>Right Hand</option>
                                    <option>Left Hand</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-start d-block">Cricket Played<span class="text-danger">*</span></label>
                                <select class="form-select" name="cricketPlayed">
                                    <option selected disabled>Select Level of Cricket Played</option>
                                    <option>School Level</option>
                                    <option>College Level</option>
                                    <option>University Level</option>
                                    <option>Club Level</option>
                                    <option>Regional Level</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                <script>
                    const regionData = {
                        "Punjab": ["Lahore", "Rawalpindi", "Multan"],
                        "Sindh": ["Karachi", "Hyderabad"],
                        "KPK": ["Peshawar", "Swat"],
                        "Balochistan": ["Quetta", "Gwadar"]
                    };

                    const districtData = {
                        "Lahore": ["Model Town", "Shalimar", "Gulberg"],
                        "Rawalpindi": ["Saddar", "Murree"],
                        "Multan": ["Cantt", "Boson"],
                        "Karachi": ["East", "West", "South"],
                        "Hyderabad": ["Latifabad", "Qasimabad"],
                        "Peshawar": ["University Town", "Hayatabad"],
                        "Swat": ["Mingora", "Kabal"],
                        "Quetta": ["Zarghoon", "Saryab"],
                        "Gwadar": ["Pasni", "Jiwani"]
                    };

                    const cityData = {
                        "Model Town": ["Block A", "Block B"],
                        "Shalimar": ["Area 1", "Area 2"],
                        "East": ["Nazimabad", "Liaquatabad"]
                    };

                    const provinceSelect = document.getElementById("province");
                    const regionSelect = document.getElementById("region");
                    const districtSelect = document.getElementById("district");
                    const citySelect = document.getElementById("city");

                    provinceSelect.addEventListener("change", () => {
                        const province = provinceSelect.value;
                        regionSelect.innerHTML = `<option value="">Select City Name</option>`;
                        districtSelect.innerHTML = `<option value="">Select District/Zone</option>`;
                        citySelect.innerHTML = `<option value="">Region Name</option>`;
                        regionSelect.disabled = true;
                        districtSelect.disabled = true;
                        citySelect.disabled = true;

                        if (province && regionData[province]) {
                            regionData[province].forEach(region => {
                                const opt = document.createElement("option");
                                opt.value = region;
                                opt.textContent = region;
                                regionSelect.appendChild(opt);
                            });
                            regionSelect.disabled = false;
                        }
                    });

                    regionSelect.addEventListener("change", () => {
                        const region = regionSelect.value;
                        districtSelect.innerHTML = `<option value="">Select District/Zone</option>`;
                        citySelect.innerHTML = `<option value="">Region Name</option>`;
                        districtSelect.disabled = true;
                        citySelect.disabled = true;

                        if (region && districtData[region]) {
                            districtData[region].forEach(district => {
                                const opt = document.createElement("option");
                                opt.value = district;
                                opt.textContent = district;
                                districtSelect.appendChild(opt);
                            });
                            districtSelect.disabled = false;
                        }
                    });

                    districtSelect.addEventListener("change", () => {
                        const district = districtSelect.value;
                        citySelect.innerHTML = `<option value="">Region Name</option>`;
                        citySelect.disabled = true;

                        if (district && cityData[district]) {
                            cityData[district].forEach(city => {
                                const opt = document.createElement("option");
                                opt.value = city;
                                opt.textContent = city;
                                citySelect.appendChild(opt);
                            });
                            citySelect.disabled = false;
                        }
                    });
                </script>

                <div class="container mt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">National ID/ B-Form no. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nationalID" placeholder="XXXXX-XXXXXX-X">
                            <div class="invalid-feedback d-block" id="nationalIDError"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" name="gender">
                                <option selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Birth Place <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="birthPlace" placeholder="Region Name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="dob">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Residence Ph. No</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img src="https://flagcdn.com/w40/pk.png" alt="PK" style="width: 20px;">
                                </span>
                                <span class="input-group-text">+92</span>
                                <input type="tel" class="form-control" name="residencePhone" maxlength="10">
                            </div>
                            <div class="invalid-feedback d-block" id="residencePhoneError"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Mobile No <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img src="https://flagcdn.com/w40/pk.png" alt="PK" style="width: 20px;">
                                </span>
                                <span class="input-group-text">+92</span>
                                <input type="tel" class="form-control" name="mobileNo" maxlength="10">
                            </div>
                            <div class="invalid-feedback d-block" id="mobileNoError"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Functional E-mail Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Enter E-mail Address">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Residence City <span class="text-danger">*</span></label>
                            <select class="form-select" name="residenceCity">
                                <option selected disabled>Select Residence City</option>
                                <option>Lahore</option>
                                <option>Karachi</option>
                                <option>Islamabad</option>
                                </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Marital Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="maritalStatus">
                                <option selected disabled>Select Marital Status</option>
                                <option>Single</option>
                                <option>Married</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Blood Group</label>
                            <select class="form-select" name="bloodGroup">
                                <option selected disabled>Select Blood Group</option>
                                <option>A+</option>
                                <option>B+</option>
                                <option>O+</option>
                                <option>AB+</option>
                                </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-start d-block">Completed Postal Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="postalAddress" placeholder="Enter Completed Postal Address">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container py-5">
                <div class="d-grid">
                    <button type="submit" class="btn btn-1 p-3">SUBMIT</button>
                </div>
            </div>
            </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('imageUpload');
                const uploadText = document.querySelector('.upload-text');
                const uploadIcon = document.querySelector('.upload-icon i');
                const nationalIDInput = document.querySelector('input[name="nationalID"]');
                const nationalIDError = document.getElementById('nationalIDError');
                const residencePhoneInput = document.querySelector('input[name="residencePhone"]');
                const residencePhoneError = document.getElementById('residencePhoneError');
                const mobileNoInput = document.querySelector('input[name="mobileNo"]');
                const mobileNoError = document.getElementById('mobileNoError');

                fileInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        const fileName = this.files[0].name;
                        uploadText.textContent = 'Selected: ' + fileName;
                        uploadIcon.classList.remove('bi-person-plus-fill');
                        uploadIcon.classList.add('bi-check-circle-fill');
                        uploadIcon.style.color = 'green';
                    } else {
                        uploadText.textContent = 'Upload Image';
                        uploadIcon.classList.remove('bi-check-circle-fill');
                        uploadIcon.classList.add('bi-person-plus-fill');
                        uploadIcon.style.color = '#28a745';
                    }
                });

                // Function to validate phone numbers
                function validatePhoneNumber(input, errorElement) {
                    const pureDigits = input.value.replace(/[^0-9]/g, '');
                    let hasError = false;
                    let errorMessage = "";

                    if (pureDigits.length === 10 && new Set(pureDigits).size === 1) {
                        hasError = true;
                        errorMessage = "add correct number";
                    }

                    if (hasError) {
                        input.classList.add('is-invalid');
                        errorElement.textContent = errorMessage;
                    } else {
                        input.classList.remove('is-invalid');
                        errorElement.textContent = "";
                    }
                }

                // Functionality for National ID field formatting and validation
                nationalIDInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/g, '');
                    
                    // Add hyphen after 5 digits
                    if (value.length > 5) {
                        value = value.slice(0, 5) + '-' + value.slice(5);
                    }
                    // Add second hyphen after 7 more digits
                    if (value.length > 13) { // 5 digits + 1 hyphen + 7 digits
                        value = value.slice(0, 13) + '-' + value.slice(13);
                    }
                    // Limit the total length
                    if (value.length > 15) {
                        value = value.slice(0, 15);
                    }

                    e.target.value = value;
                    
                    // Validation for three or more same numbers consecutively
                    const pureDigits = e.target.value.replace(/-/g, '');
                    const hasThreeSameDigits = /(.)\1{2}/.test(pureDigits);

                    if (hasThreeSameDigits) {
                        nationalIDInput.classList.add('is-invalid');
                        nationalIDError.textContent = "National ID cannot contain three or more consecutive identical digits.";
                    } else {
                        nationalIDInput.classList.remove('is-invalid');
                        nationalIDError.textContent = "";
                    }
                });

                // Event listeners for phone numbers
                residencePhoneInput.addEventListener('input', () => {
                    residencePhoneInput.value = residencePhoneInput.value.replace(/\D/g, '');
                    validatePhoneNumber(residencePhoneInput, residencePhoneError);
                });

                mobileNoInput.addEventListener('input', () => {
                    mobileNoInput.value = mobileNoInput.value.replace(/\D/g, '');
                    validatePhoneNumber(mobileNoInput, mobileNoError);
                });
            });
        </script>
    <?php endif; ?>

</body>
</html>