<?php 

$L = 13;
$N = 3;
$prime = 7;
$indexDoubleHash = 1;

function getAddressDetail($key) {
	$keyLength = strlen($key);
	$detail = new stdClass();

	if ($keyLength > 4) {	
		$detail->length = 3;
		$detail->index = (floor($keyLength / 2)) - 1;
	} else if ($keyLength > 3) {
		$detail->length = 2;
		$detail->index = 1;
	} else if ($keyLength > 2) {
		$detail->length = 2;
		$detail->index = 0;
	} else {
		$detail->length = 1;
		$detail->index = 0;
	}

	return $detail;
}

function doubleHashing($key, $listOfRelativeAddress, $collisions) {
	global $L;
	global $prime;
	global $indexDoubleHash;

	$hash1 = $key % $L;
	$hash2 = ($prime - ($key % $prime));
	$doubleHash = ($hash1 + $indexDoubleHash * $hash2) % $L;

	end($collisions);
	$collisionIndex = key($collisions);
	$listOfRelativeAddress[$collisionIndex] = $doubleHash;

	$counts = array_count_values($listOfRelativeAddress);
	$collisions = array_filter($listOfRelativeAddress, function ($value) use ($counts) {
		return $counts[$value] > 1;
	});
	
	if (count($collisions) > 0) {
		$indexDoubleHash += 1;
		return doubleHashing($key, $listOfRelativeAddress, $collisions);
	} else {
		return $doubleHash;
	}
}


if (isset($_POST['key-1']) && isset($_POST['key-2']) && isset($_POST['key-3']) && isset($_POST['key-4']) && isset($_POST['key-5']) && isset($_POST['key-6']) && isset($_POST['key-7']) && isset($_POST['key-8']) && isset($_POST['key-9']) && isset($_POST['key-10']) ) {
	$listOfKeys = [
		$_POST['key-1'],
		$_POST['key-2'],
		$_POST['key-3'],
		$_POST['key-4'],
		$_POST['key-5'],
		$_POST['key-6'],
		$_POST['key-7'],
		$_POST['key-8'],
		$_POST['key-9'],
		$_POST['key-10'],
	];

	$listOfRelativeAddressObjects = [];
	$listOfRelativeAddress = [];

	$index = 0;
	foreach ($listOfKeys as $key) {
		$key = (int) $key;
		$squaredKey = (int) pow($key, 2);
		$addressDetail = getAddressDetail($squaredKey);
		$keyRelativeAddress = (int) substr($squaredKey, $addressDetail->index, $addressDetail->length);
		$modRelativeAddress = (int) fmod($keyRelativeAddress, $L);

		$object = new stdClass();
		$object->id = $index;
		$object->key = $key;
		$object->squaredKey = $squaredKey;
		$object->relativeAddress = $keyRelativeAddress;
		$object->finalAddress = $modRelativeAddress;

		array_push($listOfRelativeAddressObjects, $object);
		array_push($listOfRelativeAddress, $modRelativeAddress);

		$counts = array_count_values($listOfRelativeAddress);
		$collisions = array_filter($listOfRelativeAddress, function ($value) use ($counts) {
			return $counts[$value] > 1;
		});

		// Double Hash Functionality
		if (count($collisions) > 0) {
			$newRelativeAddress = doubleHashing($key, $listOfRelativeAddress, $collisions);
			end($collisions);
			$collisionIndex = key($collisions);
			$listOfRelativeAddress[$collisionIndex] = $newRelativeAddress;
		}

		// echo "==================================== <br>";
		// echo "INITIAL KEY: $key <br>";
		// echo "SQUARED KEY: $squaredKey <br>";
		// echo "RELATIVE ADDRESS: $keyRelativeAddress <br>";		
		// echo "MOD: $modRelativeAddress <br>";
		// echo "==================================== <br>";
		$index++;
	}

	// echo "<br>";
	// echo "<br>";

	// var_dump(array_diff_key( $listOfRelativeAddress , array_unique( $listOfRelativeAddress ) ));
	// echo "<br>";
	// echo "<br>";

	// if (count($collisions) > 0) {
	// 	echo "THERE ARE SOME COLLISIONS";
	// } else {
	// 	echo "NOPE";
	// }

	/**
	 * If collisions then:
	 * - Another algorithm
	 * - Then output final result
	 * 
	 * 
	 * Else
	 * Output the relative address
	 */
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Project</title>

	<!-- CSS -->
	<link rel="stylesheet" href="Assets/bootstrap.min.css">

	<style type="text/css">
		form {
			text-align: center;
			margin: 0 auto;
			width: 600px;
		}
		body{
			width: 80%;
			margin: auto;
		}
		
	</style>

</head>
<body>

<form class="text-center border border-light p-5" method="POST">

    <p class="h4 mb-4">Project</p>

    <p>Tugas Terstruktur Sistem Berkas</p>

    <br>
  
    <div class="row">
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Pertama" name="key-1">
    	</div>
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Kedua" name="key-2">
    	</div>
    </div>

    <div class="row">
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Ketiga" name="key-3">
    	</div>
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Keempat" name="key-4">
    	</div>
    </div>

 	<div class="row">
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Kelima" name="key-5">
    	</div>
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Keenam" name="key-6">
    	</div>
    </div>

	<div class="row">
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Ketujuh" name="key-7">
    	</div>
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Kedelapan" name="key-8">
    	</div>
    </div>

	<div class="row">
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Kesembilan" name="key-9">
    	</div>
    	<div class="col">
    		<input type="text" class="form-control mb-4" placeholder="Key Kesepuluh" name="key-10">
    	</div>
    </div>
   
    <button class="btn btn-info btn-block mb-4" type="submit">Hitung</button>
    
    <br>
    <p>Hasil</p>
	<?php
		if(isset($listOfRelativeAddress)) {
			$template = "";
			foreach($listOfRelativeAddress as $indexHasil => $addr) {
				$template = $template . "<div class=\"row\">
					<div class=\"col-12 text-left\">
						<h5 align='center'>Key ".($indexHasil+1)." yaitu $listOfKeys[$indexHasil] akan disimpan pada alamat/index $addr</h5>
					</div>
				</div><br>";
			}
			echo $template;
		}
	?>
    

</form>

<!-- JavaScript -->
<script src="Assets/jquery-3.3.1.slim.min.js"></script>
<script src="Assets/bootstrap.min.js"></script> 

</script>
</body>
</html>