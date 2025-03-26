<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL); // Para exibir eventuais erros

if (isset($_POST['submit'])) {
  $fromdate  = $_POST['fromdate'];
  $todate    = $_POST['todate'];
  $message   = $_POST['message'];
  $useremail = $_SESSION['login'];
  $status    = 0;
  $seguroValor = 0;
  $descontoValor = 0;
  $vhid      = $_GET['vhid'];
  $bookingno = mt_rand(100000000, 999999999);

  // Verifica se o seguro foi selecionado
  $seguro = isset($_POST['seguro']) && $_POST['seguro'] == '1' ? 1 : 0;

  // Obter o preço atual do veículo no banco de dados
  $sqlPrice = "SELECT PricePerDay FROM tblvehicles WHERE id = :vhid";
  $queryPrice = $dbh->prepare($sqlPrice);
  $queryPrice->bindParam(':vhid', $vhid, PDO::PARAM_STR);
  $queryPrice->execute();
  $resultPrice = $queryPrice->fetch(PDO::FETCH_OBJ);
  $pricePerDay = $resultPrice->PricePerDay;

  // Se o seguro estiver selecionado, adicionar 150 ao valor da diária
  if ($seguro) {
    $pricePerDay += ($pricePerDay + 150);
  }

  // Calcula o número de dias entre as datas
  $datetime1 = new DateTime($fromdate);
  $datetime2 = new DateTime($todate);
  $interval  = $datetime1->diff($datetime2);
  $days      = $interval->format('%a') + 1; // número de dias total

  // Valor total da reserva
  $totalPrice = $pricePerDay * $days;

  // Verifica conflito de datas
  $ret = "SELECT * FROM tblbooking WHERE (:fromdate BETWEEN date(FromDate) and date(ToDate) 
        OR :todate BETWEEN date(FromDate) and date(ToDate) 
        OR date(FromDate) BETWEEN :fromdate and :todate) AND VehicleId=:vhid";
  $query1 = $dbh->prepare($ret);
  $query1->bindParam(':vhid', $vhid, PDO::PARAM_STR);
  $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
  $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
  $query1->execute();

  if ($query1->rowCount() == 0) {
    // Insere os dados da reserva no banco com seguro e valor total
    $sql = "INSERT INTO tblbooking(userEmail, VehicleId, FromDate, ToDate, message, Status, InsuranceIncluded, discountValue,insuranceValue,TotalPrice) 
            VALUES(:useremail, :vhid, :fromdate, :todate, :message, :status, :seguro, :discontoValor, :seguroValor, :totalPrice)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':seguro', $seguro, PDO::PARAM_INT);
    $query->bindParam(':discontoValor', $descontoValor, PDO::PARAM_STR);
    $query->bindParam(':seguroValor', $seguroValor, PDO::PARAM_STR);
    $query->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
    

    if ($query->execute()) {
      echo "<script>alert('Reserva realizada com sucesso!');</script>";
      echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
    } else {
      echo "<script>alert('Algo deu errado. Tente novamente');</script>";
      echo "<script type='text/javascript'> document.location = 'car-listing.php'; </script>";
    }
  } else {
    echo "<script>alert('Este carro já está reservado nas datas selecionadas.');</script>";
    echo "<script type='text/javascript'> document.location = 'car-listing.php'; </script>";
  }
}

?>

<!DOCTYPE HTML>
<html lang="en">

<head>

  <title>Driveway</title>
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
  <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>

  <!-- Start Switcher -->
  <?php include('includes/colorswitcher.php'); ?>
  <!-- /Switcher -->

  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <!--Listing-Image-Slider-->
  <?php
  $vhid = intval($_GET['vhid']);
  $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid  
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.id = :vhid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $_SESSION['brndid'] = $result->bid;
  ?>

      <section id="listing_img_slider">
        <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <?php
        if ($result->Vimage5 != "") {
        ?>
          <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <?php } ?>
      </section>
      <!--/Listing-Image-Slider-->

      <!--Listing-detail-->
      <section class="listing-detail">
        <div class="container">
          <div class="listing_detail_head row">
            <div class="col-md-9">
              <h2><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h2>
            </div>
            <div class="col-md-3">
              <div class="price_info">
                <p>$<?php echo htmlentities($result->PricePerDay); ?></p>Diária
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="main_features">
                <ul>
                  <li> <i class="fa fa-calendar" aria-hidden="true"></i>
                    <h5><?php echo htmlentities($result->ModelYear); ?></h5>
                    <p>Ano</p>
                  </li>
                  <li> <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h5><?php echo htmlentities($result->FuelType); ?></h5>
                    <p>Tipo de Combustivel</p>
                  </li>
                  <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <h5><?php echo htmlentities($result->SeatingCapacity); ?></h5>
                    <p>Lugares</p>
                  </li>
                </ul>
              </div>
              <div class="listing_more_info">
                <div class="listing_detail_wrap">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs gray-bg" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#vehicle-overview" aria-controls="vehicle-overview" role="tab" data-toggle="tab">Sobre</a>
                    </li>
                    <li role="presentation">
                      <a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessórios</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- vehicle-overview -->
                    <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                      <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                    </div>

                    <!-- Accessories -->
                    <div role="tabpanel" class="tab-pane" id="accessories">
                      <table>
                        <thead>
                          <tr>
                            <th colspan="2">Accessórios</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Ar Condicionado</td>
                            <?php if ($result->AirConditioner == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Freio ABS</td>
                            <?php if ($result->AntiLockBrakingSystem == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Direção Hidraulica</td>
                            <?php if ($result->PowerSteering == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Vidro Eletrico</td>
                            <?php if ($result->PowerWindows == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>CD Player</td>
                            <?php if ($result->CDPlayer == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Banco de Couro</td>
                            <?php if ($result->LeatherSeats == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Controle de Trava</td>
                            <?php if ($result->CentralLocking == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Trava Eletrica</td>
                            <?php if ($result->PowerDoorLocks == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Assistencia de Freio</td>
                            <?php if ($result->BrakeAssist == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Airbag Motorista</td>
                            <?php if ($result->DriverAirbag == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Airbag Passageiro</td>
                            <?php if ($result->PassengerAirbag == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                          <tr>
                            <td>Crash Sensor</td>
                            <?php if ($result->CrashSensor == 1) { ?>
                              <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            <?php } else { ?>
                              <td><i class="fa fa-close" aria-hidden="true"></i></td>
                            <?php } ?>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
          <?php
        }
      }
          ?>

            </div>

            <!--Side-Bar-->
            <aside class="col-md-3">

              <div class="share_vehicle">
                <p>Compartilhe: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></p>
              </div>
              <div class="sidebar_widget">
                <div class="widget_heading">
                  <h5><i class="fa fa-envelope" aria-hidden="true"></i>Reserve Já</h5>
                </div>
                <form method="post">
                  <div class="form-group">
                    <label>A Partir de:</label>
                    <input type="date" class="form-control" name="fromdate" placeholder="From Date" required>
                  </div>
                  <div class="form-group">
                    <label>Até:</label>
                    <input type="date" class="form-control" name="todate" placeholder="To Date" required>
                  </div>
                  <div class="form-group">
                    <textarea rows="4" class="form-control" name="message" placeholder="Message" required></textarea>
                  </div>
                  <!-- Check button para Seguro -->
                  <div class="form-group">
                    <input type="checkbox" id="seguro" name="seguro" value="1">
                    <label for="seguro" data-toggle="tooltip" title="Viaje tranquilo com nosso seguro completo por apenas $150 na sua diária!"> Seguro</label>
                  </div>
                  <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
                    <div class="form-group">
                      <input type="submit" class="btn" name="submit" value="Reserve">
                    </div>
                  <?php } else { ?>
                    <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>
                  <?php } ?>

                </form>
              </div>
            </aside>
            <!--/Side-Bar-->
          </div>

          <div class="space-20"></div>
          <div class="divider"></div>

          <!--Similar-Cars-->
          <div class="similar_cars">
            <h3>Veja mais:</h3>
            <div class="row">
              <?php
              $bid = $_SESSION['brndid'];
              $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.VehiclesBrand = :bid";
              $query = $dbh->prepare($sql);
              $query->bindParam(':bid', $bid, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = 1;
              if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                  <div class="col-md-3 grid_listing">
                    <div class="product-listing-m gray-bg">
                      <div class="product-listing-img">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="image" />
                        </a>
                      </div>
                      <div class="product-listing-content">
                        <h5>
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                            <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
                          </a>
                        </h5>
                        <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?></p>
                        <ul class="features_list">
                          <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                          <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> model</li>
                          <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
          <!--/Similar-Cars-->
        </div>
      </section>
      <!--/Listing-detail-->

      <!--Footer -->
      <?php include('includes/footer.php'); ?>
      <!-- /Footer-->

      <!--Back to top-->
      <div id="back-top" class="back-top">
        <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
      </div>
      <!--/Back to top-->

      <!--Login-Form -->
      <?php include('includes/login.php'); ?>
      <!--/Login-Form-->

      <!--Register-Form -->
      <?php include('includes/registration.php'); ?>
      <!--/Register-Form-->

      <!--Forgot-password-Form -->
      <?php include('includes/forgotpassword.php'); ?>

      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/interface.js"></script>
      <script src="assets/switcher/js/switcher.js"></script>
      <script src="assets/js/bootstrap-slider.min.js"></script>
      <script src="assets/js/slick.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
      <script>
        // Ativa os tooltips do Bootstrap
        $(function() {
          $('[data-toggle="tooltip"]').tooltip();
        });
      </script>

</body>

</html>