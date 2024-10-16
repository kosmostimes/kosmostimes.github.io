<?php
include "config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Your-Site.com &ndash; Status</title>
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <main id="status">
        <div class="content">
            <header>
                <img src="assets/images/logo.png">
            </header>
            <div class="text">
                <span class="big">Your-Site.com &ndash; Status</span><br>
                <span>Status of all our services in one place.</span>
            </div>
            <div class="container d-flex">
                <div id="loader" role="status" class="spinner-center spinner-border spinlod">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="content">
                    <p class="text-center">Websites</p>
                    <div id="websites" class="mb-4"></div>
                    <p class="text-center">Servers</p>
                    <div id="servers"></div>
                </div>
            </div>
            <div class="text">
                <p class="mb-2">Another refresh in <span id="refresh"></span> seconds</p>
			    <p>&copy; <span class="year"></span> Your-Site.com &ndash; | &ndash; All rights reserved.</p>
		    </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        $('.year').text(new Date().getFullYear());
    </script>
    <script>
        $( "#loader" ).show();
        $( "#content" ).hide();
        loadServers();

        function loadServers() {
            $.get( window.location.href+"api.php", function( data ) {
                var websites = '';
                for (i=0; i < data[0]['websites'].length; i++) {
                    var status = '';
                    if (data[0]['websites'][i].status === "1") {
                        status = '<?php echo $types["Online"] ?>';
                    } else if (data[0]['websites'][i].status === "0") {
                        status = '<?php echo $types["Offline"] ?>';
                    } else if (data[0]['websites'][i].status === "2") {
                        status = '<?php echo $types["Maint"] ?>';
                    } else {
                        status = "Error";
                    }
                    websites += '<div class="row no-gutters"><div class="col-6"><span>' + data[0]['websites'][i].website + '</span></div><div class="col-6">' + status + '</div></div>';
                }
                $( "#websites" ).html( websites );

                var servers = '';
                for (i=0; i < data[0]['servers'].length; i++) {
                    var status = '';
                    if (data[0]['servers'][i].status === "1") {
                        status = '<?php echo $types["Online"] ?>';
                    } else if (data[0]['servers'][i].status === "0") {
                        status = '<?php echo $types["Offline"] ?>';
                    } else if (data[0]['servers'][i].status === "2") {
                        status = '<?php echo $types["Maint"] ?>';
                    } else {
                        status = "Error";
                    }
                    servers += '<div class="row no-gutters"><div class="col-6"><span>' + data[0]['servers'][i].server + '</span></div><div class="col-6">' + status + '</div></div>';
                }
                $( "#servers" ).html( servers );
                $( "#loader" ).hide();
                $( "#content" ).show();
                $( ".container" ).removeClass('d-flex');
            });
        }

        var refresh = 30;
        setInterval(function () {
            refresh = refresh - 1;
            $( "#refresh" ).text( refresh );
            if (refresh < 1) {
                refresh = 30;
                loadServers();
            }
        }, 1000);

    </script>
</body>

</html>