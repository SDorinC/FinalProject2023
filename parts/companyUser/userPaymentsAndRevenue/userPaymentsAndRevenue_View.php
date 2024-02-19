<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <form class="form-control mx-5" method="post" id="formSelectButtons" style="width: 30%;display: none">
        <h4 class="my-3">Alege tipul operatiunii</h4>
        <button type="button" class="btn btn-primary mb-3 w-100" id="btn1"
                style="font-size: 0.9rem">Incasari facturi marfa
        </button>
        <button type="button" class="btn btn-primary mb-3 w-100" id="btn2"
                style="font-size: 0.9rem">Plati facturi marfa
        </button>
        <button type="button" class="btn btn-primary mb-3 w-100" id="btn3"
                style="font-size: 0.9rem">Plati salarii
        </button>
        <button type="button" class="btn btn-primary mb-3 w-100" id="btn4"
                style="font-size: 0.9rem">Plati diverse
        </button>
    </form>
    <div class="h-75" id="div1" style="display: none">
        <div class="card-body p-0 h-50" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative;overflow-x: hidden;">
                <table class="table table-striped mb-0" id="table1">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Nume partener</th>
                        <th scope="col" class="py-0">CUI/CIF partener</th>
                        <th scope="col" class="py-0">Numar factura</th>
                        <th scope="col" class="py-0">Data</th>
                        <th scope="col" class="py-0">Total</th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-100">
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="payBtn1">
                Confirma plata
            </button>
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="backBtn1">
                Inapoi
            </button>
        </div>
    </div>
    <div class="h-75" id="div2" style="display: none">
        <div class="card-body p-0 h-50" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative;overflow-x: hidden;">
                <table class="table table-striped mb-0" id="table2">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Nume partener</th>
                        <th scope="col" class="py-0">CUI/CIF partener</th>
                        <th scope="col" class="py-0">Numar factura</th>
                        <th scope="col" class="py-0">Data</th>
                        <th scope="col" class="py-0">Total</th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-100">
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="payBtn2">
                Confirma plata
            </button>
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="backBtn2">
                Inapoi
            </button>
        </div>
    </div>
    <div class="h-75" id="div3" style="display: none">
        <div class="card-body p-0 h-50" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative;overflow-x: hidden;">
                <table class="table table-striped mb-0" id="table3">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Nume angajat</th>
                        <th scope="col" class="py-0">CNP angajat</th>
                        <th scope="col" class="py-0">Suma de plata</th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-100">
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="payBtn3">
                Confirma plata
            </button>
            <button type="button" class="btn btn-primary mt-5 fs-4 col-5" id="backBtn3">
                Inapoi
            </button>
        </div>
    </div>
    <form class="form-control" id="div4" method="post" style="width: 35%;display: none">
        <h4 class="my-3">Introdu informatii plata</h4>
        <div class="form-outline mb-4 mt-2">
            <textarea type="text" id="input1" name="input1"
                      class="form-control text-center fw-bold fs-5 lh-1"></textarea>
            <label class="form-label" for="input1">Descriere operatiune</label>
        </div>
        <div class="form-outline mb-4 mt-2">
            <input type="number" id="input2" name="input2" class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="input2">Suma platita</label>
        </div>
        <div class="mb-4">
            <button type="button" class="btn btn-primary col-4" id="payBtn4">
                Confirma plata
            </button>
            <button type="button" class="btn btn-primary col-4" id="backBtn4">
                Inapoi
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyUser/userPaymentsAndRevenue/userPaymentsAndRevenue_Controller.php';
        let requestId = 0;

        let dataObject = {};
        dataObject[urlValue] = '';

        $('#formSelectButtons').show();

        function showTable(requestIdValue) {
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    let responseArr = JSON.parse(response);
                    let table = $('#table' + requestIdValue);
                    responseArr.forEach((infoArray) => {
                        let newRow = $('<tr></tr>');
                        newRow.attr('id', infoArray[0]);
                        infoArray.forEach((item, index) => {
                            if (index !== 0) {
                                let newCell = $('<td></td>');
                                newCell.text(item);
                                newRow.append(newCell);
                            }
                        });
                        newRow.on('click', function () {
                            if (!newRow.hasClass('row-active')) {
                                table.find('tr').removeClass('row-active');
                                newRow.addClass('row-active');
                                $('#payBtn' + requestIdValue).prop('disabled', false);
                            } else {
                                newRow.removeClass('row-active');
                                $('#payBtn' + requestIdValue).prop('disabled', true);
                            }
                        });
                        table.append(newRow);
                    });
                    $('#payBtn' + requestIdValue).prop('disabled', true);
                    $('#div' + requestIdValue).show();
                }
            });
        }

        function generateTable(requestIdValue) {
            $('#formSelectButtons').hide();
            requestId = requestIdValue;
            dataObject.requestId = requestId;
            showTable(requestIdValue);
            $('#payBtn' + requestIdValue).off('click').on('click', function () {
                dataObject.requestId = requestId;
                dataObject.transactionId = $('#table' + requestIdValue).find('tr.row-active').attr('id');
                $.ajax({
                    type: 'POST',
                    url: urlValue,
                    data: dataObject,
                    success: function () {
                        delete dataObject.transactionId;
                        $('#table' + requestIdValue).find('tbody').empty();
                        showTable(requestIdValue);
                    }
                });
            });
            $('#backBtn' + requestIdValue).on('click', function () {
                $('#div' + requestIdValue).hide();
                $('#table' + requestIdValue).find('tbody').empty();
                $('#formSelectButtons').show();
            });
        }

        $('#btn1').on('click', function () {
            generateTable(1);
        });
        $('#btn2').on('click', function () {
            generateTable(2);
        });
        $('#btn3').on('click', function () {
            generateTable(3);
        });
        $('#btn4').on('click', function () {
            $('#formSelectButtons').hide();
            $('#div4').show();
            $('#payBtn4').prop('disabled', true).off('click').on('click', function () {
                dataObject.requestId = '4';
                dataObject.description = $('#input1').val();
                dataObject.value = $('#input2').val();
                $.ajax({
                    type: 'POST',
                    url: urlValue,
                    data: dataObject,
                    success: function () {
                        $('#input1').val('');
                        $('#input2').val('');
                        $('#payBtn4').prop('disabled', true);
                        delete dataObject.description;
                        delete dataObject.value;
                    }
                });
            });
            $('#backBtn4').on('click', function () {
                $('#div4').hide();
                $('#input1').val('');
                $('#input2').val('');
                $('#formSelectButtons').show();
            });
            $('#input1,#input2').contextmenu(function () {
                return false;
            }).on('keydown keyup keypress contextmenu', function () {
                if (($('#input1').val() !== "") && ($('#input2').val() !== "")) {
                    $('#payBtn4').prop('disabled', false);
                } else {
                    $('#payBtn4').prop('disabled', true);
                }
            })
        });

    })
</script>