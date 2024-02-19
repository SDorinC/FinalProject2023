<?php

require 'vendor/autoload.php';

include 'parts/header.php';

use Itrack\Anaf\Client;
use Itrack\Anaf\Exceptions\LimitExceeded;
use Itrack\Anaf\Exceptions\RequestFailed;
use Itrack\Anaf\Exceptions\ResponseFailed;

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    die();
} else {
    $user = new User($_SESSION['user_id']);
    if ($user->getAccessLevel() != 2) {
        header('Location: index.php');
        die();
    }
}

$requestANAF = new Client();
$selectedCompany = new Company($_SESSION['company_id']);
$cif = $selectedCompany->getRegistrationCode();
$currentDate = date('Y-m-d');
$requestANAF->addCif($cif, $currentDate);
$company = null;
try {
    $company = $requestANAF->first();
} catch (LimitExceeded|RequestFailed|ResponseFailed $e) {
    die();
}
?>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
                <div class="text-center">
                    <div class="card mb-3" style="height: 90vh; width: 94vw">
                        <div class="row g-0">
                            <div class="col">
                                <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #195b8c">
                                    <div class="container-fluid">
                                        <div class="collapse navbar-collapse">
                                            <div class="navbar-brand">
                                                <img
                                                        src="images/logoSmall.png"
                                                        height="50"
                                                        width="50"
                                                        alt="ContExpert"
                                                        loading="lazy"
                                                />
                                            </div>
                                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-7">Adauga
                                                        utilizator
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-8">Sterge
                                                        utilizator
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-9">Modifica
                                                        parola utilizator
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-10">Adauga
                                                        angajat
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-11">Sterge
                                                        angajat
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-12">
                                                        Modifica informatii angajat
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="navbar-nav me-auto mb-2 mb-lg-0">
                                            <button type="button" class="btn btn-link me-2" id="logout-btn">
                                                Deconectare
                                            </button>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body show-content h-50 d-flex justify-content-center align-items-center text-center">
                            <div id="adminHPage"
                                 style="display: none">
                                <div class="card-body p-0 h-100" style="max-height: 90%">
                                    <div class="table-responsive table-scroll h-100" style="position: relative">
                                        <table class="table table-striped table-bordered mb-0" id="dataTable">
                                            <thead class="fs-1 fw-bolder table-dark">
                                            <tr class="text-uppercase">
                                                <th scope="col" colspan="2" class="py-0">Nume
                                                    firma: <?php echo $company->getName() ?></th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-3">
                                            <tr>
                                                <td class="py-0 w-50">CUI/CIF</td>
                                                <td class="py-0"><?php echo $company->getCIF() ?></td>

                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Numar registrul comertului</td>
                                                <td class="py-0"><?php echo $company->getRegCom() ?></td>

                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Numar de telefon</td>
                                                <td class="py-0"><?php echo $company->getPhone() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 text-uppercase fw-bolder" colspan="2">Adresa</td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Judet</td>
                                                <td class="py-0"><?php echo $company->getAddress()->getCounty() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Localitate/Sector</td>
                                                <td class="py-0"><?php echo $company->getAddress()->getCity() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Strada</td>
                                                <td class="py-0"><?php echo $company->getAddress()->getStreet() ?><?php echo $company->getAddress()->getStreetNumber() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Cod postal</td>
                                                <td class="py-0"><?php echo $company->getAddress()->getPostalCode() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 text-uppercase fw-bolder" colspan="2">Alte informatii
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Firma platitoare de TVA</td>
                                                <?php if ($company->getTVA()->hasTVA()): ?>
                                                    <td class="py-0">Da</td>
                                                <?php else: ?>
                                                    <td class="py-0">Nu</td>
                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Firma platitoare de TVA la incasare</td>
                                                <?php if ($company->getTVA()->hasTVACollection()): ?>
                                                    <td class="py-0">Da</td>
                                                <?php else: ?>
                                                    <td class="py-0">Nu</td>
                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <td class="py-0 w-50">Aplica plata defalcata a TVA</td>
                                                <?php if ($company->getTVA()->hasTVASplit()): ?>
                                                    <td class="py-0">Da</td>
                                                <?php else: ?>
                                                    <td class="py-0">Nu</td>
                                                <?php endif; ?>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $('#adminHPage').show()
    </script>

<?php
include 'parts/footer.php'
?>