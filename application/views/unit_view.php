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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
	<div class ="card border-primary mt-3">
		<div class="card-header bg-primary  text-white">
            <div class="d-flex justify-content-between">
            <div>Unit Organisasi</div><div><a class="text-white" href="<?php echo site_url("nip");?>">EHRM NIP/NRP</a></div>
            </div>
        </div>
		<div class="card-body">
			<form id="form-filter" class="form-row">
          
          <div class="form-group col-sm-3">
              <label for="es1" class="control-label">Eselon 1</label>
              <select name="es1" id="es1" class="form-control cmb_select2">
                <option value="">Semua</option>
                <?php 
                    foreach($cmb_es1 as $es1)
                    {
                        echo "<option value='".$es1['kdunit']."'>".$es1['keterangan']."</option>";
                    }
                ?>
              </select>
          </div>
          <div class="form-group col-sm-3">
              <label for="es2" class="control-label">Eselon 2</label>
                  <select name="es2" id="es2" class="form-control cmb_select2">
                <option value="">Semua</option>
              </select>
          </div>
          <div class="form-group col-sm-4">
              <label for="es3" class="control-label">Eselon 3</label>
                  <select name="es3" id="es3" class="form-control cmb_select2">
                <option value="">Semua</option>
              </select>
          </div>
          <div class="form-group col-sm-2">
              <label for="button" class="control-label">&nbsp;</label>
                <div class="">
                  <button type="button" id="btn-filter" class="btn btn-primary"><span class="fa fa-filter"></span>  Filter</button>
                  <button type="button" id="btn-reset" class="btn btn-danger"> <span class="fa fa-undo"></span> Reset</button>
                  
                </div>
          </div>
        </form>
            <div class="hasil">
                <table id="list" class="table table-bordered table-sm text-sm table-striped table-hover display" cellspacing="0" style="word-wrap:break-word">
                <thead class="bg-info text-white">
                <tr class="">
                  <th>Kode Unit</th>
                  <th>Nama Unit</th>
                  <th>PNS</th>
                  <th>Non PNS</th>
                  <th>Jumlah</th>
                </tr>
                </thead>
                <tbody id="showdata"></tbody>
              </table>
            </div>	
    </div>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">
<style>
.move-left {
    width: auto;
    box-shadow: none;
  }
</style>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
    var table = $("#list").DataTable({
        
        "pagination": false,
        "processing": true,
        "stateSave" : true,
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('unit/get_ehrm_unit')?>",
            "type": "POST",
            "data": function ( data ) {
             // Data untuk filter
                data.es1 = $('#es1').val();
                data.es2 = $('#es2').val();
                data.es3 = $('#es3').val();
            }
        },
        "columns" : [
                 
                  {"data" : "kdunit"},
                  {"data" : "keterangan"},
                  {"data" : "pns"},
                  {"data" : "nonpns"},
                  {"data" : "jumlah"},
                ],
        "columnDefs" : [{"targets" : [], "orderable": false},{"targets" : [2,3,4], "className" : "text-right"}]
    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();
    });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        $('#form-filter').find(".cmb_select2").val('').trigger('change');
        table.ajax.reload();  //just reload table
    });
});
</script>
<script type="text/javascript">
  $(function(e) {

    $(".cmb_select2").select2({
      theme: 'bootstrap4',
      width: '100%'
    })
    $("#es1").change(function() {
      set_loader_select2('es2');
      
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo site_url('unit/ajax_get_es2/') ?>" + $(this).val(),
        success: function(data) {
            console.log(data);
          set_option_select2('es2', data, 'Semua');
        },
        error: function(xhr, msg, e) {
          console.log(xhr.responseText);
        }
      });
    });
    $("#es2").change(function() {
      set_loader_select2('es3');
      
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo site_url('unit/ajax_get_es3/') ?>" + $(this).val(),
        success: function(data) {
          set_option_select2('es3', data, 'Semua');
        },
        error: function(xhr, msg, e) {
          console.log(xhr.responseText);
        }
      });
    });
    
  })

  function set_option_select2(cmb_name, data, placeholder, key_name='', value_name='') {
      if ( key_name == '' )
          key_name = 'kdunit';
      if ( value_name == '' )
          value_name = 'keterangan';

      var result_html = '<option value="">'+placeholder+'</option>';
      var selected_text = '';
      for ( var i=1; i < data.length; i++ ) {
          result_html += '<option ';
          result_html += 'value="'+ data[i][key_name] +'">';
          result_html += data[i][value_name];
          result_html += '</option>';
      }
      $('#'+cmb_name).html(result_html);
      $('#select2-'+cmb_name+'-container').html('');
      $('#select2-'+cmb_name+'-container').append(placeholder);
  }

  function set_loader_select2(cmb_name) {
      $('#'+cmb_name).val('');
      $('#select2-'+cmb_name+'-container').html('Loading ...');
      $('#select2-'+cmb_name+'-container .select2-selection__placeholder').html('Loading ...');
  }
  function reset_select2(cmb_name, placeholders) {
      $('#'+cmb_name).html('<option value="">'+placeholders+'</option>');
      $('#'+cmb_name).parent().children('.select2-selection__rendered').attr('title', '');
      $('#select2-'+cmb_name+'-container').html(placeholders);
      $('#select2-'+cmb_name+'-container').attr('title', placeholders);
  }
  function reset_selected_select2(cmb_name, placeholders, selected_value) {
      $('#'+cmb_name).val(selected_value);
      $('#select2-'+cmb_name+'-container').html($("#"+cmb_name+" option[value='"+selected_value+"']").text());
      $('#select2-'+cmb_name+'-container .select2-selection__placeholder').html($("#"+cmb_name+" option[value='"+selected_value+"']").text());
  }
</script>
</body>
</html>