import type { Metadata } from "next"
import { SearchPremium } from "@/components/home/search-premium"
import { Destaques } from "@/components/home/destaques"

export const metadata: Metadata = {
  title: "Comprar | MillyR Imóveis",
}

export default function Comprar() {
  return (
    <div className="pt-20">
      <div className="bg-gray-50 py-16 text-center">
        <h1 className="text-4xl sm:text-5xl font-bold mb-4">Comprar</h1>
        <p className="text-muted max-w-xl mx-auto px-4">
          Imóveis selecionados para você encontrar o lar perfeito.
        </p>
      </div>
      <SearchPremium />
      <Destaques />
    </div>
  )
}
