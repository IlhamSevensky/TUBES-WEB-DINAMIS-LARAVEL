<div class="row">
	<div class="box box-solid box-success">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b>Most Viewed Today</b></h3>
	  	</div>
	  	<div class="box-body">
	  		<ul id="trending">
	  		<?php
			  // Indonesian Time Zone
				$timezone = time() + (60 * 60 * 7);
				// $now = gmdate('Y-m-d', $timezone);
	  			$now = date('Y-m-d');
	  			$conn = $pdo->open();

	  			$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 5");
	  			$stmt->execute(['now'=>$now]);
	  			foreach($stmt as $row){
					  $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
					  echo "  <li>
					  			<img src='".$image."' width='80px' height='80px' style='border-radius: 5px; margin-right:10px;'>
								  <a href='product.php?product=".$row['slug']."'>".$row['name']." (". $row['counter'].")</a>
							  </li>
							  <hr>";
							
	  			}
				  
				  
	  			$pdo->close();
	  		?>
	    	<ul>
	  	</div>
	</div>
</div>
