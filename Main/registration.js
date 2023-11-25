const reset_button = document.getElementById("reset_button");
const register_form = document.getElementById("register_form");
const email = document.getElementById("email");




//On pressing the reset button
reset_button.addEventListener("click", (e)=> {
    let register_form_2 = document.getElementById("register_form");
    if (confirm("Clear Everything?")) {
        register_form_2.reset()
    }
}); 

//On submitting data
register_form.addEventListener("submit", (e) => {
    e.preventDefault();
    let register_form_2 = document.getElementById("register_form");
    if (validate_form(register_form_2)) {
        register_form_2.submit();
    };

    

})

function validate_form(form) {
    
const email = document.getElementById("email");    
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
    

return false;

}
