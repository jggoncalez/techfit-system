Camada de apresentação. Aqui ficam as páginas que o usuário realmente vê no navegador.

- `index.php` → Página inicial.
- `cadastro.php` → Formulário de cadastro/login.
- `treino.php` → Página de treinos.
- `/includes/header.php` e `/includes/footer.php` → Partes reutilizáveis do layout.

📌 **Boas práticas**:

- Separar lógica de visualização da lógica de negócio.
- Usar `include` ou `require` para o header e footer.
- Chamar controladores via formulários ou rotas simples.