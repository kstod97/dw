<?php
session_start();
include('includes/config.php');
error_reporting(0);
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

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/icon7.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>

  <!-- Start Switcher -->
  <?php include('includes/colorswitcher.php'); ?>
  <!-- /Switcher -->

  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <!--Page Header-->
  <section class="page-header listing_page">
    <div class="container">
      <div class="page-header_wrap">
        <div class="page-heading">
          <h1>Resultado da pesquisa de "<?php echo $_POST['searchdata']; ?>"</h1>
        </div>
        <ul class="coustom-breadcrumb">
          <li><a href="#">Home</a></li>
          <li>Lista de Carros</li>
        </ul>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Page Header-->

  <!--Listing-->
  <section class="listing-page">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-push-3">
          <div class="result-sorting-wrapper">
            <div class="sorting-count">
              <?php
              //Query for Listing count
              $searchdata = $_POST['searchdata'];
              $sql = "SELECT tblvehicles.id from tblvehicles 
join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand 
where tblvehicles.VehiclesTitle=:search || tblvehicles.FuelType=:search || tblbrands.BrandName=:search || tblvehicles.ModelYear=:search";
              $query = $dbh->prepare($sql);
              $query->bindParam(':search', $searchdata, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p><span><?php echo htmlentities($cnt); ?> Listagens encontradas na pesquisa</span></p>
            </div>
          </div>

          <?php
          $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles 
join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand 
where tblvehicles.VehiclesTitle=:search || tblvehicles.FuelType=:search || tblbrands.BrandName=:search || tblvehicles.ModelYear=:search";
          $query = $dbh->prepare($sql);
          $query->bindParam(':search', $searchdata, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $result) {  ?>
              <div class="product-listing-m gray-bg">
                <div class="product-listing-img"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image" /> </a>
                </div>
                <div class="product-listing-content">
                  <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                  <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?> Diária</p>
                  <ul>
                    <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> Assentos</li>
                    <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> Modelo</li>
                    <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                  </ul>
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">Ver Detalhes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                </div>
              </div>
          <?php }
          } ?>
        </div>

        <!--Side-Bar-->
        <aside class="col-md-3 col-md-pull-9">
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-filter" aria-hidden="true"></i> Encontre seu Carro </h5>
            </div>
            <div class="sidebar_filter">
              <?php
              $selectedBrand = $_POST['brand'] ?? '';
              $selectedFuel  = $_POST['fueltype'] ?? '';
              $selectedYear  = $_POST['year'] ?? '';
              $selectedPrice = $_POST['price'] ?? '';
              ?>

              <!-- Formulário alterado para método POST com os novos filtros -->
              <form action="#" method="post">
                <div class="form-group select">
                  <select class="form-control" name="brand">
                    <option value="">Selecione a Marca</option>
                    <?php
                    $sql = "SELECT * FROM tblbrands";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $brands = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                      foreach ($brands as $result) {
                        $selected = ($selectedBrand == $result->id) ? 'selected' : '';
                    ?>
                        <option value="<?php echo htmlentities($result->id); ?>" <?= $selected ?>>
                          <?php echo htmlentities($result->BrandName); ?>
                        </option>
                    <?php }
                    } ?>
                  </select>
                </div>

                <div class="form-group select">
                  <select class="form-control" name="fueltype">
                    <option value="">Selecione Combustivel</option>
                    <option value="Petrol" <?= ($selectedFuel == 'Petrol') ? 'selected' : '' ?>>Gasolina</option>
                    <option value="Diesel" <?= ($selectedFuel == 'Diesel') ? 'selected' : '' ?>>Diesel</option>
                    <option value="CNG" <?= ($selectedFuel == 'CNG') ? 'selected' : '' ?>>Álcool</option>
                  </select>
                </div>

                <div class="form-group">
                  <input type="number" name="year" class="form-control" placeholder="Selecione o Ano" min="1900" max="2099"
                    value="<?= htmlentities($selectedYear); ?>">
                </div>

                <div class="form-group">
                  <input type="number" name="price" class="form-control" placeholder="Preço Máximo" min="0"
                    value="<?= htmlentities($selectedPrice); ?>">
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-block">
                    <i class="fa fa-search" aria-hidden="true"></i> Procurar
                  </button>
                </div>
              </form>

            </div>
          </div>

          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-car" aria-hidden="true"></i> Adicionados Recentemente</h5>
            </div>
            <div class="recent_addedcars">
              <ul>
                <?php $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand order by id desc limit 4";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) {  ?>

                    <li class="gray-bg">
                      <div class="recent_post_img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image"></a> </div>
                      <div class="recent_post_title"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></a>
                        <p class="widget_price">$<?php echo htmlentities($result->PricePerDay); ?> Diária</p>
                      </div>
                    </li>
                <?php }
                } ?>

              </ul>
            </div>
          </div>
        </aside>
        <!--/Side-Bar-->
      </div>
    </div>
  </section>
  <!-- /Listing-->

  <!--Footer -->
  <?php include('includes/footer.php'); ?>
  <!-- /Footer-->

  <!--Back to top-->
  <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
  <!--/Back to top-->

  <!--Login-Form -->
  <?php include('includes/login.php'); ?>
  <!--/Login-Form -->

  <!--Register-Form -->
  <?php include('includes/registration.php'); ?>

  <!--/Register-Form -->

  <!--Forgot-password-Form -->
  <?php include('includes/forgotpassword.php'); ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/interface.js"></script>
  <!--Switcher-->
  <script src="assets/switcher/js/switcher.js"></script>
  <!--bootstrap-slider-JS-->
  <script src="assets/js/bootstrap-slider.min.js"></script>
  <!--Slider-JS-->
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>