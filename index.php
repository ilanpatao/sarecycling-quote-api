<!--/////////////////////////////
// Written by: Ilan Patao //
// ilan@dangerstudio.com //
//////////////////////////-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SA Recycling Quote REST API Example</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://autotrader-api.herokuapp.com/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://autotrader-api.herokuapp.com/css/mdb.min.css" rel="stylesheet">
    <!-- BST core CSS -->
    <link href="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.css" rel="stylesheet">
</head>

<body>


    <div class="container" style="margin-top:25px;">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">SA Recycling Quote REST API Example</h1>

            <h5 class="animated fadeIn mb-3"></h5>

            <p class="animated fadeIn text-muted"></p>	
			

		<div class="table-responsive" id="results">
			<div class="sm-form">
				<form name="vupdate" id="vupdate" method="post" action="">
				  <div class="form-row">
					<div class="col-auto">
					  <label class="sr-only" for="inlineFormInput">Year</label>
					  <input type="text" class="form-control mb-2 mb-sm-0" name="year" placeholder="Vehicle Year" value="">
					</div>
					<div class="col-auto">
					  <label class="sr-only" for="inlineFormInput">Make</label>
					  <input type="text" class="form-control mb-2 mb-sm-0" name="make" placeholder="Vehicle Make" value="">
					</div>
					<div class="col-auto">
					  <label class="sr-only" for="inlineFormInput">Modal</label>
					  <input type="text" class="form-control mb-2 mb-sm-0" name="model" placeholder="Vehicle Model" value="">
					</div>
					<div class="col-auto">
					  <label class="sr-only" for="inlineFormInput">Zipcode</label>
					  <input type="text" class="form-control mb-2 mb-sm-0" name="zip" placeholder="Zipcode" value="">
					</div>
					<div class="col-auto">
					  <button type="submit" class="btn btn-success">Update Vehicle</button>
					</div>
				  </div>
				</form>
			</div>

			<div style="margin-top:100px;">	
			<?PHP
			// Get form info
			$year = ucfirst($_POST['year']);
			$make = ucfirst($_POST['make']);
			$model = ucfirst($_POST['model']);
			$zip = $_POST['zip'];
			
			if (empty($make) || empty($model) || empty($zip) || empty($year)){
				$year = "2001";
				$make = "Honda";
				$model = "Accord";
				$zip = "90210";
			}
			sleep(2);
			// Let's make the call and grab the data
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://www.sarecycling.com/wp-admin/admin-ajax.php?action=gotscrap_get_quote&year=".$year."&make=".$make."&model=".$model."&zip=".$zip,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HEADER => 0,
			  CURLOPT_FRESH_CONNECT => 1,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"accept: */*",
				"referer: http://www.sarecycling.com/public/recycle-old-cars/",
				"connection: keep-alive",
				"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
				"x-requested-with: XMLHttpRequest"
			  ),
			));

			$results = curl_exec($curl);
			$err = curl_error($curl);
			$info = curl_getinfo($curl);
			$jdata = json_decode($results);
			curl_close($curl);
			
	
			$status = $jdata->success;
			if ($status == 1){
				$towprice = $jdata->data->prices->tow;
				$dropoffprice = $jdata->data->prices->dropoff;
				echo "<div class='row'>
					<div class='col-sm-6'>
						<h3>SA will tow and pay</h3>
						<h1 class='text-success'>$".$towprice."</h1>
					</div>
					
					<div class='col-sm-6'>
						<h3>If you drop it off SA will pay</h3>
						<h1 class='text-success'>$".$dropoffprice."</h1>
					</div>
				</div>";
			} else {
				echo "<div class='row'>
					<div class='col-sm-12'>
						<center>
							Sorry, SA does offer quotes in this area or the information provided is inaccurate.
						</center>
					</div>";			
			}
				echo "<div class='col-sm-12'>
						<p>&nbsp;</p>Json Output:<br>
						<textarea cols='5' rows='5' style='height:50px;'>".$results."</textarea>
						<small> It took ". $info['total_time'] . " seconds to send a request to " . $info['url'] . "</small></p>
					</div>";
			?>
			</div>
		</div>
		

			<div style="margin-top:150px;">
				<center>
						<p class="animated fadeIn text-muted">
							Note that SA Recycling covers the state of CA and some neighboring states, but does not stretch out too far from the west coast.</b>.
						</p>
									
					<br>Written by: <a href="mailto:ilan@dangerstudio.com" style="text-decoration:none;">Ilan Patao</a> - 09/18/2017
					
				</center>
			</div>
        </div>
    </div>
    <!-- JQuery -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/mdb.min.js"></script>
    <!-- BST core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.js"></script>
</body>
<script>
$(document).ready(function(){
});
</script>
</html>
