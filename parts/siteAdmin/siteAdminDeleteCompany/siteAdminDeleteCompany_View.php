<?php
include '../../header.php';

giveAccess();
?>

<div class="row h-100">
    <div class="col-7 justify-content-center align-items-center text-center overflow-x.hidden h-100" id="listContainer"
         style="display: none">
        <div class="row mt-2 sticky-top">
            <div class="mb-2">
                <div class="input-group">
                    <div class="form-outline flex-fill ms-1">
                        <input type="search" id="searchBar" class="form-control form-control-lg"/>
                        <label class="form-label" for="searchBar">Cauta firma</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0 h-100" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative">
                <table class="table table-striped mb-0" id="dataTable">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Nume firma</th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex align-items-center justify-content-center h-100">
        <button class="btn btn-primary fs-4" id="delBtn" style="display: none">Sterge firma selectata</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/siteAdmin/siteAdminDeleteCompany/siteAdminDeleteCompany_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        function handleData() {
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
                        let newCell = $('<td></td>');
                        newCell.text(infoArray[1]);
                        newRow.append(newCell);
                        newRow.on('click', function () {
                            if (!newRow.hasClass('row-active')) {
                                table.find('tr').removeClass('row-active');
                                newRow.addClass('row-active');
                                $('#delBtn').prop('disabled', false);
                            } else {
                                newRow.removeClass('row-active');
                                $('#delBtn').prop('disabled', true);
                            }
                        });
                        table.append(newRow);
                    })
                    $('#listContainer').show();
                    $('#delBtn').prop('disabled', true).show();
                }
            });
        }

        $('#delBtn').on('click', function () {
            dataObject['rowId'] = $('.row-active').attr('id');
            $('#dataTable').find('tbody').empty();
            $('#searchBar').val('');
            handleData();
        })

        handleData();

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
