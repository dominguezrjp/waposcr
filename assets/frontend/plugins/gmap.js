(function () {
    var locatorSection = document.getElementById("locator-input-section")
    var input = document.getElementsByClassName("autocomplete");
    var gmap = document.getElementById("gmapKey");
    let gmapKey = gmap.getAttribute("href"); 


    function init() {
        var locatorButton = document.getElementById("locator-button");
        locatorButton.addEventListener("click", locatorButtonPressed)

    }

    function locatorButtonPressed() {
        locatorSection.classList.add("loading")

        navigator.geolocation.getCurrentPosition(function (position,showError) {
                getUserAddressBy(position.coords.latitude, position.coords.longitude)
            },
            function (error) {
                locatorSection.classList.remove("loading")
                alert("The Locator was denied :( Please add your address manually")
            })
    }

    function getUserAddressBy(lat, long) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var address = JSON.parse(this.responseText)
             console.log(address);   
                setAddressToInputField(address.results)
                // setAddressToInputField(address.results[0].formatted_address)

            }
        };
        xhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + long + "&key="+ gmapKey, true);
        xhttp.send();
    }

    function setAddressToInputField(address) {
        var ad = '';
        address.forEach((element) => {
            $('.es-list, .autocomplete').append(`
                <li>${element.formatted_address}</li>
            `);
             
        });

        $(".autocomplete").val(address[0].formatted_address);
         input.value = address[0].formatted_address;
        // input.value = address
        locatorSection.classList.remove("loading")
    }

    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(45.4215296, -75.6971931),
    );

    var options = {
        bounds: defaultBounds
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);


    init()

    $(document).on('click','.es-list li',function(){
    	var val = $(this).text();
    	$('.autocomplete').val(val);
    });


    function showError(error) {
    var x = $('#editable-select');
      switch(error.code) {
        case error.PERMISSION_DENIED:
        x.innerHTML = "User denied the request for Geolocation."
        break;
        case error.POSITION_UNAVAILABLE:
        x.innerHTML = "Location information is unavailable."
        break;
        case error.TIMEOUT:
        x.innerHTML = "The request to get user location timed out."
        break;
        case error.UNKNOWN_ERROR:
        x.innerHTML = "An unknown error occurred."
        break;
    }}
    
})();
