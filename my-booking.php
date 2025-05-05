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

        <title>DriveGo</title>
        <!--Bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
        <!--Custome Style -->
        <link rel="stylesheet" href="assets/css/style.css" type="text/css">
        <!--OWL Carousel slider-->
        <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
        <!--slick-slider -->
        <link href="assets/css/slick.css" rel="stylesheet">
        <!--bootstrap-slider -->
        <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
        <!--FontAwesome Font Style -->
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- SWITCHER -->
        <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/images/icon7.png">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    </head>

    <body>

        <body>

            <!-- ?php include('includes/colorswitcher.php'); ? -->
            <?php include('includes/header.php'); ?>

            <section class="page-header profile_page">
                <div class="container">
                    <div class="page-header_wrap">
                        <div class="page-heading">
                            <h1>Minhas Reservas</h1>
                        </div>
                        <ul class="coustom-breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li>Minhas Reservas</li>
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
                            <div class="col-md-6 col-sm-8">
                                

                                        <div class="col-md-9 col-sm-9">
                                            <div class="profile_wrap">
                                                <h5 class="uppercase underline">Minhas Reservas</h5>

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
                                                        $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbooking.*, (DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) + 1) as totaldays 
                                                        FROM tblbooking 
                                                        JOIN tblvehicles ON tblbooking.VehicleId=tblvehicles.id 
                                                        JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand 
                                                        WHERE tblbooking.userEmail=:useremail 
                                                        ORDER BY tblbooking.PostingDate DESC";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $bookings = $query->fetchAll(PDO::FETCH_OBJ);

                                                        if ($query->rowCount() > 0) {
                                                            foreach ($bookings as $booking) {

                                                                // Corrigido aqui
                                                                $sql_prev = "SELECT COUNT(*) FROM tblbooking 
                                                                WHERE userEmail = :useremail 
                                                                AND Status = 1";
                                                                $query_prev = $dbh->prepare($sql_prev);
                                                                $query_prev->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                                                                $query_prev->execute();
                                                                $prevConfirmed = $query_prev->fetchColumn();

                                                                if( $booking->Status == 0) {

                                                                if ($prevConfirmed >= 3 && $prevConfirmed % 3 == 0) {
                                                                  
                                                                        $discount = 50;
                                                                        $sql_update_desconto = "UPDATE tblbooking SET  discountValue = :descontoValor WHERE id = :bookingid";
                                                                        $query_update = $dbh->prepare($sql_update_desconto);
                                                                        $query_update->bindParam(':descontoValor', $discount, PDO::PARAM_INT);
                                                                        $query_update->bindParam(':bookingid', $booking->id, PDO::PARAM_INT);
                                                                        $query_update->execute();                                                                    
                                                                   
                                                                }                                                                

                                                                $total = ($booking->totaldays * $booking->PricePerDay) + $booking->insuranceValue - $discount;
                                                                // Atualiza o TotalPrice no banco
                                                                $sql_update_total = "UPDATE tblbooking SET TotalPrice = :total WHERE id = :bookingid";
                                                                $query_update = $dbh->prepare($sql_update_total);
                                                                $query_update->bindParam(':total', $total, PDO::PARAM_STR);
                                                                $query_update->bindParam(':bookingid', $booking->id, PDO::PARAM_INT);
                                                                $query_update->execute();
                                                            }
                                                        ?>

                                                                <li>
                                                                    <h4 style="color:red">Reserva N.º #<?= htmlentities($booking->BookingNumber); ?></h4>
                                                                    <div class="vehicle_img">
                                                                        <a href="vehical-details.php?vhid=<?= htmlentities($booking->VehicleId); ?>">
                                                                            <img src="admin/img/vehicleimages/<?= htmlentities($booking->Vimage1); ?>" alt="image">
                                                                        </a>
                                                                    </div>
                                                                    <div class="vehicle_title">
                                                                        <h6><a href="vehical-details.php?vhid=<?= htmlentities($booking->VehicleId); ?>">
                                                                                <?= htmlentities($booking->BrandName); ?>, <?= htmlentities($booking->VehiclesTitle); ?></a></h6>
                                                                        <p><b>A Partir de:</b> <?= htmlentities($booking->FromDate); ?>
                                                                            <b>Até:</b> <?= htmlentities($booking->ToDate); ?>
                                                                        </p>
                                                                        <p><b>Mensagem:</b> <?= htmlentities($booking->message); ?></p>
                                                                    </div>

                                                                    <div class="vehicle_status">
                                                                        <?php if ($booking->Status == 1) { ?>
                                                                            <a href="#" class="btn outline btn-xs active-btn">Confirmado</a>
                                                                        <?php } elseif ($booking->Status == 2) { ?>
                                                                            <a href="#" class="btn outline btn-xs">Cancelado</a>
                                                                        <?php } else { ?>
                                                                            <a href="#" class="btn outline btn-xs">Pendente</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </li>

                                                                <?php
                                                                // Recarrega os dados da reserva após os updates
                                                                $sql_refresh = "SELECT tblvehicles.*, tblbrands.BrandName, tblbooking.*, (DATEDIFF(tblbooking.ToDate,tblbooking.FromDate)+1) as totaldays 
                                                                FROM tblbooking 
                                                                JOIN tblvehicles ON tblbooking.VehicleId=tblvehicles.id 
                                                                JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand 
                                                                WHERE tblbooking.id=:bookingid";
                                                                $query_refresh = $dbh->prepare($sql_refresh);
                                                                $query_refresh->bindParam(':bookingid', $booking->id, PDO::PARAM_INT);
                                                                $query_refresh->execute();
                                                                $updatedBooking = $query_refresh->fetch(PDO::FETCH_OBJ);
                                                                ?>

                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Carro</th>
                                                                        <th>De</th>
                                                                        <th>Até</th>
                                                                        <th>Dias Total</th>
                                                                        <th>Aluguel</th>
                                                                        <th>Seguro</th>
                                                                        <th>Desconto</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlentities($updatedBooking->VehiclesTitle) . ', ' . htmlentities($updatedBooking->BrandName); ?></td>
                                                                        <td><?= htmlentities($updatedBooking->FromDate); ?></td>
                                                                        <td><?= htmlentities($updatedBooking->ToDate); ?></td>
                                                                        <td><?= htmlentities($updatedBooking->totaldays); ?></td>
                                                                        <td><?= number_format($updatedBooking->PricePerDay, 2, ',', '.'); ?></td>
                                                                        <td><?= number_format($updatedBooking->insuranceValue, 2, ',', '.'); ?></td>
                                                                        <td style="color:<?= ($updatedBooking->discountValue > 0) ? 'green' : 'inherit' ?>;">
                                                                            <?= ($updatedBooking->discountValue > 0) ? '-' . number_format($updatedBooking->discountValue, 2, ',', '.') : '0,00' ?>
                                                                        </td>
                                                                        <td><?= number_format($updatedBooking->TotalPrice, 2, ',', '.'); ?></td>
                                                                    </tr>
                                                                </table>

                                                                <hr>

                                                            <?php }
                                                        } else { ?>
                                                            <h5 align="center" style="color:red">Nenhuma reserva encontrada!</h5>
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