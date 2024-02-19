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
        <form class="form-control w-100 mx-5" method="post" id="formAddAdmin" style="width: 30%;display: none">
            <h4 class="my-3">Adauga admin firma</h4>
            <div class="form-outline mb-4 mt-2">
                <input type="text" id="adminUsername" name="adminUsername"
                       class="form-control text-center fw-bold fs-5 lh-1"/>
                <label class="form-label" for="adminUsername">Nume utilizator</label>
            </div>
            <div class="form-outline mb-4 mt-2">
                <input type="text" id="adminPassword" name="adminPassword"
                       class="form-control text-center fw-bold fs-5 lh-1"/>
                <label class="form-label" for="adminPassword">Parola</label>
            </div>
            <button type="button" class="btn btn-primary mb-3" id="submitUserBtn"
                    style="font-size: 0.9rem">Adauga utilizator
            </button>
        </form>
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
        let urlValue = 'parts/siteAdmin/siteAdminAddCompanyAdmin/siteAdminAddCompanyAdmin_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        function loadModal(response) {
            if (response == 1) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Utilizator adaugat');
                $('#modalBtn').text('Inchide');
                myModal.show();
            } else if (response == 2) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Un utilizator cu acest nume exista deja');
                $('#modalBtn').text('Inchide');
                myModal.show();
            }
        }

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
                                $('#adminUsername').prop('disabled', false);
                                $('#adminPassword').prop('disabled', false);
                            } else {
                                newRow.removeClass('row-active');
                                $('#adminUsername').prop('disabled', true).val('');
                                $('#adminPassword').prop('disabled', true).val('');
                                $('#submitUserBtn').prop('disabled', true);
                            }
                        });
                        table.append(newRow);
                    })
                    $('#listContainer').show();
                    $('#formAddAdmin').show();
                    $('#submitUserBtn').prop('disabled', true);
                    $('#adminUsername').prop('disabled', true);
                    $('#adminPassword').prop('disabled', true);
                }
            });
        }

        $('#adminUsername, #adminPassword').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#adminUsername').val() !== "") && ($('#adminPassword').val() !== "")) {
                $('#submitUserBtn').prop('disabled', false);
            } else {
                $('#submitUserBtn').prop('disabled', true);
            }
        })

        $('#submitUserBtn').on('click', function () {
            dataObject['rowId'] = $('.row-active').attr('id');
            dataObject['username'] = $('#adminUsername').val();
            dataObject['password'] = $('#adminPassword').val();
            $('#searchBar').val('');
            $('#adminUsername').val('');
            $('#adminPassword').val('');
            $('tr.row-active').removeClass('row-active');
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    $('#submitUserBtn').prop('disabled', true);
                    $('#adminUsername').prop('disabled', true);
                    $('#adminPassword').prop('disabled', true);
                    loadModal(response);
                }
            });
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