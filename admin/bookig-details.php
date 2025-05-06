<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_REQUEST['eid'])) {
		$eid = intval($_GET['eid']);
		$status = "2";
		$sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':eid', $eid, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Booking Successfully Cancelled');</script>";
		echo "<script type='text/javascript'> document.location = 'canceled-bookings.php; </script>";
	}


	if (isset($_REQUEST['aeid'])) {
		$aeid = intval($_GET['aeid']);
		$status = 1;

		$sql = "UPDATE tblbooking SET Status=:status WHERE  id=:aeid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Booking Successfully Confirmed');</script>";
		echo "<script type='text/javascript'> document.location = 'confirmed-bookings.php'; </script>";
	}


?>

	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>DriveGo</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
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

							<h2 class="page-title">Detalhes da Reserva</h2>

							<!-- Zero Configuration Table -->
							<div class="panel panel-default">
								<div class="panel-heading">Informações de Reservas</div>
								<div class="panel-body">


									<div id="print">
										<table border="1" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">

											<tbody>
												<?php
												$bid = intval($_GET['bid']);
												$sql = "SELECT tblusers.*, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber, tblbooking.InsuranceIncluded, DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totalnodays, tblvehicles.PricePerDay FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id WHERE tblbooking.id=:bid";
												$query = $dbh->prepare($sql);
												$query->bindParam(':bid', $bid, PDO::PARAM_STR);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;

												if ($query->rowCount() > 0) {
													foreach ($results as $result) {
														$totaldias = $result->totalnodays + 1;
														$valordiaria = $result->PricePerDay;
														$subtotal = $totaldias * $valordiaria;

														$seguro = ($result->InsuranceIncluded == 1) ? 150 : 0;
														$totalfinal = $subtotal + $seguro;
												?>
														<h3 style="text-align:center; color:red">#<?php echo htmlentities($result->BookingNumber); ?> Booking Details </h3>

														<tr>
															<th colspan="4" style="text-align:center;color:blue">User Details</th>
														</tr>
														<tr>
															<th>Sem reservas.</th>
															<td>#<?php echo htmlentities($result->BookingNumber); ?></td>
															<th>Nome</th>
															<td><?php echo htmlentities($result->FullName); ?></td>
														</tr>
														<tr>
															<th>Email </th>
															<td><?php echo htmlentities($result->EmailId); ?></td>
															<th>sem contato</th>
															<td><?php echo htmlentities($result->ContactNo); ?></td>
														</tr>
														<tr>
															<th>Endereço</th>
															<td><?php echo htmlentities($result->Address); ?></td>
															<th>Cidade</th>
															<td><?php echo htmlentities($result->City); ?></td>
														</tr>
														<tr>
															<th>País</th>
															<td colspan="3"><?php echo htmlentities($result->Country); ?></td>
														</tr>

														<tr>
															<th colspan="4" style="text-align:center;color:blue">Detalhes da Reserva</th>
														</tr>
														<tr>
															<th>Nome do Veículo</th>
															<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></a></td>
															<th>Data Reserva</th>
															<td><?php echo htmlentities($result->PostingDate); ?></td>
														</tr>
														<tr>
															<th>Da Data</th>
															<td><?php echo htmlentities($result->FromDate); ?></td>
															<th>To Date</th>
															<td><?php echo htmlentities($result->ToDate); ?></td>
														</tr>
														<tr>
															<th>Dias Totais</th>
															<td><?php echo htmlentities($totaldias); ?></td>
															<th>Aluguel Por Dia</th>
															<td><?php echo htmlentities($valordiaria); ?></td>
														</tr>
														<tr>
															<th>Status do Seguro</th>
															<td colspan="3">
																<?php echo ($seguro > 0) ? "<span style='color:green'>Ativado (R$150)</span>" : "<span style='color:red'>Não ativado</span>"; ?>
															</td>
														</tr>
														<tr>
															<th colspan="3" style="text-align:center">Total Grande</th>
															<td>R$ <?php echo htmlentities(number_format($totalfinal, 2, ',', '.')); ?></td>
														</tr>

														<tr>
															<th>Status da Reserva</th>
															<td><?php
																if ($result->Status == 0) {
																	echo htmlentities('Not Confirmed yet');
																} else if ($result->Status == 1) {
																	echo htmlentities('Confirmed');
																} else {
																	echo htmlentities('Cancelled');
																}
																?>
															</td>
															<th>Última Data de Atualização</th>
															<td><?php echo htmlentities($result->LastUpdationDate); ?></td>
														</tr>

														<?php if ($result->Status == 0) { ?>
															<tr>
																<td style="text-align:center" colspan="4">
																	<a href="bookig-details.php?aeid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Você realmente deseja confirmar esta reserva?')" class="btn btn-primary">Confirmar reserva</a>

																	<a href="bookig-details.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Você realmente deseja cancelar esta reserva?')" class="btn btn-danger">Cancelar reserva</a>
																</td>
															</tr>
														<?php } ?>

														<tr>
															<td style="text-align:center" colspan="4">
																<button onclick="window.print();" class="btn btn-success">Imprimir</button>
															</td>
														</tr>

													<?php
														$cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="4" style="text-align:center;color:red">Nenhuma Reserva Encontrada</td>
													</tr>
												<?php } ?>
											</tbody>

										</table>
										<!-- form method="post">
											<input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;" />
										</form -->

									</div>
								</div>



							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- Loading Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/bootstrap-select.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/jquery.dataTables.min.js"></script>
			<script src="js/dataTables.bootstrap.min.js"></script>
			<script src="js/Chart.min.js"></script>
			<script src="js/fileinput.js"></script>
			<script src="js/chartData.js"></script>
			<script src="js/main.js"></script>
			<script language="javascript" type="text/javascript">
				function f3() {
					
				window.print();
				}
			</script>
	</body>

	</html>
<?php } ?>