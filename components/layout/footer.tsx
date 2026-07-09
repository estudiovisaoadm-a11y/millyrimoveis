import Link from "next/link"

export function Footer() {
  return (
    <footer className="bg-foreground text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
          <div>
            <h3 className="text-xl font-bold mb-4">MillyR Imóveis</h3>
            <p className="text-gray-400 text-sm leading-relaxed">
              Consultoria imobiliária premium em Brasília. Qualidade de vida,
              patrimônio e segurança para você e sua família.
            </p>
          </div>
          <div>
            <h4 className="text-sm font-semibold uppercase tracking-wider mb-4">
              Navegação
            </h4>
            <nav className="space-y-2">
              {["Comprar", "Alugar", "Lançamentos", "Condomínios", "Regiões"].map(
                (item) => (
                  <Link
                    key={item}
                    href={`/${item.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "")}`}
                    className="block text-sm text-gray-400 hover:text-white transition-colors"
                  >
                    {item}
                  </Link>
                )
              )}
            </nav>
          </div>
          <div>
            <h4 className="text-sm font-semibold uppercase tracking-wider mb-4">
              Institucional
            </h4>
            <nav className="space-y-2">
              {["Quem Somos", "Revista", "Investidores", "Serviços", "Contato"].map(
                (item) => (
                  <Link
                    key={item}
                    href={`/${item.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/\s+/g, "-")}`}
                    className="block text-sm text-gray-400 hover:text-white transition-colors"
                  >
                    {item}
                  </Link>
                )
              )}
            </nav>
          </div>
          <div>
            <h4 className="text-sm font-semibold uppercase tracking-wider mb-4">
              Contato
            </h4>
            <div className="space-y-2 text-sm text-gray-400">
              <p>SHIS QI 11, Brasília - DF</p>
              <p>(61) 99999-9999</p>
              <p>contato@millyrimoveis.com.br</p>
            </div>
          </div>
        </div>
        <div className="mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
          <p>&copy; {new Date().getFullYear()} MillyR Imóveis. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  )
}
