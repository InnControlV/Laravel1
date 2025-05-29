<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Jarb Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/login.css">
  <style>
    .hidden {
      display: none;
    }
  </style>
   <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    const API_BASE_URL = "{{ url('/api') }}";
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  </script>
</head>
<body>
<div class="container">
  <!-- Left Panel -->
  <div class="left-panel">
    <h1>Welcome back to Jarb Website</h1>
    <p>
      We’re glad to see you again! Jarb is your personalized platform for smarter work,
      seamless experiences, and innovative tools. Login to continue exploring powerful features,
      track your progress, and unlock new possibilities every day.
    </p>
  </div>

  <!-- Right Panel -->
  <div class="right-panel">
    <div class="login-container">

      <!-- LOGIN FORM -->
      <form id="loginForm">
        <h2>Login</h2>
        <div class="form-group">
          <label for="email">Email</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" placeholder="Enter your email ID" required>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" placeholder="Enter your password" required>
          </div>
        </div>

        <div class="checkbox-group">
          <div>
            <input type="checkbox" id="remember">
            <label for="remember">Remember me</label>
          </div>
          <div>
            <span class="toggle-link" onclick="showSignup()">Sign up</span>
          </div>
        </div>

        <button type="submit" class="login-btn">Login</button>
        <a href="#" class="forgot-password">Forgot password?</a>

        <div class="or-divider"><span>OR</span></div>

        <div class="social-login">
          <a href="#" class="social-circle google"><i class="fab fa-google"></i></a>
        </div>
      </form>

      <!-- SIGNUP FORM -->
      <form id="signupForm" class="hidden">
        <h2>Sign Up</h2>

        <div class="form-group">
          <label for="signup-email">Email</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" id="signup-email" placeholder="Enter your email" required>
          </div>
        </div>

        <div class="form-group">
          <label for="signup-password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" id="signup-password" placeholder="Create a password" required>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm-password">Confirm Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" id="confirm-password" placeholder="Confirm your password" required>
          </div>
        </div>

        <button type="submit" class="login-btn">Sign Up</button>

        <div style="text-align: center; margin-top: 15px;">
          <span class="toggle-link" onclick="showLogin()">Already have an account? Login</span>
        </div>
      </form>

      <!-- OTP VERIFICATION FORM -->
      <form id="otpForm" class="hidden">
        <h2>Verify OTP</h2>

        <div class="form-group">
          <label for="otp">Enter OTP</label>
          <div class="input-wrapper">
            <i class="fas fa-key"></i>
            <input type="text" id="otp" placeholder="Enter OTP" required>
          </div>
        </div>

        <button type="submit" class="login-btn">Verify OTP</button>
      </form>

    </div>
  </div>
</div>


 <script>
    const apiURL = `${API_BASE_URL}/signupOrLogin`;
    const verifyOtpURL = `${API_BASE_URL}/verify-otp`;
    let registeredEmail = "";

    // Helper to include CSRF token in fetch headers
    function getFetchOptions(formData) {
      return {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        body: formData
      };
    }

    // LOGIN
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;

      try {
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);
        formData.append("type", "old");

        const res = await fetch(apiURL, getFetchOptions(formData));
        const data = await res.json();

        if (res.ok && data.message === "Success") {
          alert("Login successful!");
          window.location.href = "/news"; // Adjust redirect as needed
        } else {
          alert(data.message || "Login failed");
        }
      } catch (err) {
        console.error(err);
        alert("Something went wrong during login.");
      }
    });

    // SIGNUP
    document.getElementById('signupForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = document.getElementById('signup-email').value.trim();
      const password = document.getElementById('signup-password').value;
      const confirmPassword = document.getElementById('confirm-password').value;

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
      }

      try {
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);
        formData.append("type", "new");

        const res = await fetch(apiURL, getFetchOptions(formData));
        const data = await res.json();

        if (res.ok && data.message === "OTP sent to your email") {
          alert("Signup successful! OTP sent to your email.");
          registeredEmail = email;
          showOtpForm();
        } else {
          alert(data.message || "Signup failed.");
        }
      } catch (err) {
        console.error(err);
        alert("Something went wrong during signup.");
      }
    });

    // OTP VERIFY
    document.getElementById('otpForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const otp = document.getElementById('otp').value.trim();

      try {
        const formData = new FormData();
        formData.append("email", registeredEmail);
        formData.append("otp", otp);

        const res = await fetch(verifyOtpURL, getFetchOptions(formData));
        const data = await res.json();

        if (res.ok && data.message === "Success") {
          alert("OTP Verified! You can now log in.");
          showLogin();
        } else {
          alert(data.message || "OTP verification failed.");
        }
      } catch (err) {
        console.error(err);
        alert("Something went wrong during OTP verification.");
      }
    });

    function showSignup() {
      document.getElementById('loginForm').classList.add('hidden');
      document.getElementById('signupForm').classList.remove('hidden');
      document.getElementById('otpForm').classList.add('hidden');
    }

    function showLogin() {
      document.getElementById('signupForm').classList.add('hidden');
      document.getElementById('otpForm').classList.add('hidden');
      document.getElementById('loginForm').classList.remove('hidden');
    }

    function showOtpForm() {
      document.getElementById('signupForm').classList.add('hidden');
      document.getElementById('loginForm').classList.add('hidden');
      document.getElementById('otpForm').classList.remove('hidden');
    }
  </script>