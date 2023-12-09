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




    function setup_edit(e) {
        
            
            if (e !== null){
            e.preventDefault();
            }

            //Get any errors, to set in the edit
            let ad_title_error = document.getElementById("ad_title_error_div").innerText || "";
            let bike_image_error = document.getElementById("bike_image_error_div").innerText|| "" ;
            let bike_desc_error = document.getElementById("bike_desc_error").innerText|| "";
            let bike_model_error = document.getElementById("bike_model_error_div").innerText|| "";
            let lower_price_error = document.getElementById("lower_price_error_div").firstChild.innerText|| "";
            let upper_price_error = document.getElementById("upper_price_error_div").firstChild.innerText|| "";
            let bike_quality_error = document.getElementById("bike_quality_error_div").firstChild.innerText|| "";
            let bike_date_of_birth_error = document.getElementById("bike_date_of_birth_error").innerText|| "";
            let bike_mileage_error = document.getElementById("bike_mileage_error_div").firstChild.innerText|| "";
            let bike_seats_error = document.getElementById("bike_seats_error_div").innerText|| "";
            let favourite_bike_colour_error = document.getElementById("favourite_bike_colour_error").firstChild.innerText|| "";
            let bike_electric_error = document.getElementById("bike_electric_error_div").firstChild.innerText|| "";
            let other_media_error = document.getElementById("other_media_error").innerText|| "";



            //Make the title editable (but set the value to what it was before)
            let current_title = document.getElementById("current_title").innerText;
            let advert_title = document.getElementById("title_container");
            advert_title.innerHTML = '<label for="advert_title">Title your advert</label>'
            advert_title.innerHTML += `<input type="text" value="${current_title}" id="advert_title" name="advert_title" autocomplete="off" required></input>`
            advert_title.innerHTML += `<div id="ad_title_error_div" class="error_div"><p>${ad_title_error}</p></div>`;
    
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
            bike_image_column.innerHTML += `<div id='current_bike_img_container'><img src='${current_bike_img_src}'/ style='max-width:180px;max-height:180px'><p>Current Image</p></div>`;
            bike_image_column.innerHTML += '<input type="file" id="bike_pic" name="bike_pic" autocomplete="off" accept="image/gif, image/jpg, image/jpeg, image/png,image/webp"></input>';
            bike_image_column.innerHTML += `<div id="bike_image_error_div" class="error_div"><p>${bike_image_error}</p></div>`;
            //bike_image_column.innerHTML += `<img id="current_bike_img" src="${current_bike_img_src}"/>`;
            
    
            //Edit the description, to make it editable
            let bike_desc = document.getElementById("bike_desc_col");
            let current_bike_desc = document.getElementById("current_bike_desc").innerText;
            
            bike_desc.innerHTML = '<label for="bike_desc" id="checkboxLabel">Short Description</label>';
            bike_desc.innerHTML += `<textarea id="bike_desc" name="bike_desc" autocomplete="off" required></textarea>`
            bike_desc.innerHTML += `<div id="bike_desc_error" class="error_div"><p>${bike_desc_error}</p></div>`;
            //Set the value of bike_desc to what it was before.
            document.getElementById("bike_desc").value = current_bike_desc;
            
    
    
            //Edit Bike Column to make editable, and place current value 
    
            let bike_model_col = document.getElementById("bike_model_col");
            let current_bike_model = document.getElementById("current_bike_model").innerText;
            bike_model_col.innerHTML = '<label for="bike_model">Enter the bike\'s model</label>';
            bike_model_col.innerHTML += `<input type="text" value="${current_bike_model}" id="bike_model" name="bike_model" autocomplete="off" required></input>`;
            bike_model_col.innerHTML += `<div id="bike_model_error_div" class="error_div"><p>${bike_model_error}</p></div>`;
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
            bike_birthday_col.innerHTML += `<div id="bike_date_of_birth_error" class="error_div"><p>${bike_date_of_birth_error}</p></div>`
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
            seat_col.innerHTML += `<div id="bike_seats_error_div" class="error_div"><p>${bike_seats_error}</p></div>`;
            //Enable colour picker
            document.getElementById("favourite_bike_colour").removeAttribute("disabled");
            //Enable Electric option
            document.getElementById("is_electric").removeAttribute("disabled");


            //Enable other media upload
            let other_media_column = document.getElementById("other_media_column");
            let current_other_media_img = document.getElementById("current_other_media_img");
            let tagname = current_other_media_img.tagName;
            let current_other_media_img_src = current_other_media_img.getAttribute("src");
            //bike_image_column.innerHTML = `<img id="current_bike_img" src="${current_bike_img}">`;
            //bike_image_column.innerHTML += "</img>"
    
            other_media_column.innerHTML = '<label for="other_media">Upload Other Media of Bike</label>';
            other_media_column.innerHTML += `<div id='other_media_column'><${tagname} src='${current_other_media_img_src}'/ style='max-width:180px' alt="No other media!"></${tagname}></div><p>Currently</p>`;
    
            other_media_column.innerHTML += '<input type="file" id="other_media" name="upload_media" autocomplete="off" accept="image/*, video/*"></input>';
            other_media_column.innerHTML += `<div id="other_media_error" class="error_div"><p>${other_media_error}</p></div>`;
            //Finally, change the text of the edit button to save changes
            document.getElementById("edit_button").innerText = "Save Changes";


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

    async function delete_bike(e) {

        let bike_id = document.getElementById("bike_id").value;
        //Delete the bike and wait for a response
        const response = await fetch(`./a_bike_owner.php?bike_id=${bike_id}`, {
            method: "DELETE"
        });
        //If all good, redirect and tell user bike was deleted
        if (response.status === 200) {
            window.location.href = "./index.php?msg=Bike Deleted!"
        }
        //Tell user to error out
        else {
            document.getElementById("main_error_p").innerText = "Sorry something"
        }

    }
    //Set all fields to editable
    const url_params = new URLSearchParams(window.location.search)

    //Automatically set edit mode if GET param has edit
    if (url_params.has("edit")) {
        
        setup_edit(null);
    }
    let edit_button = document.getElementById('edit_button')
    
    //edit_handler either sets the page to edit mode, or saves the changes.

    edit_button.addEventListener("click", edit_handler,false);
    //Also need to confirm deletion

    let delete_button = document.getElementById('delete_bike_button');

    delete_button.addEventListener("click", async function (e) {
        e.preventDefault();
        if (confirm("Delete The bike?")) {
            await delete_bike(e);
            return true;
        }
        return false;
    });
