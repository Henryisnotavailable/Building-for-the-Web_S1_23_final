


function decide_mileage_slider_colour(value) {
    
    if (value > 1000) {
        return ["<br> More than 1000 miles","darkred"];
    }
    
    if (value <= 200) {
        //mileage_output.style.color = "purple";
        //mileage_slider.style.accentColor = "purple";
        return [`<br> Around ${value} miles`,"purple"];
    }
    else if (value <= 500) {
        return [`<br> Around ${value} miles`,"green"];
    }

    else if (value <= 800) {

        return [`<br> Around ${value} miles`,"orange"];
    }

    else if (value > 800) {
        return [`<br> Around ${value} miles`,"red"];
    }

    else {
        return [`<br> Unknown miles: ${value}`,"gray"];
    }
}


function alert_user_error(column,message) {
    let error_msg = document.createElement("p");
    let error_div = document.getElementById(column);
    //Clear any previous errors
    while (error_div.hasChildNodes()) {
        error_div.firstChild.remove();
    }
    //If the form is valid, then just return early after removing the error
    if (message.length < 0) {
        return
    }
    error_msg.textContent = message;
    error_msg.setAttribute("style","color: white;background-color: #e62739;border-radius: 5px;margin-top:5px");
    error_div.appendChild(error_msg);
}


function validate() {

    let is_valid = true;

    let bike_date_of_birth = document.getElementById("bike_date_of_birth");

    let lower_asking_price = document.getElementById("asking_price_lower");
    let upper_asking_price = document.getElementById("asking_price_upper");

    let bike_quality = document.getElementById("bike_slider_value");
    let bike_mileage = document.getElementById("bike_mileage_span");

    let current_year = new Date().getFullYear();


    //If the lower price is more than the upper price, ERROR!
    if (parseInt(lower_asking_price.value,10) > parseInt(upper_asking_price.value,10)) {

        alert_user_error("lower_price_error_div","!!! Lower asking price can't be more than upper asking price !!!");
        alert_user_error("upper_price_error_div","!!! Lower asking price can't be more than upper asking price !!!");
        is_valid = false;
    }

    else {
        alert_user_error("lower_price_error_div","");
        alert_user_error("upper_price_error_div","");
    }

    //Make sure the bike wasn't made in the future.
    if (parseInt(bike_date_of_birth.value,10) > current_year) {
        alert_user_error("bike_date_of_birth_error","!!! How was your bike made in the future !!!");
        is_valid = false;
    }

    else {
        alert_user_error("bike_date_of_birth_error","");
    }

    //This equals bike_quality.innerText == "Slide the bar!"
    //Basically, the actual .innerText value had newlines, which made the code look ugly, so I use the base64 value and decode it.
    if (bike_mileage.innerText === atob("ClNsaWRlIHRoZSBiYXIh")) {
        alert_user_error("bike_mileage_error_div","!!! Again, please slide the bar !!!");
        is_valid = false;
    }

    else {
        alert_user_error("bike_mileage_error_div","");
    }

    //Strong equality is used here as well, just to avoid any edge cases where it returns true, when it shouldn't
    //e.g. "" == 0 returns TRUE
    if (bike_quality.innerText === atob("ClNsaWRlIHRoZSBiYXIh")) {
        alert_user_error("bike_quality_error_div","!!! Again, please slide the bar !!!");
        is_valid = false;
    }

    else {
        alert_user_error("bike_quality_error_div","");
    }
    

    return is_valid;



}






//To do!
document.getElementById('sell_form').addEventListener("submit", function (e) {
    
    let validation = validate();
    
    if (validation == true) {
        
        return true;
    }
    alert_user_error("error_message_row","Validation failed! Please review")
    e.preventDefault();
    return true;
});




//Handle clear button, make user confirm
document.getElementById('clear_button').addEventListener("click", function (e) {
    if (confirm("Clear Everything?")) {
        document.getElementById("bike_quality").style.accentColor = "orange";
        document.getElementById("bike_slider_value").innerHTML = "";
        document.getElementById("bike_mileage").style.accentColor = "orange";
        document.getElementById("bike_mileage_span").innerHTML = "<br>Slide the bar!";
        return true;
    }
    return false;
});

//
function decide_slider_colour(value) {
    switch (value) {
        case "0":
            return ["Broken","black"]
            break;
        case "1":
            return ["Poor","darkred"]
            break;
        case "2":
            return ["Ok","orange"]
            break;

        case "3":
            return ["Good","green"]
            break;

        case "4":
            return ["Great","blue"]
            break;

        case "5":
            return ["Perfect","purple"]
            break;

        default:
            return ["Unknown","gray"]
            break;
    }
}

var slider = document.getElementById("bike_quality");
var output = document.getElementById("bike_slider_value");

//If no value, then set to gray
if (slider.value == "0") {
//Initial DOM setup
output.innerHTML = "<br>Slide the bar!";
output.style.color = "red";
slider.style.accentColor = "gray";
}

//Otherwise, set colours
else {

    let [sliderValue,sliderColour] = decide_slider_colour(slider.value);
    output.innerHTML = "<br>"+sliderValue;
    output.style.color = sliderColour;
    slider.style.accentColor =sliderColour;
}


//On enter, change the colour of slider
slider.addEventListener("input", function (e) {

    let [sliderValue,sliderColour] = decide_slider_colour(this.value);
    output.innerHTML = "<br>"+sliderValue;
    output.style.color = sliderColour;
    slider.style.accentColor =sliderColour;
});


var mileage_slider = document.getElementById("bike_mileage");
var mileage_output = document.getElementById("bike_mileage_span");
//Initial DOM setup

if (mileage_slider.value == "0") {

    mileage_output.innerHTML = "<br>Slide the bar!";
    mileage_output.style.color = "red";
    mileage_slider.style.accentColor = "gray";
}

else {
    let [mileage_slider_value,mileage_slider_colour] = decide_mileage_slider_colour(mileage_slider.value);
    mileage_output.innerHTML = mileage_slider_value;
    mileage_output.style.color = mileage_slider_colour;
    mileage_slider.style.accentColor =mileage_slider_colour;
}


//On enter, change the colour of slider as miles increase
mileage_slider.addEventListener("input", function (e) {

    //Set colours based on value
    if (this.value <= 200) {
        mileage_output.style.color = "purple";
        mileage_slider.style.accentColor = "purple";
    }
    else if (this.value <= 500) {
        mileage_output.style.color = "green";
        mileage_slider.style.accentColor = "green";
    }

    else if (this.value <= 800) {

        mileage_output.style.color = "orange";
        mileage_slider.style.accentColor = "orange";
    }

    else if (this.value > 800) {
        mileage_output.style.color = "red";
        mileage_slider.style.accentColor = "red";
    }

    else {
        mileage_output.style.color = "gray";
        mileage_slider.style.accentColor = "gray";
    }


    //Set text if less than 1000
    if (this.value <= 1000) {
        mileage_output.innerHTML = "<br>Around " + this.value + " miles"
    }

    else {
        mileage_output.innerHTML = "<br>More than 1000 miles"
    }

   

});
