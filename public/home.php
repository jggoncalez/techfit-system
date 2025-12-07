<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../Assets/images/TechFit-icon.ico" type="image/x-icon">
    <script src="../docs/5.3/assets/js/color-modes.js"></script>
    <link rel="stylesheet" href="/Assets/style/style.css">
</head>
<?php
include_once 'include/header.php';
?>
<main>
    <!-- Começo da página -->
    <div class="imagem-fundo">
        <div class="position-relative overflow-hidden p-3 p-md-5 md-3 mt-0 text-center">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h3 class="fw-normal mb3 text-primary"></h3>
                <h1 class="display-2 text-primary fw-bold " style="text-shadow:0px 4px 4px #000;">Bem Vindo A Tech Fit
                </h1>
                <div class="d-flex gap-3 justify-content-center lead fw-normal">
                    <a href="#planos" class="btn bg-primary text-secondary">Ver Planos</a>
                    <a href="#about" class="btn btn-outline-primary bg-white">
                        Nos Conheça
                    </a>
                </div>
            </div>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <!-- Sobre nós -->
    <div id="about" class="row featurette mb-3">
        <div class="col-md-7 align-items-center justify-content-center p-5">
            <h2 class="featurette-heading fw-normal lh-1 ">Sobre a TechFit </h2>
            <p class="lead ">A Techfit une tecnologia e saúde para transformar a forma de treinar. Com o SAGEF – Sistema
                Automatizado de Geração de Exercícios Físicos, criamos treinos personalizados a partir dos dados e
                objetivos de cada usuário, ajustando séries, repetições e cargas conforme o feedback. Assim, garantimos
                evolução contínua, segurança e motivação em cada etapa.</p>
        </div>
        <div class="col-md-5 d-flex align-items-center justify-content-center " style="height: 500px; width:500px;">
            <img src="/public/images/logo-fixed.webp" alt="logo">
        </div>
    </div>
    <!-- Cards de planos -->
    <h2 id="planos" class="text-center m-5">Planos da Academia</h2>
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
        </div>
        <?php
        // Renderiza os cards do arquivo academias.json no servidor (versão PHP simples)
        $jsonPath = __DIR__ . '/../public/academias.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $items = json_decode($json, true);
                echo "<div class=\"cards\">";
                $count = 0;
                foreach ($items as $card) {
                    if ($count >= 3) break;
                    $img = isset($card['img']) ? htmlspecialchars($card['img'], ENT_QUOTES) : '';
                    $title = isset($card['title']) ? htmlspecialchars($card['title'], ENT_QUOTES) : '';
                    $bio = isset($card['bio']) ? htmlspecialchars($card['bio'], ENT_QUOTES) : '';
                    $address = isset($card['address']) ? htmlspecialchars($card['address'], ENT_QUOTES) : '';
                    $distance = isset($card['distance']) ? htmlspecialchars($card['distance'], ENT_QUOTES) : '';
                    $modalId = "modal-academia-{$count}";

                    // Card
                    echo "<div class=\"card\" style=\"width: 18rem; height:550px;\">";
                    echo "<img src=\"{$img}\" class=\"card-img-top\" alt=\"{$title}\">";
                    echo "<div class=\"card-body\">";
                    echo "<h5 class=\"card-title\">{$title}</h5>";
                    echo "<p class=\"card-text\">{$bio}</p>";
                    // botão abre o modal específico do card 
                    echo "<button class=\"btn d-flex justify-content-start\" data-bs-toggle=\"modal\" data-bs-target=\"#{$modalId}\">Ver mais 🠒</button>";
                    echo "</div></div>";

                    // Modal gerado pelo servidor para este card
                    echo "<div class=\"modal fade\" id=\"{$modalId}\">";
                    echo "<div class=\"modal-dialog\"><div class=\"modal-content\">";
                    echo "<div class=\"modal-header\"><h5 class=\"modal-title\">{$title}</h5>";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button></div>";
                    echo "<div class=\"modal-body\"><p>{$bio}</p><p class=\"text-muted\">{$address}</p><p class=\"text-muted\">{$distance}</p></div>";
                    echo "<div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Fechar</button></div>";
                    echo "</div></div></div>";

                    $count++;
                }
                echo "</div>";

        } else {
            echo "<div class=\"cards\"><p class=\"text-muted\">Arquivo academias.json não encontrado.</p></div>";
        }
        ?>

        <!-- Modais gerados individualmente por PHP (um por card) -->
</main>
<?php
require_once 'include/footer.php';
?>
