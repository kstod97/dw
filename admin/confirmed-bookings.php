<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DriveGo</title>

	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/style.css">

	<style>
		.errorWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #dd3d36;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}

		.succWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #5cb85c;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}
	</style>

</head>

<body>
	<?php include('includes/header.php'); ?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php'); ?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Reservas confirmadas</h2>
						<div class="panel panel-default">
							<div class="panel-heading">Bookings In</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Nome</th>
											<th>Reserva nº</th>
											<th>Veiculo</th>
											<th>A partir da data</th>
											<th>A data</th>
											<th>Seguro</th>
											<th>Status</th>
											<th>Data de publicação</th>
											<th>Ação</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$status = 1;
										$sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, 
												   tblbooking.FromDate, tblbooking.ToDate, tblbooking.VehicleId as vid, 
												   tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber, 
												   tblbooking.InsuranceIncluded
											FROM tblbooking 
											JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId 
											JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail 
											JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id
											WHERE tblbooking.Status=:status";

										$query = $dbh->prepare($sql);
										$query->bindParam(':status', $status, PDO::PARAM_STR);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) { ?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($result->FullName); ?></td>
													<td><?php echo htmlentities($result->BookingNumber); ?></td>
													<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>">
															<?php echo htmlentities($result->BrandName . ', ' . $result->VehiclesTitle); ?></a></td>
													<td><?php echo htmlentities($result->FromDate); ?></td>
													<td><?php echo htmlentities($result->ToDate); ?></td>
													<td><?php echo ($result->InsuranceIncluded == 1) ? '<span style="color:green">Ativado (+R$150)</span>' : '<span style="color:red">Não ativado</span>'; ?></td>
													<td><?php echo htmlentities($result->Status == 1 ? 'Confirmed' : 'Not Confirmed'); ?></td>
													<td><?php echo htmlentities($result->PostingDate); ?></td>
													<td><a href="bookig-details.php?bid=<?php echo htmlentities($result->id); ?>">View</a></td>
												</tr>
											<?php $cnt++; }
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
<?php } ?>