const express = require('express');
const app = express();

// Cria uma rota principal no seu backend
app.get('/', (req, res) => {
  res.send('Parabéns! Seu primeiro backend está rodando no Codespaces!');
});

// Liga o servidor na porta 3000
app.listen(3000, () => {
  console.log('Servidor rodando na porta 3000');
});