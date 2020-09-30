<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Akses API EHRM</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" />

	<script src="https://code.jquery.com/jquery-3.5.0.min.js" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>

<!-- 
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="#">Active</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#">Disabled</a>
    </li>
  </ul>
</nav> -->

<div class="container">
	<div class ="card border-primary mt-3">
		<div class="card-header bg-primary text-white">
      <div class="d-flex justify-content-between">
      <div>EHRM NIP</div><div><a class="text-white" href="<?php echo site_url("unit");?>">Unit Organisasi</a></div>
     </div>
    </div>
      

		<div class="card-body">
			<form id="form-nip" class="form-row" action="" enctype="multipart/form-data">
          
          <div class="form-group col-sm-6">
              <label for="nip" class="control-label">NIP/NRP</label>
              <input type="text" class="form-control" name="nip" placeholder="Input NIP/NRP" required>
          </div>
          
          <div class="form-group col-sm-3">
              <label for="button" class="control-label">&nbsp;</label>
                <div class="">
                  <button type="submit" id="btn-cari" class="btn btn-primary"><span class="fa fa-filter"></span>  Cari</button>
                  <button type="reset" id="btn-reset" class="btn btn-danger"> <span class="fa fa-undo"></span> Reset</button>
                  
                </div>
          </div>
        </form>
            <div class="hasil">
                 
            </div>	
    </div>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">
<script src="https://cdn.datatables.net/plug-ins/1.10.21/pagination/select.js"></script>
<style>
.move-left {
    width: auto;
    box-shadow: none;
  }
</style>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function()
    {
      $("#form-nip").on("submit", function(e)
        {
          e.preventDefault();
          $.ajax({
            url : "<?php echo site_url("nip/get_ehrm_nip"); ?>",
            method : "POST",
            data : $(this).serialize(),
            dataType : "json",
            success : function (data)
                {
                  if(data.hasil == "ada") {
                    var html = "<table class='table table-bordered'>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>NIP/NRP</p></td>";
                    html += "<td>" + data.nip + "</td>";
                    html += "</tr>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>Nama</p></td>";
                    html += "<td>" + data.nama + "</td>";
                    html += "</tr>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>Jabatan</p></td>";
                    html += "<td>" + data.jabatan + "</td>";
                    html += "</tr>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>Unit Organisasi</p></td>";
                    html += "<td>" + data.unor + "</td>";
                    html += "</tr>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>Unit Kerja</p></td>";
                    html += "<td>" + data.unker + "</td>";
                    html += "</tr>";
                    html += "<tr>";
                    html += "<td><p class='font-weight-bold'>Foto</p></td>";
                    html += "<td>" + "<img class='img-fluid' style='width:150px;height:200px' src='"+data.foto+"'></td>";
                    html += "</tr>";
                    html += "</table>";
                  }
                  else {
                    var html = "<p class='font-weight-bold'>Data tidak ditemukan.</p>";
                  }

                  $(".hasil").html(html); 
                }
          });
        });
    }
  );
</script>
</body>
</html>