import { NextResponse } from "next/server"
import { getAssistantReply } from "@/lib/openai"

export async function POST(req: Request) {
  try {
    const { message } = await req.json()
    const reply = await getAssistantReply(message)
    return NextResponse.json({ reply })
  } catch {
    return NextResponse.json(
      { error: "Erro ao processar sua pergunta" },
      { status: 500 }
    )
  }
}
