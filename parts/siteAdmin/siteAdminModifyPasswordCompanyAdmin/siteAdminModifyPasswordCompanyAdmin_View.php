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
            <div class="card-body p-0 h-50" style="max-height: 90%">
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
            <form class="form-control w-100 mx-1 mt-5" method="post" id="formModifyPass"
                  style="width: 30%;display: none">
                <h4 class="my-3">Modifica parola</h4>
                <div class="form-outline mb-4 mt-2">
                    <input type="text" id="oldPass" name="oldPass"
                           class="form-control text-center fw-bold fs-5 lh-1"/>
                    <label class="form-label" for="oldPass">Parola curenta</label>
                </div>
                <div class="form-outline mb-4 mt-2">
                    <input type="text" id="newPass" name="newPass"
                           class="form-control text-center fw-bold fs-5 lh-1"/>
                    <label class="form-label" for="newPass">Parola noua</label>
                </div>
                <button type="button" class="btn btn-primary mb-3" id="submitPass"
                        style="font-size: 0.9rem">Modifica parola
                </button>
            </form>
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
        <div class="modal-dialog modal-dialog-centered" id="modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fs-2 fw-bold mb-3" id="modalText"></div>
                    <button type="button" class="btn btn-primary fs-6" data-mdb-dismiss="modal" id="modalBtn"></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/siteAdmin/siteAdminModifyPasswordCompanyAdmin/siteAdminModifyPasswordCompanyAdmin_Controller.php';

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
                        dataObject['userRowId'] = $(this).attr('id');
                        $.ajax({
                            type: 'POST',
                            url: urlValue,
                            data: dataObject,
                            success: function (response) {
                                $('#oldPass').val(response).prop('disabled', true);
                                $('#submitPass').prop('disabled', true);
                                $('#formModifyPass').show();
                                $('#newPass').val('').focus();
                            }
                        })
                    } else {
                        newUserRow.removeClass('row-active');
                        $('#formModifyPass').hide();
                    }
                });
                userTable.append(newUserRow);
            });
            $('#userTable').show();
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
                            $('#formModifyPass').hide();
                            if ('userRowId' in dataObject) {
                                delete dataObject.userRowId;
                            }
                            if ('newPassword' in dataObject) {
                                delete dataObject.newPassword;
                            }
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
                            $('#userTable').hide().find('tbody').empty();
                            $('#formModifyPass').hide();
                        }
                    });
                    table.append(newRow);
                })
                $('#listContainer').show();
            }
        });

        $('#newPass').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if ($('#newPass').val() !== "") {
                $('#submitPass').prop('disabled', false);
            } else {
                $('#submitPass').prop('disabled', true);
            }
        })

        $('#submitPass').on('click', function () {
            dataObject['userRowId'] = $('tr.row-active.rowUserData').attr('id');
            dataObject['newPassword'] = $('#newPass').val();
            $('#searchBar').val('');
            $('#newPass').val('');
            $('#submitPass').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    delete dataObject.userRowId;
                    delete dataObject.newPassword;
                    $('#userTable').find('tr').removeClass('row-active');
                    $('#formModifyPass').hide();
                    if (response == 1) {
                        let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                        $('#modalText').text('Parola a fost schimbata');
                        $('#modalBtn').text('Inchide');
                        myModal.show();
                    } else if (response == 2) {
                        let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                        $('#modalText').text('A aparut o eroare');
                        $('#modalBtn').text('Inchide');
                        myModal.show();
                    }
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
