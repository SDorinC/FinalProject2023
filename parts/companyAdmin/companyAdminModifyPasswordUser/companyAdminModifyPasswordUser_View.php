<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <div class="col-5 mt-2 h-100">
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
        <form class="form-control w-100 mx-1 mt-5" method="post" id="formModifyPassUser"
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
        let urlValue = 'parts/companyAdmin/companyAdminModifyPasswordUser/companyAdminModifyPasswordUser_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        function handleData() {
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    let responseArr = JSON.parse(response);
                    let table = $('#userTable');
                    responseArr.forEach((infoArray) => {
                        let newRow = $('<tr></tr>');
                        newRow.attr('id', infoArray[0]);
                        let newCell = $('<td></td>');
                        newCell.text(infoArray[1]);
                        newRow.append(newCell);
                        newRow.on('click', function () {
                            if (!newRow.hasClass('row-active')) {
                                table.find('tr').removeClass('row-active');
                                newRow.addClass('row-active');
                                dataObject['userId'] = $(this).attr('id');
                                $.ajax({
                                    type: 'POST',
                                    url: urlValue,
                                    data: dataObject,
                                    success: function (response) {
                                        $('#oldPass').val(response).prop('disabled', true);
                                        $('#submitPass').prop('disabled', true);
                                        $('#formModifyPassUser').show();
                                        $('#newPass').val('').focus();
                                    }
                                })
                            } else {
                                newRow.removeClass('row-active');
                                $('#formModifyPassUser').hide();
                            }
                        });
                        table.append(newRow);
                    })
                    $('#userTable').show();
                }
            });
        }

        handleData();

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
            dataObject['newPassword'] = $('#newPass').val();
            $('#newPass').val('');
            $('#submitPass').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    delete dataObject.newPassword;
                    $('#userTable').find('tr').removeClass('row-active');
                    $('#formModifyPassUser').hide();
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
    })
</script>