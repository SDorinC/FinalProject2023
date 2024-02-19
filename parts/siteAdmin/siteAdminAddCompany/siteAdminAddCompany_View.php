<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <form class="form-control" method="post" id="formCUI" style="width: 30%">
        <h4 class="my-3">Introduceti CUI/CIF firma</h4>
        <div class="form-outline mb-4 mt-2">
            <input type="number" id="inputCUI" name="companyCUI" class="form-control text-center fw-bold fs-5 lh-1"/>
            <label class="form-label" for="inputCUI">CUI/CIF firma</label>
        </div>
        <button type="button" class="btn btn-primary mb-3" id="submitCUIBtn" style="font-size: 0.9rem">Adauga firma
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
        function loadModal(response) {
            if (response == 1) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Firma adaugata');
                $('#modalBtn').text('Inchide');
                myModal.show();
            } else if (response == 3) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Firma exista deja');
                $('#modalBtn').text('Inchide');
                myModal.show();
            } else {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('A aparut o eroare');
                $('#modalBtn').text('Reincearca');
                console.log(response)
                myModal.show();
            }
        }

        function sendData() {
            let fieldValue = $('#inputCUI').val();
            let urlValue = 'parts/siteAdmin/siteAdminAddCompany/siteAdminAddCompany_Controller.php';

            let dataObject = {};
            dataObject[urlValue] = '';
            dataObject.cif = fieldValue;

            $('#inputCUI').val(null);
            $('#submitCUIBtn').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    loadModal(response);
                },
                error: function () {
                    loadModal(2);
                }
            });
        }

        $('#formCUI').submit(function (e) {
            e.preventDefault();
            sendData();
        });
        $('#submitCUIBtn').prop('disabled', true).on('click', function () {
            sendData();
        })
        $('#inputCUI').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if ($('#inputCUI').val() !== "") {
                $('#submitCUIBtn').prop('disabled', false);
            } else {
                $('#submitCUIBtn').prop('disabled', true);
            }
        })
    })
</script>