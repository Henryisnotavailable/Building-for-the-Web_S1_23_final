function alert_user_error(column,message) {
    let error_msg = document.createElement("p");

    let error_div = document.getElementById(column);

    //Clear any previous errors
    while (error_div.hasChildNodes()) {
        error_div.firstChild.remove();
        console.log("Removing <p>");
    }


    //If the form is valid, then just return early
    if (message.length == 0) {
        console.log("Returning")
        return
    }
    error_msg.textContent = message;
    error_msg.setAttribute("style","color: white;background-color: #9068be;border-radius: 7px;margin-top:5px");
    



    error_div.appendChild(error_msg);
}


//This functions validates all fields that need validating. And adds errors at the bottom
//It will return either true if valid, or false if not valid
function validate() {

    let first_name = document.getElementById("firstname");
    let last_name = document.getElementById("lastname");
    let email = document.getElementById("email");
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    let password_confirm = document.getElementById("password_confirm")
    let pronouns = document.getElementById("pronouns");
    let date_of_birth = document.getElementById("date_of_birth");

    let phone_num = document.getElementById("phone_num");

    let favourite_bike = document.getElementById("favourite_bike");

    let profile_pic = document.getElementById("profile_pic");

    let short_bio = document.getElementById("bio");

    let is_valid = true;

    

    console.log(first_name);
    //No JS validation for firstname, lastname and email
    //Usernames can have characters like a ' - " " 
    console.log(last_name);
    console.log(email);
    
    //Validate first_name
    if (first_name.value.toLowerCase() == "admin") {
        //alert("Don't even try using admin...")
        alert_user_error("first_name_error_div","!!! Invalid first_name, no using admin !!!");
        is_valid = false;
    }

    else if (!(first_name.value.match(/[a-zA-Z0-9_'\-\.]{1,30}/))) {
        alert_user_error("first_name_error_div","!!! Invalid first name, it should be less than 30 alphanumeric characters or _, - , . , ' !!!");
        is_valid = false;
    }

    else {
        //When the message is == "" then it will clear all old errors, and not add any
        alert_user_error("first_name_error_div","")
    }



    //Validate username

    if (username.value.toLowerCase() == "admin") {
        //alert("Don't even try using admin...")
        alert_user_error("username_error_div","!!! Invalid username, no using admin !!!");
        is_valid = false;
    }

    else if (!(username.value.match(/[a-zA-Z0-9_]+/))) {
        alert_user_error("username_error_div","!!! Invalid username, it can only contain letters, numbers or an underscore !!!");
        is_valid = false;
    }

    else {
        //When the message is == "" then it will clear all old errors, and not add any
        alert_user_error("username_error_div","")
    }



    if (password.value != password_confirm.value) {
        alert_user_error("password_error_div","!!! Passwords don't match !!!");
        alert_user_error("password_confirm_error_div","!!! Passwords don't match !!!");
        is_valid = false;
    }

    else {
        alert_user_error("password_error_div","");
        alert_user_error("password_confirm_error_div","");
    }

    //This is a multi-choice, no validation needed
    //console.log(pronouns.value);


    //Convert into a Date object
    let date = new Date(date_of_birth.value);
    console.log(date);

    //Calculate age of the user
    let ageDifferenceMs = Date.now() - date.getTime();
    let ageDate = new Date(ageDifferenceMs);
    let yearAge = Math.abs(ageDate.getUTCFullYear() - 1970);


    //If the user enters a date in the future, then their birthday is invalid unless they're a time traveller.
    if (ageDifferenceMs < 0) {

        alert_user_error("date_of_birth_error_div","!!! Your birthday cannot be in the future !!!");
        
        is_valid = false;
        
    }

    //If user is younger than 18, they can't use the site.
    else if (yearAge < 18) {
        alert_user_error("date_of_birth_error_div","!!! Sorry, under 18s are not allowed !!!");
        is_valid = false;
    }

    else {
        alert_user_error("date_of_birth_error_div","");
    }



    //phone_num is already validated by the HTML, no JS validation required.
    //console.log(phone_num);
    
    //No validation required, favourite bike or bio may contain special characters HTML performs length validation
    //console.log(favourite_bike);
    //console.log(short_bio)

    //No need to validate file types, html contains an accept="image/gif, image/jpg, image/jpeg, image/png"
    //alert(profile_pic.files.length);


    

    return is_valid;
}



//Handle the clear button
document.getElementById('clear_button').addEventListener("click", function (e) {
    if (confirm("Clear Everything?")) {
        
        return true;
    }
    e.preventDefault();
    return false;
});

//Handle register
document.getElementById('register_form').addEventListener("submit", function (e) {
    
    let validation = validate();
    
    if (validation == true) {
        
        return true;
    }
    alert_user_error("error_message_row","Validation failed! Please review")
    e.preventDefault();
    return true;
});







