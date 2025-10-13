<?php
include_once 'Assets/views/include/header.php';
?>

<main>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div id="academias" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            </div>
        </div>
    </div>
</main>

<script>
fetch("academias.json")
  .then(response => response.json())
  .then((data) => {
    console.log(data);
    const acadGrid = document.getElementById('academias');
    
    data.forEach(local => {
      const col = document.createElement("div");
      col.className = "col";
      col.innerHTML = `
        <div class="card shadow-sm">
          <img src="${local.img}" class="card-img-top" alt="${local.title}" height="225" style="object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">${local.title}</h5>
            <p class="card-text text-muted" style="font-size: 14px;">${local.address}</p>
            <p class="card-text">${local.bio}</p>
            <div class="d-flex justify-content-between align-items-center">
              </div>
              <small class="text-body-secondary">${local.distance} km</small>
            </div>
          </div>
        </div>
      `;
      acadGrid.appendChild(col);
    });
  })
  .catch(err => console.error("ERRO! ERRO! NÃO CARREGOU!!!!:", err));

</script>