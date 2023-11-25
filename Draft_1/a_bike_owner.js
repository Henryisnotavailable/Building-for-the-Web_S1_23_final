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






var temp_fetched_data = 
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
        "description": "This is a stellar bike, that's got 1 mile",
        "bike_mileage":"Around 600 miles",
        "bike_seats":"1",
        "extra_image":"./assets/images/extra_images/0xdeadbeef",
        "is_electric":"true",
        "bike_owner_id":"15125125"
    };

    function setup_edit(e) {
        
            

            e.preventDefault();
            
            //Make the title editable (but set the value to what it was before)
            let current_title = document.getElementById("current_title").innerText;
            let advert_title = document.getElementById("title_container");
            advert_title.innerHTML = '<label for="advert_title">Title your advert</label>'
            advert_title.innerHTML += `<input type="text" value="${current_title}" id="advert_title" name="advert_title" autocomplete="off" required></input>`
            
    
            //The below code overwrites the Bike's original price values, so this has to be done first
            let lower_price = document.getElementById("lower_price").innerText;
            let upper_price = document.getElementById("upper_price").innerText;

            //Edit the bike column, to add a new option to upload a new file, but show the original file
            let bike_image_column = document.getElementById("bike_image_column");
            let current_bike_img = document.getElementById("current_bike_img");
            let current_bike_img_src = current_bike_img.getAttribute("src");
            //bike_image_column.innerHTML = `<img id="current_bike_img" src="${current_bike_img}">`;
            //bike_image_column.innerHTML += "</img>"
    
            bike_image_column.innerHTML = '<label for="bike_pic">Upload Image of Bike</label>';
            bike_image_column.innerHTML += `<div id='current_bike_img_container'><img src='${current_bike_img_src}'/ style='max-width:200px'><p>Current Image</p></div>`;
    
            bike_image_column.innerHTML += '<input type="file" id="bike_pic" name="bike_pic" autocomplete="off"></input>';
            //bike_image_column.innerHTML += `<img id="current_bike_img" src="${current_bike_img_src}"/>`;
            
    
            //Edit the description, to make it editable
            let bike_desc = document.getElementById("bike_desc_col");
            let current_bike_desc = document.getElementById("current_bike_desc").innerText;
            
            bike_desc.innerHTML = '<label for="bike_desc" id="checkboxLabel">Short Description</label>';
            bike_desc.innerHTML += `<textarea id="bike_desc" name="bike_desc" autocomplete="off" required></textarea>`
            //Set the value of bike_desc to what it was before.
            document.getElementById("bike_desc").value = current_bike_desc;
    
    
            //Edit Bike Column to make editable, and place current value 
    
            let bike_model_col = document.getElementById("bike_model_col");
            let current_bike_model = document.getElementById("current_bike_model").innerText;
            bike_model_col.innerHTML = '<label for="bike_model">Enter the bike\'s model</label>';
            bike_model_col.innerHTML += `<input type="text" value="${current_bike_model}" id="bike_model" name="bike_model" autocomplete="off" required></input>`;
    
            //Make price_row displayable
    
            let price_row = document.getElementById("price_row");
            price_row.style.display = 'flex';
            //Set values of the price selector to previous values
            let asking_price_lower = document.getElementById("asking_price_lower");
            let asking_price_upper = document.getElementById("asking_price_upper");
            asking_price_lower.value = lower_price;
            asking_price_upper.value = upper_price;
            //Make sure user can interact with them
            asking_price_lower.removeAttribute("readonly");
            asking_price_upper.removeAttribute("readonly");


            //Make Bike Quality Slider Work
            //Slider is previously defined for initial setup of the slider bar's colours
            slider.removeAttribute("disabled");

            //Make fancy colours work
            //On enter, change the colour of slider
            slider.addEventListener("input", function (e) {

                let [sliderValue,sliderColour] = decide_slider_colour(this.value);
                output.innerHTML = sliderValue;
                output.style.color = sliderColour;
                slider.style.accentColor =sliderColour;
            });


            //Setup the Bike Birthday Input
            let bike_birthday_col = document.getElementById("bike_birthday_col");
            let current_birthyear = document.getElementById("current_birthday").innerText;
            
            bike_birthday_col.innerHTML = `<label for="bike_date_of_birth">The year the bike was made</label>`
            bike_birthday_col.innerHTML += `<input value=${current_birthyear} type="number" min="1817" max="2099" step="1" placeholder="2023" id="bike_date_of_birth" name="bike_date_of_birth" autocomplete="off" required></input>`
        
            //Enable the bike mileage slider

            mileage_slider.removeAttribute("disabled");
            //On sliding, change the colour of slider
            mileage_slider.addEventListener("input", function (e) {
                let [mileage_slider_value,mileage_slider_colour] = decide_mileage_slider_colour(mileage_slider.value);
                mileage_output.innerHTML = mileage_slider_value;
                mileage_output.style.color = mileage_slider_colour;
                mileage_slider.style.accentColor =mileage_slider_colour;
            });



            //Reformat HTML of seat numbers column
            let seat_col = document.getElementById("seat_col");
            let seat_value = document.getElementById("seat_value").innerText;

            seat_col.innerHTML = '<label for="bike_seats">Number of seats</label>';
            seat_col.innerHTML += `<input value=${seat_value} type="number" min="1" max="3" step="1" placeholder="1" id="bike_seats" name="bike_seats" autocomplete="off" required></input>`

            //Enable colour picker
            document.getElementById("favourite_bike_colour").removeAttribute("disabled");
            //Enable Electric option
            document.getElementById("is_electric").removeAttribute("disabled");


            //Enable other media upload
            let other_media_column = document.getElementById("other_media_column");
            let current_other_media_img = document.getElementById("current_other_media_img");
            let current_other_media_img_src = current_other_media_img.getAttribute("src");
            //bike_image_column.innerHTML = `<img id="current_bike_img" src="${current_bike_img}">`;
            //bike_image_column.innerHTML += "</img>"
    
            other_media_column.innerHTML = '<label for="bike_pic">Upload Other Media of Bike</label>';
            other_media_column.innerHTML += `<div id='other_media_column'><img src='${current_other_media_img_src}'/ style='max-width:200px'></div><p>Currently</p>`;
    
            other_media_column.innerHTML += '<input type="file" id="bike_pic" name="upload_media" autocomplete="off"></input>';

            //Finally, change the text of the edit button to save changes
            document.getElementById("edit_button").innerText = "Save Changes";


    }

    function handle_save(e) {
        e.preventDefault();
        alert("SAVING!")
    }

    //This is the handler for when the edit/save button is pressed
    //If the edit button is pressed, then it will edit, if save then it will save.
    function edit_handler(e) {
        if (document.getElementById("edit_button").innerText != "Save Changes") {
            setup_edit(e)
        }

        else {
            handle_save(e);
        }

    } 

    function delete_bike(e) {
        alert("Lol, deleting the bike then...");
    }
    //Set all fields to editable
    let edit_button = document.getElementById('edit_button')
    //edit_handler either sets the page to edit mode, or saves the changes.

    edit_button.addEventListener("click", edit_handler,false);
    //Also need to confirm deletion

    let delete_button = document.getElementById('delete_bike_button');

    delete_button.addEventListener("click", function (e) {
        if (confirm("Delete The bike?")) {
            delete_bike(e);
            return true;
        }
        return false;
    });
