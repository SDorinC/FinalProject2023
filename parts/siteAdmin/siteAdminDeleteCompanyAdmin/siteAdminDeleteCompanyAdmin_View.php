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
    <div class="col-5 d-flex justify-content-center h-100">
        <div class="col-12 mt-2 h-100">
            <div class="card-body p-0 h-75" style="max-height: 90%">
                <div class="table-responsive table-scroll h-100" style="position: relative">
                    <table class="table table-striped mb-0" id="userTable" style="display: none">
                        <thead class="fs-3 fw-bolder table-dark">
                        <tr class="text-uppercase">
                            <th scope="col" class="py-0">Nume utilizator</th>
                        </tr>
                        </thead>
                        <tbody class="fs-5" style="background-color: #e5e8f1">
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-primary mt-5 fs-4" id="deleteUserBtn" style="display: none">
                Sterge utilizator
            </button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/siteAdmin/siteAdminDeleteCompanyAdmin/siteAdminDeleteCompanyAdmin_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        function loadUsersTable(response) {
            let responseUserArr = JSON.parse(response);
            let userTable = $('#userTable');
            userTable.find('tbody').empty();
            responseUserArr[0].forEach((infoArray) => {
                let newUserRow = $('<tr></tr>');
                newUserRow.addClass('rowUserData');
                newUserRow.attr('id', infoArray['id']);
                let newUserCell = $('<td></td>');
                newUserCell.text(infoArray['username']);
                newUserRow.append(newUserCell);
                newUserRow.on('click', function () {
                    if (!newUserRow.hasClass('row-active')) {
                        userTable.find('tr').removeClass('row-active');
                        newUserRow.addClass('row-active');
                        $('#deleteUserBtn').prop('disabled', false);
                    } else {
                        newUserRow.removeClass('row-active');
                        $('#deleteUserBtn').prop('disabled', true);
                    }
                });
                userTable.append(newUserRow);
            });
            $('#userTable').show();
            $('#deleteUserBtn').show().prop('disabled', true);
        }

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
                            dataObject['rowId'] = $('.row-active').attr('id');
                            $.ajax({
                                type: 'POST',
                                url: urlValue,
                                data: dataObject,
                                success: function (response) {
                                    loadUsersTable(response);
                                }
                            });
                        } else {
                            newRow.removeClass('row-active');
                            $('#deleteUserBtn').hide();
                            $('#userTable').hide().find('tbody').empty();
                        }
                    });
                    table.append(newRow);
                })
                $('#listContainer').show();
            }
        });

        $('#deleteUserBtn').on('click', function () {
            dataObject['userRowId'] = $('tr.row-active.rowUserData').attr('id');
            $('#searchBar').val('');
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    loadUsersTable(response);
                }
            });
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