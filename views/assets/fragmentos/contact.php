
<section class="py-3 py-md-5">
  <div class="container">
    <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
      <div class="col-12 col-xl-12">
        <div class="row justify-content-xl-center text-center">
          <div>
            <h2 class="mb-3 ">Contactos</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 text-center">
                        <p class="fs-6 mb-4 text-center wide-paragraph">Telefono</p>
                        <p class="mb-5 text-center wide-paragraph">+50684029112</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <p class="fs-6 mb-4 text-center wide-paragraph">Correo</p>
                        <p class="mb-5 text-center wide-paragraph">worklyassociation@gmail.com</p>
                    </div>
                </div>
            </div>
            <h2 class="mb-3 ">Redes Sociales</h2>
            <?php
                $imagen = "../views/assets/imgs/Facebook.png";
                $enlace = "https://www.facebook.com";
            ?>
            <?php
                $imagen2 = "../views/assets/imgs/Instagram.png";
                $enlace2 = "https://www.instagram.com";
            ?>
            <a href= "<?php echo $enlace; ?>" target="_blank">
                <img src="<?php echo $imagen; ?>" alt="Facebook" style="width:50px; height:50px;">
            </a>
            <a href= "<?php echo $enlace2; ?>" target="_blank">
                <img src="<?php echo $imagen2; ?>" alt="Instagram" style="width:50px; height:50px;">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>