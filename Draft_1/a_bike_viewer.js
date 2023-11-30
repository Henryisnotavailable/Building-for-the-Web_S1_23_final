//Slider Values need to be set at the start

var slider = document.getElementById("bike_quality");
var output = document.getElementById("bike_slider_value");

var mileage_slider = document.getElementById("bike_mileage");
var mileage_output = document.getElementById("bike_mileage_span");

//Just a switch statement to return a value and a colour like, (Broken, darkred)
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
//Just a switch statement to return a value and a colour like, (Around X miles, blue)
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

//Initial DOM setup
//Setup the slider colours, based on their values
let [sliderValue,sliderColour] = decide_slider_colour(slider.value);
output.innerHTML = sliderValue;
output.style.color = sliderColour;
slider.style.accentColor =sliderColour;


let [mileage_slider_value,mileage_slider_colour] = decide_mileage_slider_colour(mileage_slider.value);
mileage_output.innerHTML = mileage_slider_value;
mileage_output.style.color = mileage_slider_colour;
mileage_slider.style.accentColor =mileage_slider_colour;

