import express from "express";
import fetch from "node-fetch";
import cors from "cors";

const app = express();
app.use(cors());

app.get("/proxy", async (req, res) => {
  const cpf = req.query.cpf?.replace(/\D/g, "");

  if (!cpf) {
    return res.status(400).json({ error: "CPF não fornecido" });
  }

  const apiUrl = `https://api.seuservidor.com/consulta?cpf=${cpf}`; // Troque aqui pela sua API real

  try {
    const response = await fetch(apiUrl);
    const data = await response.text();
    res.setHeader("Content-Type", "application/json");
    res.send(data);
  } catch (error) {
    res.status(500).json({ error: "Erro ao consultar o servidor externo", detalhe: error.message });
  }
});

const PORT = process.env.PORT || 10000;
app.listen(PORT, () => console.log(`✅ Proxy rodando na porta ${PORT}`));
