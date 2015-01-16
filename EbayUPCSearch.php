<?php
	/**************************************************************
	Developer: Rutherford Le
	Project: Code Sample
	Core language: PHP, HTML
	System developed: Windows 7
	Purpose: Code sample will search by UPC code and return title 
	and price
	Comments: Log, try/catch left out. Usually I would create a log 
	file but errors may occur if permissions are not set.
	**************************************************************/
	
	//error_reporting(E_ALL); //Error reporting 
	
	if(isset($_POST['upc']))
		$upc = $_POST['upc'];
	?>

	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>GetProdSample</title>
		</head>
		<body>
			<form action="#" method="post">
			<table cellpadding="2" border="0">
				<tr>
					<th>UPC Code</th>
				</tr>
				<tr>
					<td><input type="text" name="upc" value="<?php if(isset($upc)) echo htmlspecialchars($upc) ?>"></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Search"></td>
				</tr>
			</table>
			</form>
			<hr/>
		</body>
	</html>

	<?php
	if(isset($upc)){
		//Credentials should be in a different file,but place here to demonstrate example on one PHP file

		$url = 'http://open.api.ebay.com/shopping';  // Shopping
		$responseEncoding = 'XML';   // Format of the response
		$searchType = 'UPC';
		$version = '525';   
		$appID   = 'AddAppIDHere'; 

		$upc  = urlencode (utf8_encode($_POST['upc']));  //753759077600

		getProdSample($upc);

	} // if

	function getProdSample($upc) {
		global $url, $responseEncoding, $version, $appID, $searchType;
		$results = '';

		$apicall = "$url?callname=FindProducts"
			. "&version=$version"
			. "&siteid=0"
			. "&appid=$appID"
			. "&ProductID.type=$searchType"
			. "&responseencoding=$responseEncoding"
			. "&ProductID.Value=$upc&"
			. "IncludeSelector=Items";

		//Simple XML Request-response
		$responseXML = simplexml_load_file($apicall);

		if($responseXML){
			foreach($responseXML->ItemArray->Item as $response){
				
				echo '<span><b>Title: </b></span>'.$response->Title;
				echo '<br />';
				echo '<span><b>Price: </b></span>'.$response->ConvertedCurrentPrice;
				echo '<hr>';

			} 
		}
	}
	?>
