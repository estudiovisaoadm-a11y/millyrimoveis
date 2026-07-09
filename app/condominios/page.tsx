import type { Metadata } from "next"
import Link from "next/link"

export const metadata: Metadata = {
  title: "Condomínios | MillyR Imóveis",
}

const condominios = [
  { name: "Residencial Park da Colina", slug: "park-da-colina", region: "Jardim Botânico", averagePrice: 2500000 },
  { name: "Condomínio Villa Verde", slug: "villa-verde", region: "Lago Sul", averagePrice: 4500000 },
  { name: "Residencial Saint Barth", slug: "saint-barth", region: "Noroeste", averagePrice: 1800000 },
  { name: "Condomínio Alto do Lago", slug: "alto-do-lago", region: "Lago Sul", averagePrice: 5800000 },
  { name: "Residencial das Palmeiras", slug: "palmeiras", region: "Jardim Botânico", averagePrice: 3200000 },
  { name: "Condomínio Boulevard Sul", slug: "boulevard-sul", region: "Asa Sul", averagePrice: 2100000 },
]

export default function Condominios() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h1 className="text-4xl sm:text-5xl font-bold mb-4">Condomínios</h1>
          <p className="text-muted max-w-2xl mx-auto">
            Cada condomínio possui história, infraestrutura e identidade
            próprias. Conheça em detalhes antes de decidir.
          </p>
        </div>
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {condominios.map((c) => (
            <Link
              key={c.slug}
              href={`/condominios/${c.slug}`}
              className="group block bg-white rounded-2xl border border-border overflow-hidden hover:shadow-sm transition-shadow"
            >
              <div className="aspect-video bg-gray-100" />
              <div className="p-6">
                <span className="text-xs text-muted uppercase tracking-wider">
                  {c.region}
                </span>
                <h3 className="text-lg font-semibold mt-1 group-hover:text-brand-600 transition-colors">
                  {c.name}
                </h3>
                <p className="text-sm text-muted mt-2">
                  Valor médio: R$ {(c.averagePrice / 1e6).toFixed(1)} M
                </p>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </div>
  )
}
