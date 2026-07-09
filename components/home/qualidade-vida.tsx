import { School, Hospital, UtensilsCrossed, TreePine, Dumbbell, ShoppingBag } from "lucide-react"

const items = [
  { icon: School, label: "Escolas", desc: "Ensino internacional e bilíngue" },
  { icon: Hospital, label: "Hospitais", desc: "Rede de saúde de excelência" },
  { icon: UtensilsCrossed, label: "Restaurantes", desc: "Gastronomia premiada" },
  { icon: TreePine, label: "Parques", desc: "Áreas verdes preservadas" },
  { icon: Dumbbell, label: "Academias", desc: "Bem-estar e qualidade de vida" },
  { icon: ShoppingBag, label: "Mercados", desc: "Comércio de alto padrão" },
]

export function QualidadeVida() {
  return (
    <section className="py-16 sm:py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <span className="text-xs font-semibold uppercase tracking-widest text-gold-500">
            Qualidade de Vida
          </span>
          <h2 className="text-3xl sm:text-4xl font-bold mt-2">
            Tudo ao seu redor
          </h2>
          <p className="text-muted mt-2 max-w-xl mx-auto">
            Mais que um imóvel. Descubra a infraestrutura completa que cada
            região oferece para você e sua família.
          </p>
        </div>
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
          {items.map((item) => (
            <div
              key={item.label}
              className="flex flex-col items-center text-center p-6 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors"
            >
              <div className="w-12 h-12 rounded-full bg-brand-50 flex items-center justify-center mb-3">
                <item.icon className="w-5 h-5 text-brand-600" />
              </div>
              <h3 className="text-sm font-semibold">{item.label}</h3>
              <p className="text-xs text-muted mt-1">{item.desc}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
