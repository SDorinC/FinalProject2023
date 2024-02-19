<?php
include '../../header.php';

giveAccess();
?>

<div class="justify-content-center align-items-center text-center h-100" id="listContainer"
     style="display: none">
    <div class="row mt-2 sticky-top w-100">
        <div class="col-6 mb-2">
            <div class="input-group">
                <div class="form-outline flex-fill ms-1">
                    <input type="search" id="searchBar" class="form-control form-control-lg"/>
                    <label class="form-label" for="searchBar">Cauta nume partener</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0 h-100" style="max-height: 90%">
        <div class="table-responsive table-scroll h-100" style="position: relative">
            <table class="table table-striped mb-0" id="dataTable">
                <thead class="fs-3 fw-bolder table-dark">
                <tr class="text-uppercase">
                    <th scope="col" class="py-0">Nume partener</th>
                    <th scope="col" class="py-0">CUI/CIF partener</th>
                    <th scope="col" class="py-0">Numarul tranzactiei</th>
                    <th scope="col" class="py-0">Data tranzactiei</th>
                    <th scope="col" class="py-0">Tipul tranzactiei</th>
                </tr>
                </thead>
                <tbody class="fs-5" style="background-color: #e5e8f1">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="justify-content-center align-items-center text-center" id="transactionInfo" style="display: none">
    <div class="w-100">
        <div class="row fs-4 fw-bolder">
            <div class="col-2 text-start" id="div1">
            </div>
            <div class="col-7 text-center" id="div2">
            </div>
            <div class="col-3 d-flex align-items-center justify-content-end">
                <div class="mx-4" id="div3"></div>
                <button type="button" class="btn btn-primary mx-2 w-25" id="backBtn">Inapoi</button>
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
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyUser/userTransactions/userTransactions_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';
        $.ajax({
            type: 'POST',
            url: urlValue,
            data: dataObject,
            success: function (response) {
                let responseArr = JSON.parse(response);
                let table = $('#dataTable');
                responseArr.forEach((infoArray) => {
                    let newRow = $('<tr></tr>');
                    newRow.addClass('rowData');
                    newRow.attr('id', infoArray[0]);
                    infoArray.forEach((element, index) => {
                        if (index != 0) {
                            let newCell = $('<td></td>');
                            if (index === infoArray.length - 1) {
                                if (element == 1) {
                                    newCell.text('cumparare');
                                } else if (element == 2) {
                                    newCell.text('vanzare');
                                }
                            } else {
                                newCell.text(element);
                            }
                            newRow.append(newCell)
                        }
                    })
                    newRow.on('click', function () {
                        if (!newRow.hasClass('row-active')) {
                            table.find('tr').removeClass('row-active');
                            newRow.addClass('row-active');
                        } else {
                            newRow.removeClass('row-active');
                        }
                    });
                    newRow.on('dblclick', function () {
                        let transactionId = $(this).attr('id');
                        showTransaction(transactionId);
                    });
                    table.append(newRow);
                })
                $('#listContainer').show();
            }
        });

        function showTransaction(id) {
            let transactionTotal = 0;
            dataObject.transactionId = id;

            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    let responseArr = JSON.parse(response);
                    $('#listContainer').hide();
                    let newDiv1 = $('<div></div>');
                    let newDiv2 = $('<div></div>');
                    let newDiv3 = $('<div></div>');
                    let newDiv4 = $('<div></div>');
                    newDiv1.text('Nume partener: ' + responseArr[0]);
                    newDiv2.text('CUI/CIF partener: ' + responseArr[1]);
                    newDiv3.text('Numar factura: ' + responseArr[2]);
                    newDiv4.text('Data: ' + responseArr[3]);
                    $('#div1').append(newDiv1, newDiv2);
                    $('#div2').append(newDiv3, newDiv4);
                    if (responseArr[4] == 1) {
                        $('#div3').append('Tip tranzactie: cumparare');
                    } else if (responseArr[4] == 2) {
                        $('#div3').append('Tip tranzactie: vanzare');
                    }

                    responseArr[5].forEach((infoArray) => {
                        let newRow = $('<tr></tr>');

                        let price = parseFloat(infoArray[1]);
                        let tva = parseFloat(infoArray[2]);
                        let quantity = parseFloat(infoArray[3]);
                        let total = [(price / 100 * tva) + price] * quantity;
                        let formattedTotal = total.toFixed(2);

                        let newCell1 = $('<td></td>').text(infoArray[0]);
                        let newCell2 = $('<td></td>').text(parseFloat(infoArray[1]).toFixed(2) + ' lei');
                        let newCell3 = $('<td></td>').text(infoArray[2] + '%');
                        let newCell4 = $('<td></td>').text(infoArray[3]);
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

                        transactionTotal += parseFloat(formattedTotal);
                        $('#transactionTotal').text('Total: ' + transactionTotal.toFixed(2) + ' lei')
                        $('#productsTable').append(newRow);
                    })
                }
            });


            $('#transactionTotal').text('Total: ' + transactionTotal.toFixed(2) + ' lei')
            $('#transactionInfo').show();
        }

        $('#backBtn').on('click', function () {
            $('#transactionInfo').hide();
            $('#div1, #div2,#div3').empty();
            $('#productsTable').find('tbody').empty();
            $('#listContainer').show();
        })

        function performSearch() {
            let searchText = $('#searchBar').val().toLowerCase();
            $('.rowData').each(function () {
                let data = $(this).find(':nth-child(1)').text().toLowerCase();
                if (searchText === '') {
                    $(this).show();
                } else if (data.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $('#searchBar').on('input', function () {
            performSearch();
        });
    })
</script>