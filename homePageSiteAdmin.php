<?php
include 'parts/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    die();
} else {
    $user = new User($_SESSION['user_id']);
    if ($user->getAccessLevel() != 1) {
        header('Location: index.php');
        die();
    }
}

$companiesArr = findAll('companies');
$usersArr = findAll('users');
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
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-1">Afiseaza
                                                        lista firme
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-2">Adauga
                                                        firma
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-3">Sterge
                                                        firma
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-4">Adauga
                                                        admin firma
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-5">Sterge
                                                        admin firma
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn m-1 btn-style btn-action" id="nav-btn-6">Modifica
                                                        parola admin firma
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
                            <div class="w-50" style="border: 5px double black">
                                <div class="fs-1 fw-bolder">NUMAR FIRME
                                    INREGISTRATE: <?php echo count($companiesArr) ?></div>
                                <div class="fs-1 fw-bolder">NUMAR UTILIZATORI
                                    INREGISTRATI: <?php echo(count($usersArr) - 1) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

<?php
include 'parts/footer.php'
?>