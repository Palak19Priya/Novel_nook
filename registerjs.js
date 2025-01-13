function myFunction(x) {
    x.style.background = "#cedfdf";
}

function upperCase() {
    const x = document.getElementById("fullname");
    x.value = x.value.toUpperCase();
}

// Clear form and reset error messages
function clearForm() {
    document.getElementById("registrationForm").reset(); // Clear all input fields
    var errors = document.querySelectorAll('.error');
    for (var i = 0; i < errors.length; i++) {
        errors[i].textContent = ''; // Clear error messages
    }
}

// Form validation and handling
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Reset error messages
    var errors = document.querySelectorAll('.error');
    for (var i = 0; i < errors.length; i++) {
        errors[i].textContent = '';
    }

    var fullname = document.getElementById('fullname').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var email = document.getElementById('email').value;
    var contact = document.getElementById('contact').value;
    var gender = document.querySelector('input[name="gender"]:checked');
    var birthdate = document.getElementById('birthdate').value;
    var nationality = document.getElementById('nationality').value;

    // Validation
    var hasError = false;

    if (!fullname) {
        document.getElementById('fullnameError').textContent = 'Enter your name.';
        hasError = true;
    } else if (!/^[a-z A-Z]{3,50}$/.test(fullname)) {
        document.getElementById('fullnameError').textContent = "Name should only have alphabets and at least 3 characters.";
        hasError = true;
    }

    if (!username) {
        document.getElementById('usernameError').textContent = 'Username is required.';
        hasError = true;
    } else if (!/^[a-zA-Z0-9_]{1,20}$/.test(username)) {
        document.getElementById('usernameError').textContent = 'Username must be alphanumeric and at most 20 characters.';
        hasError = true;
    }

    if (!password) {
        document.getElementById('passwordError').textContent = 'Password is required.';
        hasError = true;
    } else if (password.length < 8 || password.length > 10) {
        document.getElementById('passwordError').textContent = 'Password must be between 8 and 10 characters.';
        hasError = true;
    } else if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,10}$/.test(password)) {
        document.getElementById('passwordError').textContent = 'Password must include upper, lower, digit, and special character.';
        hasError = true;
    }

    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
        hasError = true;
    }

    if (!email) {
        document.getElementById('emailError').textContent = 'Email is required.';
        hasError = true;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById('emailError').textContent = 'Invalid email format.';
        hasError = true;
    }

    if (!contact) {
        document.getElementById('contactError').textContent = 'Contact number is required.';
        hasError = true;
    } else if (!/^\d{10}$/.test(contact)) {
        document.getElementById('contactError').textContent = 'Contact number must be 10 digits.';
        hasError = true;
    }

    if (!gender) {
        document.getElementById('genderError').textContent = 'Select your gender.';
        hasError = true;
    }

    if (!birthdate) {
        document.getElementById('birthdateError').textContent = 'Enter your birthdate.';
        hasError = true;
    }

    if (!nationality) {
        document.getElementById('nationalityError').textContent = 'Enter your nationality.';
        hasError = true;
    } else if (!/^[a-zA-Z]+$/.test(nationality)) {
        document.getElementById('nationalityError').textContent = 'Nationality should contain only letters.';
        hasError = true;
    }

    // If no errors, submit the form
    if (!hasError) {
        alert('Account created successfully! You can login using your username and password and enjoy personalized experience.');
        // Here, you can proceed with actual form submission or further processing
    }
});
