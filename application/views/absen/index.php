<!DOCTYPE html>
<html lang="en">
    <head>
        <meta/>
        <meta/>
        <meta/>
        <title>Geolocation</title>
    </head>
    <body>
        <button id="getlocation">Get Location</button>
    </body>

    <script>
        const getLocation = document.getElementById("getlocation");

        getLocation.addEventListener('click', evt=>{
            if('geolocation' in navigator){
                navigator.geolocation.getCurrentPosition(position=>{
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    console.log(latitude,longitude)
                },error=>{
                    console.log(error.code)
                })
            }else{
                console.log("Not Supported");
            }
        });

    </script>
</html>

