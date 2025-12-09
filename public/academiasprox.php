<!doctype html>
<html lang="pt-br">
<head>
    <title>TechFit - Nossas Academias</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="../Assets/images/TechFit-icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="../docs/5.3/assets/js/color-modes.js"></script>
    <link rel="stylesheet" href="/Assets/style/style.css">
</head>
<?php
include_once 'include/header.php';
?>
<main>
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Nossas Academias</h1>
            <p class="lead mb-4">Encontre a unidade TechFit mais próxima de você</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group input-group-lg shadow-lg">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="searchLocation" 
                               placeholder="Digite seu bairro ou cidade...">
                        <button class="btn btn-secondary" type="button" id="searchBtn">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtros -->
    <section class="bg-light py-4 border-bottom">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <select class="form-select" id="filterDistance">
                        <option value="">Todas as distâncias</option>
                        <option value="5">Até 5 km</option>
                        <option value="10">Até 10 km</option>
                        <option value="20">Até 20 km</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="sortBy">
                        <option value="distance">Mais próximas</option>
                        <option value="name">Nome (A-Z)</option>
                        <option value="rating">Melhor avaliadas</option>
                    </select>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-building"></i>
                        <span id="academyCount">0</span> academias encontradas
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid de Academias -->
    <section class="py-5">
        <div class="container">
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="text-center py-5">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-3 text-muted">Carregando academias...</p>
            </div>

            <!-- Grid -->
            <div id="academias" class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4" style="display: none;">
            </div>

            <!-- Mensagem de erro -->
            <div id="errorMessage" class="alert alert-danger d-none" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Ops! Não foi possível carregar as academias. Tente novamente.
            </div>

            <!-- Nenhum resultado -->
            <div id="noResults" class="text-center py-5 d-none">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h3 class="mt-3">Nenhuma academia encontrada</h3>
                <p class="text-muted">Tente ajustar os filtros de busca</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-dark text-white py-5">
        <div class="container text-center">
            <h2 class="mb-3">Não encontrou a academia ideal?</h2>
            <p class="lead mb-4">Entre em contato conosco e descubra novas unidades em breve!</p>
            <a href="#" class="btn btn-primary btn-lg">
                <i class="bi bi-envelope-fill me-2"></i>Fale Conosco
            </a>
        </div>
    </section>
</main>

<script>
// Estado da aplicação
let academiasData = [];
let filteredData = [];

// Carrega os dados
fetch("/public/academias.json")
    .then(response => {
        if (!response.ok) throw new Error('Erro ao carregar');
        return response.json();
    })
    .then((data) => {
        console.log('📍 Academias carregadas:', data);
        academiasData = data;
        filteredData = data;
        
        // Esconde loading, mostra grid
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('academias').style.display = 'flex';
        
        renderAcademias(data);
        updateCount(data.length);
    })
    .catch(err => {
        console.error("❌ ERRO AO CARREGAR:", err);
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('errorMessage').classList.remove('d-none');
    });

// Renderiza as academias
function renderAcademias(data) {
    const acadGrid = document.getElementById('academias');
    acadGrid.innerHTML = '';

    if (data.length === 0) {
        acadGrid.style.display = 'none';
        document.getElementById('noResults').classList.remove('d-none');
        return;
    }

    document.getElementById('noResults').classList.add('d-none');
    acadGrid.style.display = 'flex';

    data.forEach((local, index) => {
        const col = document.createElement("div");
        col.className = "col";
        col.innerHTML = `
            <div class="card h-100 shadow-sm hover-card">
                <div class="position-relative">
                    <img src="${local.img}" 
                         class="card-img-top" 
                         alt="${local.title}" 
                         height="225" 
                         style="object-fit: cover;">
                    <span class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary">
                            <i class="bi bi-star-fill"></i> 4.8
                        </span>
                    </span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-geo-alt-fill me-1"></i>${local.title}
                    </h5>
                    <p class="card-text text-muted small mb-2">
                        <i class="bi bi-map me-1"></i>${local.address}
                    </p>
                    <p class="card-text flex-grow-1">${local.bio}</p>
                    
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-signpost-fill text-primary"></i>
                                ${local.distance} km
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-clock-fill text-primary"></i>
                                06h - 22h
                            </span>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal-${index}">
                                <i class="bi bi-info-circle me-2"></i>Ver Detalhes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        acadGrid.appendChild(col);

        // Cria modal para cada academia
        createModal(local, index);
    });
}

// Cria modais
function createModal(local, index) {
    const modalHTML = `
        <div class="modal fade" id="modal-${index}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-building me-2"></i>${local.title}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="${local.img}" class="img-fluid rounded mb-3" alt="${local.title}">
                        
                        <h6 class="text-primary mb-2">
                            <i class="bi bi-info-circle-fill me-2"></i>Sobre
                        </h6>
                        <p>${local.bio}</p>
                        
                        <h6 class="text-primary mb-2 mt-4">
                            <i class="bi bi-geo-alt-fill me-2"></i>Localização
                        </h6>
                        <p class="text-muted mb-1">${local.address}</p>
                        <p class="text-muted">
                            <i class="bi bi-signpost-fill me-1"></i>
                            Distância: ${local.distance} km
                        </p>
                        
                        <h6 class="text-primary mb-2 mt-4">
                            <i class="bi bi-clock-fill me-2"></i>Horário de Funcionamento
                        </h6>
                        <p class="mb-0">Segunda a Sexta: 06h - 22h</p>
                        <p class="mb-0">Sábado: 08h - 18h</p>
                        <p>Domingo: 08h - 14h</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Atualiza contador
function updateCount(count) {
    document.getElementById('academyCount').textContent = count;
}

// Filtro por distância
document.getElementById('filterDistance').addEventListener('change', function() {
    const maxDistance = parseFloat(this.value);
    
    if (maxDistance) {
        filteredData = academiasData.filter(a => parseFloat(a.distance) <= maxDistance);
    } else {
        filteredData = academiasData;
    }
    
    applySort();
});

// Ordenação
document.getElementById('sortBy').addEventListener('change', function() {
    applySort();
});

function applySort() {
    const sortBy = document.getElementById('sortBy').value;
    let sorted = [...filteredData];
    
    switch(sortBy) {
        case 'distance':
            sorted.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
            break;
        case 'name':
            sorted.sort((a, b) => a.title.localeCompare(b.title));
            break;
        case 'rating':
            // Implementar quando tiver ratings reais
            break;
    }
    
    renderAcademias(sorted);
    updateCount(sorted.length);
}

// Busca por texto
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchLocation').value.toLowerCase();
    
    if (searchTerm) {
        filteredData = academiasData.filter(a => 
            a.title.toLowerCase().includes(searchTerm) || 
            a.address.toLowerCase().includes(searchTerm)
        );
    } else {
        filteredData = academiasData;
    }
    
    applySort();
});

// Enter para buscar
document.getElementById('searchLocation').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('searchBtn').click();
    }
});
</script>

<?php
require_once 'include/footer.php';
?>