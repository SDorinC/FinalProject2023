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
                    <label class="form-label" for="searchBar">Cauta angajat</label>
                </div>
            </div>
        </div>
        <div class="col-6 mb-2 d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary mb-3" id="resetSalaries"
                    style="font-size: 0.9rem">Reseteaza salarii platite
            </button>
        </div>
    </div>
    <div class="card-body p-0 h-100" style="max-height: 90%">
        <div class="table-responsive table-scroll h-100" style="position: relative">
            <table class="table table-striped mb-0" id="dataTable">
                <thead class="fs-4 fw-bolder table-dark">
                <tr class="text-uppercase">
                    <th scope="col" class="py-0">Nume angajat</th>
                    <th scope="col" class="py-0">CNP</th>
                    <th scope="col" class="py-0">Salariu brut</th>
                    <th scope="col" class="py-0">CAS</th>
                    <th scope="col" class="py-0">CASS</th>
                    <th scope="col" class="py-0">Impozit</th>
                    <th scope="col" class="py-0">Salariu net</th>
                    <th scope="col" class="py-0">Data angajarii</th>
                </tr>
                </thead>
                <tbody class="fs-5" style="background-color: #e5e8f1">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyUser/userEmployees/userEmployees_Controller.php';

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
                    infoArray.forEach((element) => {
                        let newCell = $('<td></td>');
                        newCell.text(element);
                        newRow.append(newCell)
                    })
                    newRow.find('td:first').addClass('sortable-column');
                    newRow.on('click', function () {
                        if (!newRow.hasClass('row-active')) {
                            table.find('tr').removeClass('row-active');
                            newRow.addClass('row-active');
                        } else {
                            newRow.removeClass('row-active');
                        }
                    });
                    table.append(newRow);
                    sortTable();
                })
                $('#listContainer').show();
            }
        });

        $('#resetSalaries').on('click', function () {
            dataObject.resetSalaries = 1;
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
            });
        });

        function sortTable() {
            let rows = $('tbody > tr', $('#dataTable')).toArray();
            rows.sort(function (a, b) {
                let columnValueA = $(a).find('.sortable-column').text().toUpperCase();
                let columnValueB = $(b).find('.sortable-column').text().toUpperCase();
                return columnValueA.localeCompare(columnValueB);
            });
            $.each(rows, function (index, row) {
                $('#dataTable').append(row);
            });
        }

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