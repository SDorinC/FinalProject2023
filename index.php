<?php
include 'parts/header.php';
?>

    <body style="display: none">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
                <div class="text-center">
                    <?php if (isset($_SESSION['loginFailed']) && $_SESSION['loginFailed']): ?>
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img
                                            src="images/logo.png"
                                            alt="No Image"
                                            class="img-fluid rounded-start"
                                    />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fs-2" style="margin-top: 20%">Numele de utilizator sau
                                            parola
                                            sunt incorecte</h5>
                                        <form method="post" action="logout.php">
                                            <button type="submit" class="btn btn-primary mt-5"
                                                    style="width: 30%;background-color: #195b8c">Reincearca
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img
                                            src="images/logo.png"
                                            alt="No Image"
                                            class="img-fluid rounded-start"
                                    />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fs-2 mt-4">Conectare utilizator</h5>
                                        <form method="post" action="processLogin.php">
                                            <div class="form-outline mb-4 mt-5">
                                                <input type="text" id="user" name="username" class="form-control"/>
                                                <label class="form-label" for="user">Nume utilizator</label>
                                            </div>
                                            <div class="form-outline mb-4 mt-5">
                                                <input type="password" id="pass" name="password" class="form-control"/>
                                                <label class="form-label" for="pass">Parola</label>
                                            </div>
                                            <button type="submit" id="btn-login" class="btn btn-primary mt-5"
                                                    style="width: 30%;background-color: #195b8c">Conectare
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#btn-login').prop('disabled', true);
                $('#user, #pass').contextmenu(function () {
                    return false;
                }).on('keydown keyup keypress contextmenu', function () {
                    if (($('#user').val() !== "") && ($('#pass').val() !== "")) {
                        $('#btn-login').prop('disabled', false);
                    } else {
                        $('#btn-login').prop('disabled', true);
                    }
                })
            })
        </script>
        <script>
            $(function () {
                $('body').show();
            });
        </script>
    </body>

<?php
include 'parts/footer.php';
?>