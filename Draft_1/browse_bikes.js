//I'll need to use an API call to fetch the current user's bikes
//For now, placeholder JSON array of expected values



async function search_bike(query) {

    let response = await fetch(`./api/bike_search.php?query=${encodeURIComponent(query)}`);
    return response.json()
}


function display_bike_info(current_ad_jason) {
    document.getElementById("AdvertTitle").innerText = current_ad_jason.bike_ad_name;
    document.getElementById("BikeModel").innerText = current_ad_jason.bike_model;
    document.getElementById("PriceRange").innerText = `£${current_ad_jason.lower_asking_price} - ${current_ad_jason.upper_asking_price}`;
    document.getElementById("BikeQuality").innerText = current_ad_jason.bike_quality;
    document.getElementById("BikeYearOfBirth").innerText = current_ad_jason.bike_birthday;
    document.getElementById("BikeColour").style.backgroundColor = current_ad_jason.bike_colour_code;
    document.getElementById("BikeDescription").innerText = current_ad_jason.description;
}

function setup_slideshow() {

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


            slideshow.innerHTML += `<a href="./a_bike_viewer.php?id=${api_data[i].bike_id}"><img class="mySlides" src="${api_data[i].image_url}" id="slideImg"></img></a>`;


        }
    }
    //Get each slide
    var all_slides = document.getElementsByClassName("mySlides");
    //Set the first slide to visible, mySlides has a display:none, but showing has a display:flex.
    all_slides[0].className = "mySlides showing"
    //Get the first bike's information
    //Go to the first slide, and display its information
    currentSlide = 0;
    goToSlide(currentSlide)
}

//Placeholder for API data to fetch random bikes


function goToSlide(n) {
    //Get all the slides
    let all_slides = document.getElementsByClassName("mySlides");
    //Set the previously visible slide to hidden
    all_slides[currentSlide].className = 'mySlides';
    //Get the current slide (loops back to 0 if greater than total slides)
	currentSlide = (n+all_slides.length)%all_slides.length;
    //Set the current slide to visible
    all_slides[currentSlide].className = "mySlides showing";
    console.log(api_data[currentSlide]);
    //Set the value of current slide of total (e.g. slide 1 of 5)
    document.getElementById("slide_count").innerText = `${currentSlide+1} of ${all_slides.length}`;
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
//api_data is defined in the PHP file, within the script declaration
setup_slideshow(api_data);


document.getElementById("prev_button").addEventListener("click",function(e) {
    previous_slide();
});

document.getElementById("next_button").addEventListener("click",function(e) {
    next_slide();
});

//If user searches, fetch new data based on the query, then setup the slideshow again, the user doesn't need to reload the entire page
document.getElementById("search_button").addEventListener("click",async (e) => {

    e.preventDefault();

    let search_value = document.getElementById("search_value").value;
    let search_error = document.getElementById("search_error_msg");
    //Validate input
    if (search_value.length == 0) {
        search_error.innerText = "!!! Search cannot be empty !!!";
        return false;
    }

    else if (search_value.length > 50) {
        search_error.innerText = "!!! Search cannot be more than 50 characters !!!";
        return false;
    }


    api_data = await search_bike(search_value);

    console.log(api_data);
    //Erorrs on output
    if (api_data.length == 0) {
        //document.getElementById("search_value").value = "No results!";
        search_error.innerText = "!!! No results, showing previous !!!";
    }
    else {
        //document.getElementById("search_value").value = `${api_data.length} results found!`
        if (api_data.length == 1) {
            search_error.innerText = `1 result found!`;
        }
        else {
            search_error.innerText = `${api_data.length} results found!`;
        }
        
        slideshow = document.getElementById("bike_slides");
        //This clears the slideshow, to get rid of any old searches
        while(slideshow.firstChild) {
            slideshow.removeChild(slideshow.firstChild)
        }
        
        setup_slideshow(api_data);
        
    }
    


})

