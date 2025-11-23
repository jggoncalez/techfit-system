<?php
include_once 'Assets/views/include/header.php';
?>

<main class="form-signin w-100 m-auto d-flex align-items-center justify-content-center p-5 ">
    <form style="height: 300px; width:500px;"> 
        <h1 class="h3 mb-3 fw-normal text-center" data-vivaldi-translated="">LOGIN</h1>
        <h1 class="h6 mb-3 fw-normal text-center" data-vivaldi-translated="">Se possuir uma conta, insira seus dados</h1>
        <div class="form-floating" data-vivaldi-translated=""> <input type="email" class="form-control" style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                id="floatingInput" placeholder="name@example.com" data-vivaldi-translated=""> <label for="floatingInput"
                data-vivaldi-translated="">CPF ou nome de usuário</label> </div>
        <div class="form-floating" data-vivaldi-translated=""> <input type="password" class="form-control" style="border-bottom: #E35C38; border-width: 2px; border-style: solid;"
                id="floatingPassword" placeholder="Senha" data-vivaldi-translated=""> <label for="floatingPassword"
                data-vivaldi-translated="">Senha</label> </div>
        <button class="btn btn-primary w-100 py-2 mt-5" type="submit" data-vivaldi-translated="">Acessar</button>
        <h1 class="h6 m-3 fw-normal text-center" data-vivaldi-translated="">É seu primeiro acesso como cliente ou não lembra a senha? <a href="views/funcionario/main.php">Clique Aqui </a> para cadastrar uma nova.</h1>
    </form>
</main>
