<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form name="patientSignup" class="patientSignupForm">

<h2 class="signupTitle">Sign Up</h2>

<div class="fields multiStepForm">
  <div class="steps">
    <div data-step="one">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" value="Hari" required />
      <small class="message" data-message=""></small>

      <label for="middleName">Middle Name</label>
      <input type="text" id="middleName" name="middleName" value="Prasad" />
      <small class="message" data-message=""></small>

      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" value="Bastola" required />
      <small class="message" data-message=""></small>
    </div>

    <div data-step="two">
      <label for="gender">Gender</label>
      <select name="gender" id="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="others">Others</option>
      </select>
      <small class="message" data-message=""></small>

      <label for="dob">Date of Birth</label>
      <input type="date" name="dob" id="dob" />
      <small class="message" data-message=""></small>

      <label for="bloodGroup">Blood Group</label>
      <select name="bloodGroup" id="bloodGroup">
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>
      <small class="message" data-message=""></small>

      <label for="maritalStatus">Marital Status</label>
      <select name="maritalStatus" id="maritalStatus">
        <option value="single">single</option>
        <option value="married">married</option>
        <option value="divorced">divorced</option>
      </select>
      <small class="message" data-message=""></small>
    </div>

    <div data-step="three">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="name@domain.com" required>
      <small class="message" data-message=""></small>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="password" required />
      <small class="message" data-message=""></small>
    </div>

    <div data-step="four">
      <label for="address">Address</label>
      <input type="address" id="address" name="address" value="Biratnagar" required>
      <small class="message" data-message=""></small>

      <label for="telephone">Telephone</label>
      <input type="tel" id="telephone" name="telephone" value="telephone" required />
      <small class="message" data-message=""></small>
    </div>
  </div>
  <button type="submit">Sign Up</button>
</div>
</form>
<script>
        const form = document.querySelector("[name=patientSignup]");
            form.addEventListener("submit", e => {
            e.preventDefault();
            // console.log(form);
            const {
                firstName,
                middleName,
                lastName,
                gender,
                dob,
                bloodGroup,
                maritalStatus,
                email,
                password,
                address,
                telephone
            } = form;

            console.log(firstName);
            
            const formFields = {
                firstName,
                middleName,
                lastName,
                gender,
                dob,
                bloodGroup,
                maritalStatus,
                email,
                password,
                address,
                telephone
            } 

            const data = {};

            for (const key in formFields) {
                data[key] = formFields[key].value;
                console.log(formFields[key])
                console.log(data[key]);
            }
            
            })
</script>
</body>
