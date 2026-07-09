import Link from "next/link"

const regioes = [
  {
    name: "Jardim Botânico",
    slug: "jardim-botanico",
    headline: "Natureza e sofisticação",
    image: "",
    color: "from-emerald-900/70 to-emerald-800/30",
  },
  {
    name: "Lago Sul",
    slug: "lago-sul",
    headline: "Vida à beira do lago",
    image: "",
    color: "from-blue-900/70 to-blue-800/30",
  },
  {
    name: "Asa Sul",
    slug: "asa-sul",
    headline: "O coração de Brasília",
    image: "",
    color: "from-amber-900/70 to-amber-800/30",
  },
  {
    name: "Noroeste",
    slug: "noroeste",
    headline: "O novo bairro planejado",
    image: "",
    color: "from-rose-900/70 to-rose-800/30",
  },
  {
    name: "Águas Claras",
    slug: "aguas-claras",
    headline: "Verticalização com qualidade",
    image: "",
    color: "from-violet-900/70 to-violet-800/30",
  },
]

export function RegioesGrid() {
  return (
    <section className="py-16 sm:py-24">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <span className="text-xs font-semibold uppercase tracking-widest text-gold-500">
            Onde atuamos
          </span>
          <h2 className="text-3xl sm:text-4xl font-bold mt-2">
            Regiões
          </h2>
          <p className="text-muted mt-2 max-w-xl mx-auto">
            Cada região com sua identidade única. Conheça os melhores bairros
            para viver em Brasília.
          </p>
        </div>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          {regioes.map((regiao, i) => (
            <Link
              key={regiao.slug}
              href={`/regioes/${regiao.slug}`}
              className={`group relative h-72 rounded-2xl overflow-hidden ${
                i === 0 ? "lg:col-span-2 lg:row-span-1" : ""
              }`}
            >
              <div className={`absolute inset-0 bg-gradient-to-br ${regiao.color} z-10`} />
              <div className="absolute inset-0 bg-gray-200" />
              <div className="relative z-20 p-8 flex flex-col justify-end h-full">
                <h3 className="text-2xl font-bold text-white mb-1">
                  {regiao.name}
                </h3>
                <p className="text-white/80 text-sm">{regiao.headline}</p>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  )
}
