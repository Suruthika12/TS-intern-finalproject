document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");

  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const submitBtn = document.getElementById("submit");

    if (username === "" || password === "") {
      alert("Please fill in both fields.");
      return;
    }

    submitBtn.disabled = true; // Disable button to prevent multiple clicks

    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    fetch("login.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      submitBtn.disabled = false; // Re-enable after response

      if (data.status === "success") {
        localStorage.setItem("user_id", data.user_id);
        localStorage.setItem("username", data.username);
        alert("Login successful!");
        window.location.href = "tasks.html";
      } else {
        alert(data.message || "Login failed.");
      }
    })
    .catch(err => {
      submitBtn.disabled = false; // Re-enable on error too
      console.error("Error during login:", err);
      alert("Something went wrong. Please try again.");
    });
  });
});
