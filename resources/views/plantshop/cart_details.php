<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	$output = '';

	if(isset($_SESSION['user'])){
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
				$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				$crow = $stmt->fetch();
				if($crow['numrows'] < 1){
					$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
					$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid'], 'quantity'=>$row['quantity']]);
				}
				else{
					$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
					$stmt->execute(['quantity'=>$row['quantity'], 'user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				}
			}
			unset($_SESSION['cart']);
		}
					
		try{
			// Check cart is empty or not
			$stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = :id");
			$stmt->execute(['id'=>$user['id']]);
			$data = $stmt->fetchColumn();

			if ($data == 0) { // If Empty
				echo $output;
				$output = "<tr>
							<td colspan='6' align='center'>Shopping cart empty</td>
						<tr>
					";
			}else { // Otherwise
				$total = 0;
				$stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
				$stmt->execute(['user'=>$user['id']]);
				foreach($stmt as $row){
					$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
					$subtotal = $row['price']*$row['quantity'];
					$total += $subtotal;
					$output .= "
						<tr>
							
							<td><img src='".$image."' width='30px' height='30px'></td>
							<td>".$row['name']."</td>
							<td>Rp. ".number_format($row['price'])."</td>
							<td class='input-group'>
								<span class='input-group-btn'>
									<button type='button' id='minus' class='btn btn-default minus' data-id='".$row['cartid']."'><i class='fa fa-minus'></i></button>
								</span>
								<input type='text' class='form-control' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
								<span class='input-group-btn'>
									<button type='button' id='add' class='btn btn-default add' data-id='".$row['cartid']."'><i class='fa fa-plus'></i>
									</button>
								</span>
							</td>
							<td>Rp. ".number_format($subtotal)."</td>
							<td><button type='button' data-id='".$row['cartid']."' class='btn btn-danger cart_delete'><i class='fa fa-remove'></i></button></td>
						</tr>
					";
				}
				$output .= "
					<tr>
						<td colspan='5' align='right'><b>Total</b></td>
						<td><b>Rp. ".number_format($total)."</b></td>
					<tr>
				";
			}
				
		}
		catch(PDOException $e){
			$output .= $e->getMessage();
		}

	}
	else{
		if(count($_SESSION['cart']) != 0){
			$total = 0;
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				$stmt->execute(['id'=>$row['productid']]);
				$product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
				$subtotal = $product['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					<tr>
						<td><img src='".$image."' width='30px' height='30px'></td>
						<td>".$product['name']."</td>
						<td>Rp. ".number_format($product['price'])."</td>
						<td class='input-group'>
							<span class='input-group-btn'>
            					<button type='button' id='minus' class='btn btn-default minus' data-id='".$row['productid']."'><i class='fa fa-minus'></i></button>
            				</span>
            				<input type='text' class='form-control' value='".$row['quantity']."' id='qty_".$row['productid']."'>
				            <span class='input-group-btn'>
				                <button type='button' id='add' class='btn btn-default add' data-id='".$row['productid']."'><i class='fa fa-plus'></i>
				                </button>
				            </span>
						</td>
						<td>Rp. ".number_format($subtotal)."</td>
						<td><button type='button' data-id='".$row['productid']."' class='btn btn-danger cart_delete'><i class='fa fa-remove'></i></button></td>
					</tr>
				";
				
			}

			$output .= "
				<tr>
					<td colspan='5' align='right'><b>Total</b></td>
					<td><b>Rp. ".number_format($total)."</b></td>
				<tr>
			";
		}

		else{
			$output .= "
				<tr>
					<td colspan='6' align='center'>Shopping cart empty</td>
				<tr>
			";
		}
		
	}

	$pdo->close();
	echo json_encode($output);

?>

