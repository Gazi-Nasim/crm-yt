<?php
session_start();
$_SESSION["mnu"] = "invoice";
$_SESSION["mnu_in"] = "sif_crt_inv";

if (!isset($_SESSION['username'])) {
  header('Location: ../index.php');
}
$con = new mysqli('localhost', 'root', '', 'crm');
// $create=$con->query('select * from products order by id desc');

$d = $con->query('select * from admin where admin.role = "admin" ');
$md = $con->query('select * from products  ');
$a = $con->query("select * from admin");
$cr = $con->query('select * from admin');

// $i = $con->query('select * from invoice');

if (isset($_POST['dealID'])) {
  $price = $_POST['price'];
  $s = $con->query("select max(invoice_id) as i from invoice")->fetch_assoc();
  $dealID = $_POST['dealID'];

  $invID = $s['i'] + 1;
  $proID = $_POST['proID'];
  $qID = $_POST['qID'];
  $total = $_POST['tot'];
  $vat = $_POST['vat'];
  $discount = $_POST['discount'];

  $stotal = $_POST['stotal'];
  $create_at = $_POST['created_at'];
  $create_by = $_SESSION['id'];
  $prID = $_POST['pid'];
  foreach ($qID as $index => $qIDs) {
    // echo $qIDs."-".$proID.", ";
    $s_prID = $prID[$index];
    $s_qID = $qIDs;
    $s_vat = $vat[$index];
    $s_price = $price[$index];
    $s_stotal = $stotal[$index];
    $query = "INSERT INTO `invoice`(id, dealer_id, invoice_id, product_id, price, quantity, total, vat, discount, payable, created_at, created_by)VALUES(null, $dealID, $invID, $s_prID, $s_price, $s_qID, $total, $s_vat, $discount, $s_stotal, '$create_at', $create_by)";
    $con->query($query);
  }

  // echo $query ="INSERT INTO `invoice`(id, dealer_id, invoice_id, product_id, price, quantity, total, vat, discount, payable, created_at, created_by)VALUES(null, $dealID, $invID, $proID, $s_price, $s_qID, $total, $s_vat, $discount, $payable, '$create_at', $create_by)";
  // $con->query($query);
  header('Location: create_invoice.php');
};
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- apni apnar directory wise ekhane path change kore niben-->

  <!--  -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- apni apnar directory wise ekhane path change kore niben -->
  <link rel="stylesheet" href="../cstmStyle/style.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">


      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <?php
    require('../menu.php');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Starter Page</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">


              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h2 class="m-0">Create Invoice</h2>
                </div>
                <div class="card-body">

                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group ">
                            <label for="exampleInputEmail1">Admin Name: </label>
                            <select name="admin" id="div" class="dropdown form-control">
                              <?php while ($ad = $d->fetch_assoc()) { ?>
                                <option value="<?php echo $ad['id'] ?>"><?php echo $ad['name'] ?></option>
                              <?php } ?>
                            </select>
                            <br>
                            <span id="mar" class="caret">

                            </span>
                          </div>

                        </div>

                        <div class="col-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Date: </label>
                            <input type="datetime-local" name="created_at" class="form-control" id="exampleInputEmail1" placeholder="">
                          </div>

                          <div id="dealer" class="caret">

                          </div>

                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Product Name: </label>
                          <select name="proID" id="product" class="form-control">
                            <option value="">Select product</option>
                            <?php while ($p = $md->fetch_assoc()) { ?>
                              <option value="<?php echo $p['id'] ?>"><?php echo $p['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <table class="table table-bordered table-responsive ">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Tax</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody id="pd">
                              <!-- ---ht --- -->
                            </tbody>
                            <tbody>
                              <tr>
                                <th colspan="5">Grand Total</th>
                                <td id="gt" style="font-weight:bold"></td>
                              </tr>
                              <tr>
                                <th colspan="4">Discount (percentage & amount)</th>
                                <td><input type="text" id="dis" class="form-control" name="discount" value="0" onkeyup="payable()"></td>
                                <td id="adis" style="color:blue;"></td>
                              </tr>
                              <tr>
                                <th colspan="5">Net Payable</th>
                                <td>
                                  <input type="text" class="form-control" id="net" name="pable" readonly value="" style="font-weight:bold; ">
                                </td>
                              </tr>
                              <tr>
                                <th colspan="5">Paid Amount</th>
                                <td><input type="text" id="gt1" class="form-control" name="paid" value="0" onkeyup="payable()" style="color:green"></td>
                              </tr>

                              <tr>
                                <th colspan="5">Due</th>
                                <td id="gt2" style="color:red;"></td>
                              </tr>


                            </tbody>
                          </table>

                        </div>
                      </div>
                      <div class="">
                        <div class="form-group">
                          <label for="exampleInputEmail1"></label>
                          <input type="submit" class="btn btn-primary btn-block" value="Save">
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>
                </form>

              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->

        </div>
        <!-- /.row -->
        <span>

          <?php require('./list_invoice.php') ?>

        </span>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../jquery-3.6.1.min.js"></script>
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <!-- Bootstrap 4 -->

  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <!-- AdminLTE App -->

  <script src="../dist/js/adminlte.min.js"></script>
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- apni apnar directory wise ekhane path change kore niben -->

  <script>
    $(function() {
      // Summernote
      $('.summernote').summernote();
      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
    })
  </script>
  <script>
    $(document).ready(function() {
      $('#div').change(function() {
        let divID = $(this).val();
        $.ajax({
          url: 'marketing.php',
          method: 'post',
          data: {
            id: divID
          },
          success: function(data) {
            $('#mar').html(data)
          }
        })
      })

      $(document).on('change', '#mark', function() {
        let disID = $(this).val();
        $.ajax({
          url: 'dealer.php',
          method: 'post',
          data: {
            id: disID
          },
          success: function(data) {
            $('#dealer').html(data);
          }
        })
      })
    })
  </script>

  <script>
    $(document).ready(function() {
      let i = 1
      $(document).on('change', '#product', function() {
        let id = $(this).val();

        $.getJSON('fetch_data.php?id=' + id, function(data) {
          //first vul ekhane chiloh apnar, fetch_data.php diye j id ta pathiyechen oi file ta create na korle kaj hobe nah. r kore thakle amake oi file ta pathate vule gesen.
          let ht = `<tr  id="rem_${i}">
                      <td> ${data.name}</td>
                      <td >
                        <input type="text" id="m_${i}" name="price[]" class="form-control" readonly value="${data.dealer_price}" >
                        <input type="hidden" id="pk_${i}" name="pid[]" class="form-control" readonly value="${data.id}" >
                      </td>                     
                      <td>
                        <input type="text" class="form-control" name="qID[]" id="q_${i}" onkeyup="payable(${i})" value="1" >
                      </td>
                      <td >
                        <input type="text" class="form-control" id="t_${i}" name="tot" readonly value="${data.dealer_price}" >
                      </td>
                      <td>
                        <input type="text" class="form-control" name="vat[]" id="tx_${i}" value="0" onkeyup="payable(${i})" >
                      </td>
                      <td><input type="text" id="p_${i}" name="stotal[]" class="total form-control" readonly value="${data.dealer_price}" ></td>
                      <td><input type="text" name="" id="r_${i}" onclick="r_(${i})" value="Delete" class="btn btn-danger btn-sm"></td>
                    </tr>`
          $('#pd').append(ht)

          //upore 4 no td te ekta function chalate hobe tax er jonno, jate tax input dile payable ta calculate hoy
          i += 1;
          let gtotal = 0;
          $('.total').each(function(e) {
            let v = parseInt($(this).val());
            gtotal += v;
          })
          $('#gt').text(gtotal);
          let discount = $('#dis').val()
          let amountDis = (gtotal * discount) / 100;
          $('#adis').text(amountDis);
          let ntotal = gtotal - amountDis;
          $('#net').val(ntotal)
          let paid = $('#gt1').val()
          let due = ntotal - paid
          $('#gt2').text(due)

        })

      })
    });

    function r_(i) {
      $('#rem_' + i).remove();
      let gtotal = 0;
      $('.total').each(function(e) {
        let v = parseInt($(this).val());
        gtotal += v;
      })
      $('#gt').text(gtotal);
      let discount = $('#dis').val()
      let amountDis = (gtotal * discount) / 100;
      $('#adis').text(amountDis);
      let ntotal = gtotal - amountDis;
      $('#net').val(ntotal)
      let paid = $('#gt1').val()
      let due = ntotal - paid
      $('#gt2').text(due)
    }

    function payable(d) {
      let price = $('#m_' + d).val();
      let qty = $('#q_' + d).val();
      let tax = $('#tx_' + d).val();
      let total = price * qty;
      $('#t_' + d).val(total);
      let subtotal = (total) + (total * tax) / 100;
      $('#p_' + d).val(subtotal);
      let gtotal = 0;
      //gtotal hisab korar jonno protita payable element er class same hote hobe. tai dekhben ht er moddhe 6 no td te id er pasha pashi ekta class dhore newa hoise. jeta dhore nicher function ta kaj kora hoise

      $('.total').each(function(e) {
        let v = parseInt($(this).val());
        gtotal += v;
      })
      $('#gt').text(gtotal);
      let discount = $('#dis').val()
      let amountDis = (gtotal * discount) / 100;
      $('#adis').text(amountDis);
      let ntotal = gtotal - amountDis;
      $('#net').val(ntotal)
      let paid = $('#gt1').val()
      let due = ntotal - paid
      $('#gt2').text(due)
    }
  </script>
</body>

</html>