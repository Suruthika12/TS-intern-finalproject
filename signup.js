document.addEventListener("DOMContentLoaded", function () {
  const signupForm = document.getElementById("signupForm");

  signupForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const submitBtn = document.getElementById("submit");

    if (username === "" || password === "") {
      alert("Please fill in both fields.");
      return;
    }

    const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
    if (!usernameRegex.test(username)) {
     alert("Username should be 3–20 characters long and only contain letters, numbers, or underscores.");
    return;
    }



    if (password.length < 6) {
      alert("Password should be at least 6 characters long.");
      return;
    }

    submitBtn.disabled = true; // 🔒 Disable the button during submission

    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);
    
    fetch("signup.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      submitBtn.disabled = false;
      submitBtn.textContent = "Sign Up";
      
  if (data.status === "success") {
    alert("Signup successful! Please log in.");
    window.location.href = "login.html";
  } else {
    alert(data.message || "Signup failed.");
  }
})
.catch(error => {
  submitBtn.disabled = false;
  submitBtn.textContent = "Sign Up";
  alert("An error occurred. Please try again.");
  console.error(error);
});

  });
});
