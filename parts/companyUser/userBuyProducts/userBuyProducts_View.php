<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" id="buyProductsContainer"
     style="height: 100%">
    <form class="form-control" method="post" id="formTransaction" style="width: 30%">
        <h4 class="my-3">Tranzactie noua</h4>
        <div class="form-outline mb-4 mt-2">
            <input type="text" id="partnerName" name="partnerName" class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="partnerName">Nume partener</label>
        </div>
        <div class="form-outline mb-4 mt-2">
            <input type="number" id="partnerCUI" name="partnerCUI" class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="partnerCUI">CUI/CIF partener</label>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-outline mb-4">
                    <input type="text" id="transactionNr" name="transactionNr"
                           class="form-control text-center fw-bold fs-5 lh-1"/>
                    <label class="form-label" for="transactionNr">Numar factura</label>
                </div>
            </div>
            <div class="col">
                <div class="form-outline mb-4">
                    <input type="text" id="transactionDate" name="transactionDate"
                           class="form-control text-center fw-bold fs-5 lh-1"/>
                    <label class="form-label" for="transactionDate">Data</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary mb-3" id="submitTransaction" style="font-size: 0.9rem">Adauga
            tranzactie
        </button>
    </form>
    <div class="w-100" id="productsInput" style="display: none">
        <div class="row fs-4 fw-bolder">
            <div class="col-2 text-start" id="div1">
            </div>
            <div class="col-7 text-center" id="div2">
            </div>
            <div class="col-3 d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-primary mx-2" id="addProductBtn">Adauga produs</button>
                <button type="button" class="btn btn-primary" id="finalizeTransactionBtn">Finalizeaza tranzactia
                </button>
            </div>
        </div>
        <div class="row">
            <hr style="border: 2px solid black;">
            <hr style="border: 2px solid black;">
        </div>
        <div class="card-body p-0 h-100" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative">
                <table class="table table-striped mb-0" id="productsTable">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Denumire produs</th>
                        <th scope="col" class="py-0">Pret</th>
                        <th scope="col" class="py-0">Cota TVA</th>
                        <th scope="col" class="py-0">Cantitate</th>
                        <th scope="col" class="py-0" id="transactionTotal"></th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
            class="modal fade"
            id="staticBackdrop"
            data-mdb-backdrop="static"
            data-mdb-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fs-2 fw-bold mb-3">Adauga produs</div>
                    <div class="form-outline mb-4">
                        <input type="text" id="productName" name="productName"
                               class="form-control text-center fw-bold fs-5 lh-1"/>
                        <label class="form-label" for="productName">Denumire produs</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="number" id="productPrice" name="productPrice"
                               class="form-control text-center fw-bold fs-5 lh-1"/>
                        <label class="form-label" for="productPrice">Pret</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="number" id="productTVA" name="productTVA"
                               class="form-control text-center fw-bold fs-5 lh-1"/>
                        <label class="form-label" for="productTVA">Cota TVA</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="number" id="productQuantity" name="productQuantity"
                               class="form-control text-center fw-bold fs-5 lh-1"/>
                        <label class="form-label" for="productQuantity">Cantitate</label>
                    </div>
                    <button type="button" class="btn btn-primary fs-6" data-mdb-dismiss="modal" id="modalBtnOK">Adauga
                        produs
                    </button>
                    <button type="button" class="btn btn-primary fs-6" data-mdb-dismiss="modal" id="modalBtnCancel">
                        Anuleaza
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyUser/userBuyProducts/userBuyProducts_Controller.php';
        let productsObject = {};
        let counter = 0;
        let transactionId;
        let transactionTotal = 0;

        let name;
        let cui;
        let number;
        let date;

        function showTransactionData() {
            $('#formTransaction').hide();
            $('#buyProductsContainer').removeClass('align-items-center');
            let newDiv1 = $('<div></div>');
            let newDiv2 = $('<div></div>');
            let newDiv3 = $('<div></div>');
            let newDiv4 = $('<div></div>');
            newDiv1.text('Nume partener: ' + $('#partnerName').val());
            newDiv2.text('CUI/CIF partener: ' + $('#partnerCUI').val());
            newDiv3.text('Numar factura: ' + $('#transactionNr').val());
            newDiv4.text('Data: ' + $('#transactionDate').val());
            $('#div1').append(newDiv1, newDiv2);
            $('#div2').append(newDiv3, newDiv4);
            $('#transactionTotal').text('Total: ' + transactionTotal + ' lei')
            $('#finalizeTransactionBtn').prop('disabled', true);
            $('#productsInput').show();

            name = $('#partnerName').val();
            cui = $('#partnerCUI').val();
            number = $('#transactionNr').val();
            date = $('#transactionDate').val();

            $('#partnerName, #partnerCUI, #transactionNr,#transactionDate').val(null);
            $('#submitTransaction').prop('disabled', true);
        }

        function sendTransactionData() {
            let dataObject = {};
            dataObject[urlValue] = '';
            dataObject.partnerName = name;
            dataObject.partnerCUI = cui;
            dataObject.transactionNr = number;
            dataObject.transactionDate = date;
            dataObject.transactionTotal = transactionTotal;
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    transactionId = response;
                    let dataObject = {};
                    dataObject[urlValue] = '';
                    dataObject.products = productsObject;
                    dataObject.transactionId = transactionId;
                    $.ajax({
                        type: 'POST',
                        url: urlValue,
                        data: dataObject,
                        success: function () {
                            productsObject = {};
                            counter = 0;
                            transactionTotal = 0;
                            $('#finalizeTransactionBtn').prop('disabled', true);
                            $('#productsTable tbody,#div1,#div2').empty();
                            $('#productsInput').hide();
                            $("#buyProductsContainer").addClass('align-items-center');
                            $('#formTransaction').show();
                        }
                    });
                }
            });
        }

        function processProductData() {
            productsObject[counter] = [$('#productName').val(), $('#productPrice').val(),
                $('#productTVA').val(), $('#productQuantity').val()];
            counter++;
            $('#modalBtnOK').prop('disabled', true);

            let price = parseFloat($('#productPrice').val());
            let tva = parseFloat($('#productTVA').val());
            let quantity = parseFloat($('#productQuantity').val());
            let total = [(price / 100 * tva) + price] * quantity;
            let formattedTotal = total.toFixed(2);

            transactionTotal += parseFloat(formattedTotal);
            $('#transactionTotal').text('Total: ' + transactionTotal.toFixed(2) + ' lei')

            let newRow = $('<tr></tr>');
            let newCell1 = $('<td></td>').text($('#productName').val());
            let newCell2 = $('<td></td>').text($('#productPrice').val() + ' lei');
            let newCell3 = $('<td></td>').text($('#productTVA').val() + '%');
            let newCell4 = $('<td></td>').text($('#productQuantity').val());
            let newCell5 = $('<td></td>').text(formattedTotal + ' lei');
            newRow.append(newCell1, newCell2, newCell3, newCell4, newCell5);
            newRow.on('click', function () {
                if (!newRow.hasClass('row-active')) {
                    $('#productsTable').find('tr').removeClass('row-active');
                    newRow.addClass('row-active');
                } else {
                    newRow.removeClass('row-active');
                }
            });
            $('#productsTable').prepend(newRow);
        }

        $('#submitTransaction').prop('disabled', true).on('click', function () {
            showTransactionData();
        })
        $('#partnerName, #partnerCUI, #transactionNr,#transactionDate').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#partnerName').val() !== "") && ($('#partnerCUI').val() !== "") && ($('#transactionNr').val() !== "") &&
                ($('#transactionDate').val() !== "")) {
                $('#submitTransaction').prop('disabled', false);
            } else {
                $('#submitTransaction').prop('disabled', true);
            }
        })

        $('#addProductBtn').on('click', function () {
            let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
            myModal.show();
        })

        $('#modalBtnOK').prop('disabled', true).on('click', function () {
            processProductData();
            if (Object.keys(productsObject).length > 0) {
                $('#finalizeTransactionBtn').prop('disabled', false);
            }
            $('#productName').val('');
            $('#productPrice').val('');
            $('#productTVA').val('');
            $('#productQuantity').val('');
        })
        $('#modalBtnCancel').on('click', function () {
            $('#productName').val('');
            $('#productPrice').val('');
            $('#productTVA').val('');
            $('#productQuantity').val('');
        })
        $('#productName, #productPrice, #productTVA,#productQuantity').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#productName').val() !== "") && ($('#productPrice').val() !== "") && ($('#productTVA').val() !== "") &&
                ($('#productQuantity').val() !== "")) {
                $('#modalBtnOK').prop('disabled', false);
            } else {
                $('#modalBtnOK').prop('disabled', true);
            }
        })

        $('#finalizeTransactionBtn').on('click', function () {
            sendTransactionData();
        });
    })
</script>