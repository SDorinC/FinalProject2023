<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <form class="form-control mx-5" method="post" id="formAddEmployee" style="width: 30%;display: none">
        <h4 class="my-3">Adauga angajat</h4>
        <div class="row mb-4">
            <div class="col">
                <div class="form-outline">
                    <input type="text" id="employeeFirstName" class="form-control"/>
                    <label class="form-label" for="employeeFirstName">Nume</label>
                </div>
            </div>
            <div class="col">
                <div class="form-outline">
                    <input type="text" id="employeeLastName" class="form-control"/>
                    <label class="form-label" for="employeeLastName">Prenume</label>
                </div>
            </div>
        </div>
        <div class="form-outline mb-4">
            <input type="number" id="employeeCNP" class="form-control"/>
            <label class="form-label" for="employeeCNP">CNP</label>
        </div>
        <div class="form-outline mb-4">
            <input type="number" id="employeeSalary" class="form-control"/>
            <label class="form-label" for="employeeSalary">Salariu</label>
        </div>
        <div class="form-outline mb-4">
            <input type="text" id="employeeDate" class="form-control"/>
            <label class="form-label" for="employeeDate">Data angajarii</label>
        </div>
        <button type="button" class="btn btn-primary mb-3" id="submitEmployeeBtn"
                style="font-size: 0.9rem">Adauga angajat
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
        let urlValue = 'parts/companyAdmin/companyAdminAddEmployee/companyAdminAddEmployee_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        $('#formAddEmployee').show();
        $('#submitEmployeeBtn').prop('disabled', true);

        function loadModal(response) {
            if (response == 1) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Angajat adaugat');
                $('#modalBtn').text('Inchide');
                myModal.show();
            } else if (response == 2) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Un angajat cu acest CNP exista deja');
                $('#modalBtn').text('Inchide');
                myModal.show();
            }
        }

        $('#employeeFirstName, #employeeLastName, #employeeCNP, #employeeSalary, #employeeDate').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#employeeFirstName').val() !== "") && ($('#employeeLastName').val() !== "") &&
                ($('#employeeCNP').val() !== "") && ($('#employeeSalary').val() !== "") && ($('#employeeDate').val() !== "")) {
                $('#submitEmployeeBtn').prop('disabled', false);
            } else {
                $('#submitEmployeeBtn').prop('disabled', true);
            }
        })

        $('#submitEmployeeBtn').on('click', function () {
            dataObject['first_name'] = $('#employeeFirstName').val();
            dataObject['last_name'] = $('#employeeLastName').val();
            dataObject['personal_id_number'] = $('#employeeCNP').val();
            dataObject['gross_salary'] = $('#employeeSalary').val();
            dataObject['employment_date'] = $('#employeeDate').val();

            $('#employeeFirstName').val('');
            $('#employeeLastName').val('');
            $('#employeeCNP').val('');
            $('#employeeSalary').val('');
            $('#employeeDate').val('');
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    $('#submitEmployeeBtn').prop('disabled', true);
                    loadModal(response);
                }
            });
        })
    })
</script>