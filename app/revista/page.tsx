import type { Metadata } from "next"
import Link from "next/link"

export const metadata: Metadata = {
  title: "Revista | MillyR Imóveis",
}

const posts = [
  { title: "Como escolher o condomínio ideal em Brasília", slug: "como-escolher-condominio-ideal", category: "Guia", readTime: 8 },
  { title: "Quanto custa morar no Jardim Botânico", slug: "quanto-custa-morar-jardim-botanico", category: "Mercado", readTime: 6 },
  { title: "Onde investir em Brasília em 2026", slug: "onde-investir-brasilia-2026", category: "Investimento", readTime: 10 },
  { title: "Comparativo: Lago Sul vs Jardim Botânico", slug: "comparativo-lago-sul-jardim-botanico", category: "Comparativo", readTime: 7 },
  { title: "Arquitetura contemporânea em Brasília", slug: "arquitetura-contemporanea-brasilia", category: "Arquitetura", readTime: 5 },
  { title: "Financiamento imobiliário: guia completo", slug: "financiamento-imobiliario-guia", category: "Financiamento", readTime: 12 },
]

export default function Revista() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <span className="text-xs font-semibold uppercase tracking-widest text-gold-500">
            Conteúdo Editorial
          </span>
          <h1 className="text-4xl sm:text-5xl font-bold mt-2 mb-4">Revista</h1>
          <p className="text-muted max-w-2xl mx-auto">
            Análises, guias e tendências do mercado imobiliário de alto padrão
            em Brasília.
          </p>
        </div>
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {posts.map((post) => (
            <Link
              key={post.slug}
              href={`/revista/${post.slug}`}
              className="group block bg-white rounded-2xl border border-border overflow-hidden hover:shadow-sm transition-shadow"
            >
              <div className="aspect-[16/9] bg-gray-100" />
              <div className="p-6">
                <div className="flex items-center gap-2 text-xs text-muted mb-2">
                  <span className="text-gold-600 font-medium">{post.category}</span>
                  <span className="w-1 h-1 rounded-full bg-gray-300" />
                  <span>{post.readTime} min de leitura</span>
                </div>
                <h3 className="text-lg font-semibold leading-snug group-hover:text-brand-600 transition-colors">
                  {post.title}
                </h3>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </div>
  )
}
