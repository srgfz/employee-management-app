<!-- Comienzo del Header -->
<header class=" sticky-lg-top border-4 border-bottom header sticky-top">
    <!-- Comienzo del Nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 py-0">
        <div class=" bg-light  d-flex d-lg-none d-block justify-content-between">
            <h1><a href="./index.php">UT6.1 Empresa</a></h1>
        </div>
        <div class="d-flex d-lg-none">
            <button class="navbar-toggler mx-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="./logOut.php">
                <i class="bi bi-box-arrow-right fs-3"></i>
            </a>
        </div>
        <div class="container-fluid justify-content-center justify-content-lg-between">
            <h1 class="navbar-brand d-flex d-lg-block d-none"><a href="./index.php">UT6.1 Empresa</a></h1>
            <div class="col-5">
                <div class="collapse navbar-collapse gap-5 m-3 justify-content-evenly" id="navbarTogglerDemo03">
                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?show=emps"; ?>" class="btn btn-secondary col-8 my-2 fw-bold">Empleados</a>
                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?show=deps"; ?>"  class="btn btn-secondary col-8 my-2 fw-bold">Departamentos</a>
                </div>
            </div>
            <div class="d-flex justify-content-center d-none d-lg-flex">
                <div class="align-items-center d-none d-md-flex gap-3">
                    <a href="./logOut.php">
                        <i class="bi bi-box-arrow-right fs-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>