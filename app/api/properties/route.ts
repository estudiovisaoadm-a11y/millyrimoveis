import { NextResponse } from "next/server"

export async function GET() {
  const properties = []
  return NextResponse.json({ properties, total: 0 })
}

export async function POST(req: Request) {
  const body = await req.json()
  return NextResponse.json({ message: "Property created", id: "mock-id" })
}
