import OpenAI from "openai"

const openai = new OpenAI({
  apiKey: process.env.OPENAI_API_KEY,
})

export async function getAssistantReply(message: string) {
  const response = await openai.chat.completions.create({
    model: "gpt-4o",
    messages: [
      {
        role: "system",
        content:
          "Você é um assistente imobiliário especializado no mercado de alto padrão de Brasília, especialmente Jardim Botânico, Lago Sul e Asa Sul. Responda de forma consultiva e elegante.",
      },
      { role: "user", content: message },
    ],
  })

  return response.choices[0]?.message?.content
}
