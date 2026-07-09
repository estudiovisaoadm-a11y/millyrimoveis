import { NextResponse } from "next/server"

export async function POST(req: Request) {
  const { query } = await req.json()
  return NextResponse.json({ results: [], query })
}
