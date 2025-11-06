<?php
include_once 'Assets/views/include/header.php';
?>
<main>
    <!-- Começo da página -->
    <div class="imagem-fundo ">
        <div class="position-relative overflow-hidden p-3 p-md-5 md-3 mt-0 text-center">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h3 class="fw-normal mb3 " style="color: #000000;">A tecnologia que treina com você</h3>
                <h1 class="display-2 text-primary fw-bold " style="text-shadow:0px 4px 4px #000;">Bem Vindo A Tech Fit
                </h1>
                <div class="d-flex gap-3 justify-content-center lead fw-normal">
                    <button class="btn bg-primary text-secondary">
                        Seja Um Cliente
                    </button>
                    <button class="btn btn-outline-primary">
                        Nos Conheça
                    </button>
                </div>
            </div>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <!-- Sobre nós -->
    <div class="row featurette mb-3">
        <div class="col-md-7 align-items-center justify-content-center p-5">
            <h2 class="featurette-heading fw-normal lh-1 ">Sobre a TechFit </h2>
            <p class="lead ">A Techfit une tecnologia e saúde para transformar a forma de treinar. Com o SAGEF – Sistema
                Automatizado de Geração de Exercícios Físicos, criamos treinos personalizados a partir dos dados e
                objetivos de cada usuário, ajustando séries, repetições e cargas conforme o feedback. Assim, garantimos
                evolução contínua, segurança e motivação em cada etapa.</p>
        </div>
        <div class="col-md-5 d-flex align-items-center justify-content-center " style="height: 500px; width:500px;">
            <img src="Assets\images\logo-fixed.webp" alt="logo">
        </div>
    </div>
    <!-- Cards de planos -->
    <h2 class="text-center m-5">Planos da Academia</h2>
        <div class="row row-cols-1 row-cols-md-4  align-items-center justify-content-center mb-5 ">
            <div class="col">
                <div class="card mb-1 rounded-3 shadow-p">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-bold">Starter</h4>
                        <h6 class="my-0 fw-normal">Basicão</h6>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title text-center">R$60<small
                                class="text-body-secondary fw-light">/mês</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✓ First Training</li>
                            <li>✓ Acesso a uma academia</li>
                            <li>✓ Sistemas de Rankings</li>

                        </ul> <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up</button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card mb-1 rounded-3 border-primary" style="box-shadow: 0px 5px 19px #DA614E ;">
                    <div class="card-header py-1 text-bg-primary border-primary ">
                        <h4 class="my-0 fw-normal text-secondary text-center">O mais pedido</h4>
                    </div>
                    <div class="card-body">
                        <h4 class="my-0 fw-bold">Basic</h4>
                        <h6 class="my-0 fw-normal">O custo benefício</h6>
                            <h1 class="card-title pricing-card-title text-center">R$100<small
                                    class="text-body-secondary fw-light">/mês</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>✓ First Training</li>
                                <li>✓ Acesso a todas as academias</li>
                                <li>✓ Treinos Personalizados</li>
                                <li>✓ Sistema de Rankings</li>
                                <li>✓ Sistema de Rendimento por Treino</li>
                            </ul> <button type="button" class="w-100 btn btn-lg btn-primary">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-1 rounded-3 shadow-p">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-bold">Advanced</h4>
                        <h6 class="my-0 fw-normal">Só para os entusiastas</h6>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title text-center">R$150<small
                                class="text-body-secondary fw-light">/mês</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>✓ First Training</li>
                            <li>✓ Acesso a todas as academias</li>
                            <li>✓ Treinos Personalizados</li>
                            <li>✓ Sistema de Rankings</li>
                            <li>✓ Sistema de Rendimento por treino</li>
                            <li>✓ 1 treino com personal por semana</li>
                        </ul> <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up</button>
                    </div>
                </div>
            </div>
        </div>

    <h2 class="text-center mb-3">Academias Mais Próximas</h2>
        <div class="cards">
            <!-- <div class="card" style="width: 18rem;">
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
        </div> -->
        </div>
        <div id="modal-academia" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
</main>
<script>
    fetch("academias.json")
        .then(resposta => resposta.json())
        .then((data) => {
            console.log(data);
            const cards = document.getElementsByClassName("cards")[0];
            data.forEach(card => {
                let div = document.createElement("div");
                div.className = "card";
                div.innerHTML = `
            <div class="card" style="width: 18rem; height:750px;" >
                    <img src="${card.img}" class="card-img-top" alt="${card.title}">
                    <div class="card-body">
                        <h5 class="card-title">${card.title}</h5>
                        <p class="card-text">${card.bio}</p>
                        <button class="btn d-flex justify-content-start" data-bs-toggle="modal" data-bs-target="#modal-academia">Ver mais 🠒</button>
                    </div>
            </div>`;
                if (document.getElementsByClassName("card").length <= 7) {
                    cards.appendChild(div);
                } else {
                    return
                }

            });
        })
</script>
<?php
require_once 'Assets/views/include/footer.php';
?>
