<?php
include_once 'Assets/views/include/header.php';
?>
    <main>
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h3 class="fw-normal text-muted mb-3">A tecnologia que treina com você</h3>
                <h1 class="display-3 fw-bold">Bem Vindo A Tech Fit</h1>
                <div class="d-flex gap-3 justify-content-center lead fw-normal"> <a class="icon-link" href="#">
                        Seja um Cliente
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#chevron-right"></use>
                        </svg> </a> <a class="icon-link" href="#">
                        Nos Conheça
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#chevron-right"></use>
                        </svg> </a> </div>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
        <div class="sobre">
        <div class="row featurette">
            <div class="col-md-7 align-items-center justify-content-center">
                <h2 class="featurette-heading fw-normal lh-1 ">Sobre a TechFit </h2>
                <p class="lead  ">A Techfit une tecnologia e saúde para transformar a forma de treinar. Com o SAGEF – Sistema Automatizado de Geração de Exercícios Físicos, criamos treinos personalizados a partir dos dados e objetivos de cada usuário, ajustando séries, repetições e cargas conforme o feedback. Assim, garantimos evolução contínua, segurança e motivação em cada etapa.</p>
            </div>
            <div class="col-md-5"> <svg aria-label="Placeholder: 500x500"
                    class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" height="500"
                    preserveAspectRatio="xMidYMid slice" role="img" width="500" xmlns="http://www.w3.org/2000/svg">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="var(--bs-secondary-bg)"></rect><text x="50%" y="50%"
                        fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
                </svg> </div>
        </div>
        </div>
        <div class="row row-cols-1 row-cols-md-6 mb-3 text-center align-items-center justify-content-center">
            <div class="col">
                <div class="card mb-1 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Free</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$0<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>10 users included</li>
                            <li>2 GB of storage</li>
                            <li>Email support</li>
                            <li>Help center access</li>
                        </ul> <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up for
                            free</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-1 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Pro</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$15<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>20 users included</li>
                            <li>10 GB of storage</li>
                            <li>Priority email support</li>
                            <li>Help center access</li>
                        </ul> <button type="button" class="w-100 btn btn-lg btn-primary">Get started</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb- rounded-3 shadow-sm border-primary">
                    <div class="card-header py-3 text-bg-primary border-primary">
                        <h4 class="my-0 fw-normal">Enterprise</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$29<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>30 users included</li>
                            <li>15 GB of storage</li>
                            <li>Phone and email support</li>
                            <li>Help center access</li>
                        </ul> <button type="button" class="w-100 btn btn-lg btn-primary">Contact us</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="cards">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card’s content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card’s content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card’s content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        </div>
    </main>

<?php
require_once 'Assets/views/include/footer.php';
?>