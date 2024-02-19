<?php
include '../../header.php';

giveAccess();
?>

<div class="d-flex justify-content-center align-items-center text-center" style="height: 100%">
    <div class="col-5 d-flex justify-content-center h-100">
        <div class="col-12 mt-2 h-100">
            <div class="card-body p-0 h-75" style="max-height: 90%">
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
            <button type="button" class="btn btn-primary mt-5 fs-4" id="deleteEmployeeBtn" style="display: none">
                Sterge angajat
            </button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let urlValue = 'parts/companyAdmin/companyAdminDeleteEmployee/companyAdminDeleteEmployee_Controller.php';

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
                                $('#deleteEmployeeBtn').prop('disabled', false);
                            } else {
                                newRow.removeClass('row-active');
                                $('#deleteEmployeeBtn').prop('disabled', true);
                            }
                        });
                        table.append(newRow);
                    })
                    $('#employeeTable').show();
                    $('#deleteEmployeeBtn').prop('disabled', true).show();
                }
            });
        }

        handleData();

        $('#deleteEmployeeBtn').on('click', function () {
            dataObject['employeeId'] = $('tr.row-active').attr('id');
            $('#employeeTable').find('tbody').empty();
            handleData();
        })
    })
</script>