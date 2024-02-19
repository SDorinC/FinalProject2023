<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <div class="col-5 mt-2 h-100">
        <div class="card-body p-0 h-50" style="max-height: 90%">
            <div class="table-responsive table-scroll h-100" style="position: relative">
                <table class="table table-striped mb-0" id="employeeTable" style="display: none">
                    <thead class="fs-3 fw-bolder table-dark">
                    <tr class="text-uppercase">
                        <th scope="col" class="py-0">Nume angajat</th>
                    </tr>
                    </thead>
                    <tbody class="fs-5" style="background-color: #e5e8f1">
                    </tbody>
                </table>
            </div>
        </div>
        <form class="form-control mt-2" method="post" id="formEditEmployee" style="display: none">
            <h4 class="my-3">Editeaza angajat</h4>
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
            <button type="button" class="btn btn-primary mb-3" id="editEmployeeBtn"
                    style="font-size: 0.9rem">Editeaza angajat
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
        let urlValue = 'parts/companyAdmin/companyAdminModifyEmployeeInfo/companyAdminModifyEmployeeInfo_Controller.php';

        let dataObject = {};
        dataObject[urlValue] = '';

        function handleData() {
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    let responseArr = JSON.parse(response);
                    let table = $('#employeeTable');
                    responseArr.forEach((infoArray) => {
                        let newRow = $('<tr></tr>');
                        newRow.attr('id', infoArray[0]);
                        let newCell = $('<td></td>');
                        newCell.text(infoArray[1] + ' ' + infoArray[2]);
                        newRow.append(newCell);
                        newRow.on('click', function () {
                            if (!newRow.hasClass('row-active')) {
                                table.find('tr').removeClass('row-active');
                                newRow.addClass('row-active');
                                dataObject['employeeId'] = $(this).attr('id');
                                $.ajax({
                                    type: 'POST',
                                    url: urlValue,
                                    data: dataObject,
                                    success: function (response) {
                                        let infoArr = JSON.parse(response)[0][0];
                                        $('#employeeFirstName').val(infoArr['first_name']);
                                        $('#employeeLastName').val(infoArr['last_name']);
                                        $('#employeeCNP').val(infoArr['personal_id_number']);
                                        $('#employeeSalary').val(infoArr['gross_salary']);
                                        $('#employeeDate').val(infoArr['employment_date']);
                                        $('#formEditEmployee').show();
                                        $('#employeeFirstName ,#employeeLastName,#employeeCNP,#employeeSalary,#employeeDate').focus();
                                    }
                                })
                            } else {
                                newRow.removeClass('row-active');
                                $('#formEditEmployee').hide();
                            }
                        });
                        table.append(newRow);
                    })
                    $('#employeeTable').show();
                }
            });
        }

        handleData();

        function loadModal(response) {
            if (response == 1) {
                let myModal = new mdb.Modal(document.getElementById('staticBackdrop'));
                $('#modalText').text('Angajat editat');
                $('#modalBtn').text('Inchide');
                myModal.show();
            }
        }

        $('#employeeFirstName, #employeeLastName, #employeeCNP, #employeeSalary, #employeeDate').contextmenu(function () {
            return false;
        }).on('keydown keyup keypress contextmenu', function () {
            if (($('#employeeFirstName').val() !== "") && ($('#employeeLastName').val() !== "") &&
                ($('#employeeCNP').val() !== "") && ($('#employeeSalary').val() !== "") && ($('#employeeDate').val() !== "")) {
                $('#editEmployeeBtn').prop('disabled', false);
            } else {
                $('#editEmployeeBtn').prop('disabled', true);
            }
        })

        $('#editEmployeeBtn').on('click', function () {
            dataObject['first_name'] = $('#employeeFirstName').val();
            dataObject['last_name'] = $('#employeeLastName').val();
            dataObject['personal_id_number'] = $('#employeeCNP').val();
            dataObject['gross_salary'] = $('#employeeSalary').val();
            dataObject['employment_date'] = $('#employeeDate').val();
            $.ajax({
                type: 'POST',
                url: urlValue,
                data: dataObject,
                success: function (response) {
                    delete dataObject.employeeId;
                    delete dataObject.first_name;
                    delete dataObject.last_name;
                    delete dataObject.personal_id_number;
                    delete dataObject.gross_salary;
                    delete dataObject.employment_date;
                    $('#employeeTable').find('tbody').empty();
                    $('#formEditEmployee').hide();
                    handleData();
                    loadModal(response);
                }
            });
        })
    })
</script>