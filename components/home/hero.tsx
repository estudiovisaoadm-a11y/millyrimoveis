import Link from "next/link"

export function Hero() {
  return (
    <section className="relative h-screen min-h-[600px] max-h-[900px] flex items-center justify-center overflow-hidden">
      <div className="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/60 z-10" />
      <div
        className="absolute inset-0 bg-cover bg-center"
        style={{
          backgroundImage: "url(/images/hero-brasilia.jpg)",
          backgroundColor: "#1a1a2e",
        }}
      />
      <div className="relative z-20 text-center text-white px-4 max-w-4xl mx-auto">
        <h1 className="text-4xl sm:text-5xl md:text-7xl font-bold leading-tight mb-6">
          O lugar onde seu próximo capítulo começa.
        </h1>
        <p className="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
          Residências selecionadas, atendimento personalizado e inteligência
          imobiliária para quem valoriza tempo, segurança e qualidade de vida.
        </p>
        <div className="flex flex-col sm:flex-row gap-4 justify-center">
          <Link
            href="/comprar"
            className="inline-flex items-center justify-center px-8 py-4 bg-white text-foreground font-semibold rounded-lg hover:bg-gray-100 transition-all"
          >
            Encontrar meu imóvel
          </Link>
          <Link
            href="/contato"
            className="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-all"
          >
            Falar com um especialista
          </Link>
        </div>
      </div>
    </section>
  )
}
