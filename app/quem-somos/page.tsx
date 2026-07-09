import type { Metadata } from "next"

export const metadata: Metadata = {
  title: "Quem Somos | MillyR Imóveis",
}

export default function QuemSomos() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h1 className="text-4xl sm:text-5xl font-bold mb-6">Quem Somos</h1>
          <p className="text-lg text-muted max-w-2xl mx-auto leading-relaxed">
            Mais que uma imobiliária. Uma consultoria imobiliária premium que
            transforma a busca pelo imóvel em uma experiência personalizada.
          </p>
        </div>
        <div className="aspect-video bg-gray-100 rounded-2xl mb-16 flex items-center justify-center text-muted">
          Vídeo Institucional
        </div>
        <div className="grid md:grid-cols-2 gap-12">
          <div>
            <h2 className="text-2xl font-bold mb-4">Nossa História</h2>
            <p className="text-muted leading-relaxed">
              Nascida em Brasília, a MillyR Imóveis nasceu da visão de oferecer
              um atendimento imobiliário verdadeiramente premium. Combinamos
              conhecimento profundo do mercado de alto padrão com tecnologia de
              ponta para criar uma experiência única.
            </p>
          </div>
          <div>
            <h2 className="text-2xl font-bold mb-4">Nossos Valores</h2>
            <ul className="space-y-3 text-muted">
              <li className="flex gap-2">
                <span className="text-gold-500 font-bold">—</span>
                Excelência no atendimento personalizado
              </li>
              <li className="flex gap-2">
                <span className="text-gold-500 font-bold">—</span>
                Transparência e ética em cada negociação
              </li>
              <li className="flex gap-2">
                <span className="text-gold-500 font-bold">—</span>
                Conhecimento profundo do mercado de Brasília
              </li>
              <li className="flex gap-2">
                <span className="text-gold-500 font-bold">—</span>
                Inovação e inteligência imobiliária
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  )
}
