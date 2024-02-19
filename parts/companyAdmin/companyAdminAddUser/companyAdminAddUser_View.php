<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <form class="form-control mx-5" method="post" id="formAddUser" style="width: 30%;display: none">
        <h4 class="my-3">Adauga utilizator</h4>
        <div class="form-outline mb-4 mt-2">
            <input type="text" id="usernameUser" name="usernameUser"
                   class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="usernameUser">Nume utilizator</label>
        </div>
        <div class="form-outline mb-4 mt-2">
            <input type="text" id="passwordUser" name="passwordUser"
                   class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="passwordUser">Parola</label>
        </div>
        <button type="button" class="btn btn-primary mb-3" id="submitUserBtn"
                style="font-size: 0.9rem">Adauga utilizator
        </button>
    </form>

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
                    <div class="fs-2 fw-bold mb-3" id="modalText"></div>
                    <button type="button" class="btn btn-primary fs-6" data-mdb-dismiss="modal" id="modalBtn"></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyAdmin/companyAdminAddUser/companyAdminAddUser_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        $('#formAddUser').show();
        $('#submitUserBtn').prop('disabled', true);

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

        $('#usernameUser, #passwordUser').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#usernameUser').val() !== "") && ($('#passwordUser').val() !== "")) {
                $('#submitUserBtn').prop('disabled', false);
            } else {
                $('#submitUserBtn').prop('disabled', true);
            }
        })

        $('#submitUserBtn').on('click', function () {
            dataObject['username'] = $('#usernameUser').val();
            dataObject['password'] = $('#passwordUser').val();
            $('#usernameUser').val('');
            $('#passwordUser').val('');
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    $('#submitUserBtn').prop('disabled', true);
                    loadModal(response);
                }
            });
        })
    })
</script>