<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="../views/index.php"><!-- RUTA ESTATICA -->
                <i class="bi bi-briefcase icono-header"></i>
                Workly
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-around" id="navbarNav">
                <div class="d-flex flex-grow-1 justify-content-center">
                    <form class="form-busqueda d-flex mx-2">
                        <input class="form-control me-2" type="search" placeholder="Buscar trabajos o postulantes" aria-label="Buscar">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                            <span class="visually-hidden">Buscar</span>
                        </button>
                    </form>
                </div>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#" aria-label="ttt">
                            <i class="fa-solid fa-lock icono-sidebar"></i>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <label for="sidebar-toggle" class="btn btn-outline-primary" aria-label="Mostrar/Ocultar barra lateral">
                            <i class="bi bi-list"></i>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->
    <input type="checkbox" id="sidebar-toggle" class="d-none">
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="position-sticky sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">

                </li>
            </ul>
        </div>
    </nav>
</header>