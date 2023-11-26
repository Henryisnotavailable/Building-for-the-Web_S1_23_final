//I'll need to use an API call to fetch the current user's bikes
//For now, placeholder JSON array of expected values



//Set API data to blank first
let api_data = [];


//Fetch the bikes' details
async function getOwnedBikes() {
    const response = await fetch("./api/bike_owner_info.php");

    return response.json()
}



function display_bike_info(current_ad_jason) {
    console.log(current_ad_jason);
    document.getElementById("AdvertTitle").innerText = current_ad_jason.bike_ad_name;
    document.getElementById("BikeModel").innerText = current_ad_jason.bike_model;
    document.getElementById("PriceRange").innerText = `£${current_ad_jason.lower_asking_price} - ${current_ad_jason.upper_asking_price}`;
    document.getElementById("BikeQuality").innerText = current_ad_jason.bike_quality;
    document.getElementById("BikeYearOfBirth").innerText = current_ad_jason.bike_birthday;
    document.getElementById("BikeColour").style.backgroundColor = current_ad_jason.bike_colour_code;
    document.getElementById("BikeDescription").innerText = current_ad_jason.description;
}

async function setup_slideshow() {
    //Wait for the API response
    api_data = await getOwnedBikes();
    //Once loaded, set listeners on the arrow buttons
    enable_controls();
    
    if (api_data.length == 0) {
        
        alert("Sorry, there were no results from that search.")
        document.getElementById("AdvertTitle").innerText = "No results...";
        document.getElementById("BikeModel").innerText = "No results...";
        document.getElementById("PriceRange").innerText = "No results...";
        document.getElementById("BikeQuality").innerText = "No results...";
        document.getElementById("BikeYearOfBirth").innerText = "No results...";
        document.getElementById("BikeColour").style.backgroundColor = "red";
        document.getElementById("BikeDescription").innerText = "No results...";
        return
    }

    slideshow = document.getElementById("bike_slides");
    //This clears the slideshow, to get rid of any old searches
    while(slideshow.firstChild) {
        slideshow.removeChild(slideshow.firstChild)
    }

    //Load the images into the DOM, but keep them hidden.
    if (api_data.length > 0) {

        for (var i = 0; i < api_data.length; i++) {


            slideshow.innerHTML += `<a href="./a_bike_viewer.html?id=${api_data[i].bike_id}"><img class="mySlides" src="${api_data[i].image_url}" id="slideImg"></img></a>`;


        }
    }
    //Get each slide
    var all_slides = document.getElementsByClassName("mySlides");
    //Set the first slide to visible, mySlides has a display:none, but showing has a display:flex.
    all_slides[0].className = "mySlides showing"
    //Get the first bike's information
    let current_ad_jason = api_data[0];
    //Display the info to the user.
    display_bike_info(current_ad_jason);

    return api_data;
}

//Placeholder for API data to fetch random bikes


async function goToSlide(n) {
    //Get all the slides
    let all_slides = document.getElementsByClassName("mySlides");
    //Set the previously visible slide to hidden
    all_slides[currentSlide].className = 'mySlides';
    //Get the current slide (loops back to 0 if greater than total slides)
	currentSlide = (n+all_slides.length)%all_slides.length;
    //Set the current slide to visible
    all_slides[currentSlide].className = "mySlides showing"
    //Display the current bike's data to the user
    display_bike_info(api_data[currentSlide]);
}

//Called when next button is clicked
function next_slide() {
    goToSlide(currentSlide+1);
}

function previous_slide() {
    goToSlide(currentSlide-1);
}




//Start the slide at 0
var currentSlide = 0;

var slideshow = document.getElementById("bike_slides");


setup_slideshow();

function enable_controls() {

document.getElementById("prev_button").addEventListener("click",function(e) {
    previous_slide();
});

document.getElementById("next_button").addEventListener("click",function(e) {
    next_slide();
});

}