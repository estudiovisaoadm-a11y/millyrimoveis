import type { Metadata } from "next"
import "@/styles/globals.css"
import { Header } from "@/components/layout/header"
import { Footer } from "@/components/layout/footer"

export const metadata: Metadata = {
  title: "MillyR Imóveis | Consultoria Imobiliária Premium em Brasília",
  description:
    "Residências selecionadas, atendimento personalizado e inteligência imobiliária para quem valoriza tempo, segurança e qualidade de vida em Brasília.",
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="pt-BR">
      <body className="min-h-screen antialiased">
        <Header />
        <main>{children}</main>
        <Footer />
      </body>
    </html>
  )
}
