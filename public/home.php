<!doctype html>
<html lang="pt-br">

<head>
    <title>TechFit - Tecnologia e Fitness</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Academia com tecnologia de ponta. Treinos personalizados com IA através do sistema SAGEF.">
    <link rel="shortcut icon" href="../Assets/images/TechFit-icon.ico" type="image/x-icon">
    <script src="../docs/5.3/assets/js/color-modes.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/Assets/style/style.css">
    
    <!-- Animações CSS customizadas -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(218, 97, 78, 0.3) !important;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #DA614E;
        }
        
        .badge-animated {
            animation: pulse 2s infinite;
        }
        
        .testimonial-card {
            transition: all 0.3s ease;
            border-left: 4px solid #DA614E;
        }
        
        .testimonial-card:hover {
            transform: scale(1.05);
        }
        
        .cta-section {
            background: linear-gradient(135deg, #DA614E 0%, #c54d3a 100%);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(218, 97, 78, 0.1);
            margin-bottom: 1rem;
        }
        
        .plan-card-popular {
            position: relative;
            overflow: hidden;
        }
        
        .plan-card-popular::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #DA614E, #ff8a75);
        }
    </style>
</head>

<body>
<?php
include_once 'include/header.php';
?>

<main>
    <!-- Hero Section MELHORADO -->
    <div class="imagem-fundo position-relative">
        <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
            <div class="col-md-8 p-lg-5 mx-auto my-5 fade-in-up">
                <!-- Badge animado -->
                <span class="badge bg-primary text-secondary mb-3 px-4 py-2 badge-animated">
                    <i class="bi bi-stars me-2"></i>Sistema SAGEF Integrado
                </span>
                
                <h1 class="display-1 text-primary fw-bold mb-4" style="text-shadow: 0px 4px 8px rgba(0,0,0,0.3);">
                    Bem-Vindo à TechFit
                </h1>
                
                <p class="lead text-white fs-4 mb-4" style="text-shadow: 0px 2px 4px #000; max-width: 700px; margin: 0 auto;">
                    Transforme seu corpo com tecnologia de ponta. Treinos personalizados por inteligência artificial.
                </p>
                
                <div class="d-flex gap-3 justify-content-center lead fw-normal flex-wrap mb-5">
                    <a href="#planos" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="bi bi-lightning-fill me-2"></i>Ver Planos
                    </a>
                    <a href="#about" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="bi bi-info-circle me-2"></i>Nos Conheça
                    </a>
                </div>
                
                <!-- Contador de membros -->
                <div class="mt-5 d-flex justify-content-center gap-5 flex-wrap">
                    <div class="text-white text-center">
                        <div class="stat-number text-white">500+</div>
                        <small class="d-block fs-6">Membros Ativos</small>
                    </div>
                    <div class="text-white text-center">
                        <div class="stat-number text-white">50K+</div>
                        <small class="d-block fs-6">Treinos Realizados</small>
                    </div>
                    <div class="text-white text-center">
                        <div class="stat-number text-white">98%</div>
                        <small class="d-block fs-6">Satisfação</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <!-- Sobre nós MELHORADO -->
    <div class="container col-xxl-8 px-4 py-5">
        <div id="about" class="row featurette mb-3 align-items-center">
            <div class="col-md-7 p-5">
                <span class="badge bg-primary text-secondary mb-3">Quem Somos</span>
                <h2 class="featurette-heading fw-bold lh-1 mb-4">Sobre a TechFit</h2>
                <p class="lead">A Techfit une tecnologia e saúde para transformar a forma de treinar. Com o SAGEF – 
                    Sistema Automatizado de Geração de Exercícios Físicos, criamos treinos personalizados a partir dos dados e 
                    objetivos de cada usuário, ajustando séries, repetições e cargas conforme o feedback.</p>
                <p class="text-muted">Assim, garantimos evolução contínua, segurança e motivação em cada etapa do seu desenvolvimento físico.</p>
                
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle-fill text-primary fs-4 me-3"></i>
                        <span>Treinos baseados em dados reais</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-check-circle-fill text-primary fs-4 me-3"></i>
                        <span>Acompanhamento em tempo real</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-primary fs-4 me-3"></i>
                        <span>Resultados comprovados</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-center">
                <img src="/public/images/techbg.webp" alt="logo TechFit" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>

    <!-- Seção Revolução -->
    <div class="container col-xxl-8 px-4 py-5 bg-light rounded-4 my-5">
        <div class="row align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="/public/images/halter.webp" class="d-block mx-lg-auto img-fluid rounded shadow" 
                     alt="Equipamentos TechFit" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <span class="badge bg-primary text-secondary mb-3">Inovação</span>
                <h1 class="display-5 fw-bold lh-1 mb-3">A Revolução do Treinamento Físico</h1>
                <p class="lead">A TechFit é mais que uma academia – é o futuro do fitness. Com tecnologia de ponta, 
                    transformamos dados em resultados. Cada treino é único, cada movimento é calculado, cada evolução é 
                    rastreada.</p>
                <p class="text-muted">Somos a academia que treina seu corpo e revoluciona sua forma de se exercitar.</p>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                    <button type="button" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-rocket-takeoff me-2"></i>Começar Agora
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-play-circle me-2"></i>Saiba Mais
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Features MELHORADAS -->
    <div class="container px-4 py-5" id="featured-3">
        <h2 class="pb-2 border-bottom mb-5">Por que a TechFit é a melhor escolha para você?</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="feature col">
                <div class="feature-icon">
                    <i class="bi bi-lightning-fill" style="font-size: 2rem; color: #DA614E;"></i>
                </div>
                <h3 class="mb-3">Tecnologia de Ponta</h3>
                <p>Nossa plataforma oferece treinos personalizados e inteligentes para você. Com a tecnologia SAGEF, 
                    cada sessão é adaptada ao seu nível e objetivo. Aproveite uma experiência de treino otimizada, 
                    segura e eficiente em nossas academias.</p>
                <a href="#planos" class="icon-link text-primary text-decoration-none fw-bold">
                    Conheça nossa plataforma
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            
            <div class="feature col">
                <div class="feature-icon">
                    <i class="bi bi-graph-up-arrow" style="font-size: 2rem; color: #DA614E;"></i>
                </div>
                <h3 class="mb-3">Acompanhamento de Resultados</h3>
                <p>Monitore seu progresso em tempo real com nossos sistemas de ranking e relatórios de desempenho. 
                    Veja cada evolução, celebre suas conquistas e mantenha-se motivado com dados concretos do seu 
                    desenvolvimento físico.</p>
                <a href="#planos" class="icon-link text-primary text-decoration-none fw-bold">
                    Comece sua transformação
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            
            <div class="feature col">
                <div class="feature-icon">
                    <i class="bi bi-shield-check" style="font-size: 2rem; color: #DA614E;"></i>
                </div>
                <h3 class="mb-3">Segurança e Confiabilidade</h3>
                <p>Treine com segurança e confiança em uma plataforma robusta que protege seus dados. A TechFit oferece 
                    a melhor experiência de treino, com a estrutura e qualidade que você merece.</p>
                <a href="#planos" class="icon-link text-primary text-decoration-none fw-bold">
                    Experimente agora
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Cards de planos MELHORADOS -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-secondary mb-3">Planos</span>
            <h2 id="planos" class="display-5 fw-bold">Escolha Seu Plano Ideal</h2>
            <p class="lead text-muted">Transforme seu corpo com a tecnologia que você merece</p>
        </div>
        
        <div class="row row-cols-1 row-cols-md-3 g-4 align-items-center justify-content-center mb-5">
            <!-- Plano Starter -->
            <div class="col">
                <div class="card mb-1 rounded-3 shadow hover-lift h-100">
                    <div class="card-header py-3 bg-light">
                        <h4 class="my-0 fw-bold">Starter</h4>
                        <h6 class="my-0 fw-normal text-muted">Basicão</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title text-center mb-4">
                            R$60<small class="text-body-secondary fw-light fs-5">/mês</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>First Training</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Acesso a uma academia</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sistema de Rankings</li>
                            <li class="mb-3 text-muted"><i class="bi bi-x-circle me-2"></i>Treinos Personalizados</li>
                            <li class="mb-3 text-muted"><i class="bi bi-x-circle me-2"></i>Personal Trainer</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Começar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Plano Basic (POPULAR) -->
            <div class="col">
                <div class="card mb-1 rounded-3 shadow-lg hover-lift h-100 plan-card-popular" 
                     style="border: 2px solid #DA614E; transform: scale(1.05);">
                    <div class="card-header py-2 text-bg-primary border-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary">
                                <i class="bi bi-star-fill me-1"></i>MAIS POPULAR
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h4 class="my-0 fw-bold">Basic</h4>
                        <h6 class="my-0 fw-normal text-muted mb-3">O custo benefício</h6>
                        <h1 class="card-title pricing-card-title text-center mb-4 text-primary">
                            R$100<small class="text-body-secondary fw-light fs-5">/mês</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>First Training</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Acesso a todas as academias</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Treinos Personalizados (SAGEF)</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sistema de Rankings</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Rendimento por Treino</li>
                            <li class="mb-3 text-muted"><i class="bi bi-x-circle me-2"></i>Personal Trainer</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">
                            <i class="bi bi-rocket-takeoff me-2"></i>Assinar Agora
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Plano Advanced -->
            <div class="col">
                <div class="card mb-1 rounded-3 shadow hover-lift h-100">
                    <div class="card-header py-3 bg-dark text-white">
                        <h4 class="my-0 fw-bold">Advanced</h4>
                        <h6 class="my-0 fw-normal">Só para os entusiastas</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title text-center mb-4">
                            R$150<small class="text-body-secondary fw-light fs-5">/mês</small>
                        </h1>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>First Training</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Acesso a todas as academias</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Treinos Personalizados (SAGEF)</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sistema de Rankings</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Rendimento por Treino</li>
                            <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>1 Personal por semana</strong></li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary">
                            <i class="bi bi-trophy me-2"></i>Seja Premium
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Depoimentos dos Clientes (NOVO) -->
    <div class="container py-5 my-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-secondary mb-3">Depoimentos</span>
            <h2 class="display-5 fw-bold">O Que Nossos Membros Dizem</h2>
            <p class="lead text-muted">Histórias reais de transformação</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow testimonial-card">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text mb-4">"O SAGEF mudou completamente minha rotina de treinos. Os exercícios 
                        personalizados me ajudaram a evoluir muito mais rápido. Resultados visíveis em apenas 2 meses!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <span class="fw-bold">MS</span>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Maria Silva</p>
                                <small class="text-muted">Membro há 6 meses</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow testimonial-card">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text mb-4">"A melhor academia que já frequentei! A tecnologia realmente faz 
                        diferença. O sistema de rankings me mantém sempre motivado a superar meus próprios limites."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <span class="fw-bold">JS</span>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">João Santos</p>
                                <small class="text-muted">Membro há 1 ano</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow testimonial-card">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text mb-4">"Nunca pensei que treinar pudesse ser tão inteligente! O 
                        acompanhamento em tempo real e os ajustes automáticos dos treinos são incríveis. Vale cada centavo!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <span class="fw-bold">AL</span>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">Ana Lima</p>
                                <small class="text-muted">Membro há 3 meses</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academias Mais Próximas -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-secondary mb-3">Unidades</span>
            <h2 class="display-5 fw-bold">Academias Mais Próximas</h2>
            <p class="lead text-muted">Encontre a unidade TechFit mais perto de você</p>
        </div>
        
        <div class="cards d-flex flex-wrap justify-content-center gap-4">
            <?php
            // Renderiza os cards do arquivo academias.json no servidor (versão PHP simples)
            $jsonPath = __DIR__ . '/../public/academias.json';
            if (file_exists($jsonPath)) {
                $json = file_get_contents($jsonPath);
                $items = json_decode($json, true);
                $count = 0;
                foreach ($items as $card) {
                    if ($count >= 3) break;
                    
                    $img = isset($card['img']) ? htmlspecialchars($card['img'], ENT_QUOTES) : '';
                    $title = isset($card['title']) ? htmlspecialchars($card['title'], ENT_QUOTES) : '';
                    $bio = isset($card['bio']) ? htmlspecialchars($card['bio'], ENT_QUOTES) : '';
                    $address = isset($card['address']) ? htmlspecialchars($card['address'], ENT_QUOTES) : '';
                    $distance = isset($card['distance']) ? htmlspecialchars($card['distance'], ENT_QUOTES) : '';
                    $modalId = "modal-academia-{$count}";

                    // Card melhorado
                    echo "<div class=\"card shadow hover-lift\" style=\"width: 22rem;\">";
                    echo "<img src=\"{$img}\" class=\"card-img-top\" alt=\"{$title}\" style=\"height: 250px; object-fit: cover;\">";
                    echo "<div class=\"card-body d-flex flex-column\">";
                    echo "<h5 class=\"card-title fw-bold\">{$title}</h5>";
                    echo "<p class=\"card-text text-muted flex-grow-1\">{$bio}</p>";
                    echo "<div class=\"d-flex justify-content-between align-items-center mt-3\">";
                    echo "<span class=\"badge bg-primary\"><i class=\"bi bi-geo-alt me-1\"></i>{$distance}</span>";
                    echo "<button class=\"btn btn-outline-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#{$modalId}\">";
                    echo "Ver Detalhes <i class=\"bi bi-arrow-right ms-1\"></i></button>";
                    echo "</div></div></div>";

                    // Modal melhorado
                    echo "<div class=\"modal fade\" id=\"{$modalId}\" tabindex=\"-1\">";
                    echo "<div class=\"modal-dialog modal-dialog-centered\">";
                    echo "<div class=\"modal-content\">";
                    echo "<div class=\"modal-header bg-primary text-white\">";
                    echo "<h5 class=\"modal-title\"><i class=\"bi bi-building me-2\"></i>{$title}</h5>";
                    echo "<button type=\"button\" class=\"btn-close btn-close-white\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
                    echo "</div>";
                    echo "<div class=\"modal-body\">";
                    echo "<img src=\"{$img}\" class=\"img-fluid rounded mb-3\" alt=\"{$title}\">";
                    echo "<p class=\"lead\">{$bio}</p>";
                    echo "<hr>";
                    echo "<p class=\"mb-2\"><i class=\"bi bi-geo-alt-fill text-primary me-2\"></i><strong>Endereço:</strong></p>";
                    echo "<p class=\"text-muted ms-4\">{$address}</p>";
                    echo "<p class=\"mb-2\"><i class=\"bi bi-pin-map-fill text-primary me-2\"></i><strong>Distância:</strong></p>";
                    echo "<p class=\"text-muted ms-4\">{$distance}</p>";
                    echo "</div>";
                    echo "<div class=\"modal-footer\">";
                    echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Fechar</button>";
                    echo "<a href=\"#planos\" class=\"btn btn-primary\">Assinar Plano</a>";
                    echo "</div></div></div></div>";

                    $count++;
                }
            } else {
                echo "<div class=\"alert alert-warning\"><i class=\"bi bi-exclamation-triangle me-2\"></i>Arquivo academias.json não encontrado.</div>";
            }
            ?>
        </div>
    </div>

    <!-- Call to Action Final (NOVO) -->
    <div class="cta-section text-white py-5 my-5">
        <div class="container text-center py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2">Comece Hoje</span>
                    <h2 class="display-4 fw-bold mb-3">Pronto Para Sua Transformação?</h2>
                    <p class="lead mb-4 fs-5">
                        Junte-se a centenas de pessoas que já alcançaram seus objetivos com tecnologia de ponta
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#planos" class="btn btn-light btn-lg px-5 py-3">
                            <i class="bi bi-lightning-fill text-primary me-2"></i>
                            <strong>Começar Gratuitamente</strong>
                        </a>
                        <a href="#about" class="btn btn-outline-light btn-lg px-5 py-3">
                            <i class="bi bi-telephone me-2"></i>Falar com Consultor
                        </a>
                    </div>
                    <p class="mt-4 mb-0"><small><i class="bi bi-shield-check me-2"></i>Sem compromisso. Cancele quando quiser.</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section (BONUS) -->
    <div class="container py-5 mb-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-secondary mb-3">FAQ</span>
            <h2 class="display-5 fw-bold">Perguntas Frequentes</h2>
            <p class="lead text-muted">Tire suas dúvidas sobre a TechFit</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle me-2 text-primary"></i>
                                O que é o sistema SAGEF?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                O SAGEF (Sistema Automatizado de Geração de Exercícios Físicos) é nossa tecnologia exclusiva 
                                que cria treinos personalizados baseados nos seus dados, objetivos e feedback em tempo real.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-question-circle me-2 text-primary"></i>
                                Posso cancelar minha assinatura a qualquer momento?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim! Não há fidelidade. Você pode cancelar sua assinatura quando quiser, sem multas ou taxas adicionais.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-question-circle me-2 text-primary"></i>
                                Preciso ter experiência prévia com academia?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Não! O SAGEF adapta os treinos para todos os níveis, de iniciantes a avançados. 
                                Você receberá orientação completa desde o primeiro dia.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animação suave ao scroll -->
<script>
    // Smooth scroll para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animação de entrada dos cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.card, .feature').forEach(el => {
        observer.observe(el);
    });
</script>

<?php
require_once 'include/footer.php';
?>
</body>
</html>