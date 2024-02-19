<?php
include '../../../functionsAndClassesLoader.php';

giveAccess();

function showTable($tableId) {
    echo <<<HTML
 <div class="card-body p-0 h-100" style="max-height: 90%">
                <div class="table-responsive table-scroll h-100" style="position: relative">
                    <table class="table table-striped mb-0 w-100" id="table{$tableId}">
                        <thead class="fs-3 fw-bolder table-dark">
                        <tr class="text-uppercase">
                            <th scope="col" class="py-0">Descriere</th>
                            <th scope="col" class="py-0">Suma</th>
                            <th scope="col" class="py-0">Data</th>
                        </tr>
                        </thead>
                        <tbody class="fs-5" style="background-color: #e5e8f1">
                        </tbody>
                    </table>
                </div>
            </div>
HTML;
}

?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <form class="form-control mx-5" method="post" id="formSelect" style="width: 30%;display: none">
        <h4 class="my-3">Alege luna si anul</h4>
        <div class="row mb-3">
            <div class="col">
                <select class="form-select" id="selectMonth">
                    <option value="" selected disabled hidden>Alege luna</option>
                    <?php
                    $monthNames = [
                        "Ianuarie", "Februarie", "Martie", "Aprilie",
                        "Mai", "Iunie", "Iulie", "August",
                        "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
                    ];

                    for ($i = 0; $i < 12; $i++) {
                        $monthNumber = $i + 1;
                        echo "<option value=\"$monthNumber\">$monthNames[$i]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <select class="form-select" id="selectYear">
                    <option value="" selected disabled hidden>Alege anul</option>
                    <?php
                    $currentYear = date('Y');
                    for ($year = 2022; $year <= $currentYear; $year++) {
                        echo "<option value=\"$year\">$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary mb-3 w-100" id="showInfoBtn"
                style="font-size: 0.9rem">Afiseaza raportul contabil
        </button>
    </form>
    <div id="info" style="display: none; overflow-y: auto; height: 100%; width: 95%"
    ">
    <div class="my-5">
        <h4 class="my-3 fs-3">INCASARI FACTURI MARFA</h4>
        <?php showTable(1); ?>
    </div>
    <div class="my-5">
        <h4 class="my-3 fs-3">PLATI FACTURI MARFA</h4>
        <?php showTable(2); ?>
    </div>
    <div class="my-5">
        <h4 class="my-3 fs-3">PLATI SALARII</h4>
        <?php showTable(3); ?>
    </div>
    <div class="my-5">
        <h4 class="my-3 fs-3">PLATI DIVERSE</h4>
        <?php showTable(4); ?>
    </div>
    <div>
        <h1 class="my-3 fs-1 fw-bolder" id="initialSold"></h1>
        <h1 class="my-3 fs-1 fw-bolder" id="finalSold"></h1>
    </div>
</div>
<div class="w-50" id="noData" style="display: none">
    <div class="fs-2 fw-bolder my-3">
        NU EXISTA DATE PENTRU LUNA SI ANUL SELECTATE
    </div>
    <button type="button" class="btn btn-primary mb-3 w-25" id="noDataBtn"
            style="font-size: 0.9rem">Inapoi
    </button>
</div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyUser/userMonthlyAccountingReport/userMonthlyAccountingReport_Controller.php';

        let total1 = 0;
        let total2 = 0;
        let total3 = 0;
        let total4 = 0;

        let initialSold = 0;
        let finalSold = 0;

        let dataObject = {};
        dataObject[urlValue] = '';

        function showTable(idValue, array) {
            let value = parseFloat(array[1]);
            let formattedValue = value.toFixed(2);
            if (idValue == 1) {
                total1 += parseFloat(formattedValue);
            } else if (idValue == 2) {
                total2 += parseFloat(formattedValue);
            } else if (idValue == 3) {
                total3 += parseFloat(formattedValue);
            } else if (idValue == 4) {
                total4 += parseFloat(formattedValue);
            }

            let date = new Date(array[4], array[3] - 1, array[2]);
            let formattedDate = `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;

            let newRow = $('<tr></tr>');
            let newCell1 = $('<td></td>').text(array[0]);
            let newCell2 = $('<td></td>').text(array[1] + ' lei');
            let newCell3 = $('<td></td>').text(formattedDate);
            newRow.append(newCell1, newCell2, newCell3);
            $('#table' + idValue).append(newRow);
        }

        $('#formSelect').show();
        $('#showInfoBtn').on('click', function () {
            dataObject.month = $('#selectMonth').val();
            dataObject.year = $('#selectYear').val();
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    let responseArr = JSON.parse(response);
                    if (responseArr.length > 0) {
                        responseArr.forEach((infoArray) => {
                            if (infoArray[5] == 0) {
                                initialSold = infoArray[1];
                                $('#initialSold').text('SOLD PRECEDENT: ' + initialSold + ' LEI')
                            } else if (infoArray[5] == 2) {
                                showTable(1, infoArray);
                            } else if (infoArray[5] == 1) {
                                showTable(2, infoArray);
                            } else if (infoArray[5] == 3) {
                                showTable(3, infoArray);
                            } else if (infoArray[5] == 4) {
                                showTable(4, infoArray);
                            }
                        });
                        let totalRow1 = $('<tr></tr>');
                        let totalCell1 = $('<td colspan="3"></td>').text('TOTAL: ' + total1.toFixed(2) + ' LEI');
                        finalSold += total1;
                        totalRow1.append(totalCell1);
                        totalRow1.css({
                            'font-size': '2.3rem',
                            'font-weight': 'bold'
                        });
                        $('#table1').append(totalRow1);
                        let totalRow2 = $('<tr></tr>');
                        let totalCell2 = $('<td colspan="3"></td>').text('TOTAL: ' + total2.toFixed(2) + ' LEI');
                        finalSold += total2;
                        totalRow2.append(totalCell2);
                        totalRow2.css({
                            'font-size': '2.3rem',
                            'font-weight': 'bold'
                        });
                        $('#table2').append(totalRow2);
                        let totalRow3 = $('<tr></tr>');
                        let totalCell3 = $('<td colspan="3"></td>').text('TOTAL: ' + total3.toFixed(2) + ' LEI');
                        finalSold += total3;
                        totalRow3.append(totalCell3);
                        totalRow3.css({
                            'font-size': '2.3rem',
                            'font-weight': 'bold'
                        });
                        $('#table3').append(totalRow3);
                        let totalRow4 = $('<tr></tr>');
                        let totalCell4 = $('<td colspan="3"></td>').text('TOTAL: ' + total4.toFixed(2) + ' LEI');
                        finalSold += total4;
                        totalRow4.append(totalCell4);
                        totalRow4.css({
                            'font-size': '2.3rem',
                            'font-weight': 'bold'
                        });
                        $('#table4').append(totalRow4);

                        $('#selectMonth').val('');
                        $('#selectYear').val('');
                        $('#showInfoBtn').prop('disabled', true);
                        $('#finalSold').text('SOLD ACTUAL: ' + (initialSold - finalSold).toFixed(2) + ' LEI')
                        $('#formSelect').hide();
                        $('#info').show();
                    } else {
                        $('#selectMonth').val('');
                        $('#selectYear').val('');
                        $('#showInfoBtn').prop('disabled', true);
                        $('#formSelect').hide();
                        $('#noData').show();
                    }
                }
            });
        }).prop('disabled', true);
        $('#selectMonth, #selectYear').change(function () {
            let selectedMonth = $('#selectMonth').val();
            let selectedYear = $('#selectYear').val();

            if (selectedMonth && selectedYear) {
                $('#showInfoBtn').prop('disabled', false);
            } else {
                $('#showInfoBtn').prop('disabled', true);
            }
        });
        $('#noDataBtn').on('click', function () {
            $('#noData').hide();
            $('#formSelect').show();
        });
    })
</script>