//I'll need to use an API call to fetch the current user's bikes
//For now, placeholder JSON array of expected values



//Placeholder for API data



var temp_fetched_data = [
    {
        "bike_id":"0xdeadbeef",
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
        "bike_id":"0xcoffee",
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
        "bike_id":"0xfeedbeef",
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

//Setup the slideshow
var slideshow = document.getElementById("bike_slides");
//If there are no results
if (temp_fetched_data.length != 0) {

    for (var i = 0; i < temp_fetched_data.length; i++) {


        slideshow.innerHTML += `<a href="./a_bike_owner.html?id=${temp_fetched_data[i].bike_id}"><img class="mySlides" src="${temp_fetched_data[i].image_url}" id="slideImg"></img></a>`;
        
        
    }

    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        //Get each slide
        var all_slides = document.getElementsByClassName("mySlides");
        //If we've reached the end, then loop back to the first one
        if (n > all_slides.length) { slideIndex = 1 }
        //If we go backwards from the start, go to the end
        if (n < 1) { slideIndex = all_slides.length };
        //Loop over all the elements and set the display to none
        for (i = 0; i < all_slides.length; i++) {
            all_slides[i].style.display = "none";
        }
        //Set the selected slide to visible
        all_slides[slideIndex - 1].style.display = "flex";
        let current_ad_jason = temp_fetched_data[slideIndex - 1];
        document.getElementById("AdvertTitle").innerText = current_ad_jason.bike_ad_name;
        document.getElementById("BikeModel").innerText = current_ad_jason.bike_model;
        document.getElementById("PriceRange").innerText = `£${current_ad_jason.lower_asking_price} - ${current_ad_jason.upper_asking_price}`;
        document.getElementById("BikeQuality").innerText = current_ad_jason.bike_quality;
        document.getElementById("BikeYearOfBirth").innerText = current_ad_jason.bike_birthday;

        document.getElementById("BikeColour").style.backgroundColor = current_ad_jason.bike_colour_code;


        document.getElementById("BikeDescription").innerText = current_ad_jason.description;



    }
}

else {
    slideshow.innerHTML = "<h1>No results!</h1><p>You haven't submitted any bikes for sale, try going to <a href='./sell.html'>sell</a>.</p>"
    document.getElementById("AdvertTitle").innerText = "No result";
    document.getElementById("BikeModel").innerText = "No result";
    document.getElementById("PriceRange").innerText = "No result";
    document.getElementById("BikeQuality").innerText = "No result";
    document.getElementById("BikeYearOfBirth").innerText = "No result";
    document.getElementById("BikeColour").innerText = "No result";
    document.getElementById("BikeDescription").innerText = "No result";
}