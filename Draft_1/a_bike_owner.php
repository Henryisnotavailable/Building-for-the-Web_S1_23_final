<?php

session_start();


if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}



?>





<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./a_bike_owner.css">
    </link>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Bike Info (Owner)</p>
                </div>
            </div>
            <div id="navbarWrapper">
                <nav>
                    <ul>
                        <li><a href="./index.php"><img src="./assets/icons/home_icon.png" />Home</a></li>
                        <li><a href="./my_account.php"><img
                                    src="./assets/icons/3994415_account_avatar_person_profile_user_icon.png" />My
                                Account</a></li>
                        <li><a href="./sell.php"><img
                                    src="./assets/icons/4634978_pig_coin_financial_money_icon.png" />Sell!</a>
                        </li>
                        <li><a href="./my_bikes.php"><img src="./assets/icons/352313_bike_directions_icon.png" />My
                                Bikes</a></li>
                                <li><a href="./browse_bikes.php"><img src="./assets/icons/4781848_bag_buy_cart_ecommerce_shop_icon.png" />Browse Bikes</a>
                                </li>
                        <li><a href="./about_auth.php"><img src="./assets/icons/430101_help_question_icon.png" />About Us</a>
                        </li>
                        
                        <li id="placeholder"><a></a></li>
                        <li id="logout_button"><a href="./logout.php"><img
                                    src="./assets/icons/2931185_door_enter_exit_leave_out_icon(1).png" />Logout</a>
                        </li>
                    </ul>
                </nav>


            </div>
        </header>
        <main>
            <div class="page-wrapper">
                <div class="row">

                    <div class='right-column'>
                        <div class="main_body_container">
                            <h1><u>Bike Info</u></h1>

                            <form id="sell_form" action="a_bike_owner.html"
                                method="post" enctype="multipart/form-data">
                                <div class="form_main">







                                    <div class="input_row">
                                        <div class="input_col" id="title_container">
                                            <h1>Advert Title</h1>
                                            <div id="advert_title_container">
                                                <h3 id="current_title">Something Witty</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input_row" id="input_row_for_bike_image">
                                        <div class="input_col" id="bike_image_column">
                                            
                                            <img id="current_bike_img" src="./assets/images/bike_2.jpg"></img>
                        
                                            <p id="price_range">Selling for between <b>£<span id="lower_price">1000</span></b>
                                                - <b>£<span id="upper_price">2000</span></b></p>
                                        </div>
                                    </div>


                                    <div class="input_row">
                                        <div class="input_col" id="bike_desc_col">
                                            <h2>Short Description</h2>
                                            <div class="bike_desc">
                                                <p id="current_bike_desc"><i>This is a super nice bicycle, sold for $1000000 at auction, with less than 1 mile</i></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col" id="bike_model_col">
                                            <h2>Bike model</h2>
                                            <div class="bike_model_container">
                                                <p id="current_bike_model">Helicopter</p>
                                            </div>
                                        </div>


                                    </div>

                                    <!--This will be changed to display once EDIT is pressed-->
                                    <div class="input_row" style="display: none;" id="price_row">
                                        <div class="input_col">
                                            <label for="asking_price_lower">Select lower asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="1000" step="10"
                                                id="asking_price_lower" name="asking_price_lower" autocomplete="off"
                                                readonly></input>

                                        </div>

                                        <div class="input_col">
                                            <label for="asking_price_upper">Select upper asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="2000" step="10"
                                                id="asking_price_upper" name="asking_price_upper" autocomplete="off"
                                                readonly></input>
                                        </div>
                                    </div>
                                    <!--End of hidden row before EDIT is pressed-->



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_quality">Bike quality: <span
                                                    id="bike_slider_value">Ok</span></label>
                                            <input id="bike_quality" autocomplete="off" type="range" min="0" max="5"
                                                step="1" value=3 class="slider" name="bike_quality" disabled></input>


                                        </div>

                                        <div class="input_col" id="bike_birthday_col">
                                            <h2>The year the bike was made</h2>
                                            <div class="bike_birthday_container">
                                                <p id="current_birthday">2025</p>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_mileage">Select bike mileage: <span id="bike_mileage_span">
                                                    < 500 miles</span></label>
                                            <input id="bike_mileage" autocomplete="off" type="range" min="0" max="1100"
                                                step="100" value=300 class="slider" name="bike_mileage"
                                                disabled></input>


                                        </div>

                                        <div class="input_col" id="seat_col">
                                            <h2>Number of seats</h2>
                                            <div class="seat_container">
                                                <p id="seat_value">2</p>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="input_row">


                                        <div class="input_col" id="FaveColourBike">
                                            <h2>The Bike's Colour</h2>
                                            <input type="color" value="#e62739" id="favourite_bike_colour"
                                                autocomplete="off" name="favourite_bike_colour" autocomplete="off"
                                                disabled></input>
                                        </div>

                                        <div class="input_col" id="electric_row">
                                            <h2>Is the bike electric?</h2>
                                            <input id="is_electric" autocomplete="off" type="checkbox" disabled
                                                name="is_electric" checked><label for="is_electric"></label></input>


                                        </div>
                                    </div>

                                    <div class="input_row" id="other_media_row">

                                        <div class="input_col" id="other_media_column">
                                            <h2>Other media of the Bike</h2>
                                            <img
                                                src="https://gifdb.com/images/high/three-floating-fat-cats-3m2l3a79v6bght5d.gif" id="current_other_media_img"/>

                                        </div>
                                    </div>





                                    <div class="button_row">
                                        <button class="custom_button" id="delete_bike_button" type="reset">DELETE
                                            BIKE</button>
                                        <button class="custom_button" id="edit_button" type="submit">Edit
                                            Details</button>


                                    </div>

                                    <div class="input_row" id="button_row">

                                        <button class="custom_button" id="sell_button" type="submit">Save
                                            Changes</button>

                                        <button class="custom_button" id="clear_button" type="reset">Clear</button>

                                    </div>
                                </div>
                            </form>






                        </div>
                    </div>
                    <div class="left-column">
                        <h1>Seller Details</h1>
                        <br>
                        <div class="user_picture"><img
                                src="https://static.vecteezy.com/system/resources/previews/008/530/693/original/white-cat-transparent-png.png" />
                        </div>
                        <p id="username_line">Username - <b id="username_value">Mr Byk3</b></p>
                        <p id="registered_line">Registered - <b id="registered_date_value">01/01/1970</b></p>
                        <p id="mobile_line">Phone Number - <b id="bikes_sold_value">09884204998</b></p>
                        <p id="pronouns_line">Preferred Pronouns - <b id="pronouns_value">he/him</b></p>
                        <p id="email_line">Email - <b id="email_value">byk3r_br34k3r@protonmail.com</b></p>
                        <p id="favourite_bike_line">Favourite Bike - <b id="favourite_bike_value">The 270th Brompton
                                Mark 1</b></p>
                        <p id="bio_line">Bio - <br><i id="bio_value">I like taking long walks with my bike, but I need
                                the money, so I have to pimp it out :(</i></p>
                    </div>
                </div>

        </main>
        <footer>
            <div class="social_media_row">
                <p><b>Follow our social media accounts!</b></p>


                <a href="https://twitter.com"><img
                        src="./assets/icons/twitter.webp"
                        id="twitter" /></a>

                <a href="https://instagram.com"><img
                        src="./assets/icons/instagram-white-icon.webp" /></a>

                <a href="https://example.com"><img
                        src="./assets/icons/tiktok.png" /></a>
                <a href="https://old.com"><img
                        src="./assets/icons/facebook-icon-white-png.png" /></a>

            </div>
        </footer>
    </article>
    <script src="./a_bike_owner.js"></script>
</body>

</html>