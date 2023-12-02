function remove_all_forms() {
    let change_divs = document.getElementsByClassName("added_form");
    console.log(change_divs);
    Array.from(change_divs).forEach(
        function(element,index,array) {
            element.remove();
        }
    )
}


function setup_bio_change(value) {
    const bio_change_div = document.getElementById("change_bio_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("bio_form")) {

        let bio_form = document.createElement("form");

        bio_form.action = "./my_account.php";
        bio_form.id = "bio_form";
        bio_form.classList.add("added_form");;
        bio_form.method = "POST";

        let bio_label = document.createElement("label");
        bio_label.for = "bio_change_input";
        bio_label.innerText = "Enter your new bio!";

        let bio_input = document.createElement("textarea");
        //Set html tag attributes for validation
        bio_input.id = "bio_change_input";
        bio_input.maxLength = "200";
        bio_input.name = "new_bio";
        bio_input.required = true;
        if (value != null) {
        bio_input.value = value;
        }

        //Don't allow horizontal expansion (everything breaks, remove at your own peril)
        bio_input.style.resize = "vertical";

        //Set position of the inputs
        bio_input.style.maxWidth = bio_change_div.width + "px";
        bio_input.style.maxHeight = "100px";
        bio_input.style.width = bio_change_div.width + "px";

        let bio_button = document.createElement("button");
        bio_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        bio_change_div.appendChild(bio_form);
        bio_form.appendChild(line_divider);
        bio_form.appendChild(bio_label);
        bio_form.appendChild(bio_input);
        bio_form.appendChild(bio_button);
    }
}


document.getElementById("bio_change").addEventListener("click",(e) => {

    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_bio_change(null);
});

function setup_username_change(value) {
    const username_change_div = document.getElementById("change_username_input_div");

    //Don't duplicate the form if it exists
    if (!document.getElementById("username_form")) {
        let break_element = document.createElement("br");
        let username_form = document.createElement("form");


        username_form.action = "./my_account.php";
        username_form.id = "username_form";
        username_form.method = "POST";
        username_form.classList.add("added_form");;

        let username_label = document.createElement("label");
        username_label.for = "username_change_input";
        username_label.innerText = "Enter your new username!";

        let username_input = document.createElement("input");
        //Set html tag attributes for validation
        username_input.id = "username_change_input";
        username_input.maxLength = "20";
        username_input.name = "new_username";
        username_input.required = true;
        username_input.type = "text";

        if (value != null) {
            username_input.value = value;
        }


        //Set position of the inputs
        username_input.style.maxWidth = username_change_div.width + "px";
        username_input.style.maxHeight = "100px";
        username_input.style.width = username_change_div.width + "px";

        let username_button = document.createElement("button");
        username_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        username_change_div.appendChild(username_form);
        username_form.appendChild(line_divider);
        username_form.appendChild(username_label);
        username_form.appendChild(username_input);
        username_form.appendChild(break_element);
        username_form.appendChild(username_button);
    }
}


document.getElementById("change_username").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_username_change(null);

});

function setup_fave_bike_change(value) {
    const fave_bike_change_div = document.getElementById("change_fave_bike_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("fave_bike_form")) {
        let break_element = document.createElement("br");
        let fave_bike_form = document.createElement("form");


        fave_bike_form.action = "./my_account.php";
        fave_bike_form.id = "fave_bike_form";
        fave_bike_form.method = "POST";
        fave_bike_form.classList.add("added_form");;

        let fave_bike_label = document.createElement("label");
        fave_bike_label.for = "fave_bike_change_input";
        fave_bike_label.innerText = "Enter your new favourite bike!";

        let fave_bike_input = document.createElement("input");
        //Set html tag attributes for validation
        fave_bike_input.id = "fave_bike_change_input";
        fave_bike_input.maxLength = "50";
        fave_bike_input.name = "new_fave_bike";
        fave_bike_input.required = true;
        fave_bike_input.type = "text";

        if (value != null) {
            fave_bike_input.value = value;
        }


        //Set position of the inputs
        fave_bike_input.style.maxWidth = fave_bike_change_div.width + "px";
        fave_bike_input.style.maxHeight = "100px";
        fave_bike_input.style.width = fave_bike_change_div.width + "px";

        let fave_bike_button = document.createElement("button");
        fave_bike_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        fave_bike_change_div.appendChild(fave_bike_form);
        fave_bike_form.appendChild(line_divider);
        fave_bike_form.appendChild(fave_bike_label);
        fave_bike_form.appendChild(fave_bike_input);
        fave_bike_form.appendChild(break_element);
        fave_bike_form.appendChild(fave_bike_button);
    }
}

document.getElementById("change_favourite_bike").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_fave_bike_change(null);

});

function setup_profile_pic_change() {
    const profile_pic_change_div = document.getElementById("change_profile_pic_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("profile_pic_form")) {
        let break_element = document.createElement("br");
        let profile_pic_form = document.createElement("form");


        profile_pic_form.action = "./my_account.php";
        profile_pic_form.id = "profile_pic_form";
        profile_pic_form.method = "POST";
        profile_pic_form.enctype = "multipart/form-data"

        profile_pic_form.classList.add("added_form");;

        let profile_pic_label = document.createElement("label");
        profile_pic_label.for = "profile_pic_change_input";
        profile_pic_label.innerText = "Choose a new profile picture!";

        let profile_pic_input = document.createElement("input");
        //Set html tag attributes for validation
        profile_pic_input.id = "profile_pic_change_input";
        profile_pic_input.name = "new_profile_pic";
        profile_pic_input.required = true;
        profile_pic_input.type = "file";
        profile_pic_input.accept = "image/gif, image/jpg, image/jpeg, image/png, image/webp";


        //Set position of the inputs
        profile_pic_input.style.maxWidth = profile_pic_change_div.width + "px";
        profile_pic_input.style.maxHeight = "100px";
        profile_pic_input.style.width = profile_pic_change_div.width + "px";

        let profile_pic_button = document.createElement("button");
        profile_pic_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        profile_pic_change_div.appendChild(profile_pic_form);
        profile_pic_form.appendChild(line_divider);
        profile_pic_form.appendChild(profile_pic_label);
        profile_pic_form.appendChild(profile_pic_input);
        profile_pic_form.appendChild(break_element);
        profile_pic_form.appendChild(profile_pic_button);
    }
}

document.getElementById("change_profile_pic").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_profile_pic_change();

});

function setup_pronouns_change(value) {
    const pronouns_change_div = document.getElementById("change_pronouns_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("pronouns_form")) {
        let break_element = document.createElement("br");
        let pronouns_form = document.createElement("form");


        pronouns_form.action = "./my_account.php";
        pronouns_form.id = "pronouns_form";
        pronouns_form.method = "POST";
        pronouns_form.classList.add("added_form");;

        let pronouns_label = document.createElement("label");
        pronouns_label.for = "pronouns_change_input";
        pronouns_label.innerText = "Change your pronouns!";

        let pronouns_select = document.createElement("select");
        //Set html tag attributes for validation
        pronouns_select.id = "pronouns_change_select";
        pronouns_select.name = "new_pronouns";

        //Add the options
        options = ["he/him", "she/her", "they/them"];
        for (var i = 0; i < 3; i++) {
            pronouns_select.add(new Option(options[i]));
        }

        if (value != null) {
            pronouns_select.value = value;
        }

        //Set position of the inputs
        pronouns_select.style.maxWidth = pronouns_change_div.width + "px";
        pronouns_select.style.maxHeight = "100px";
        pronouns_select.style.width = pronouns_change_div.width + "px";

        let pronouns_button = document.createElement("button");
        pronouns_button.innerText = "Submit!";


        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        pronouns_change_div.appendChild(pronouns_form);
        pronouns_form.appendChild(line_divider);
        pronouns_form.appendChild(pronouns_label);
        pronouns_form.appendChild(document.createElement("br"));
        pronouns_form.appendChild(pronouns_select);
        pronouns_form.appendChild(break_element);
        pronouns_form.appendChild(pronouns_button);
    }
}

document.getElementById("change_pronouns").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_pronouns_change(null);

});

function setup_password_change() {
    const password_change_div = document.getElementById("change_password_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("password_form")) {
        let break_element = document.createElement("br");
        let password_form = document.createElement("form");


        password_form.action = "./my_account.php";
        password_form.id = "password_form";
        password_form.method = "POST";
        password_form.classList.add("added_form");;

        let password_label = document.createElement("label");
        password_label.for = "password_change_input";
        password_label.innerText = "Change your password!";

        let password_input = document.createElement("input");
        //Set html tag attributes for validation
        password_input.id = "password_change_select";
        password_input.name = "new_password";

        password_input.minLength = "10";
        password_input.required = true;
        password_input.type = "password";
        password_input.required = true;



        //Set position of the inputs
        password_input.style.maxWidth = password_change_div.width + "px";
        password_input.style.maxHeight = "100px";
        password_input.style.width = password_change_div.width + "px";


        let password_confirm_label = document.createElement("label");
        password_confirm_label.for = "password_confirm_change_input";
        password_confirm_label.innerText = "Password confirmation";

        let password_confirm_input = document.createElement("input");
        //Set html tag attributes for validation
        password_confirm_input.id = "password_confirm_change_select";
        password_confirm_input.name = "new_password_confirm";

        password_confirm_input.minLength = "10";
        password_confirm_input.required = true;
        password_confirm_input.type = "password";
        password_confirm_input.required = true;


        //Set position of the inputs
        password_confirm_input.style.maxWidth = password_change_div.width + "px";
        password_confirm_input.style.maxHeight = "100px";
        password_confirm_input.style.width = password_change_div.width + "px";

        let password_button = document.createElement("button");
        password_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        password_change_div.appendChild(password_form);
        password_form.appendChild(line_divider);
        password_form.appendChild(password_label);
        password_form.appendChild(document.createElement("br"));
        password_form.appendChild(password_input);
        password_form.appendChild(document.createElement("br"));
        password_form.appendChild(password_confirm_label);
        password_form.appendChild(password_confirm_input);
        password_form.appendChild(break_element);
        password_form.appendChild(password_button);
    }
}

document.getElementById("change_password").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_password_change();

});

function setup_visibility_change() {
    const profile_visibility_change_div = document.getElementById("change_visibility_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("profile_visibility_form")) {
        let break_element = document.createElement("br");
        let profile_visibility_form = document.createElement("form");


        profile_visibility_form.action = "./my_account.php";
        profile_visibility_form.id = "profile_visibility_form";
        profile_visibility_form.method = "POST";
        profile_visibility_form.classList.add("added_form");;



        let profile_visibility_label = document.createElement("label");
        profile_visibility_label.for = "profile_visibility_change_input";
        profile_visibility_label.innerText = "Are you sure?";

        //Just so we can actually send something to the server (keep it hidden though)
        let profile_visibility_input = document.createElement("input");
        //Set html tag attributes for validation
        profile_visibility_input.id = "profile_visibility_change";
        profile_visibility_input.name = "new_profile_visibility";
        profile_visibility_input.value = "change";
        profile_visibility_input.required = true;
        profile_visibility_input.readOnly = true;


        //Set position of the inputs
        profile_visibility_input.style.maxWidth = profile_visibility_change_div.width + "px";
        profile_visibility_input.style.maxHeight = "100px";
        profile_visibility_input.style.width = profile_visibility_change_div.width + "px";
        //Hide it, I just need something to submit, this is a bool field (e.g. private vs public)
        profile_visibility_input.style.display = "none";





        let profile_visibility_button = document.createElement("button");
        profile_visibility_button.innerText = "Yes!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        profile_visibility_change_div.appendChild(profile_visibility_form);
        profile_visibility_form.appendChild(line_divider);
        profile_visibility_form.appendChild(profile_visibility_label);

        profile_visibility_form.appendChild(profile_visibility_input);
        profile_visibility_form.appendChild(break_element);
        profile_visibility_form.appendChild(profile_visibility_button);
    }
}

document.getElementById("profile_visibility").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_visibility_change();

});

function setup_email_change(value) {
    const email_change_div = document.getElementById("change_email_input_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("email_form")) {
        let break_element = document.createElement("br");
        let email_form = document.createElement("form");


        email_form.action = "./my_account.php";
        email_form.id = "email_form";
        email_form.method = "POST";
        email_form.className="added_form";

        let email_label = document.createElement("label");
        email_label.for = "email_change_input";
        email_label.innerText = "Enter your new email!";

        //Just so we can actually send something to the server (keep it hidden though)
        let email_input = document.createElement("input");
        //Set html tag attributes for validation
        email_input.id = "email_change";
        email_input.name = "new_email";
        email_input.type = "email";
        email_input.required = true;

        if (value != null) {
            email_input.value = value;
        }


        //Set position of the inputs
        email_input.style.maxWidth = email_change_div.width + "px";
        email_input.style.maxHeight = "100px";
        email_input.style.width = email_change_div.width + "px";





        let email_button = document.createElement("button");
        email_button.innerText = "Submit!";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        email_change_div.appendChild(email_form);
        email_form.appendChild(line_divider);
        email_form.appendChild(email_label);
        email_form.appendChild(document.createElement("br"));
        email_form.appendChild(email_input);
        email_form.appendChild(break_element);
        email_form.appendChild(email_button);
    }
}

document.getElementById("change_email").addEventListener("click",(e) => {
    //Remove all forms to make sure only one exists at once
    remove_all_forms();
    setup_email_change(null);

});

function setup_delete_account() {
    const delete_account_change_div = document.getElementById("delete_account_div");
    //Don't duplicate the form if it exists
    if (!document.getElementById("delete_account_form")) {
        let break_element = document.createElement("br");
        let delete_account_form = document.createElement("form");


        delete_account_form.action = "./my_account.php";
        delete_account_form.id = "delete_account_form";
        delete_account_form.method = "POST";
        delete_account_form.classList.add("added_form");;



        let delete_account_label = document.createElement("label");
        delete_account_label.for = "delete_account_placeholder";
        delete_account_label.innerText = "Are you sure?";

        //Just so we can actually send something to the server (keep it hidden though)
        let delete_account_input = document.createElement("input");
        //Set html tag attributes for validation
        delete_account_input.id = "delete_account_placeholder";
        delete_account_input.name = "delete_account";
        delete_account_input.value = "yes";
        delete_account_input.required = true;
        delete_account_input.readOnly = true;


        //Set position of the inputs
        delete_account_input.style.maxWidth = delete_account_change_div.width + "px";
        delete_account_input.style.maxHeight = "100px";
        delete_account_input.style.width = delete_account_change_div.width + "px";
        //Hide it, I just need something to submit, this is a bool field (e.g. private vs public)
        delete_account_input.style.display = "none";





        let delete_account_button = document.createElement("button");
        delete_account_button.innerText = "Yes, I am sure.";

        let line_divider = document.createElement("hr");
        line_divider.style.marginTop = "5px";

        delete_account_change_div.appendChild(delete_account_form);
        delete_account_form.appendChild(line_divider);
        delete_account_form.appendChild(delete_account_label);

        delete_account_form.appendChild(delete_account_input);
        delete_account_form.appendChild(break_element);
        delete_account_form.appendChild(delete_account_button);
    }
}

document.getElementById("delete_account").addEventListener("click",(e) => {
    
    setup_delete_account();

});


function inform_user_of_change(message,error_div_id) {

    const error_div_p = document.getElementById(error_div_id).firstChild;
    error_div_p.innerText = message;

}

const url_query_string = window.location.search;
const url_params = new URLSearchParams(url_query_string);


//If we're coming from a sucessfull update, let the user know
if (url_params.has("updated")) {
    //Stop user reloading and displaying new update message (if they didn't actually update anything)
    //(this sets the history to the page WITHOUT URL params)
    window.history.pushState({}, document.title, window.location.pathname);
    switch(url_params.get("updated")) {
        case "description":
            inform_user_of_change("Description updated!","bio_error_div");
            break;
        case "username":
            inform_user_of_change("Username updated!","username_error_div");
            break;
        case "favourite_bike":
            inform_user_of_change("Favourite bike updated!","fave_bike_error_div");
            break;
        case "pronouns":
            inform_user_of_change("Pronouns updated!","pronouns_error_div");
            break;
        case "password":
            inform_user_of_change("Password updated!","password_error_div");
            break;
        case "visibility":
            inform_user_of_change("Visibility updated!","visibility_error_div");
            break;
        case "email":
            inform_user_of_change("Email updated!","email_error_div");
            break;
        case "profile_url":
            inform_user_of_change("Profile picture updated!","profile_pic_error_div");
            break;
    }

}

