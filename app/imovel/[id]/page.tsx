import type { Metadata } from "next"
import { formatPrice } from "@/lib/utils"
import { MapPin, Bed, Bath, Square, Car, Calendar, Shield, BarChart3 } from "lucide-react"

export const metadata: Metadata = {
  title: "Imóvel | MillyR Imóveis",
}

const mockProperty = {
  title: "Casa contemporânea com vista para o Lago",
  price: 4850000,
  type: "buy",
  bedrooms: 4,
  bathrooms: 5,
  area: 620,
  parking: 4,
  region: "Lago Sul",
  address: "SHIS QI 11, Brasília - DF",
  description:
    "Imponente residência com vista panorâmica para o Lago Paranoá. Arquitetura contemporânea assinada por renomado escritório, com acabamentos premium e integração total dos ambientes internos com a área externa. Cada detalhe foi pensado para proporcionar conforto, privacidade e uma experiência única de morar.",
  amenities: [
    "Piscina aquecida com borda infinita",
    "Academia completa",
    "Home theater com isolamento acústico",
    "Automação residencial",
    "Painéis solares",
    "Sistema de segurança inteligente",
    "Adega climatizada",
    "Lareira ecológica",
  ],
}

export default function PropertyPage() {
  const p = mockProperty

  return (
    <div className="pt-20">
      <div className="aspect-[21/9] bg-gray-100" />
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid lg:grid-cols-3 gap-12">
          <div className="lg:col-span-2 space-y-10">
            <div>
              <div className="flex items-center gap-2 text-xs text-muted uppercase tracking-wider mb-2">
                <span>{p.region}</span>
                <span className="w-1 h-1 rounded-full bg-gray-300" />
                <span>{p.type === "buy" ? "Venda" : "Aluguel"}</span>
              </div>
              <h1 className="text-3xl sm:text-4xl font-bold leading-tight">{p.title}</h1>
              <div className="flex items-center gap-1 text-muted text-sm mt-2">
                <MapPin className="w-4 h-4" />
                {p.address}
              </div>
            </div>

            <div className="flex flex-wrap gap-8 p-6 bg-gray-50 rounded-2xl">
              {[
                { icon: Bed, label: "Dormitórios", value: p.bedrooms },
                { icon: Bath, label: "Banheiros", value: p.bathrooms },
                { icon: Square, label: "Área", value: `${p.area}m²` },
                { icon: Car, label: "Vagas", value: p.parking },
              ].map((item) => (
                <div key={item.label} className="flex items-center gap-3">
                  <item.icon className="w-5 h-5 text-muted" />
                  <div>
                    <p className="text-sm font-semibold">{item.value}</p>
                    <p className="text-xs text-muted">{item.label}</p>
                  </div>
                </div>
              ))}
            </div>

            <div>
              <h2 className="text-xl font-bold mb-4">Descrição</h2>
              <p className="text-muted leading-relaxed">{p.description}</p>
            </div>

            <div>
              <h2 className="text-xl font-bold mb-4">Amenidades</h2>
              <div className="grid sm:grid-cols-2 gap-3">
                {p.amenities.map((a) => (
                  <div key={a} className="flex items-center gap-2 text-sm">
                    <span className="w-1.5 h-1.5 rounded-full bg-brand-500" />
                    {a}
                  </div>
                ))}
              </div>
            </div>

            <div className="aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-muted">
              Mapa interativo (Google Maps)
            </div>

            <div className="grid sm:grid-cols-2 gap-4">
              <div className="p-4 bg-gray-50 rounded-xl">
                <p className="text-xs text-muted mb-1">Escolas próximas</p>
                <p className="text-sm font-medium">Colégio Sigma, Galois, Mackenzie</p>
              </div>
              <div className="p-4 bg-gray-50 rounded-xl">
                <p className="text-xs text-muted mb-1">Tempo até o Aeroporto</p>
                <p className="text-sm font-medium">20 minutos</p>
              </div>
              <div className="p-4 bg-gray-50 rounded-xl">
                <p className="text-xs text-muted mb-1">Tempo até o Plano Piloto</p>
                <p className="text-sm font-medium">15 minutos</p>
              </div>
              <div className="p-4 bg-gray-50 rounded-xl">
                <p className="text-xs text-muted mb-1">Restaurantes nas proximidades</p>
                <p className="text-sm font-medium">+15 opções premium</p>
              </div>
            </div>
          </div>

          <div className="lg:col-span-1">
            <div className="sticky top-28 space-y-6">
              <div className="p-6 bg-white rounded-2xl border border-border">
                <p className="text-3xl font-bold">{formatPrice(p.price)}</p>
                <div className="mt-6 space-y-3">
                  <button className="w-full h-12 bg-foreground text-white rounded-xl font-medium hover:bg-foreground/90 transition-colors">
                    Agendar visita
                  </button>
                  <button className="w-full h-12 border-2 border-foreground text-foreground rounded-xl font-medium hover:bg-gray-50 transition-colors">
                    Falar no WhatsApp
                  </button>
                </div>
              </div>
              <div className="p-6 bg-white rounded-2xl border border-border space-y-4">
                <div className="flex items-center gap-3">
                  <Calendar className="w-5 h-5 text-muted" />
                  <div>
                    <p className="text-sm font-medium">Simulação de financiamento</p>
                    <p className="text-xs text-muted">Calcule as parcelas</p>
                  </div>
                </div>
                <div className="flex items-center gap-3">
                  <Shield className="w-5 h-5 text-muted" />
                  <div>
                    <p className="text-sm font-medium">Documentação</p>
                    <p className="text-xs text-muted">Due diligence inclusa</p>
                  </div>
                </div>
                <div className="flex items-center gap-3">
                  <BarChart3 className="w-5 h-5 text-muted" />
                  <div>
                    <p className="text-sm font-medium">Valorização da região</p>
                    <p className="text-xs text-muted">+12% nos últimos 12 meses</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
