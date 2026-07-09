import type { Metadata } from "next"

export const metadata: Metadata = {
  title: "Regiões | MillyR Imóveis",
}

export default function Regioes() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 className="text-4xl sm:text-5xl font-bold mb-4">Regiões</h1>
        <p className="text-muted max-w-xl mx-auto">
          Conheça cada região de Brasília em profundidade: infraestrutura,
          escolas, hospitais, restaurantes e muito mais.
        </p>
      </div>
    </div>
  )
}
