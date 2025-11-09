import express from "express";
import fetch from "node-fetch";
import cors from "cors";

const app = express();
const PORT = process.env.PORT || 10000;

// 🔓 Libera o domínio do seu site
app.use(cors({
  origin: ["https://consutasdarkaurora.wuaze.com"],
  methods: ["GET"]
}));

app.get("/proxy", async (req, res) => {
  const { cpf } = req.query;
  if (!cpf) return res.json({ error: "CPF não informado." });

  try {
    // Substitua esse endpoint pela API real que você consulta
    const response = await fetch(`https://api.exemplo.com/consulta?cpf=${cpf}`);
    const data = await response.json();
    res.json(data);
  } catch (error) {
    console.error("Erro ao consultar:", error);
    res.status(500).json({ error: "Erro ao consultar o servidor externo" });
  }
});

app.listen(PORT, () => console.log(`🚀 Servidor rodando na porta ${PORT}`));
