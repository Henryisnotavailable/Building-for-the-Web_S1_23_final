//I'll need to use an API call to fetch the current user's bikes
//For now, placeholder JSON array of expected values



function display_bike_info(current_ad_jason) {
    document.getElementById("AdvertTitle").innerText = current_ad_jason.bike_ad_name;
    document.getElementById("BikeModel").innerText = current_ad_jason.bike_model;
    document.getElementById("PriceRange").innerText = `£${current_ad_jason.lower_asking_price} - ${current_ad_jason.upper_asking_price}`;
    document.getElementById("BikeQuality").innerText = current_ad_jason.bike_quality;
    document.getElementById("BikeYearOfBirth").innerText = current_ad_jason.bike_birthday;
    document.getElementById("BikeColour").style.backgroundColor = current_ad_jason.bike_colour_code;
    document.getElementById("BikeDescription").innerText = current_ad_jason.description;
}

function setup_slideshow(api_data) {

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
    display_bike_info(current_ad_jason)
}

//Placeholder for API data to fetch random bikes
var api_data = [
    {
        "bike_id": "0xdeadbeef",
        "bike_ad_name": "Greg's Bike for sale",
        "bike_model": "Brompton Mk1",
        "lower_asking_price": "1000",
        "upper_asking_price": "2000",
        "bike_quality": "Poor",
        "bike_birthday": "2023",
        "image_url": "./assets/images/bike_1.jpg",
        "bike_colour_code": "#1F00A2",
        "description": "This is a stellar bike, that's got 1 mile"
    },
    {
        "bike_id": "0xcoffee",
        "bike_ad_name": "Greg's 2nd Bike for sale",
        "bike_model": "Brompton Mk2",
        "lower_asking_price": "1400",
        "upper_asking_price": "2500",
        "bike_quality": "Excellent",
        "bike_birthday": "2024",
        "image_url": "./assets/images/bike_2.jpg",
        "bike_colour_code": "#000000",
        "description": "LALAL"
    },
    {
        "bike_id": "0xfeedbeef",
        "bike_ad_name": "Greg's Bike for sale",
        "bike_model": "Brompton Mk1",
        "lower_asking_price": "1000",
        "upper_asking_price": "2000",
        "bike_quality": "Poor",
        "bike_birthday": "2023",
        "image_url": "./assets/images/bike_1.jpg",
        "bike_colour_code": "#169201",
        "description": "This is a stellar bike, that's got 1 mile"
    }
]

function goToSlide(n) {
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

setup_slideshow(api_data);


document.getElementById("prev_button").addEventListener("click",function(e) {
    previous_slide();
});

document.getElementById("next_button").addEventListener("click",function(e) {
    next_slide();
});

//If user searches, fetch new data based on the query, then setup the slideshow again
document.getElementById("search_button").addEventListener("click",function (e) {

    e.preventDefault();
    api_data = [
        {
            "bike_id": "AAAAAAAA",
            "bike_ad_name": "1",
            "bike_model": "Brompton Mk1666",
            "lower_asking_price": "666",
            "upper_asking_price": "6666",
            "bike_quality": "Poor",
            "bike_birthday": "2023",
            "image_url": "./assets/images/bike_1.jpg",
            "bike_colour_code": "#1F00A2",
            "description": "This is a stellar bike, that's got 1 mile"
        },
        {
            "bike_id": "AAAAAAAA",
            "bike_ad_name": "2",
            "bike_model": "Brompton Mk1666",
            "lower_asking_price": "666",
            "upper_asking_price": "6666",
            "bike_quality": "Excellent",
            "bike_birthday": "2024",
            "image_url": "./assets/images/bike_2.jpg",
            "bike_colour_code": "#000000",
            "description": "LALAL"
        },
        {
            "bike_id": "AAAAAAAA",
            "bike_ad_name": "3",
            "bike_model": "Brompton Mk1666",
            "lower_asking_price": "666",
            "upper_asking_price": "6666",
            "bike_quality": "Poor",
            "bike_birthday": "2023",
            "image_url": "./assets/images/bike_1.jpg",
            "bike_colour_code": "#169201",
            "description": "This is a stellar bike, that's got 1 mile"
        }
    ];


    if (api_data.length == 0) {
        document.getElementById("search_value").value = "No results!"
    }
    else {
        document.getElementById("search_value").value = `${api_data.length} results found!`
    setup_slideshow(api_data);
    }

})

