<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/user.php'; ?>
<?php require 'inc/_global/token.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>
<?php $one->get_css('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css'); ?>
<?php $one->get_css('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css'); ?>
<?php $one->get_css('js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css'); ?>
<style>
table.table-bordered>tbody>tr>td {
    border: 1px solid #364054;
}

table.table-bordered>tbody>tr>th {
    border: 1px solid #364054;
}
</style>
<div class="content">
    <h2 class="d-print-none">Ad Soyad Sorgu</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">Ad</span>
                        <input id="ad" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">İkinci Ad</span>
                        <input id="ikinciad" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">Soyad</span>
                        <input id="soyad" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">İl</span>
                        <input id="il" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">İlçe</span>
                        <input id="ilce" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">Cinsiyet</span>
                        <select id="cinsiyet" class="form-select">
                            <option value="1" selected>Erkek</option>
                            <option value="2">Kadın</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <div class="input-group">
                        <button class="btn btn-secondary" onclick="sorgula()" type="button">Sorgula</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-12">
        <div class="col-xl-12 col-lg-6">
            <div class="table-responsive">
                <table id="t" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Tc</th>
                            <th>Ad Soyad</th>
                            <th>Yakınlık Durumu</th>
                            <th>Telefon</th>
                        </tr>
                    </thead>
                    <tbody id="tbod">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/lib/jquery.min.js'); ?>
<?php $one->get_js('js/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?php $one->get_js('js/pages/op_auth_signin.min.js'); ?>
<script>
$('input.tcNumber').on('input', function() {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
});

function sorgula() {
    var ad = $('#ad').val();
	var ikinciad = $('#ikinciad').val();
    var soyad = $('#soyad').val();
	var il = $('#il').val();
	var ilce = $('#ilce').val();
	var cinsiyet = $('#cinsiyet').val();
    One.helpers('jq-notify', {
        type: 'info',
        icon: 'fa fa-info-circle me-1',
        message: `${ad} ${soyad} Sorgulanıyor...`
    });
    if (ad.length < 2 || soyad.length < 2 || ad.length < 2 && soyad.length < 2) {
        $('.notifyjs-corner').empty();
        One.helpers('jq-notify', {
            type: 'danger',
            icon: 'fa fa-times me-1',
            message: `Lütfen geçerli ad soyad girin, Girilen (${ad} ${soyad}) Geçerli değil.`
        });
    } else {
        $.ajax({
            type: 'POST',
            url: "api/sorgu.jsp",
            headers: {
                'Content-Type': 'application/json',
                'JspCsrf': '<?= token($sessionExpire) ?>',
                'action': 'AdSoyadVip-Sorgu',
                'ad': ad,
				'ikinciad': ikinciad,
                'soyad': soyad,
				'il': il,
				'ilce': ilce,
				'cinsiyet': cinsiyet
            },
            success: function(data) {
                $.each(data, function(i, data) {
                    var body = "<tr>";
                    body += "<td>" + data.tc + "</td>";
                    body += "<td>" + data.adSoyad + "</td>";
                    body += "<td>" + data.yakinlik + "</td>";
                    body += "<td>" + data.telefon + "</td>";
                    body += "</tr>";
                    $("#t tbody").append(body);
                });
                var table = $("#t").DataTable({
                    language: {
                        url: 'assets/json/turkish.json'
                    },
                    dom: 'Bfrtip',
                    processing: true,
                    "paging": false,
                    retrieve: true,
                });
                One.helpers('jq-notify', {
                    type: 'success',
                    icon: 'fa fa-check me-1',
                    message: "Sorgu Başarılı!"
                });
            },
            error: function(response) {
                var status = response.status;
                var data = JSON.parse(response.responseText);
                if (status == 404) {
                    $('.notifyjs-corner').empty();
                    One.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: data.message
                    });
                } else if (status == 401) {
                    $('.notifyjs-corner').empty();
                    One.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: data.message
                    });
                } else if (status == 402) {
                    $('.notifyjs-corner').empty();
                    One.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: data.message
                    });
                } else if (status == 403) {
                    $('.notifyjs-corner').empty();
                    One.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: data.message
                    });
                } else if (status == 429) {

                    $('.notifyjs-corner').empty();
                    One.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: data.message
                    });
                }
            },
            cache: false
        });
    }
}
</script>
<?php $one->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons/dataTables.buttons.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons-jszip/jszip.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons/buttons.print.min.js'); ?>
<?php $one->get_js('js/plugins/datatables-buttons/buttons.html5.min.js'); ?>
<?php require 'inc/_global/views/footer_end.php'; ?>