<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Car Rental Portal - My Booking</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<?php include('includes/colorswitcher.php'); ?>
<?php include('includes/header.php'); ?>

<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>My Booking</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>My Booking</li>
            </ul>
        </div>
    </div>
    <div class="dark-overlay"></div>
</section>

<section class="user_profile inner_pages">
    <div class="container">
        <?php
        $useremail = $_SESSION['login'];
        $sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
        $query = $dbh->prepare($sql);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->execute();
        $userdetails = $query->fetch(PDO::FETCH_OBJ);
        ?>
        <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo">
                <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>
            <div class="dealer_info">
                <h5><?= htmlentities($userdetails->FullName); ?></h5>
                <p><?= htmlentities($userdetails->Address); ?><br>
                   <?= htmlentities($userdetails->City); ?>&nbsp;<?= htmlentities($userdetails->Country); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>
            </div>

            <div class="col-md-9 col-sm-9">
                <div class="profile_wrap">
                    <h5 class="uppercase underline">My Bookings</h5>

                    <?php
                    $sql_total = "SELECT COUNT(*) FROM tblbooking WHERE userEmail=:useremail AND Status=1";
                    $query_total = $dbh->prepare($sql_total);
                    $query_total->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                    $query_total->execute();
                    $total_confirmed = $query_total->fetchColumn();
                    ?>

                    <?php if ($total_confirmed > 0 && $total_confirmed % 3 == 0) { ?>
                        <div class="alert alert-success">
                            <strong>Parabéns!</strong> Você tem um desconto de R$50 disponível para sua próxima reserva.
                        </div>
                    <?php } ?>

                    <div class="my_vehicles_list">
                        <ul class="vehicle_listing">
                            <?php
                            $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbooking.*, DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays 
                                    FROM tblbooking 
                                    JOIN tblvehicles ON tblbooking.VehicleId=tblvehicles.id 
                                    JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand 
                                    WHERE tblbooking.userEmail=:useremail 
                                    ORDER BY tblbooking.PostingDate ASC";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                            $query->execute();
                            $bookings = $query->fetchAll(PDO::FETCH_OBJ);

                            if ($query->rowCount() > 0) {
                                foreach ($bookings as $booking) {

                                    // Corrigido aqui
                                    $sql_prev = "SELECT COUNT(*) FROM tblbooking 
                                                 WHERE userEmail = :useremail 
                                                 AND Status = 1 
                                                 AND PostingDate < :postingDate";
                                    $query_prev = $dbh->prepare($sql_prev);
                                    $query_prev->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                                    $query_prev->bindParam(':postingDate', $booking->PostingDate, PDO::PARAM_STR);
                                    $query_prev->execute();
                                    $prevConfirmed = $query_prev->fetchColumn();

                                    $discount = ($prevConfirmed > 0 && $prevConfirmed % 3 == 0) ? 50 : 0;

                                    $insurance = ($booking->InsuranceIncluded == 1) ? 150 : 0;
                                    $total = ($booking->totaldays * $booking->PricePerDay) + $insurance - $discount;
                            ?>

                            <li>
                                <h4 style="color:red">Booking No #<?= htmlentities($booking->BookingNumber); ?></h4>
                                <div class="vehicle_img">
                                    <a href="vehical-details.php?vhid=<?= htmlentities($booking->VehicleId); ?>">
                                        <img src="admin/img/vehicleimages/<?= htmlentities($booking->Vimage1); ?>" alt="image">
                                    </a>
                                </div>
                                <div class="vehicle_title">
                                    <h6><a href="vehical-details.php?vhid=<?= htmlentities($booking->VehicleId); ?>">
                                        <?= htmlentities($booking->BrandName); ?>, <?= htmlentities($booking->VehiclesTitle); ?></a></h6>
                                    <p><b>From:</b> <?= htmlentities($booking->FromDate); ?> 
                                       <b>To:</b> <?= htmlentities($booking->ToDate); ?></p>
                                    <p><b>Message:</b> <?= htmlentities($booking->message); ?></p>
                                </div>

                                <div class="vehicle_status">
                                    <?php if ($booking->Status == 1) { ?>
                                        <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                                    <?php } elseif ($booking->Status == 2) { ?>
                                        <a href="#" class="btn outline btn-xs">Cancelled</a>
                                    <?php } else { ?>
                                        <a href="#" class="btn outline btn-xs">Not Confirmed yet</a>
                                    <?php } ?>
                                </div>
                            </li>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Nome do Carro</th><th>A Partir de</th><th>Até</th><th>Dias Total</th>
                                    <th>Aluguel</th><th>Seguro</th><th>Desconto</th><th>Total</th>
                                </tr>
                                <tr>
                                    <td><?= htmlentities($booking->VehiclesTitle).', '.htmlentities($booking->BrandName); ?></td>
                                    <td><?= htmlentities($booking->FromDate); ?></td>
                                    <td><?= htmlentities($booking->ToDate); ?></td>
                                    <td><?= htmlentities($booking->totaldays); ?></td>
                                    <td><?= number_format($booking->PricePerDay,2,',','.'); ?></td>
                                    <td><?= number_format($insurance,2,',','.'); ?></td>
                                    <td style="color:<?=($discount>0)?'green':'inherit'?>;">
                                        <?=($discount>0)?'-'.number_format($discount,2,',','.'):'0,00'?>
                                    </td>
                                    <td><?= number_format($total,2,',','.'); ?></td>
                                </tr>
                            </table>

                            <hr>

                            <?php } } else { ?>
                                <h5 align="center" style="color:red">No booking yet</h5>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>

</body>
</html>
<?php } ?>
